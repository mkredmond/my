<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_role')->truncate();

        $administratorPermissions = [
        	'superuser'
        ];

        $role = Role::whereName('administrator')->first();

        foreach ($administratorPermissions as $permission) {
        	$role->giveRolePermissionTo($permission);
        }
    }
}
