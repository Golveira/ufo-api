<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_users_are_listed(): void
    {
        User::factory()->count(16)->create();

        $this->get("api/v1/users")
            ->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.last_page', 2);
    }

    public function test_existing_user_is_shown(): void
    {
        $user = User::factory()->create();

        $this->get("api/v1/users/$user->id")
            ->assertOk()
            ->assertJsonFragment(['id' => $user->id]);
    }

    public function test_non_existing_user_is_not_shown(): void
    {
        $this->get("api/v1/users/1")
            ->assertNotFound();
    }

    public function test_authenticated_user_can_update_own_data(): void
    {
        $user = User::factory()->create([
            'email' => 'email@old.com',
            'password' => 'oldpassword'
        ]);

        Sanctum::actingAs($user);

        $this->putJson("api/v1/user", [
            'email' => 'email@new.com',
            'password' => 'newpassword'
        ])
            ->assertOk()
            ->assertJsonFragment(['id' => $user->id]);

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword', $user->password));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => $user->username,
            'email' => 'email@new.com'
        ]);
    }
}
