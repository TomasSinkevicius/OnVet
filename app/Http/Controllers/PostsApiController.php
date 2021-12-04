<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Topic;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class PostsApiController extends Controller
{
    //
    public function index()
    {

        return Post::all();
    }

    public function getPost($id)
    {

        if (Post::where('id', $id)->exists())
        {
            $post = Post::where('id', $id)->get();
            return response($post, 200);
        }
        else
        {
            return response()->json(["message" => "Post not found"], 404);
        }
    }

    public function store()
    {

        request()
            ->validate(['title' => 'required', 'content' => 'required', 'topic_id' => 'required', ]);

        $isGuest = auth()->guest();

        //Checks if user is logged in.
        if (!$isGuest)
        {
            $user_id = auth()->user()->id;

            if (Topic::where('id', request('topic_id'))
                ->exists())
            {
                return Post::create(['title' => request('title') , 'content' => request('content') , 'topic_id' => request('topic_id') , 'user_id' => $user_id, ]);
            }
            else
            {
                return response()->json(["message" => "Topic not found"], 404);
            }
        }
        else
        {
            return response()
                ->json(["message" => "Unauthorized"], 401);
        }
    }

    public function update(Request $request, $id)
    {

        $isGuest = auth()->guest();

        //Checks if user is logged in.
        if (!$isGuest)
        {

            $user_id = auth()->user()->id;
            $user_role = auth()->user()->role;

            if (Post::where('id', $id)->exists())
            {

                $post = Post::find($id);

                //Checks if its current users post or its an admin trying to update.
                if ($user_id == $post->user_id || $user_role == 1)
                {

                    $post->title = is_null($request->title) ? $post->title : $request->title;
                    $post->content = is_null($request->content) ? $post->content : $request->content;
                    // $post->topic_id = is_null($request->topic_id) ? $post->topic_id : $request->topic_id;
                    $post->topic_id = $post->topic_id;
                    $post->user_id = $post->user_id;
                    $post->save();

                    return response()
                        ->json(["message" => "Post updated successfully", "post" => $post], 200);
                }
                else
                {
                    return response()->json(["message" => "Unauthorized"], 401);
                }
            }
            else
            {
                return response()
                    ->json(["message" => "Post not found"], 404);
            }
        }
        else
        {
            return response()
                ->json(["message" => "Unauthorized"], 401);
        }

    }

    public function destroy($id)
    {

        $isGuest = auth()->guest();

        //Checks if user is logged in.
        if (!$isGuest)
        {

            $user_id = auth()->user()->id;
            $user_role = auth()->user()->role;

            if (Post::where('id', $id)->exists())
            {

                $post = Post::find($id);

                //Checks if its current users post or its an admin trying to delete.
                if ($user_id == $post->user_id || $user_role == 0)
                {

                    $post->delete();

                    return response()
                        ->json(["message" => "post deleted"], 202);
                }

                else
                {
                    return response()
                        ->json(["message" => "Unauthorized"], 401);
                }

            }
            else
            {
                return response()
                    ->json(["message" => "post not found"], 404);
            }
        }
        else
        {
            return response()
                ->json(["message" => "Unauthorized"], 401);
        }
    }

    public function getPostComments($id, Comment $comments)
    {
        if (Post::where('id', $id)->exists())
        {
            $post = Post::where('id', $id)->get();
            return response(($comments = Comment::where('post_id', $id)->get()) , 200);
        }
        else
        {
            return response()
                ->json(["message" => "Post not found"], 404);
        }
    }
}

