<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogMessageReplyResource;
use App\Http\Resources\BlogMessageResource;
use App\Models\BlogMessageReply;
use Illuminate\Http\Request;

class BlogMessageReplyController extends Controller
{
    //
    public function store(Request $request){
        $data = $request->validate([
            'blog_message_id'=> 'required',
            'reply'=>'required'
        ]);

        $data['user_id'] = $request->user()->id;

        $reply = BlogMessageReply::create($data);
        return new BlogMessageReplyResource($reply);
    }

    public function index(){
        return BlogMessageReplyResource::collection(BlogMessageReply::paginate(20));
    }
}
