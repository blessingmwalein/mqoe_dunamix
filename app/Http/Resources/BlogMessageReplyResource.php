<?php

namespace App\Http\Resources;

use App\Models\BlogMessage;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogMessageReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'user_id' =>$this->user_id,
            'user'=>$this->user,
            'blog_message_id'=>$this->blog_message_id,
            'blog_message' =>new BlogMessageResource(BlogMessage::find($this->blog_message_id)->first()),
            'reply'=> $this->reply
        ];
    }
}
