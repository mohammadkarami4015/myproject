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
                'title' => 'allRole',
            ],
            [
                'title' => 'allUser',
            ]
            ,
            [
                'title' => 'allLetter',
            ]
            ,
            [
                'title' => 'addUser',
            ]
            ,
            [
                'title' => 'deleteUser',
            ]
            ,
            [
                'title' => 'editUser',
            ]
            ,
            [
                'title' => 'addRole',
            ]
            ,
            [
                'title' => 'deleteRole',
            ]
            ,
            [
                'title' => 'editRole',
            ]
            ,
            [
                'title' => 'addLetter',
            ]
            ,
            [
                'title' => 'deleteLetter',
            ],
            [
                'title' => 'editLetter',
            ]
        ]);
      ($permissions = \App\Permission::all());

        $role = factory(\App\Role::class)->create();

        $role->permissions()->sync($permissions);

        $user = factory(\App\User::class)->create();

        $user->roles()->sync($role->id);
    }
}
