<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\QueryBuilder;

class TodoController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all todos for this user
        $todos = QueryBuilder::for(Todo::class)
                ->where('user_id', auth()->id())
                ->allowedFilters(['title', 'description', 'status'])
                ->allowedSorts(['title', 'status', 'created_at'])
                ->orderBy('created_at', 'desc')
                ->jsonPaginate();

        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|string|in:pending,completed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->respondWithError($e->errors(), 'VALIDATION_ERROR', 422);
        }

        // Create a new todo
        $todo = new Todo($request->only('title', 'description', 'status'));
        $todo->user_id = auth()->id();
        $todo->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Todo created successfully',
            'todo' => $todo,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        // Validate id
        if (!is_numeric($id)) {
            return $this->respondWithError('Invalid ID', 'INVALID_ID', 400);
        }

        // Get the todo
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();

        // Check if todo exists
        if (!$todo) {
            return $this->respondWithError('Todo not found', 'NOT_FOUND', 404);
        }

        // Return the todo
        return response()->json($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate id
        if (!is_numeric($id)) {
            return $this->respondWithError('Invalid id', 'INVALID_ID', 400);
        }
        // Validate the request
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'status' => 'required|string|in:pending,completed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->respondWithError($e->errors(), 'VALIDATION_ERROR', 422);
        }

        // Get the todo
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();

        // Check if todo exists
        if (!$todo) {
            return $this->respondWithError('Todo not found', 'NOT_FOUND', 404);
        }

        // Update the todo
        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        // Return the updated todo
        return response()->json([
            'status' => 'success',
            'message' => 'Todo updated successfully',
            'todo' => $todo,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Validate id
        if (!is_numeric($id)) {
            return $this->respondWithError('Invalid id', 'INVALID_ID', 400);
        }

        // Get the todo
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();

        // Check if todo exists
        if (!$todo) {
            return $this->respondWithError('Todo not found', 'NOT_FOUND', 404);
        }

        // Delete the todo
        $todo->delete();

        // Return success message
        return response()->json([
            'status' => 'success',
            'message' => 'Todo deleted successfully',
        ]);

    }
}
