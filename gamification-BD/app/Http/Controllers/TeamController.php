<?php
namespace App\Http\Controllers;
use App\Models\Achievement;
use App\Models\Quest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('user_in_team:$teamId',[
            'only'=>[
                'teamData'
            ]
        ]);
    }
    public function allTeams(){
        $currentUser = Auth::user();
        $teamList= $currentUser->teams;
        return view('content.teams',["teamlist"=>$teamList]);
    }

    public function teamData($teamId){
        $team = Team::find($teamId);

        $leaderboard = $team->users
            ->sortByDesc(function($member,$key) use ($teamId){
                return $member->achievements
                    ->where('team_id',$teamId)
                    ->where('status','completed')
                    ->sum(function($achievement)
                    {
                        return $achievement->quest->experience;
                    });
        });

        $maxModule = Quest::where('team_id',$teamId)->max('module');

        return view('content.team',["team"=>$team,"leaderboard"=>$leaderboard,"maxModule"=>$maxModule]);
    }

    public function makeNewTeam(Request $request, Factory $validator){
        $validation = $validator->make($request->all(),[
            'name'=>'required',
            'description'=>'required'
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation);
        } else {
            $name = $request->input('name');
            $description = $request->input('description');
            $user = auth()->user();
            $username = $user->name;

            $team = new Team();
            $team->name=$name;
            $team->description=$description;
            $team->docent=$username;
            $team->save();

            $team->users()->attach(auth()->id());

            return redirect()->route('teams');
        }

    }

    public function addMembers(Request $request, Factory $validator){

        $validation = $validator->make($request->all(),[
            'newUsers'=>'required',
            'teamId'=>'required|numeric'
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation);
        } else {
            $newUserIds = $request->input('newUsers');
            $teamId = $request->input('teamId');
            $team = Team::find($teamId);
            $quests = $team->quests;

            foreach($newUserIds as $newUserId)
            {
                $newUser = User::find($newUserId);
                $newUser->teams()->attach($teamId);

                foreach($quests as $quest){
                    $achievement = new Achievement();
                    $achievement->status = 'not completed';
                    $achievement->quest_id=$quest->id;
                    $achievement->user_id=$newUserId;
                    $achievement->save();
                }
            }
            return redirect()->back();
        }


    }
}
