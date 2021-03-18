<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\UserInvitation;
use Illuminate\Support\Facades\Mail;
use App\Models\Invitation;

class MailController extends Controller
{
    public function inviteUser(Request $req){
        $details = [
            'title' => 'Mail from Laravel Assessment',
            'body' => 'This is for testing email using smtp mailtrap',
            'email' => $req->email,
        ];
       
        Mail::to($req->email)->send(new UserInvitation($details));
            $invitation = Invitation::create(['email' => $req->email]);
            if($invitation){
                return response()->json(['message' => 'Invitation has been sent']);
            }
            else
            {
                return response()->json(['message' => 'Invitation Couldn\'t be sent']);
            }
        
    }
}
