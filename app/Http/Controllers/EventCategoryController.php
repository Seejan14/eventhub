<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;

class EventCategoryController extends Controller
{
    public function index()
    {
        $data = EventCategory::orderBy('id','ASC')->get();

        return view('event-category.list',compact('data'));
    }

    public function create()
    {
        return view('event-category.create');
    }

    public function view($id)
    {
        $details = EventCategory::where('id',$id)->first();
        return response()->json($details);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'description'=>'required',
            'image'=>'required|mimes:jpg,jpeg,png,gif,avif,svg,webp|max:4096'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try{
            $imagePath = null;
            $publicId = null;
            if($request->hasFile('image'))
            {
                $imageResult = Cloudinary::upload($request->file('image')->getRealPath(), ['folder' => 'event-hub/categories']);
                $imagePath = $imageResult->getSecurePath();
                $publicId = $imageResult->getPublicId();
            }

            DB::transaction(function() use ($request,$imagePath,$publicId){
                EventCategory::create([
                    'title'=>$request->title,
                    'slug'=>Str::slug($request->title),
                    'description'=>$request->description,
                    'image_url'=>$imagePath,
                    'public_id'=>$publicId,
                ]);
            });

            return redirect()->route('list-event-categories')
            ->with('success','event Category created successfully');

            $category->save();
            
            DB::commit();

            return redirect()->route('list-event-categories');
        }
        catch(Exception $error){
            DB::rollBack();

            if($publicId){
                Cloudinary::destroy($publicId);
            }

            return redirect()->back()
            ->with('error', 'Error creating event category: ' . $error->getMessage())
            ->withInput();        
        }

    }

    public function edit($id)
    {
        $details = EventCategory::where('id',$id)->first();
        
        return view('event-category.edit',compact('details'));
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'image'=>'mimes:jpg,png,jpeg,gif,svg,avif,webp|max:4096',
            'description'=>'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try{
            DB::beginTransaction();
            $data = $request->all();
            $category = EventCategory::where('id',$id)->first();
            $category->slug = Str::slug($request->title);
            
            if($request->hasFile('image'))
            {
                try{
                    Cloudinary::destroy($category->public_id);
                    
                    $imageResult = Cloudinary::upload($request->file('image')->getRealPath(), ['folder' => 'event-hub/categories']);
                    $imagePath = $imageResult->getSecurePath();
                    $publicId = $imageResult->getPublicId();
                    
                    $category->image_url = $imagePath;
                    $category->public_id = $publicId;
                    
                }catch(Exception $e){
                    return redirect()->back()
                        ->with('error', 'Error updating event category: ' . $e->getMessage())
                        ->withInput();
                }
            } 
            $category->fill($data);
            $category->save();
            
            DB::commit();

            return redirect()->route('list-event-categories');
        }
        catch(Exception $e)
        {
            DB::rollback();
        }
    }
}
