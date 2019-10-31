<?php

namespace Tests\Feature;

use App\Http\Requests\UserRequest;
use App\Permission;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function unAuthenticated_can_see_user()
    {
        $response = $this->get(route('user.index'));
        $response->assertRedirect('/login');
    }
//******** user index Tests

    /** @test */
    public function can_see_all_users_without_role()
    {
        $this->signIn();
        $response = $this->get(route('user.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_see_users_with_any_roles()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach( factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('user.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function users_need_allUser_role()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach( factory(Permission::class)->create(['title' => 'allUser']));
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('user.index'));
        $response->assertStatus(200);
    }

//    *****user_create_form Tests

    /** @test */
    public function can_see_create_user_form_without_role()
    {
        $this->signIn();
        $response = $this->get(route('user.create'));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_see_userCreate_form_with_any_roles()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach( factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('user.create'));
        $response->assertStatus(403);
    }

    /** @test */
    public function userCreate_need_addUser_role()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach( factory(Permission::class)->create(['title' => 'addUser']));
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('user.create'));
        $response->assertStatus(200);
        $response->assertViewIs('user.create');
    }
//    *****user_delete Tests

    /** @test */
    public function can_delete_user_without_role()
    {
        $this->signIn();
        $user = factory(User::class)->create();
        $response = $this->json('delete', route('user.destroy', $user->id));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_delete_user_with_any_roles()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach( factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->json('delete', route('user.destroy', 1));
        $response->assertStatus(403);
    }

    /** @test */
    public function userDelete_need_deleteUser_role()
    {
        $role = factory(Role::class)->create();
       $role->permissions()->attach( factory(Permission::class)->create(['title' => 'deleteUser']));
        $this->signIn()->roles()->attach($role);
        $user = factory(User::class)->create();
        $response = $this->json('delete', route('user.destroy', 2));
        $this->assertDatabaseMissing('users', $user->toArray());
    }

    //    *****user_edit_form Tests

    /** @test */
    public function can_see_editUser_form_without_role()
    {
        $this->signIn();
        $response = $this->json('get', route('user.edit', 1));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_see_editUser_form_with_any_roles()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach( factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->json('get', route('user.edit', 1));
        $response->assertStatus(403);
    }

    /** @test */
    public function editUser_form_need_editUser_role()
    {
        $user = $this->signIn();
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'editUser']));
        $user->roles()->attach($role);
        $response = $this->json('get', route('user.edit',$user->id ));
        $response->assertStatus(200);
        $response->assertViewIs('user.edit');
    }

    //    *****user_update Tests

    /** @test */
    public function can_update_user_without_role()
    {
        $this->signIn();
        $response = $this->json('patch', route('user.update', 1));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_update_user_with_any_role()
    {

        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->json('patch', route('user.update', 1));
        $response->assertStatus(403);
    }

    /** @test */
    public function userUpdate_need_editUser_role()
    {
        $user = $this->signIn();
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'editUser']));
        $user->roles()->attach($role);
        $user1=factory(User::class)->make();
        $response = $this->json('patch', route('user.update',$user),[
            'name'=>'mohammad',
            'email'=>'m@gmai.com',
            'password'=>'987654321',
            'password_confirmation'=>'987654321',
        ]);
        $this->assertDatabaseHas('users',['name'=>'mohammad']);
    }



}
