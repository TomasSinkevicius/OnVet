<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentsApiController extends Controller
{
    //
    public function index()
    {

        return Comment::all();
    }

    public function store()
    {

        $isGuest = auth()->guest();

        //Checks if user is logged in.
        if (!$isGuest)
        {
            $user_id = auth()->user()->id;

            //Checks if post with id declared in the request exists.
            if (Post::where('id', request('post_id'))
                ->exists())
            {
                return Comment::create(['author_name' => request('author_name') , 'comment_text' => request('comment_text') , 'post_id' => request('post_id') , 'user_id' => $user_id, ]);
            }
            else
            {
                return response()->json(["message" => "Post not found"], 404);
            }
        }
        else
        {
            return response()
                ->json(["message" => "Unauthorized"], 401);
        }
    }

    public function getComment($id)
    {

        if (Comment::where('id', $id)->exists())
        {
            $comment = Comment::where('id', $id)->get();
            return response($comment, 200);
        }
        else
        {
            return response()->json(["message" => "Comment not found"], 404);
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

            //Checks if comment exists
            if (Comment::where('id', $id)->exists())
            {
                $comment = Comment::find($id);

                //Checks if its current users comment or its an admin trying to update.
                if ($user_id == $comment->user_id || $user_role == 0)
                {

                    $comment->author_name = is_null($request->author_name) ? $comment->author_name : $request->author_name;
                    $comment->comment_text = is_null($request->comment_text) ? $comment->comment_text : $request->comment_text;
                    // $comment->post_id = is_null($request->post_id) ? $comment->post_id : $request->post_id;
                    $comment->post_id = $comment->post_id;
                    $comment->user_id = $comment->user_id;
                    $comment->save();

                    return response()
                        ->json(["message" => "Comment updated successfully"], 200);
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
                    ->json(["message" => "Comment not found"], 404);
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

            //Checks if comment exists
            if (Comment::where('id', $id)->exists())
            {

                $comment = Comment::find($id);

                //Checks if its current users comment or its an admin trying to update.
                if ($user_id == $comment->user_id || $user_role == 0)
                {

                    $comment->delete();

                    return response()
                        ->json(["message" => "Comment deleted"], 202);
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
                    ->json(["message" => "Comment not found"], 404);
            }
        }
        else
        {
            return response()
                ->json(["message" => "Unauthorized"], 401);
        }
    }
}

