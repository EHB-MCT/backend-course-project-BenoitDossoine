<?php
namespace App\Http\Controllers;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;

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
        return view('content.team',["team"=>$team,"quests"=>$quests]);
    }
}
