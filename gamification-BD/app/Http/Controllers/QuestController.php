<?php
namespace App\Http\Controllers;
use App\Models\Quest;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;

class QuestController extends Controller
{
    public function newTeamQuest($teamId){
        return view('content.newquest',["teamId"=>$teamId]);
    }

    public function addTeamQuest(Request $request, Factory $validator){

        $validation = $validator->make($request->all(),[
            'name'=>'required',
            'description'=>'required',
            'experience'=>'required|numeric',
            'module'=>'nullable|numeric|gt:0',
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation);
        } else {

            $name = $request->input('name');
            $description = $request->input('description');
            $experience = $request->input('experience');
            $teamId = $request->input('teamId');
            $module = $request->input('module');

            $quest = new Quest();
            $quest->name = $name;
            $quest->description = $description;
            $quest->experience = $experience;
            $quest->team_id = $teamId;
            $quest->module = $module;
            $quest->save();

            $team = Team::find($teamId);
            $teamUsers = $team->users;

            foreach ($teamUsers as $teamUser) {
                $achievement = new \App\Models\Achievement();
                $achievement->status = 'not completed';
                $achievement->quest_id = $quest->id;
                $achievement->user_id = $teamUser->id;
                $achievement->save();
            }
            return redirect()->route('team', ['team_id' => $teamId]);
        }
    }

    public function deleteQuest(Request $request){
        $quest = Quest::find($request->input('questId'));
        $quest->delete();
        return redirect()->back();
    }

    public function editQuest(Request $request, Factory $validator){
        $validation = $validator->make($request->all(),[
            'name'=>'required',
            'description'=>'required',
            'experience'=>'required|numeric',
            'module'=>'nullable|numeric|gt:0',
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation);
        } else {

            $name = $request->input('name');
            $description = $request->input('description');
            $experience = $request->input('experience');
            $teamId = $request->input('teamId');
            $module = $request->input('module');
            $questId = $request->input('questId');

            $quest = Quest::find($questId);
            $quest->name = $name;
            $quest->description = $description;
            $quest->experience = $experience;
            $quest->team_id = $teamId;
            $quest->module = $module;
            $quest->save();
        }
        return redirect()->route('team', ['team_id' => $teamId]);

    }
}
