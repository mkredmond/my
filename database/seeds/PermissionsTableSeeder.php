<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Permission::truncate();
        DB::statement("SET foreign_key_checks=1");

        $default_permissions = [
            [
            	'name' => 'superuser', 
            	'label' => 'SuperUser', 
            	'description' => 'A superuser can perform any action in the system. Use with caution.'
           	],[
            	'name' => 'admin_edit', 
            	'label' => 'Admin Edit',
            	'description' => 'Admin edit allows a user to add, modify, and update forms in the admin area.'
            ],[
            	'name' => 'content_edit', 
            	'label' => 'Content Edit',
            	'description' => 'Content edit allows a user to add content to the system. They have access to their account only and cannot carry out any administrative actions.'
            ]
        ];

        foreach ($default_permissions as $default_permission) {
            $permission        = new Permission;
            $permission->name  = $default_permission['name'];
            $permission->label = $default_permission['label'];
            $permission->description = $default_permission['description'];

            $permission->save();
        }
    }
}
