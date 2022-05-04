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

    public function updateAchievement(Request $request){
        $achievement = Achievement::find($request->achievementId);
        $status = $request->achievementStatus;

        if($status == 'not completed'){
            $achievement->status = 'not completed';
            $achievement->save();
        } else if($status == 'completed'){
            $achievement->status = 'completed';
            $achievement->save();

            $quest = $achievement->quest;
            $user = $achievement->user;

            $userXP = $user->experience;
            $user->experience = $userXP + $quest->experience;
            $user->save();
        }

        return redirect()->back();
    }
}
