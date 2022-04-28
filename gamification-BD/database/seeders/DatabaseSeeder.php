<?php

namespace Database\Seeders;

use App\Models\Quest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $user = new User();
        $user->name = "Benoit";
        $user->email = "benoit@dossoine.be";
        $user->password = Hash::make("student");
        $user->save();

        $user = new User();
        $user->name = "Mike";
        $user->email = "mike@derycke.be";
        $user->password = Hash::make("docent");
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

        $teams = Team::factory()->count(3)->create();
    }
}
