<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogMessage extends Model
{
    use HasFactory;

    protected $guarded;

    public function replies(){
        return $this->hasMany(BlogMessageReply::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
