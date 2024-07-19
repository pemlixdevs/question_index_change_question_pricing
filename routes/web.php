<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionResponseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/post/order', [PostController::class, 'post_order'])->name('post.post_order');
Route::post('/post/post_order_change', [PostController::class, 'post_order_change'])->name('post.order_change');

Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');


Route::get('/responses/create', [QuestionResponseController::class, 'create'])->name('responses.create');
Route::post('/responses/store', [QuestionResponseController::class, 'store'])->name('responses.store');

