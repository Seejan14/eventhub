<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailVerification;
use App\Models\User;
use DB;

class ProfileController extends Controller
{
    public function verifyEmail($token)
    {
        DB::beginTransaction();
        $email = EmailVerification::where('token',$token)->first();
        if(!$email)
        {
            return view('auth.message',[
                'title1' => "Oops, this link is expired.",
                'title2' => "This URL is not valid anymore.",
            ]); 
        }

        $user = User::where('email',$email->email)->first();
        $user->email_verified_at = now();
        $user->status = 1;
        $user->save();
        $email->delete();
        DB::commit();

        return view('auth.message',[
            'title1' => "Successful.",
            'title2' => "Email verified successfully.",
        ]);

    }
}
