<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        User::truncate();
        DB::statement("SET foreign_key_checks=1");

        $user = new User();
        $user->role_id = Role::whereName('administrator')->first()->id;
        $user->user_type = "Local";
        $user->username = "administrator";
        $user->givenname = "Administrator";
        $user->surname = "";
        $user->email = "webadmin@sjfc.edu";
        $user->password = 'admin';

        $user->save();
    }
}
