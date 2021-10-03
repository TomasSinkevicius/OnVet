<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicsApiController extends Controller
{
    public function index(){

        return Topic::all();
    }

    public function getTopic($id){

        // if ($topic->exists()) {
        //     $topic->toJson(JSON_PRETTY_PRINT);
        //     return response($topic, 200);
        //   } else {
        //     return response()->json([
        //       "message" => "Post not found"
        //     ], 404);
        //   }


          if (Topic::where('id', $id)->exists()) {
            $topic = Topic::where('id', $id)->get();
            return response($topic, 200);
          } else {
            return response()->json([
              "message" => "Topic not found"
            ], 404);
          }
    }



    public function store(){

        request()->validate([
            'title' => 'required',
        ]);

        return Topic::create([
            'title'=> request('title'),
        ]);
    }

    public function update(Request $request, $id){

        if (Topic::where('id', $id)->exists()) {
            $topic = Topic::find($id);
            $topic->title = is_null($request->title) ? $topic->title : $request->title;
            $topic->save();

            return response()->json([
                "message" => "topic updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "topic not found"
            ], 404);

        }
    }

    public function destroy($id){

        if(Topic::where('id', $id)->exists()) {
            $topic = Topic::find($id);
            $topic->delete();

            return response()->json([
              "message" => "topic deleted"
            ], 202);
          } else {
            return response()->json([
              "message" => "topic not found"
            ], 404);
          }
    }

}
