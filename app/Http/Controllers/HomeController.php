<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;

class HomeController extends Controller
{
    //
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $users = User::count();
        // $bookings = Booking::with('yoga_program','user')
        // ->whereHas('yoga_program',function($q)use($user){
            // if($user->hasRole('provider'))
            // {
            //     $q->where('service_provider_user_id',$user->id); 
            // }
            // else if($user->hasRole('operator'))
            // {
            //     $q->where('service_provider_user_id',$user->operator->service_provider->id); 
            // }
            
        // })->get();
        // return view('dashboard.index', compact('users'));
    }

    public function profile()
    {
        return view('profile.index');
    }

}
