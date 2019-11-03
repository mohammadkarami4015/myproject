<?php

namespace Tests\Feature;

use App\Permission;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function unAuthenticated_user_can_see_roles()
    {
        $response = $this->get(route('role.index'));
        $response->assertRedirect('/login');
    }

    /** @test */
    public function can_see_all_roles_without_role()
    {
        $this->signIn();
        $response = $this->get(route('user.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_see_roles_with_any_role()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('user.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function roles_need_allRole()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'allRole']));
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('role.index'));
        $response->assertStatus(200);
    }


    /** @test */
    public function can_see_create_role_form_without_role()
    {
        $this->signIn();
        $response = $this->get(route('role.create'));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_see_roleCreate_form_with_any_roles()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('role.create'));
        $response->assertStatus(403);
    }

    /** @test */
    public function roleCreate_need_addRole_and_allRole()
    {
        $role = factory(Role::class)->create();
        $per1 = factory(Permission::class)->create(['title' => 'addRole']);
        $per2 = factory(Permission::class)->create(['title' => 'allRole']);
        $role->permissions()->attach([$per1->id, $per2->id]);
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('role.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function can_delete_role_without_role()
    {
        $this->signIn();
        $role = factory(Role::class)->create();
        $response = $this->json('delete', route('role.destroy', $role->id));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_delete_role_with_any_roles()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->json('delete', route('role.destroy', 1));
        $response->assertStatus(403);
    }

    /** @test */
    public function roleDelete_need_deleteRole_and_allRole()
    {
        $role = factory(Role::class)->create();
        $per1 = factory(Permission::class)->create(['title' => 'deleteRole']);
        $per2 = factory(Permission::class)->create(['title' => 'allRole']);
        $role->permissions()->attach([$per1->id, $per2->id]);
        $this->signIn()->roles()->attach($role);
        $response = $this->json('delete', route('role.destroy', $role->id));
        $this->assertDatabaseMissing('roles', $role->toArray());
    }

    /** @test */
    public function can_see_editRole_form_without_role()
    {
        $this->signIn();
        $role = factory(Role::class)->create();
        $response = $this->json('get', route('role.edit', 1));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_see_editRole_form_with_any_roles()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->json('get', route('role.edit', 1));
        $response->assertStatus(403);
    }

    /** @test */
    public function editRole_form_need_editRole_and_allRole()
    {
        $role = factory(Role::class)->create();
        $per1 = factory(Permission::class)->create(['title' => 'editRole']);
        $per2 = factory(Permission::class)->create(['title' => 'allRole']);
        $role->permissions()->attach([$per1->id, $per2->id]);
        $this->signIn()->roles()->attach($role);
        $response = $this->json('get', route('role.edit', $role->id));
        $response->assertStatus(200);
        $response->assertViewIs('role.edit');
    }

    /** @test */
    public function can_update_role_without_role()
    {
        $this->signIn();
        $role = factory(Role::class)->create();
        $response = $this->json('patch', route('role.update', 1));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_update_user_with_any_role()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->json('patch', route('role.update', 1));
        $response->assertStatus(403);
    }

    public function userUpdate_need_editRole_and_allRole()
    {
        $role = factory(Role::class)->create();
        $per1 = factory(Permission::class)->create(['title' => 'editRole']);
        $per2 = factory(Permission::class)->create(['title' => 'allRole']);
        $role->permissions()->attach([$per1->id, $per2->id]);
        $this->signIn()->roles()->attach($role);
        $response = $this->json('patch', route('role.update', $role), [
            'title' => 'test',
        ]);
        $this->assertDatabaseHas('users', ['title' => 'test']);
    }

    /** @test */
    public function required_field_for_roleUpdate()
    {
        $role = factory(Role::class)->create();
        $per1 = factory(Permission::class)->create(['title' => 'editRole']);
        $per2 = factory(Permission::class)->create(['title' => 'allRole']);
        $role->permissions()->attach([$per1->id, $per2->id]);
        $this->signIn()->roles()->attach($role);
        $response = $this->json('patch', route('role.update', $role));
        $response->assertSeeText('The title field is required');
    }

    /** @test */
    public function can_store_role_without_role()
    {
        $this->signIn();
        $response = $this->json('post', route('user.store', [
            'title' => 'test',
        ]));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_store_user_with_any_role()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->json('post', route('user.store', [
            'title' => 'test',
        ]));
        $response->assertStatus(403);
    }

    /** @test */
    public function roleStore_need_addRole_role()
    {
        $role = factory(Role::class)->create();
        $per1 = factory(Permission::class)->create(['title' => 'addRole']);
        $per2 = factory(Permission::class)->create(['title' => 'allRole']);
        $role->permissions()->attach([$per1->id, $per2->id]);
        $this->signIn()->roles()->attach($role);
        $response = $this->json('post', route('role.store', $role), [
            'title' => 'test',
        ]);
        $this->assertDatabaseHas('roles', ['title' => 'test']);
    }

    /** @test */
    public function required_field_for_userStore()
    {
        $role = factory(Role::class)->create();
        $per1 = factory(Permission::class)->create(['title' => 'addRole']);
        $per2 = factory(Permission::class)->create(['title' => 'allRole']);
        $role->permissions()->attach([$per1->id, $per2->id]);
        $this->signIn()->roles()->attach($role);
        $response = $this->json('post', route('role.store'));
        $response->assertSee('The title field is required');
    }




}
