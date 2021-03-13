<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogMessageReply extends Model
{
    use HasFactory;

    protected $guarded;

    public function blogmessage(){
        return $this->belongsTo(BlogMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
