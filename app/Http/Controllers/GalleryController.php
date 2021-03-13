<?php

namespace App\Http\Controllers;

use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    //

    public function index(){
        return GalleryResource::collection(Gallery::paginate(20));
    }

    public function show(Gallery $gallery, Request $request){

        return new GalleryResource($gallery);
    }


}
