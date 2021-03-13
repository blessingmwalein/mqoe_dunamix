<?php

namespace App\Http\Controllers;

use App\Models\GalleryComments;
use Illuminate\Http\Request;

class GalleryCommentsController extends Controller
{
    //

    public function store(Request $request){

        $data = $request->validate([
            'gallery_id' => 'required | numeric',
            'user_id' => 'required | numeric',
            'comment' => 'required | string'
        ]);
        $comment = GalleryComments::create($data);
        return $comment;
    }
}
