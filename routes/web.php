<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/posts-view');
});

Route::get('/posts-view', function () {
    return Inertia::render('Posts');
})->name('posts.index');
Route::middleware(['auth'])->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}/', [PostController::class, 'destroy'])->name('posts.destroy');
});
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');


Route::get('/dashboard', function () {
    return redirect('/posts-view');

})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/posts', [PostController::class, 'index']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
