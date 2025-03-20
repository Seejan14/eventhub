<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\RespondTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use RespondTrait;
    public function index() {
        $user = Auth::user();

        return $this->successResponse($user);
    }
}
