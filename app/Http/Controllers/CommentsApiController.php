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

        return Comment::create([
            'author_name'=> request('author_name'),
            'comment_text' => request('comment_text'),
            'post_id' => request('post_id'),
        ]);
    }

    public function getComment($id){

          if (Comment::where('id', $id)->exists()) {
            $comment = Comment::where('id', $id)->get();
            return response($comment, 200);
          } else {
            return response()->json([
              "message" => "Comment not found"
            ], 404);
          }
    }

    public function update(Request $request, $id){

        if (Comment::where('id', $id)->exists()) {
            $comment = Comment::find($id);
            $comment->author_name = is_null($request->author_name) ? $comment->author_name : $request->author_name;
            $comment->comment_text = is_null($request->comment_text) ? $comment->comment_text : $request->comment_text;
            $comment->post_id = is_null($request->post_id) ? $comment->post_id : $request->post_id;
            $comment->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);

        }

    }

    public function destroy($id){

        if(Comment::where('id', $id)->exists()) {
            $comment = Comment::find($id);
            $comment->delete();

            return response()->json([
              "message" => "Comment deleted"
            ], 202);
          } else {
            return response()->json([
              "message" => "Comment not found"
            ], 404);
          }
    }
}
