<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    /**
      * Test login without data.
      */
    public function test_Login_without_data(): void
    {
        $response = $this->postJson('/api/v1/login', []);
        $response->assertJsonValidationErrors(['email', 'password']);
        $response->assertStatus(422);
    }

    /**
     * Test login with invalid credentials.
     */
    public function test_login_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/v1/login', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword',
        ]);
        $response->assertStatus(401);
        $response->assertJson([
            'message' => __('auth.failed'),
            'success' => false,
        ]);
    }

    /**
     * Test login with valid credentials.
     */
    public function test_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'token' => true,
            'profile' => true,
        ]);
    }
}
