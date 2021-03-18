<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Invitation;
use App\Jobs\WelcomeJob;
use  Image;

class UsersController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:2048',
            'email' => 'required',
            'password' => 'required|min:8',
            'name' => 'required|string',
         ]);
         

         if ($request->has('file')){
            $image = $request->file('file');

            $imageName = $image->getClientOriginalName();
            $imageName = time().'_avatar_'.$imageName;
            $avatar_path = 'images/'.$imageName;

            $admin_thumb = $image->getClientOriginalName();
            $admin_thumb = time().'_large_'.$admin_thumb;
            $thumb_path = 'images/'.$admin_thumb;

            //////  image uploading and resizing

            Image::make($image)
            ->resize(256,256)
            ->save(public_path('./images/'.$admin_thumb));

            Image::make($image)
            ->resize(64,64)
            ->save(public_path('./images/'.$imageName));

            ///// image uploading and resizing

         $user = User::create(['name' => $request->name,'email' => $request->email,'password' => Hash::make($request->password),'avatar' => $avatar_path,'for_admin' => $thumb_path]);
         if($user){
             $inv = Invitation::where('email',$request->email)->first();
             $inv->invite_status = 1;
             $inv->save();

             // dispatching a job after 5 mins of account createtion

             WelcomeJob::dispatch($request->name,$request->email)->delay(now()->addMinutes(5)); 

             return response()->json(['message' => 'Registered successfully']);
         }
         else
         {
             return response()->json(['message' => 'User Were not created']);
         }
    }
}

    public function block(Request $req){
        $user = User::where('email',$req->email)->first();
        $user->status = 0;
        $user->save();

        return response()->json(['message' => 'user has been blocked']);
    }

}
