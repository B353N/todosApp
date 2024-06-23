<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Todo;
use Illuminate\Http\Request;
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
            ->jsonPaginate();

        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
