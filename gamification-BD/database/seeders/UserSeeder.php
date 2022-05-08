<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Quest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Mike Derycke";
        $user->email = "mike@derycke.be";
        $user->password = Hash::make("backendisawesome");
        $user->save();

        $user = new User();
        $user->name = "Benoit";
        $user->email = "benoit@dossoine.be";
        $user->password = Hash::make("student");
        $user->experience = 0;
        $user->save();


        $team = new Team();
        $team->name = "Web 2";
        $team->description = "This course is given in semester 1.";
        $team->docent = "Mike Derycke";
        $team->save();

        $quest = new Quest();
        $quest->name = "Start web 2";
        $quest->description = "Let's get started!";
        $quest->experience = 8;
        $quest->team_id=1;
        $quest->save();

        $achievement = new Achievement();
        $achievement->status = 'not completed';
        $achievement->quest_id = 1;
        $achievement->user_id = 2;
        $achievement->save();

        $benoit = User::find(2);
        $benoit->teams()->attach(1);

        $mike = User::find(1);
        $mike->teams()->attach(1);
    }
}
