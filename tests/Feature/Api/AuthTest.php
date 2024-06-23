<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test the registration endpoint.
     */
    public function test_register(): void
    {
        // Make a POST request to the register endpoint
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        // Assert that the request was successful
        $response->assertStatus(200);
    }

    /**
     * Test register validation.
     *
     */
    public function test_register_validation(): void
    {
        // Make a POST request to the register endpoint
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'asdafs',
            'password' => 'password',
        ]);

        // Assert that the request was unsuccessful
        $response->assertStatus(422);

        // Assert that the error message is 'The email field must be a valid email address.'
        $response->assertJsonPath('error.message.email.0', 'The email field must be a valid email address.');
    }

    /**
     * Test the login endpoint.
     */
    public function test_login(): void
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
    }

    /**
     * Test login validation.
     *
     */
    public function test_login_validation(): void
    {
        // Make a POST request to the login endpoint
        $response = $this->postJson('/api/login', [
            'email' => 'testtest.com',
            'password' => 'password',
        ]);

        // Assert that the request was unsuccessful
        $response->assertStatus(422);

        // Assert that the error message is 'The email field must be a valid email address.'
        $response->assertJsonPath('error.message.email.0', 'The email field must be a valid email address.');
    }

    /**
     * Test login authentication.
     *
     */
    public function test_login_authentication(): void
    {
        // Make a POST request to the login endpoint
        $response = $this->postJson('/api/login', [
            'email' => 'test@test.com',
            'password' => 'password123'
        ]);

        // Assert that the request was unsuccessful
        $response->assertStatus(401);

        // Assert that the error message is 'Unauthorized'
        $response->assertJsonPath('error.message', 'Unauthorized');
    }

    /**
     * Test the logout endpoint.
     */
    public function test_logout(): void
    {
        // Register a new user and login
        $loginResponse = $this->login_test_user();

        // Assert that the login was successful
        $loginResponse->assertJsonStructure(['authorisation' => ['token']]);

        // Extract the token from the login response
        $token = $loginResponse->json('authorisation.token');

        // Use the token to make a request to the logout endpoint
        $logoutResponse = $this->postJson('/api/logout', ['Authorization' => 'Bearer '.$token], ['Accept' => 'application/json']);

        // Assert that the request was successful
        $logoutResponse->assertStatus(200);
    }

    /**
     * Test refresh token endpoint.
     *
     */
    public function test_refresh_token(): void
    {
        // Register a new user and login
        $loginResponse = $this->login_test_user();

        // Assert that the login was successful
        $loginResponse->assertJsonStructure(['authorisation' => ['token']]);

        // Extract the token from the login response
        $token = $loginResponse->json('authorisation.token');

        // Use the token to make a request to the refresh endpoint
        $refreshResponse = $this->postJson('/api/refresh', ['Authorization' => 'Bearer '.$token], ['Accept' => 'application/json']);

        // Assert that the request was successful
        $refreshResponse->assertStatus(200);
    }

    /**
     * Test expired token.
     *
     */
    public function test_expired_token(): void
    {
        // Register a new user and login
        $loginResponse = $this->login_test_user();

        // Assert that the login was successful
        $loginResponse->assertJsonStructure(['authorisation' => ['token']]);

        // Extract the token from the login response
        $token = $loginResponse->json('authorisation.token');

        // Sleep for 20161 seconds to make the token expire
        \Carbon\Carbon::setTestNow(\Carbon\Carbon::now()->addDays(15));

        // Use the expired token to make a request to the refresh endpoint
        $refreshResponse = $this->postJson('/api/refresh', ['Authorization' => 'Bearer '.$token], ['Accept' => 'application/json']);

        // Assert that the request was unsuccessful
        $refreshResponse->assertStatus(401);

        // Reset the Carbon instance
        \Carbon\Carbon::setTestNow();
    }
}
