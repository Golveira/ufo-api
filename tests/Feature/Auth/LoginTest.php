<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_user_can_login_with_valid_credentials(): void
    {
        User::factory()->create([
            'email' => 'user@user.com',
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'user@user.com',
            'password' => 'password',
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure(['access_token']);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'user@user.com',
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'user@user.com',
            'password' => 'wrongpassword',
        ]);

        $response
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);
    }
}
