<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_users_are_listed_with_pagination(): void
    {
        User::factory()->count(16)->create();

        $this->get("api/v1/users")
            ->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.last_page', 2);
    }

    public function test_user_is_showed_with_valid_id(): void
    {
        $user = User::factory()->create();

        $this->get("api/v1/users/$user->id")
            ->assertOk()
            ->assertJsonFragment(['id' => $user->id]);
    }

    public function test_unauthenticated_user_cannot_update_user(): void
    {
        $user = User::factory()->create();

        $this->putJson("api/v1/users/$user->id", [])
            ->assertUnauthorized();
    }

    public function test_user_can_update_own_data(): void
    {
        $user = User::factory()->create([
            'email' => 'email@old.com',
            'password' => 'oldpassword'
        ]);

        Sanctum::actingAs($user);

        $this->putJson("api/v1/users/$user->id", [
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

    public function test_user_cannot_update_data_from_another_user(): void
    {
        $user = User::factory()->create();
        $anotherUser =  User::factory()->create();

        Sanctum::actingAs($user);

        $this->putJson("api/v1/users/$anotherUser->id", [
            'email' => 'test@email.com',
            'password' => '12345678'
        ])
            ->assertForbidden();
    }
}
