<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('user/login', [UserController::class, 'login']);
Route::post('user/register', [UserController::class, 'register']);
Route::get('healthcheck', function (Request $request) {
    return response()->json([
        'success' => true,
        'response' => 'ip client: ' . request()->ip()
    ]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return response()->json([
        'success' => true,
        'response' => $request->user()
    ]);
});

Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('detail/{id}', [PostController::class, 'show']);
    Route::get('search', [PostController::class, "search"]);
    Route::get('{postId}/comments', [PostController::class, 'getCommentsByPost']);
});


Route::middleware('auth:api')->group(function () {

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::post('{postId}/like', [PostController::class, 'likePost']);
        Route::post('{postId}/comment', [PostController::class, 'commentPost']);
        Route::put('', [PostController::class, 'createPost']);
    });


    Route::prefix('user')->name('user.')->group(function () {
        Route::post('edit', [UserController::class, 'changeUser']);
        Route::delete('destroy', [UserController::class, "destroy"]);
    });
});
