<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_all_user(): void
    {
        $response = $this->get('/api/user');

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
            $json->whereType('success', 'boolean')
                ->whereType('data', 'array')
        );
    }

    public function test_create_with_empty_body_user(): void
    {
        $response = $this->postJson('/api/user', [
            'name' => 'asdf',
            'email' => 'example@example.com',
        ]);
        
        //$response->assertStatus(422); // Assuming validation should fail
        
        dump($response->json()); // Inspect the validation errors
        
    }
}