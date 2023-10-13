<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'email' => 'test@email.com',
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword'
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure(['access_token']);
    }

    public function test_user_cannot_register_with_invalid_data()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'email' => 'test@email.com',
            'password' => 'testpassword',
            'password_confirmation' => 'wrongpassword'
        ]);

        $response->assertUnprocessable();
    }
}
