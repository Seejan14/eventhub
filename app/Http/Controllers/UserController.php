<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Str;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::all();

        return view('user.list', compact('users'));
    }

    public function profile()
    {
        $data = User::where('id', auth()->user()->id)->first();
        return view('profile.index', compact('data'));
    }

    // public function update(Request $request, $id)
    // {
    //     $rules = [
    //         'f_name' => 'required',
    //         'l_name' => 'required',
    //         'email' => 'required|unique:users,email,' . $id,
    //         'phone' => 'required|numeric|unique:users,phone,' . $id,
    //         'profile_picture' => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
    //     ];

    //     $user = User::where('id', $id)->first();
    //     $validator = Validator::make($request->all(), $rules);
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     try {
    //         DB::beginTransaction();
    //         $data = $request->all();
    //         $user->update($data);
    //         if ($request->hasFile('profile_picture')) {
    //             $file = $request->file('profile_picture');
    //             $imageName = Str::random(4) . time() . '.' . $file->extension();

    //             $file->move(public_path($this->profilePath), $imageName);
    //             $user->profile_picture = $this->profilePath . $imageName;
    //         }
    //         $user->save();


    //         DB::commit();
    //         return redirect()->route('list-user', ['user_type' => $user->roles->first()->name, 'page' => $request->page]);
    //     } catch (Exception $e) {
    //         DB::rollback();
    //     }
    // }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::where('id', auth()->user()->id)->first();

        if (!auth()->attempt([
            'email' => $user->email,
            'password' => $request->old_password
        ])) {
            return redirect()->back()->withErrors(['old_password' => 'Invalid Password.'])->withInput();
        }
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('status', 'Password Changed.');
    }
}
