<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\RespondTrait;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Mail\PdfMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    use RespondTrait;

    public function indexCategories()
    {
        $categories = BlogCategory::all();
        return $this->successResponse($categories);
    }

    public function index(Request $request)
    {
        $search = $request->search_value;
        $category = $request->filter_category;
        $blogs = Blog::with('media','category')
                ->where(function($q)use($search, $category){
                    if($search)
                    {
                        $q->where('title','like',"%$search%");
                    }
                    if($category)
                    {
                        $q->where('blog_category_id',$category);
                    }
                })
                ->paginate(\config('app.paginate_count'));

        $res = [
            "blogs" => $blogs->values(),
            "total" => $blogs->total(),
            "current_page" => $blogs->currentPage(),
            "last_page" => $blogs->lastPage(),
            "page_size" => $blogs->perPage(),
        ];

        return $this->successResponse($res,"");
    }

    public function show($id)
    {
        $blog = Blog::with('media','category')
                ->where('id',$id)
                ->first();
        return $this->successResponse($blog,"");
    }

    public function sendPdf(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
        ]);

        if($validator->fails()){
            return $this->errorResponse($validator->errors(),"Data validation Error.");
        }

        Mail::to($request->email)->send(new PdfMail());

    }
}
