<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionResponse;
use Illuminate\Http\Request;

class QuestionResponseController extends Controller
{
    //
    public function create()
    {
        $questions = Question::all();
        return view('responses.create', compact('questions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'responses.*.question_id' => 'required|exists:questions,id',
            'responses.*.response' => 'required|string',
        ]);

        foreach ($request->responses as $responseData) {
            QuestionResponse::create($responseData);
        }

        return redirect()->route('responses.create')->with('success', 'Responses submitted successfully');
    }
}
