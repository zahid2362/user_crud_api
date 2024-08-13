<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_all_user(): void
    {
        $response = $this->get('/api/user');

        $response->assertStatus(200)->assertJson(
            fn (AssertableJson $json) =>
            $json->whereType('success', 'boolean')
                ->whereType('data', 'array')
        );
    }

    public function test_create_user_with_empty_body(): void
    {
        $response = $this->postJson('/api/user', []);
        $response->assertStatus(422);
    }

    public function test_create_user_with_partial_data(): void
    {
        $data = [
            'name' => 'demo',
            'email' => 'example@example.com',
        ];
        $response = $this->postJson('/api/user', $data);

        $response->assertStatus(422);
    }

    public function test_create_user_with_wrong_data(): void
    {
        $data = [
            'name' => 'demo',
            'password' => '1345',
            'email' => 'example',
        ];
        $response = $this->postJson('/api/user', $data);

        $response->assertStatus(422);
    }

    public function test_create_user_with_data(): void
    {
        $data = [
            'name' => 'demo',
            'password' => '12345',
            'email' => rand(1111, 9999).'@example.com',
        ];
        $response = $this->postJson('/api/user', $data);

        $response->assertStatus(200);
    }

    public function test_get_single_user_data_id_not_found(): void
    {
        $id = 1;
        $response = $this->get('/api/user/'.$id);
        $response->assertStatus(404);
    }

    public function test_get_single_user_data(): void
    {
        $user = User::first();
        $response = $this->get('/api/user/'.$user->id);
        $response->assertStatus(200);
    }

    public function test_update_user_data(): void
    {
        $data = [
            'name' => 'demo',
            'password' => '12345',
            'email' => rand(1111, 9999).'@example.com',
            '_method' => 'PUT'
        ];
        $user = User::first();
        $response = $this->postJson('/api/user/'.$user->id, $data);
        $response->assertStatus(200);
    }

    public function test_delete_user_data(): void
    {
        $user = User::first();
        $response = $this->delete('/api/user/'.$user->id);
        $response->assertStatus(200);
    }

    public function test_delete_user_data_id_not_found(): void
    {
        $id = 1;
        $response = $this->delete('/api/user/'.$id);
        $response->assertStatus(404);
    }

}