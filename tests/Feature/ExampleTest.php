<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function get_all_user_response(): void
    {
        $response = $this->get('/api/user');

        $response->assertStatus(000);
    }
}