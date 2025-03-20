<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('category')->orderBy('created_at', 'desc')->get();
        return view('event.index', [
            'events' => $events,
            'activePage' => 'events',
        ]);
    }

    public function create()
    {
        $data['eventCategories'] = EventCategory::all();
        return view('event.create', compact('data'));
    }

    public function show($id)
    {
        $data['event'] = Event::findOrFail($id);
        $data['event_category'] = EventCategory::findorFail($data['event']->event_category_id);
        return view('event.show', [
            'data' => $data,
            'activePage' => 'Show Event'
        ]);
    }

    public function edit($id)
    {
        $data['event'] = Event::findOrFail($id);
        $data['eventCategories'] = EventCategory::all();
        return view('event.edit', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'event_category_id' => 'required|numeric',
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'start_date' => 'required',
                'end_date' => 'required',
                'status' => 'required',
                'total_space' => 'required',
                'price' => 'required',
                'country' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('image')) {
                $imageResult = Cloudinary::upload($request->image->getRealPath(), ['folder' => 'event-hub/events']);
                $imagePath = $imageResult->getSecurePath();
                $publicId = $imageResult->getPublicId();
            }

            DB::beginTransaction();

            $event = Event::create([
                'title' => $request->get('title'),
                'event_category_id' => intval($request->get('event_category_id')),
                'description' => $request->get('description'),
                'status' => $request->get('status'),
                'start_date' => $request->get('start_date'),
                'end_date' => $request->get('end_date'),
                'image_url' => $imagePath,
                'image_public_id' => $publicId,
                'country' => $request->get('country'),
                'total_space' => $request->get('total_space'),
                'price' => $request->get('price')
            ]);

            DB::commit();

            return redirect()->route('event.index')->with('success', 'Event created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'event_category_id' => 'required|numeric',
                'title' => 'required',
                'description' => 'required',
                'image' => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'status' => 'required',
                'total_space' => 'required|integer',
                'price' => 'required|numeric',
                'country' => 'required|string',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $event = Event::findOrFail($id);
    
            $imagePath = $event->image_url;
            $publicId = $event->image_public_id;
    
            if ($request->hasFile('image')) {
                if ($publicId) {
                    Cloudinary::destroy($publicId);
                }
                $imageResult = Cloudinary::upload($request->file('image')->getRealPath(), ['folder' => 'event-hub/events']);
                $imagePath = $imageResult->getSecurePath();
                $publicId = $imageResult->getPublicId();
            }
    
            DB::beginTransaction();
    
            $event->update([
                'title' => $request->get('title'),
                'event_category_id' => intval($request->get('event_category_id')),
                'description' => $request->get('description'),
                'status' => $request->get('status'),
                'start_date' => $request->get('start_date'),
                'end_date' => $request->get('end_date'),
                'image_url' => $imagePath,
                'image_public_id' => $publicId,
                'country' => $request->get('country'),
                'total_space' => $request->get('total_space'),
                'price' => $request->get('price'),
            ]);
    
            DB::commit();
    
            return redirect()->route('event.index')->with('success', 'Event updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
}
