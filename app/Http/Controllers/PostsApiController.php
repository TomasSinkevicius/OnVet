<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostsApiController extends Controller
{
    //
    public function index(){

        return Post::all();
    }

    public function getPost(Post $post){

        if ($post->exists()) {
            $post->toJson(JSON_PRETTY_PRINT);
            return response($post, 200);
          } else {
            return response()->json([
              "message" => "Post not found"
            ], 404);
          }
    }

    public function store(){

        request()->validate([
            'title' => 'required',
            'content'=> 'required',
            'topic_id'=> 'required',
        ]);

        return Post::create([
            'title'=> request('title'),
            'content' => request('content'),
            'topic_id' => request('topic_id'),
        ]);
    }

    public function update(Post $post){

        $post->update([
            'title'=>request('title'),
            'content'=>request('content'),
            'topic_id'=>request('topic_id'),
        ]);
    }

    public function destroy(Post $post){

        $success = $post->delete();

    return [
        'success'=> $success
    ];
    }
}
