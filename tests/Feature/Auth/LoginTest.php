<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    public function test_user_can_login_with_valid_credentials(): void
    {
        User::factory()->create([
            'email' => 'user@user.com',
        ]);

        $response =  $this->postJson('/api/v1/auth/login', [
            'email' => 'user@user.com',
            'password' => 'password'
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

        $response =  $this->postJson('/api/v1/auth/login', [
            'email' => 'user@user.com',
            'password' => 'wrongpassword'
        ]);

        $response
            ->assertUnauthorized()
            ->assertJsonStructure(['message']);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/logout');

        $response
            ->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertEmpty($user->tokens);
    }

    public function test_unauthenticated_user_cannot_logout(): void
    {
        $response = $this->postJson('/api/v1/auth/logout');

        $response->assertUnauthorized();
    }
}
