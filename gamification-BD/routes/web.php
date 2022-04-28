<?php

use App\Http\Controllers\TeamController;
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

    return redirect()->back();

})->name('teamcreate');

require __DIR__.'/auth.php';
