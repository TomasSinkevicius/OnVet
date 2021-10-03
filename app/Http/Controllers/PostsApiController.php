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

        request()->validate([
            'title' => 'required',
            'content'=> 'required',
            'topic_id'=> 'required',
        ]);


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
