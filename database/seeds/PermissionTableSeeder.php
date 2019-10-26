<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->insert([
            [
                'title' => 'manageRole',
            ],
            [
                'title' => 'manageUser',
            ]
            , [
            'title' => 'manageLetter',
            ]]);
    }
}
