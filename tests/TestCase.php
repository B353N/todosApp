<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function register_test_user()
    {
        // Register a new user
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        // Assert that the request was successful
        $response->assertStatus(200);
    }

    public function login_test_user()
    {
        // Register a new user
        $this->register_test_user();

        // Log in with the registered user's credentials
        $response = $this->postJson('/api/login', [
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        // Assert that the request was successful
        $response->assertStatus(200);

        return $response;
    }
}
