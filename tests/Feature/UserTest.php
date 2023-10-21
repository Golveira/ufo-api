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
}
