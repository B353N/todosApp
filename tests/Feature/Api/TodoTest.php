<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_todo()
    {
        // Make a POST request to the register endpoint
        $loginResponse = $this->login_test_user();

        // Extract the token from the login response
        $token = $loginResponse->json('authorisation.token');

        // Make a POST request to the create todo endpoint
        $response = $this->postJson('/api/todos', [
            'title' => 'Test Todo',
            'description' => 'This is a test todo',
            'status' => 'pending',
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Todo created successfully',
            ]);
    }

    public function test_user_can_get_all_todos()
    {
        // Make a POST request to the register endpoint
        $loginResponse = $this->login_test_user();

        // Extract the token from the login response
        $token = $loginResponse->json('authorisation.token');

        // Make a GET request to the get all todos endpoint
        $response = $this->getJson('/api/todos', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Assert the response
        $response->assertStatus(200);
    }

    public function test_user_can_get_a_todo()
    {
        // Make a POST request to the register endpoint
        $loginResponse = $this->login_test_user();

        // Extract the token from the login response
        $token = $loginResponse->json('authorisation.token');

        // Make a POST request to the create todo endpoint
        $createResponse = $this->postJson('/api/todos', [
            'title' => 'Test Todo',
            'description' => 'This is a test todo',
            'status' => 'pending',
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Extract the todo ID from the create response
        $todoId = $createResponse->json('todo.id');

        // Make a GET request to the get a todo endpoint
        $response = $this->getJson('/api/todos/' . $todoId, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Assert the response
        $response->assertStatus(200);
    }

    public function test_user_can_update_a_todo()
    {
        // Make a POST request to the register endpoint
        $loginResponse = $this->login_test_user();

        // Extract the token from the login response
        $token = $loginResponse->json('authorisation.token');

        // Make a POST request to the create todo endpoint
        $createResponse = $this->postJson('/api/todos', [
            'title' => 'Test Todo',
            'description' => 'This is a test todo',
            'status' => 'pending',
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Extract the todo ID from the create response
        $todoId = $createResponse->json('todo.id');

        // Make a PUT request to the update todo endpoint
        $response = $this->putJson('/api/todos/' . $todoId, [
            'title' => 'Updated Test Todo',
            'description' => 'This is an updated test todo',
            'status' => 'completed',
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Todo updated successfully',
            ]);
    }

    public function test_user_can_delete_a_todo()
    {
        // Make a POST request to the register endpoint
        $loginResponse = $this->login_test_user();

        // Extract the token from the login response
        $token = $loginResponse->json('authorisation.token');

        // Make a POST request to the create todo endpoint
        $createResponse = $this->postJson('/api/todos', [
            'title' => 'Test Todo',
            'description' => 'This is a test todo',
            'status' => 'pending',
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Extract the todo ID from the create response
        $todoId = $createResponse->json('todo.id');

        // Make a DELETE request to the delete todo endpoint
        $response = $this->deleteJson('/api/todos/' . $todoId, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Todo deleted successfully',
            ]);
    }
}
