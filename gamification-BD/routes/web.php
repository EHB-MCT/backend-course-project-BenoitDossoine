<?php

use App\Http\Controllers\TeamController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\AchievementController;
use App\Models\Quest;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/teams',[TeamController::class,"allTeams"])->middleware(['auth'])->name('teams');

Route::get('/newteam', function(){
    return view('content.newteam');
})->middleware(['auth'])->name('newteam');

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

Route::get('/team/{team_id}',[TeamController::class,"teamData"])->name('team');

Route::get('/team/{team_id}/newquest', [QuestController::class,"newTeamQuest"])->middleware(['auth'])->name('newquest');

Route::post('/questcreate', function(Request $request){
    $name = $request->input('name');
    $description = $request->input('description');
    $experience = $request->input('experience');
    $teamId = $request->input('teamId');
//    $module = $request->input('module');


    $quest = new Quest();
    $quest->name=$name;
    $quest->description=$description;
    $quest->experience=$experience;
    $quest->team_id=$teamId;
    $quest->save();

    $team = Team::find($teamId);
    $teamUsers = $team->users;

    foreach ($teamUsers as $teamUser)
    {
        $achievement = new \App\Models\Achievement();
        $achievement->status = 'not completed';
        $achievement->quest_id = $quest->id;
        $achievement->user_id = $teamUser->id;
        $achievement->save();
    }
    return redirect()->route('team',['team_id'=>$teamId]);
})->name('questcreate');

Route::post('/markStudentQuestPending', [AchievementController::class,'markStudentQuestPending'])->name('markStudentQuestPending');

require __DIR__.'/auth.php';
