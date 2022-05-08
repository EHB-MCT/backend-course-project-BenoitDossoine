<?php

use App\Http\Controllers\TeamController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\AchievementController;
use App\Models\Quest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authorize;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //team overview
    Route::get('/teams',[TeamController::class,"allTeams"])->name('teams');

    //specific team
    Route::get('/team/{team_id}',[TeamController::class,"teamData"])->name('team');

    //leaderboard
    Route::get('/leaderboard', function(){
        $users = User::all()->sortByDesc('experience');
        return view('content.leaderboard',['users'=>$users]);
    })->name('leaderboard');

    Route::post('/markStudentQuestPending', [AchievementController::class,'markStudentQuestPending'])->name('markStudentQuestPending');

    //routes only available to managers
    Route::middleware(['role:manager'])->group(function(){

        //form to create new team
        Route::get('/newteam', function(){
            return view('content.newteam');
        })->name('newteam');

        //handling of new team data
        Route::post('/teamcreate', function(Request $request){
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

            return redirect()->back();

        })->name('teamcreate');

        //form to create new quest
        Route::get('/team/{team_id}/newquest', [QuestController::class,"newTeamQuest"])->name('newquest');

        //handling of new quest data
        Route::post('/questcreate', [QuestController::class,"addTeamQuest"])->name('questcreate');

        //overview of members and possibility to add multiple
        Route::get('/team/{team_id}/members',function($teamId){
            $team = Team::find($teamId);
            $allUsers = User::role('member')->get();
            return view('content.teammembers',["team"=>$team, "allUsers"=>$allUsers]);
        })->name('teammembers');

        //overview of member's quests to approve
        Route::get('/team/{team_id}/teamprogress',function($teamId){
            $team = Team::find($teamId);
            return view('content.progress',['team'=>$team]);
        })->name('teamprogress');

        //handle data to add new members to team
        Route::post('/team/{team_id}/addTeamMembers',[TeamController::class,'addMembers'])->middleware(['auth'])->name('addTeamMembers');

        //handle data to update a member's achievement
        Route::post('team/{team_id}/updateAchievement',[AchievementController::class,'updateAchievement'])->middleware(['auth'])->name('updateAchievement');
    });

});

require __DIR__.'/auth.php';
