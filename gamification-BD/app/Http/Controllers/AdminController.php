<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function usersList(){
        $users = User::all();
        $teams = Team::all();
        return view('content.admin',["users"=>$users,"teams"=>$teams]);
    }

    public function changeMemberRole(Request $request){
        $newRole = $request->input('role');
        $user = User::find($request->input('userId'));

        if($user->hasRole('member')){
            $user->removeRole('member');
        } else if($user->hasRole('manager')){
            $user->removeRole('manager');
        } else if($user->hasRole('admin')){
            $user->removeRole('admin');
        }

        $user->assignRole($newRole);

        return redirect()->back();
    }
}
