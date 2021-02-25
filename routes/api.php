<?php

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return new UserResource($request->user());
    });
    Route::middleware('auth:sanctum')->post('/blog/store/message', 'App\Http\Controllers\BlogMessageController@store')->name('save-blog-message');
    Route::middleware('auth:sanctum')->get('/blog/view/messages', 'App\Http\Controllers\BlogMessageController@index')->name('view-blog-messages');

    Route::middleware('auth:sanctum')->post('/blog/store/message/reply', 'App\Http\Controllers\BlogMessageReplyController@store')->name('save-blog-message-reply');
    Route::middleware('auth:sanctum')->get('/blog/view/message/replies', 'App\Http\Controllers\BlogMessageReplyController@index')->name('view-blog-messages-replies');
    Route::middleware('auth:sanctum')->post('/user/courses/store', 'App\Http\Controllers\UserCourseController@store')->name('user-course-store');

    Route::post("/login", "App\Http\Controllers\AuthController@login");
    Route::get("/courses/all", "App\Http\Controllers\CourseController@index");
    Route::get("/courses/{course}", "App\Http\Controllers\CourseController@show");
	// Route::middleware(["auth:sanctum"])->group(function () {
	//   Route::get("/users", "UserController@index");
	// });
    Route::post("/register", "App\Http\Controllers\AuthController@register");
});
