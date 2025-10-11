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
        // Optional filter by user_id (usergmail)
        $topics = Topic::query()
            ->when(request('user_id'), function ($q, $userId) {
                $q->where('user_id', $userId);
            })
            ->get();
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
        $topic = Topic::find($id);
        if (!$topic) {
            return response()->json(['error' => 'Topic not found'], 404);
        }

        // Ownership check: prefer auth user; otherwise require matching user_id in request
        if (auth()->check()) {
            if (($topic->user_id ?? null) !== (auth()->user()->usergmail ?? null)) {
                return response()->json(['error' => 'Forbidden'], 403);
            }
        } else {
            $reqUser = $request->input('user_id');
            if (!$reqUser || $reqUser !== $topic->user_id) {
                return response()->json(['error' => 'Forbidden (owner mismatch or missing user_id)'], 403);
            }
        }

        $data = $request->validate([
            'name' => ['sometimes','string','max:255'],
            'slug' => ['sometimes','nullable','string','max:255'],
        ]);

        $topic->fill($data);
        $topic->save();

        return response()->json($topic);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $topic = Topic::with('questions.choices')->find($id);
        if (!$topic) {
            return response()->json(['error' => 'Topic not found'], 404);
        }

        // Ownership check like update()
        if (auth()->check()) {
            if (($topic->user_id ?? null) !== (auth()->user()->usergmail ?? null)) {
                return response()->json(['error' => 'Forbidden'], 403);
            }
        } else {
            $reqUser = request('user_id');
            if (!$reqUser || $reqUser !== $topic->user_id) {
                return response()->json(['error' => 'Forbidden (owner mismatch or missing user_id)'], 403);
            }
        }

        // Xóa các bản ghi liên quan (phòng khi DB không cascade)
        foreach ($topic->questions as $question) {
            $question->choices()->delete();
        }
        $topic->questions()->delete();

        $topic->delete();

        return response()->json(['message' => 'Topic deleted']);
    }
}
