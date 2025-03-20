<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use App\Traits\RespondTrait;
use Carbon\Carbon;
use Exception;

class ForgotPasswordController extends Controller
{

    use RespondTrait;

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|exists:users',
        ]);
        if($validator->fails()){
            return $this->errorResponse($validator->errors(),"Data validation Error.");
        }
        try{
            $token = Str::random(64);
  
            DB::table('password_resets')->updateOrInsert([
                    'email' => $request->email,
                ] ,
                [
                'token' => $token, 
                'created_at' => Carbon::now()
              ]);

            $mailData = [
                'link' => config('app.url')."/reset-password/$token",
                // 'logo' => \config('app.url') . "/assets/img/logos/app.png"
            ];
             
            Mail::to($request->email)->send(new PasswordResetMail($mailData));
            return $this->successResponse(null,"Email sent.");
        }
        catch(Exception $e)
        {
            return $this->errorResponse($e->getMessage());
        }
    }

    
}
