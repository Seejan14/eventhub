<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use DB;

class ForgotPasswordController extends Controller
{
    public function showResetPasswordForm($token) { 
        $updatePassword = DB::table('password_resets')
                            ->where([ 
                              'token' => $token
                            ])
                            ->first();

        if(!$updatePassword){
            return view('auth.message',[
                    'title1' => "Oops, this link is expired.",
                    'title2' => "This URL is not valid anymore.",
                ]);
        }
        return view('auth.password-reset-form', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);
        
        $updatePassword = DB::table('password_resets')
                            ->where([
                              'email' => $request->email, 
                              'token' => $request->token
                            ])
                            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)
                    ->update(['password' => bcrypt($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return view('auth.message',[
            'title1' => "Successful.",
            'title2' => "Password changed successfully. ",
        ]);
    }
}
