<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use Illuminate\Http\Request;

class ChoiceApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $choices = Choice::all();
        return response()->json($choices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'question_id' => ['required','integer','exists:questions,id'],
            'content' => ['required','string','max:1000'],
            'is_correct' => ['nullable','boolean'],
        ]);

        $choice = Choice::create([
            'question_id' => $data['question_id'],
            'content' => $data['content'],
            'is_correct' => (bool)($data['is_correct'] ?? false),
        ]);

        return response()->json($choice, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $choice = Choice::find($id);
        if (!$choice) {
            return response()->json(['error' => 'Choice not found'], 404);
        }
        return response()->json($choice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $choice = Choice::find($id);
        if (!$choice) {
            return response()->json(['error' => 'Choice not found'], 404);
        }

        $data = $request->validate([
            'content' => ['sometimes','string','max:1000'],
            'is_correct' => ['nullable','boolean'],
        ]);

        if (array_key_exists('content', $data)) {
            $choice->content = $data['content'];
        }
        if (array_key_exists('is_correct', $data)) {
            $choice->is_correct = (bool)$data['is_correct'];
        }
        $choice->save();

        return response()->json($choice);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $choice = Choice::find($id);
        if (!$choice) {
            return response()->json(['error' => 'Choice not found'], 404);
        }

        $choice->delete();
        return response()->json(['message' => 'Choice deleted']);
    }
}
