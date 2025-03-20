<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\RespondTrait;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use Str;

class SocialMediaAuthController extends Controller
{
    use RespondTrait;

    public function facebookLogin(Request $request)
    {
        try{
            $facebookUser = Socialite::driver('facebook')->fields([
                'name', 
                'first_name', 
                'last_name', 
                'email', 
                'gender', 
                'verified'
            ])->userFromToken($request->token);

            if(!$facebookUser)
            {
                return $this->errorResponse(null,"Invalid user.");
            }
            $user = User::where('facebook_id',$facebookUser->id)
                        ->first();
                        
            if(!$user)
            {
                $user = User::create([
                    "f_name" => $facebookUser->user['first_name'],
                    "l_name" => $facebookUser->user['last_name'],
                    "facebook_id" => $facebookUser->id,
                    "profile_picture" => $facebookUser->avatar_original,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
                $user->assignRole('user');
    
            }
            $user->role = $user->roles()->pluck('name')->first();

            $token= $user->createToken(Str::random(16))->accessToken;
            // dd($token);
            $data = [
                'user' => $user,
                'login_type' => 'facebook',
                'token' => $token,
            ];
            
            return $this->successResponse($data,'Successfully logged in', 200);
        }
        catch(ClientException $e)
        {
            return $this->errorResponse("User not found");
        }
        catch(\Exception $e)
        {
            return $this->errorResponse($e->getMessage());
        }
        

    }

    public function googleLogin(Request $request)
    {
        try{
            $googleUser = Socialite::driver('google')->userFromToken($request->token);
            if(!$googleUser)
            {
                return $this->errorResponse(null,"Invalid user.");
            }
            $user = User::where('google_id',$googleUser->id)
                        ->first();
            if(!$user)
            {
                $user = User::create([
                    "f_name" => $googleUser->user['given_name'],
                    "l_name" => $googleUser->user['family_name'],
                    "google_id" => $googleUser->id,
                    "profile_picture" => $googleUser->avatar_original,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
                $user->assignRole('user');

            } 
            $user->role = $user->roles()->pluck('name')->first();
            $token= $user->createToken(Str::random(16))->accessToken;
            // dd($token);
            $data = [
                'user' => $user,
                'login_type' => 'google',
                'token' => $token,
            ];
            
            return $this->successResponse($data, 'Successfully logged in', 200);
        }
        catch(ClientException $e)
        {
            return $this->errorResponse("User not found");
        }
        catch(\Exception $e)
        {
            return $this->errorResponse($e->getMessage());
        }

    }
}
