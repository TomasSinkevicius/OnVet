<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class PostsApiController extends Controller
{
    //
    public function index(){

        return Post::all();
    }

    public function getPost($id){

          if (Post::where('id', $id)->exists()) {
            $post = Post::where('id', $id)->get();
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

    public function update(Request $request, $id){

        if (Post::where('id', $id)->exists()) {
            $post = Post::find($id);
            $post->title = is_null($request->title) ? $post->title : $request->title;
            $post->content = is_null($request->content) ? $post->content : $request->content;
            $post->topic_id = is_null($request->topic_id) ? $post->topic_id : $request->topic_id;
            $post->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Post not found"
            ], 404);

        }

    }

    public function destroy($id){


            return response()->json([
                $id
              ], 404);

        // if(Post::where('id', $id)->exists()) {
        //     $post = Post::find($id);
        //     $post->delete();

        //     return response()->json([
        //       "message" => "post deleted"
        //     ], 202);
        //   } else {
        //     return response()->json([
        //       "message" => "post not found"
        //     ], 404);
        //   }
    }

    public function getPostComments($id, Comment $comments){
        if(Post::where('id', $id)->exists()){
            $post = Post::where('id', $id)->get();
            return response((
                $comments = Comment::where('post_id', $id)->get()), 200);
        } else {
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }
    }
}
