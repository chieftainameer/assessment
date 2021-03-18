<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Invitation;
use App\Models\User;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/send-mail',[App\Http\Controllers\MailController::class,'inviteUser']);
Route::get('/invitations',function(){
return response()->json(['users' => Invitation::all()]);
});
Route::get('/all_users',function(){
    return response()->json(['users' => User::all()]);
    });
Route::post('/registration',[App\Http\Controllers\UsersController::class,'register']);
Route::post('/block',[App\Http\Controllers\UsersController::class,'block']);
