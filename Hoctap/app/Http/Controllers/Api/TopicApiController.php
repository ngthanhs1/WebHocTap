<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        //
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
