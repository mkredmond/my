<?php

use App\Group;
use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Group::truncate();
        DB::statement("SET foreign_key_checks=1");

        $default_groups = [
            ['name' => 'faculty_staff', 'label' => 'Faculty/Staff'],
            ['name' => 'students', 'label' => 'Students'],
            ['name' => 'alumni', 'label' => 'Alumni'],
            ['name' => 'prospects', 'label' => 'Prospects'],
        ];

        foreach ($default_groups as $default_group) {
            $group        = new Group;
            $group->name  = $default_group['name'];
            $group->label = $default_group['label'];

            $group->save();
        }
    }
}
