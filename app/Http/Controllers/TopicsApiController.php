<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;

class TopicsApiController extends Controller
{
    public function index(){

        return Topic::all();
    }

    public function store(){

        request()->validate([
            'title' => 'required',
            'content'=> 'required',
        ]);

        return Topic::create([
            'title'=> request('title'),
            'content' => request('content'),
        ]);
    }

    public function update(Topic $topic){

        request()->validate([
            'title' => 'required',
            'content'=> 'required',
        ]);


        $topic->update([
            'title'=>request('title'),

            'content'=>request('content'),
        ]);
    }

    public function destroy(Topic $topic){

        $success = $topic->delete();

    return [
        'success'=> $success
    ];
    }
}
