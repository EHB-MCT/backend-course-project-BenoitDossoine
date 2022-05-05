<?php
namespace App\Http\Controllers;
use App\Models\Achievement;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;

class TeamController extends Controller
{
    public function allTeams(){
        $currentUser = Auth::user();
        $teamList= $currentUser->teams;
        return view('content.teams',["teamlist"=>$teamList]);
    }

    public function teamData($teamId){
        $team = Team::find($teamId);
        $quests = $team->quests;

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

        return view('content.team',["team"=>$team,"leaderboard"=>$leaderboard]);
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
                    $achievement->quest_id=1;
                    $achievement->user_id=$newUserId;
                    $achievement->save();
                }
            }
            return redirect()->back();
        }


    }
}
