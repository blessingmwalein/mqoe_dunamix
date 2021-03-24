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
        // $course= Course::find($data['course_id'])->first();
        $course = Course::where('id', '=', $data['course_id'])->first();
        $type = "course";

        // return $course;
        // var_dump($course);
        try{

            if(env("APP_DEBUG")) {
                $payment = $this->paynow()->createPayment($type.uniqid(), 'bmwale2000000@gmail.com');
                $payment->add('Course Payment',$course->price);
                $response = $this->paynow()->sendMobile($payment, '0771111111', 'ecocash');
                // var_dump($response);
                if($response->success()) {
                    // Get the poll url (used to check the status of a transaction). You might want to save this in your DB
                    $pollUrl = $response->pollUrl();
                    // Get the instructions
                    $instrutions = $response->instructions();
                    // var_dump($instrutions);
                    $status = $this->paynow()->pollTransaction($pollUrl);

                    if($status->paid()) {
                      $usercourse = UserCourse::create($data);
                      return response()->json(['course'=> $usercourse, 'pollUrl'=> $pollUrl, 'instructions'=> $instrutions, 'status' => $status]);
                    }

                    return response()->json(['pollUrl'=> $pollUrl, 'instructions'=> $instrutions, 'status' => $status]);
                }
            }else{
                $payment = $this->paynow()->createPayment($type.uniqid(), $request->user()->email);
                $payment->add('Course Payment',$course->price);
                $response = $this->paynow()->sendMobile($payment, $request->mobile_number, 'ecocash');
                // var_dump($response);
                if($response->success()) {
                    // Get the poll url (used to check the status of a transaction). You might want to save this in your DB
                    $pollUrl = $response->pollUrl();
                    // Get the instructions
                    $instrutions = $response->instructions();
                    // var_dump($instrutions);
                    $status = $this->paynow()->pollTransaction($pollUrl);

                    if($status->paid()) {
                      $usercourse = UserCourse::create($data);
                      return response()->json(['course'=> $usercourse, 'pollUrl'=> $pollUrl, 'instructions'=> $instrutions, 'status' => $status]);
                    }

                    return response()->json(['pollUrl'=> $pollUrl, 'instructions'=> $instrutions, 'status' => $status]);
                }
            }


        }  catch (ConnectionException $e){
            return $e;
        } catch (HashMismatchException $e) {
            return $e;
        } catch (InvalidIntegrationException $e) {
            return $e;
        } catch (NotImplementedException $e) {
            return $e;
        }

        // $transaction = $this->initiateTransaction($course->price, "course", $request->mobile,$request->mobile,"paynow");

	    // if($transaction === null){
		//     return $this->jsonError("Problem connecting to the PSP",500);
	    // }
	    // else if($transaction instanceof Transaction){

        //     return UserCourse::create($data);
	    // }
	    // else if($transaction instanceof ConnectionException){
		//     return $this->jsonError($transaction->getMessage(),500);
	    // }
        // return new UserCourseResource($usercourse);
    }
    public function getPllUrlStatus(Request $request){

        $status = $this->paynow()->pollTransaction($request->pollUrl);

        $data = $request->validate([
            'course_id' => 'required'
        ]);
        $data['user_id'] = $request->user()->id;
        $data['status'] = true;

        if($status->paid()) {
            $course = UserCourse::create($data);
            return response()->json(['message'=> 'paid', 'course'=>$course]);
        } else {
            return response()->json(['message'=> 'canceled']);
        }
    }
}
