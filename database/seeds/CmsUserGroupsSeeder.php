<?php

use Illuminate\Database\Seeder;

class CmsUserGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('cms_user_groups')->insert([
            [
                'access_name' => 'Super Administrator',
                'access_user' => 1,
                'access_userpasswords' => 1,
                'access_useraccesslevel' => 1,
                'access_accessgroups' => 1,
                'access_cmssettings' => 1,
                'access_settings' => 1,
            ],
            [
                'access_name' => 'General Editor',
                'access_user' => 0,
                'access_userpasswords' => 0,
                'access_useraccesslevel' => 0,
                'access_accessgroups' => 0,
                'access_cmssettings' => 0,
                'access_settings' => 1,
            ]
        ]);
    }
}
