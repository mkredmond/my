<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Role::truncate();
        DB::statement("SET foreign_key_checks=1");

        $default_roles = [
            ['name' => 'administrator', 'label' => 'Administrator'],
            ['name' => 'editor', 'label' => 'Editor'],
            ['name' => 'user', 'label' => 'User'],
        ];

        foreach ($default_roles as $default_role) {
            $role        = new Role;
            $role->name  = $default_role['name'];
            $role->label = $default_role['label'];

            $role->save();
        }
    }
}
