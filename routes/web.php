<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PostController::class, 'index'])->name('posts.index');

Route::view('/login', 'auth.login')->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::view('/password/request', 'auth.forgot-password')->name('password.request');
Route::post('/password/request', [AuthController::class, 'getResetEmail']);
Route::get('/password/reset/{token}', [AuthController::class, 'resetForm']);
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.request');

Route::resource('posts', PostController::class)->except('index');

Route::resource('categories', CategoryController::class);

Route::resource('users', UserController::class)->middleware('auth');

Route::apiResource('posts.comments', CommentController::class)->shallow();


