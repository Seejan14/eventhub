<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\RespondTrait;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use Carbon\Carbon;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    use RespondTrait;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'login',
            'register',
            'verifyOtp',
            'verifyAndRegister',
            'forgotPassword',
            'resetPassword',
            'verifyEmail',
            'resendVerificationEmail',
            'handleGoogleCallback',
        ]]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|string|min:8',
            'phone' => 'nullable|string|unique:users,phone',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => 1,
            'role' => 2,
            'email_verified_at' => now(),
        ]);

        return $this->successResponse($user, 'User registered successfully');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid login credentials'
            ], 401);
        }

        $user = Auth::user();

        if ($user->status !== 1) {
            return response()->json([
                'status' => false,
                'message' => 'Account is inactive or not verified'
            ], 401);
        }

        // Revoke previous tokens
        $user->tokens()->delete();

        // Generate new Passport token
        $token = $user->createToken('AuthToken')->accessToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => config('auth.passport_expiration', 60) * 60 // Customize expiration
            ]
        ]);
    }

    public function me()
    {
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function refresh(Request $request)
    {
        $user = Auth::user();

        // Revoke the current access token
        $request->user()->token()->revoke();

        // Generate a new token
        $newToken = $user->createToken('AuthToken')->accessToken;

        return response()->json([
            'status' => true,
            'data' => [
                'token' => $newToken,
                'token_type' => 'Bearer',
                'expires_in' => config('auth.passwords.users.expire') * 60
            ]
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => ['email', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
            ], 422);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/profile_pictures', $fileName);
            $user->profile_picture = 'profile_pictures/' . $fileName;
        }

        // Update other fields
        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('email')) $user->email = $request->email;
        if ($request->has('phone')) $user->phone = $request->phone;

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => [
                'user' => $user
            ]
        ]);
    }

    public function forgotPassword(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation Error'], 422);
        }

        // Generate OTP
        // $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // // Store OTP
        // Otp::where('email', $request->email)->delete();

        // Otp::create([
        //     'email' => $request->email,
        //     'otp' => Hash::make($otp),
        //     'expires_at' => Carbon::now()->addMinutes(10)
        // ]);

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('AuthToken', ['*'], Carbon::now()->addHour(1))->accessToken;
        $resetUrl = env('FRONTEND_URL') . '/reset-password?email=' . $request->email . '&token=' . $token;

        // Send Password Reset OTP
        try {
            Mail::send('emails.forgot-password-link', ['resetUrl' => $resetUrl, 'user' => $user], function ($message) use ($request) {
                $message->to($request->email)->subject('Password Reset');
            });

            return response()->json(['status' => true, 'message' => 'Password reset link sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Failed to send link', 'error' => $e->getMessage()], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'token' => ['required', 'string'],
            'password' => 'required|string|min:8|confirmed',
            // 'confirm_password' => 'required|same:new_password'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        // $otpRecord = Otp::where('email', $request->email)
        //     ->where('expires_at', '>', Carbon::now())
        //     ->latest()
        //     ->first();

        // if (!$otpRecord || !Hash::check($request->otp, $otpRecord->otp)) {
        //     return response()->json(['status' => false, 'message' => 'Invalid or expired OTP'], 400);
        // }

        // Update password
        $tokenParts = explode('.', $request->token);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtPayload = json_decode($tokenPayload, true);
        $tokenId = $jwtPayload['jti'];

        $user = User::where('email', $request->email)->first();
        // dd($user);

        $tokenExists = DB::table('oauth_access_tokens')
            ->where('user_id', $user->id)
            ->where('revoked', 0)
            ->where('expires_at', '>', now())
            ->where('id', $tokenId)
            ->exists();

        if (!$tokenExists) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired token'
            ], 401);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Delete 
        DB::table('oauth_access_tokens')
            ->where('user_id', $user->id)
            ->where('id', $request->token)
            ->delete();

        return response()->json(['status' => true, 'message' => 'Password reset successfully']);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|same:new_password'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Validation Error'], 422);
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['status' => false, 'message' => 'Current password is incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['status' => true, 'message' => 'Password changed successfully']);
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $token = $request->input('token');
            $response = $this->handleGoogleCallbackWithToken($token);

            if ($response['success']) {
                return $this->successResponse($response['data'], 'Logged in successfully via Google');
            }

            return $this->errorResponse($response['message'], [], 400);
        } catch (Exception $e) {
            return $this->errorResponse("Google Login Failed: " . $e->getMessage(), [], 500);
        }
    }

    private function handleGoogleCallbackWithToken($token)
    {
        $googleUser = Socialite::driver('google')->userFromToken($token);

        // Check if user already exists in the database
        $user = User::where('email', $googleUser->getEmail())->where('role', 2)->first();

        // If the user doesn't exist, create a new user
        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => null,
                'role' => 2,
                'google_id' => $googleUser->getId(),
            ]);
        }

        // Log the user in using Auth
        Auth::login($user);

        // Generate a JWT token for the user
        $token = $user->createToken('AuthToken')->accessToken;

        return [
            'success' => true,
            'data' => [
                'user' => $user,
                'token_type' => 'bearer',
                'token' => $token,
            ],
        ];
    }
}
