<?php

namespace Tests\Feature;

use App\Models\User;
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
}
