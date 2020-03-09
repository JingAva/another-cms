<?php

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('pages')->insert([
            [
                'name' => 'Home',
                'url' => '/',
                'full_url' => '/',
                'parent_id' => 0,
                'status' => 'A',
                'rank' => 1
            ],
            [
                'name' => 'Contact',
                'url' => '/contact',
                'full_url' => '/contact',
                'parent_id' => 0,
                'status' => 'A',
                'rank' => 4
            ],
            [
                'name' => 'Blog',
                'url' => '/blog',
                'full_url' => '/blog',
                'parent_id' => 0,
                'status' => 'A',
                'rank' => 5
            ],
        ]);
    }
}
