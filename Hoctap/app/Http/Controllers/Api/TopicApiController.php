<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = \App\Models\Topic::all();
        return response()->json($topics);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name'   => ['required','string','max:255'],
            'slug'   => ['sometimes','nullable','string','max:255'],
            'user_id' => ['sometimes','nullable','string'],
        ]);

        $userId = auth()->check() ? (auth()->user()->usergmail ?? null) : ($data['user_id'] ?? null);
        if (!$userId) {
            return response()->json([
                'error' => 'user_id required (or provide an authenticated user)'
            ], 422);
        }
        $topic = Topic::create([
            'user_id' => $userId,
            'name'    => $data['name'],
            'slug'    => $data['slug'] ?? null,
        ]);

        return response()->json($topic, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $topic = \App\Models\Topic::find($id);
        if (!$topic) {
            return response()->json(['error' => 'Topic not found'], 404);
        }
        return response()->json($topic);
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
