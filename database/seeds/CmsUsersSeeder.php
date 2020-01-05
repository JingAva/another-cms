<?php

use Illuminate\Database\Seeder;

class CmsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            [
                'name' => 'Tomahawk Support',
                'password' => '9bc129f7a46381be15f1329c4479e02c70d10d19',
                'email' => 'support@tomahawk.co.nz',
                'access_id' => 1
            ]
        ]);
    }
}
