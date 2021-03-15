<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCourseResource;
use App\Models\Course;
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
        $course= Course::find($data['course_id'])->first();

        $transaction = $this->initiateTransaction($course->price, "course", $request->mobile,$request->mobile,"paynow");

	    if($transaction === null){
		    return $this->jsonError("Problem connecting to the PSP",500);
	    }
	    else if($transaction instanceof Transaction){
	    	
            return UserCourse::create($data);
	    }
	    else if($transaction instanceof ConnectionException){
		    return $this->jsonError($transaction->getMessage(),500);
	    }
        return new UserCourseResource($usercourse);
    }


}
