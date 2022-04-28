<?php
namespace App\Http\Controllers;
class QuestController extends Controller
{
    public function newTeamQuest($teamId){
        return view('content.newquest',["teamId"=>$teamId]);
    }
}
