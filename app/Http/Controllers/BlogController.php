<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogMedia;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Validator;
use DB;
use Str;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->mediaPath = '/uploads/blogs/';
    }

    public function index(Request $request)
    {
        $search = $request->search_value;
        $category = $request->filter_category;
        $blogs = Blog::with('media')
            ->where(function ($q) use ($search, $category) {
                if ($search) {
                    $q->where('title', 'like', "%$search%");
                }
                if ($category) {
                    $q->where('blog_category_id', $category);
                }
            })
            // ->paginate(\config('app.paginate_count'));
            ->get();

        return view('blogs.index', compact('blogs', 'search'));
    }

    public function create(Request $request)
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'author' => 'nullable',
            'author_photo' => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'media' => 'required',
            'media.*' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            $blog = new Blog;
            if ($request->hasFile('author_photo')) {
                $photoName = time() . Str::random(4) . '.' . $request->author_photo->extension();
                $request->author_photo->move(public_path($this->mediaPath), $photoName);
                $blog->author_photo = $this->mediaPath . $photoName;
            }

            $blog->fill($request->all());
            $blog->save();

            if ($request->media) {
                foreach ($request->media as $file) {
                    $photoName = time() . Str::random(4) . '.' . $file->extension();

                    $media = new BlogMedia;
                    $media->blog_id = $blog->id;
                    $media->media = $this->mediaPath . $photoName;
                    $media->save();
                    $file->move(public_path($this->mediaPath), $photoName);
                }
            }


            DB::commit();

            return redirect()->route('list-blogs', ['page' => 1]);
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function edit(Request $request, $id)
    {
        $blog = Blog::where('id', $id)->first();
        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'author' => 'nullable',
            'author_photo' => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'media.*' => 'mimes:jpg,png,jpeg,gif,svg|max:2048',
            'delete_old_media.*' => 'exists:blog_media,id'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            $blog = Blog::where('id', $id)->first();
            if ($request->hasFile('author_photo')) {
                $photoName = time() . Str::random(4) . '.' . $request->author_photo->extension();
                $request->author_photo->move(public_path($this->mediaPath), $photoName);
                $blog->author_photo = $this->mediaPath . $photoName;
            }

            $blog->fill($request->all());
            $blog->save();

            if ($request->media) {
                foreach ($request->media as $file) {
                    $photoName = time() . Str::random(4) . '.' . $file->extension();

                    $media = new BlogMedia;
                    $media->blog_id = $blog->id;
                    $media->media = $this->mediaPath . $photoName;
                    $media->save();
                    $file->move(public_path($this->mediaPath), $photoName);
                }
            }
            if ($request->delete_old_media) {
                BlogMedia::whereIn('id', $request->delete_old_media)->delete();
            }

            DB::commit();

            return redirect()->route('list-blogs', ['page' => $request->page]);
        } catch (Exception $e) {
            DB::rollback();
        }
    }

    public function destroy(Request $request, $id)
    {
        Blog::where('id', $id)->delete();
        return redirect()->route('list-blogs', ['page' => $request->page]);
    }
}
