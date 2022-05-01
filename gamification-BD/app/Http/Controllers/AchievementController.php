<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Quest;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function markStudentQuestPending(Request $request){
        $user = User::find($request->userId);
        $quest = Quest::find($request->questId);

        $achievement = $quest->achievements()->where('user_id',$user->id)->first();
        $achievement->status = 'pending';
        $achievement->save();
        return redirect()->back();
    }
}
