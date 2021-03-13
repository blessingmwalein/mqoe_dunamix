<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogMessageResource;
use Illuminate\Http\Request;
use App\Models\BlogMessage;

class BlogMessageController extends Controller
{
    //
    public function index(){
        return BlogMessageResource::collection(BlogMessage::paginate(20));
    }

    public function store(Request $request){
        $data = $request->validate([
            'message' =>'required | string',
        ]);

        $data['user_id'] = $request->user()->id;
        $blog_message = BlogMessage::create($data);

        return new BlogMessageResource($blog_message);

    }
}
