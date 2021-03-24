<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(){
        return CourseResource::collection(Course::paginate(10));
    }

    public function show(Course $course){
        return new CourseResource($course);
    }

    
}
