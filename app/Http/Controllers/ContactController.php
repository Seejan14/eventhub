<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){

        $contacts = Contact::all();
        if(!$contacts){
            return response()->json(['error'=>'No data in Contact us'],404);
        }

        return view('contacts/index', compact('contacts'));
        

    }

    public function show($id){

        $contacts = Contact::findOrFail($id);
        return view('contacts/show', compact('contacts'));
        

    }
}
