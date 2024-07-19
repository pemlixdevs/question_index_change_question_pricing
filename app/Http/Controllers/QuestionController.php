<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //

    public function index()
{
    $questions = Question::all();
    return view('questions.index', compact('questions'));
}

    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_text' => 'required|string',
            'answer_type' => 'required|in:dropdown,text,radio,checkbox,date,time',
            'options' => 'nullable|array',
            'options.*.option' => 'required_with:options|string',
            'options.*.price' => 'required_if:answer_type,dropdown,radio,checkbox|numeric',
        ]);

        $data = $request->only('question_text', 'answer_type');
        $data['options'] = json_encode($request->options);

        Question::create($data);

        return redirect()->route('questions.create')->with('success', 'Question created successfully');
    }
}
