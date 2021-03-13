<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCourseResource;
use Illuminate\Http\Request;
use App\Models\UserCourse;

class UserCourseController extends Controller
{
    //

    public function store(Request $request){
        $data = $request->validate([
            "course_id" => 'required | numeric'
        ]);

        $data['user_id'] = $request->user()->id;
        $data['status']= false;

        $usercourse = UserCourse::create($data);

        return new UserCourseResource($usercourse);
    }
}
