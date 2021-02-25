<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;


class AuthController extends Controller
{
    public function login(Request $request)
	{
	  try {
		    $request->validate([
		      "email" => "email|required",
		      "password" => "required"
		    ]);
		    $credentials = request(["email", "password"]);
		    if (!Auth::attempt($credentials)) {
		      return response()->json([
		        "status_code" => 500,
		        "message" => "Unauthorized"
		      ]);
		    }
		    $user = User::where("email", $request->email)->first();
		    if ( ! Hash::check($request->password, $user->password, [])) {
		       throw new \Exception("Error in Login");
		    }
		    $tokenResult = $user->createToken("authToken")->plainTextToken;
		    return response()->json([
		      "status_code" => 200,
		      "access_token" => $tokenResult,
		      "token_type" => "Bearer",
              "user" => new UserResource($user)
	    ]);
	  } catch (Exception $error) {
	    return response()->json([
	      "status_code" => 500,
	      "message" => "Error in Login",
	      "error" => $error,
	    ]);
	  }
	}

	 public function register(Request $request)
    {
    	try {
    		$validatedData = $request->validate([
	            'name' => 'required|max:55',
	            'email' => 'email|required|unique:users',
	            'password' => 'required|confirmed'
	        ]);

	        $validatedData['password'] = bcrypt($request->password);

	        $user = User::create($validatedData);

		    $tokenResult = $user->createToken("authToken")->plainTextToken;
		    return response()->json([
			      "status_code" => 200,
			      "access_token" => $tokenResult,
			      "token_type" => "Bearer",
			      "status" => "user created",
                  "user"=> new UserResource($user)
		    ]);
    	}catch (Exception $error) {
		    return response()->json([
		      "status_code" => 500,
		      "message" => "Error in Login",
		      "error" => $error,
		    ]);
		  }
	    }

        public function user(Request  $request){
            return new UserResource(auth()->user);
        }
}
