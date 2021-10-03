<?php

use App\Models\Post;
use App\Http\Controllers\PostsApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/posts', [PostsApiController::class, 'index']);

Route::post('/posts',[PostsApiController::class,'store']);

Route::put('/posts/{post}',[PostsApiController::class,'update']);

Route::delete('/posts/{post}',[PostsApiController::class,'destroy']);


Route::get('/topics', [PostsApiController::class, 'index']);

Route::post('/topics',[TopicsApiController::class,'store']);

Route::put('/topics/{topic}',[TopicsApiController::class,'update']);

Route::delete('/topics/{topic}',[TopicsApiController::class,'destroy']);


Route::get('/comments', [CommentsApiController::class, 'index']);

Route::post('/comments',[CommentsApiController::class,'store']);

Route::put('/comments/{topic}',[CommentsApiController::class,'update']);

Route::delete('/comments/{topic}',[CommentsApiController::class,'destroy']);





