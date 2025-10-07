<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with('choices')->get();
        return response()->json($questions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'topic_id' => ['required','integer','exists:topics,id'],
            'content'  => ['required','string','max:1000'],
            'choices'  => ['nullable','array'],
            'choices.*.content' => ['required_with:choices','string','max:1000'],
            'choices.*.is_correct' => ['nullable','boolean'],
        ]);

        $question = Question::create([
            'topic_id' => $data['topic_id'],
            'content'  => $data['content'],
        ]);

        if (!empty($data['choices'])) {
            foreach ($data['choices'] as $choiceData) {
                $question->choices()->create([
                    'content' => $choiceData['content'],
                    'is_correct' => (bool)($choiceData['is_correct'] ?? false),
                ]);
            }
        }

        return response()->json($question->load('choices'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = Question::with('choices')->find($id);
        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }
        return response()->json($question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $data = $request->validate([
            'content'  => ['sometimes','string','max:1000'],
            'choices'  => ['nullable','array'],
            'choices.*.id' => ['sometimes','integer'],
            'choices.*.content' => ['required_with:choices','string','max:1000'],
            'choices.*.is_correct' => ['nullable','boolean'],
            'choices.*._delete' => ['nullable','boolean'],
        ]);

        if (array_key_exists('content', $data)) {
            $question->content = $data['content'];
            $question->save();
        }

        if (!empty($data['choices'])) {
            foreach ($data['choices'] as $choiceData) {
                if (!empty($choiceData['_delete']) && !empty($choiceData['id'])) {
                    $question->choices()->where('id', $choiceData['id'])->delete();
                    continue;
                }

                if (!empty($choiceData['id'])) {
                    $question->choices()->where('id', $choiceData['id'])->update([
                        'content' => $choiceData['content'],
                        'is_correct' => (bool)($choiceData['is_correct'] ?? false),
                    ]);
                } else {
                    $question->choices()->create([
                        'content' => $choiceData['content'],
                        'is_correct' => (bool)($choiceData['is_correct'] ?? false),
                    ]);
                }
            }
        }

        return response()->json($question->load('choices'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response()->json(['error' => 'Question not found'], 404);
        }

        $question->choices()->delete();
        $question->delete();

        return response()->json(['message' => 'Question deleted']);
    }
}
