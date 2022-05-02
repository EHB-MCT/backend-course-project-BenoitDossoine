<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name'=>'create teams']);
        Permission::create(['name'=>'change roles']);
        Permission::create(['name'=>'create quests']);
        Permission::create(['name'=>'add students to teams']);
        Permission::create(['name'=>'verify achievements']);
        Permission::create(['name'=>'edit team']);
        Permission::create(['name'=>'achieve quest']);

        $member = Role::create(['name'=>'member']);
        $member->givePermissionTo('achieve quest');

        $manager = Role::create(['name'=>'manager']);
        $manager->givePermissionTo('create teams');
        $manager->givePermissionTo('add students to teams');
        $manager->givePermissionTo('create quests');
        $manager->givePermissionTo('verify achievements');
        $manager->givePermissionTo('edit team');

        $admin = Role::create(['name'=>'admin']);

        $users=User::all();
        foreach($users as $user){
            if($user->id !=2){
                $user->assignRole($member);
            }
        }

        $mike = User::find(2);
        $mike->assignRole($manager);

    }
}
