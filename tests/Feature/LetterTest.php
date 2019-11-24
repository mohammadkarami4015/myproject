<?php

namespace Tests\Feature;

use App\Letter;
use App\Permission;
use App\Role;
use App\User;
use Carbon\Carbon;
use Psr\Log\NullLogger;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LetterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function unAuthenticated_user_can_see_latter()
    {
        $response = $this->get(route('letter.index'));
        $response->assertRedirect('/login');
    }

    //******** letter_index Tests

    /** @test */
    public function can_see_all_letter_without_role()
    {
        $this->signIn();
        $response = $this->get(route('letter.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_see_letter_with_any_roles()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('letter.index'));
        $response->assertStatus(403);
    }

    /** @test */
    public function letter_need_allLetter_role()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'allLetter']));
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('letter.index'));
        $response->assertStatus(200);
    }

    //    *****letter_create_form Tests

    /** @test */
    public function can_see_create_letter_form_without_role()
    {
        $this->signIn();
        $response = $this->get(route('letter.create'));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_see_letterCreate_form_with_any_roles()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('letter.create'));
        $response->assertStatus(403);
    }

    /** @test */
    public function userCreate_need_addLetter_role()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'addLetter']));
        $this->signIn()->roles()->attach($role);
        $response = $this->get(route('letter.create'));
        $response->assertStatus(200);
        $response->assertViewIs('letter.create');
    }

    /** @test */
    public function can_delete_letter()
    {
        $user = $this->signIn();
        $letter = factory(Letter::class)->create([
            'user_id' => $user->id
        ]);
        $response = $this->json('delete', route('letter.destroy', $letter));
        $this->assertDatabaseMissing('letters', $letter->toArray());
    }

    //    *****letter_store Tests

    /** @test */
    public function can_store_letter_without_role()
    {
        $this->signIn();
        $response = $this->json('post', route('letter.store', [
            'title' => 'test1',
            'details' => 'ttttttttt'
        ]));
        $response->assertStatus(403);
    }

    /** @test */
    public function can_store_letter_with_any_role()
    {
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'test']));
        $this->signIn()->roles()->attach($role);
        $response = $this->json('post', route('letter.store', [
            'title' => 'test1',
            'details' => 'ttttttttt'
        ]));
        $response->assertStatus(403);
    }

    /** @test */
    public function letterStore_need_addLetter_role()
    {
        $user = $this->signIn();
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'addLetter']));
        $user->roles()->attach($role);
        $response = $this->json('post', route('letter.store'), [
            'title' => 'test1',
            'details' => 'kldjsfkldjfkdsjfkdlsfjdls'
        ]);
        $this->assertDatabaseHas('letters', ['title' => 'test1']);
    }

    /** @test */
    public function required_field_letterStore()
    {
        $user = $this->signIn();
        $role = factory(Role::class)->create();
        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'addLetter']));
        $user->roles()->attach($role);
        $response = $this->json('post', route('letter.store'), [
        ]);
        $response->assertSeeInOrder(['The title field is required', 'The details field is required']);
    }

    /** @test */
//    public function attach_in_letterUserTable_with_exp_time()
//    {
//        $user = $this->signIn();
//        $role = factory(Role::class)->create();
//        $role->permissions()->attach(factory(Permission::class)->create(['title' => 'addLetter']));
//        $user->roles()->attach($role);
//
//        $user1 = factory(User::class)->create([
//            'code' => '00010001'
//        ]);
//
//        $response = $this->json('post', route('letter.store'), $data = [
//            'title' => 'test',
//            'details' => 'jfkdlsjfdklsfjdklfjd',
//            'user_id' => [$user1->id],
//            'exp_time' => [$user1->id => 1]
//        ]);
//        $this->assertDatabaseHas('letter_user', ['letter_id' => 1, 'user_id' => $user1->id]);
//    }

    /** @test */
    public function user_can_see_his_letters_()
    {
        $user = $this->signIn();
        $letter = factory(Letter::class)->create([
            'title' => 'TEST',
            'user_id' => $user->id
        ]);
        $response = $this->get(route('letter.myIndex'));
        $response->assertSee('TEST');
    }

    /** @test */
    public function user_can_see_child_letters_()
    {
        $user = $this->signIn();
        $user1 = factory(User::class)->create([
            'code' => $user->code . '00001',
        ]);

        $letter = factory(Letter::class)->create([
            'title' => 'TEST',
            'user_id' => $user1->id,
        ]);
        $response = $this->get(route('letter.child'));
        $response->assertSeeText('TEST');
    }

    /** @test */
    public function can_all_user_see_letter_edit_form_()
    {
        $user = $this->signIn();
        $user1 = factory(User::class)->create([
            'code' => $user->code . '00001',
        ]);
        $letter = factory(Letter::class)->create([
            'title' => 'TEST',
            'user_id' => $user1->id,
        ]);
        $response = $this->get(route('letter.edit', $letter->id));
        $response->assertStatus(302);
    }

    /** @test */
    public function letter_edit_form_show_to_owner()
    {
        $user = $this->signIn();
        $letter = factory(Letter::class)->create([
            'title' => 'TEST',
            'user_id' => $user->id,
        ]);
        $response = $this->get(route('letter.edit', $letter->id));
        $response->assertStatus(200);
        $response->assertSee('TEST');
    }

    /** @test */
    public function can_user_update_his_letters()
    {
        $user = $this->signIn();
        $letter = factory(Letter::class)->create([
            'title' => 'TEST',
            'user_id' => $user->id,
        ]);
        $response = $this->patch(route('letter.update', $letter->id), [
            'title' => 'updateTest',
            'details' => 'this is sample for details'
        ]);
//        $response->assertSessionHas('flash_message', 'نامه مورد نطر با موفقیت ویرایش شد.');
        $this->assertDatabaseHas('letters', ['title' => 'updateTest']);
    }

    /** @test */
    public function can_user_see_accessLetters()
    {
        $user = $this->signIn();
        $letter = factory(Letter::class)->create([
            'title' => 'TEST',
        ]);
        $letter->users()->attach($user->id, ['exp_time' => Carbon::now()->addDays(1)]);
        $response = $this->json('get',route('letter.access'));
        $response->assertSeeText('TEST');
    }



}
