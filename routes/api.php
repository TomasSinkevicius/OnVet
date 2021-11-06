<?php

use App\Models\Post;
use App\Models\Topic;
use App\Models\Comment;
use App\Http\Controllers\PostsApiController;
use App\Http\Controllers\CommentsApiController;
use App\Http\Controllers\TopicsApiController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::get('/posts', [PostsApiController::class, 'index']);

Route::get('/posts/{post}', [PostsApiController::class, 'getPost']);

Route::post('/posts',[PostsApiController::class,'store']);

Route::put('/posts/{post}',[PostsApiController::class,'update']);

Route::delete('/posts/{post}',[PostsApiController::class,'destroy']);

Route::get('/posts/{post}/comments',[PostsApiController::class,'getPostComments']);




Route::get('/topics', [TopicsApiController::class, 'index']);

Route::get('/topics/{topic}', [TopicsApiController::class, 'getTopic']);

Route::post('/topics',[TopicsApiController::class,'store']);

Route::put('/topics/{topic}',[TopicsApiController::class,'update']);

Route::delete('/topics/{topic}',[TopicsApiController::class,'destroy']);


Route::get('/comments', [CommentsApiController::class, 'index']);

Route::get('/comments/{comment}', [CommentsApiController::class, 'getComment']);

Route::post('/comments',[CommentsApiController::class,'store']);

Route::put('/comments/{comment}',[CommentsApiController::class,'update']);

Route::delete('/comments/{comment}',[CommentsApiController::class,'destroy']);





