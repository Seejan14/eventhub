<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Traits\RespondTrait;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use RespondTrait;

    public function index(Request $request)
    {
        $events = Event::with('category:id,title')->orderBy('created_at', 'desc')->get();
        return $this->successResponse($events, 'Events retrieved successfully');
    }

    public function show(Request $request, $id)
    {
        $event = Event::with('category:id,title')->where('id', $id)->first();
        if (!$event) {
            return $this->errorResponse('Event not found', 404);
        }
        return $this->successResponse($event, 'Event retrieved successfully');
    }
}
