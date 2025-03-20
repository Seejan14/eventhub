<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ServiceProviderDocument;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Traits\RespondTrait;
use App\Mail\EmailVerificationMail;
use Carbon\Carbon;
use DB;
use Str;
use Mail;

class ProfileController extends Controller
{
    use RespondTrait;

    public function __construct()
    {
        $this->mediaPath = '/uploads/providers/';
        $this->documentPath = '/uploads/providers/documents/';
    }

    public function resendVerificationMail(Request $request)
    {
        User::where('email',$request->email)->where('email_verified_at',null)->firstOrFail();

        $token = Str::random(64);
  
        DB::table('email_verifications')->updateOrInsert([
                'email' => $request->email,
            ] ,
            [
            'token' => $token, 
            'created_at' => Carbon::now()
            ]);
            $mailData = [
            'link' => \config('app.url')."/verify-email/$token",
            'logo' => \config('app.url') . "/assets/img/logos/app.png"
        ];
        Mail::to($request->email)->send(new EmailVerificationMail($mailData));

        return $this->successResponse(null,'Email sent');
    } 

    public function updateServiceProvider(Request $request)
    {
        // $validator = Validator::make($request->all(),[
        //     'name' => 'required',
        //     'num_of_seats' => 'required|numeric',
        //     'date' => 'required|date|after:now',
        //     'email' => 'nullable|email',
        //     'country_code' => 'required',
        //     'phone' => 'required',
        //     'payment_amount' => 'required|in:deposit,full',
        // ]);
        // if($validator->fails()){
        //     return $this->errorResponse($validator->errors(),"Data validation Error.");
        // }

        $provider = ServiceProvider::where('user_id',auth()->user()->id)->firstOrFail();
        $provider->fill($request->all());
        $provider->save();

        return $this->successResponse(null,'Updated successfully');


    }

    public function updateProviderProfile(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'business_name' => 'required',
                'description' => 'nullable',
                'featured_photo' => 'mimes:jpg,png,jpeg,gif,svg|max:2048',
                'featured_video' => 'nullable|mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi',
        ]);
        if($validator->fails()){
            return $this->errorResponse($validator->errors(),"Data validation Error.");
        }
        $provider = ServiceProvider::where('user_id',auth()->user()->id)->firstOrFail();
        $provider->fill($validator->validated());

        if($request->hasFile('featured_photo'))
        {
            $file = $request->featured_photo;
            $photoName = time().Str::random(4).'.'.$file->extension();
            $provider->featured_photo = $this->mediaPath.$photoName;
            $file->move(public_path($this->mediaPath),$photoName);
        }

        if($request->hasFile('featured_video'))
        {
            $file = $request->featured_video;
            $photoName = time().Str::random(4).'.'.$file->extension();
            $provider->featured_video = $this->mediaPath.$photoName;
            $file->move(public_path($this->mediaPath),$photoName);
        }

        $provider->save();

        return $this->successResponse(null,'Updated successfully');
    }

    public function updateProviderBusiness(Request $request)
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $validator = Validator::make($request->all(),[
            'business_name' => 'required',
            'website' => 'nullable|regex:'.$regex,
            'business_registration_number' => 'nullable',
            'street_number' => 'nullable',
            'city' => 'nullable',
            'province' => 'nullable',
            'zip_code' => 'nullable',
            'country_id' => 'nullable|exists:countries,id',
            'contact_f_name' => 'nullable',
            'contact_l_name' => 'nullable',
            'contact_country_code' => 'nullable',
            'contact_phone' => 'nullable',
            'contact_email' => 'nullable|email',
            'owner_f_name' => 'nullable',
            'owner_l_name' => 'nullable',
            'owner_dob' => 'nullable|date',
            'owner_country_code' => 'nullable',
            'owner_phone' => 'nullable',
            'owner_email' => 'nullable|email',
        ]);
        if($validator->fails()){
            return $this->errorResponse($validator->errors(),"Data validation Error.");
        }
        $provider = ServiceProvider::where('user_id',auth()->user()->id)->firstOrFail();
        $provider->fill($validator->validated());
        $provider->save();

        return $this->successResponse(null,'Updated successfully');
    }

    public function showProvider()
    {
        $provider = User::where('id',auth()->user()->id)->with('service_provider')->firstOrFail();

        return $this->successResponse([
            'user' => $provider,
        ],'');
    }

    public function addProviderDocument(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'document' => 'required|mimes:jpg,png,jpeg,gif,svg,pdf,docx,doc|max:5000',
            'license_number' => 'nullable',
            'expiry_date' => 'nullable',
        ]);
        if($validator->fails()){
            return $this->errorResponse($validator->errors(),"Data validation Error.");
        }

        $doc = new ServiceProviderDocument;
        $doc->user_id = $user->id;
        $doc->service_provider_id = $user->service_provider->id;
        $doc->title = $request->title;
        $doc->license_number = $request->license_number;
        $doc->expiry_date = $request->expiry_date;

        $file = $request->document;
        $photoName = time().Str::random(4).'.'.$file->extension();
        $doc->document = $this->documentPath.$photoName;
        $file->move(public_path($this->documentPath),$photoName);

        $doc->save();       

        return $this->successResponse($doc,'Added successfully');

    }

    public function updateProviderDocument(Request $request,$id)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'document' => 'nullable|mimes:jpg,png,jpeg,gif,svg,pdf,docx,doc|max:5000',
            'license_number' => 'nullable',
            'expiry_date' => 'nullable',
        ]);
        if($validator->fails()){
            return $this->errorResponse($validator->errors(),"Data validation Error.");
        }

        $doc = ServiceProviderDocument::where('id',$id)->first();
        $doc->title = $request->title;
        $doc->license_number = $request->license_number;
        $doc->expiry_date = $request->expiry_date;

        if($request->hasFile('document'))
        {
            $file = $request->document;
            $photoName = time().Str::random(4).'.'.$file->extension();
            $doc->document = $this->documentPath.$photoName;
            $file->move(public_path($this->documentPath),$photoName);
        }

        $doc->save();       

        return $this->successResponse($doc,'Updated successfully');

    }

    public function deleteDocument($id)
    {
        ServiceProviderDocument::where('id',$id)->delete();

        return $this->successResponse(null,'Deleted successfully');

    }

    public function getDocuments()
    {
        $docs = ServiceProviderDocument::where('user_id',auth()->user()->id)->get();

        return $this->successResponse($docs,'');
    }

    public function showDocument($id)
    {
        $docs = ServiceProviderDocument::where('user_id',auth()->user()->id)
                ->where('id',$id)
                ->first();

        return $this->successResponse($docs,'');
    }

    public function updatePaymentInformation(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(),[
            'bank_id' => 'required',
            'account_number' => 'required',
            'account_name' => 'required',
            'branch' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return $this->errorResponse($validator->errors(),"Data validation Error.");
        }

        if (!auth()->guard('web')->attempt([
            'email' => $user->email,
            'password' => $request->input('password')
        ]))
        {
            return $this->errorResponse(null,
                        'Incorrect Password',
                    401);
        }
        $provider = ServiceProvider::where('user_id',auth()->user()->id)->firstOrFail();
        $provider->bank_id = $request->input('bank_id');
        $provider->branch = $request->input('branch');
        $provider->account_name = $request->input('account_name');
        $provider->account_number = $request->input('account_number');
        $provider->save();

        return $this->successResponse($provider,'Successfully updated.');

    }
    
}
