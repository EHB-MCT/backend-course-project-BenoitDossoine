<?php
namespace App\Http\Controllers;
use App\Models\Team;
class TeamController extends Controller
{
    public function allTeams(){
        $teamList= Team::all();
        return view('content.teams',["teamlist"=>$teamList]);
    }

    public function teamData($teamId){
        $team = Team::find($teamId);
        $quests = $team->quests;
        return view('content.team',["team"=>$team,"quests"=>$quests]);
    }
}
