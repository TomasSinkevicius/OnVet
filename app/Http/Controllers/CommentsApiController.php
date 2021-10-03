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
            'title' => 'required',
            'content'=> 'required',
        ]);

        return Comment::create([
            'title'=> request('title'),
            'content' => request('content'),
        ]);
    }

    public function update(Comment $comment){

        request()->validate([
            'title' => 'required',
            'content'=> 'required',
        ]);


        $comment->update([
            'title'=>request('title'),

            'content'=>request('content'),
        ]);
    }

    public function destroy(Comment $comment){

        $success = $comment->delete();

    return [
        'success'=> $success
    ];
    }
}
