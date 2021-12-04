<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class TopicsApiController extends Controller
{
    public function index()
    {

        return Topic::all();
    }

    public function test()
    {

        $isGuest = auth()->guest();

        if (!$isGuest)
        {
            $user = auth()->user();
            $user_role = auth()->user()->role;
            return response()
                ->json($user, 200);
        }
        else
        {
            return response()->json(["message" => "Unauthorized"], 401);
        }
    }

    public function getTopic($id)
    {

        if (Topic::where('id', $id)->exists())
        {
            $topic = Topic::where('id', $id)->get();
            return response($topic, 200);
        }
        else
        {
            return response()->json(["message" => "Topic not found"], 404);
        }
    }

    public function store()
    {
        if(request('title') == null){
            return response()
                         ->json(["message" => "Not all data fields filled"], 403);
        }
        else{

        request()
            ->validate(['title' => 'required', ]);

        $isGuest = auth()->guest();

        //Checks if user is logged in.
        if (!$isGuest)
        {
            $user_id = auth()->user()->id;

            return Topic::create(['title' => request('title') , 'user_id' => $user_id, ]);
        }
        else
        {
            return response()->json(["message" => "Unauthorized"], 401);
        }
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

            //Checks if topic exists
            if (Topic::where('id', $id)->exists())
            {

                $topic = Topic::find($id);

                //Checks if its current users topic or its an admin trying to update.
                if ($user_id == $topic->user_id || $user_role == 1)
                {

                    $topic->title = is_null($request->title) ? $topic->title : $request->title;
                    $topic->user_id = $topic->user_id;
                    $topic->save();

                    return response()
                        ->json(["message" => "topic updated successfully"], 200);
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
                    ->json(["message" => "topic not found"], 404);
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

            //Checks if topic exists
            if (Topic::where('id', $id)->exists())
            {

                $topic = Topic::find($id);

                //Checks if its current users topic or its an admin trying to delete.
                if ($user_id == $topic->user_id || $user_role == 1)
                {

                    $topic->delete();

                    return response()
                        ->json(["message" => "topic deleted"], 202);
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
                    ->json(["message" => "topic not found"], 404);
            }
        }
        else
        {
            return response()
                ->json(["message" => "Unauthorized"], 401);
        }
    }

    public function getTopicPosts($id, Post $posts)
    {
        if (Topic::where('id', $id)->exists())
        {
            $topic = Topic::where('id', $id)->get();
            return response(($post = Post::where('topic_id', $id)->get()) , 200);
        }
        else
        {
            return response()
                ->json(["message" => "Topic not found"], 404);
        }
    }

}

