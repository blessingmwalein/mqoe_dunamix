<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryComments extends Model
{
    use HasFactory;

    protected $guarded;

    protected $with= ['user'];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
