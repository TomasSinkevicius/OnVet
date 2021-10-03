<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsApiController extends Controller
{
    //
    public function index(){

        return Comment::all();
    }

    public function store(){

        request()->validate([
            'username' => 'required',
            'comment_text'=> 'required',
            'post_id'=>'required',
        ]);

        return Comment::create([
            'username'=> request('title'),
            'comment_text' => request('content'),
            'post_id' => request('content'),
        ]);
    }

    public function update(Comment $comment){

        request()->validate([
            'username' => 'required',
            'comment_text'=> 'required',
            'post_id'=>'required',
        ]);


        $comment->update([
            'username'=> request('title'),
            'comment_text' => request('content'),
            'post_id' => request('content'),
        ]);
    }

    public function destroy(Comment $comment){

        $success = $comment->delete();

    return [
        'success'=> $success
    ];
    }
}
