<?php

namespace Database\Seeders;

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
        $team->save();
    }
}
