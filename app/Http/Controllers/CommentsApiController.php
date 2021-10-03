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

        // request()->validate([
        //     'author_name' => 'required',
        //     'comment_text'=> 'required',
        //     'post_id'=>'required',
        // ]);

        return Comment::create([
            'author_name'=> request('author_name'),
            'comment_text' => request('comment_text'),
            'post_id' => request('post_id'),
        ]);
    }

    public function update(Comment $comment){

        request()->validate([
            'author_name' => 'required',
            'comment_text'=> 'required',
            'post_id'=>'required',
        ]);

        if($comment->exists()){
            $comment->update([
                'author_name'=> request('author_name'),
                'comment_text' => request('comment_text'),
                'post_id' => request('post_id'),
            ]);

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        }

        else {return response()->json([
            "message" => "Student not found"
        ], 404);}

    }

    public function destroy(Comment $comment){

        $success = $comment->delete();

    return [
        'success'=> $success
    ];
    }
}
