<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_text',
        'answer_type',
        'options',
    ];

    protected $casts = [
        'options' => 'array', // options को JSON के रूप में कास्ट करें
    ];
}
