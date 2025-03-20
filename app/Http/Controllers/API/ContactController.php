<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Traits\RespondTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    
    public function store(Request $request){
        $request->validate([
            'full_name'=>'required|string|min:3',
            'phone' => 'required',
            'email'=>'required|email',
            'address'=>'nullable|string',
            'message'=>'required|min:7',
        ]);
        
        if(!$request){
            return response()->json(['error'=>'Required field is missing']);
        }

        $contact = new Contact();
        $contact->full_name = $request->full_name;
        $contact->address = $request->address;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->message = $request->message;
        $contact-> save();
        return response()->json(['success'=>'Creation of Contact Us is successful'],200);


    }



}
