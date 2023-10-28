<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// 帖子
Route::resource('posts', PostController::class);

// 评论
Route::get('posts/{post}/comments', [CommentController::class, 'index'])->name('posts.comments.index');
Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// 点赞
Route::post('posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');
Route::post('comments/{comment}/likes', [LikeController::class, 'store'])->name('comments.likes.store');
Route::delete('comments/{comment}/likes', [LikeController::class, 'destroy'])->name('comments.likes.destroy');

// 关注
Route::post('followees/{followee}/follows', [FollowController::class, 'store'])->name('followees.follows.store');
Route::delete('followees/{followee}/follows', [FollowController::class, 'destroy'])->name('followees.follows.destroy');

// 关注列表
Route::get('users/{user}/follows', [FollowController::class, 'index'])->name('users.follows.index');
Route::put('follows/{follow}', [FollowController::class, 'update'])->name('follows.update');

// 关注分组
// Route::get('users/{user}/follow-groups', [FollowGroupController::class, 'store'])->name('users.follow-groups.store');
// Route::put('follow-groups/{follow-group}', [FollowGroupController::class, 'update'])->name('follow-groups.update');
// Route::delete('follow-groups/{follow-group}', [FollowGroupController::class, 'destroy'])->name('follow-groups.destroy');

// 分类
Route::resource('categories', CategoryController::class);
