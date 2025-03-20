@extends('layouts.index', [
    'title' => 'Show Event',
    'activePage' => 'Show Event',
    'subPage' => 'Show Event',
])

@section('content')
    <div class="container py-4">
        <div class="card shadow-lg border-0 p-4">
            <div class="card-body">
                <h2 class="mb-4 text-center">Event Details</h2>
                
                <!-- Event Main Details -->
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="p-3 border rounded bg-light">
                            <p><strong>Title:</strong> {{ $data['event']->title }}</p>
                            <p><strong>Description:</strong> {{ $data['event']->description ?: 'No description available' }}</p>
                            <p><strong>Country:</strong> {{ $data['event']->country ?? 'N/A' }}</p>
                            <p><strong>Category:</strong> {{ $data['event_category']->title }}</p>
                            <p><strong>Status:</strong> 
                                @if ($data['event']->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="p-3 border rounded bg-light">
                        <p><strong>Start Date:</strong> {{ $data['event']->start_date }}</p>
                        <p><strong>End Date:</strong> {{ $data['event']->end_date }}</p>
                        <p><strong>Total Ticket Left:</strong> {{ $data['event']->total_space }}</p>
                        <p><strong>Price:</strong> {{ $data['event']->price }}</p>                            
                        </div>
                    </div>
                </div>

                <!-- Event Images -->
                <div class="row g-4 mt-4 text-center">
                    <div class="col-md-6">
                        <strong>Image:</strong>
                        @if (!empty($data['event']->image_url))
                            <div class="d-flex justify-content-center">
                                <img src="{{ $data['event']->image_url }}" alt="Event Image" 
                                    class="img-fluid rounded shadow" style="max-width: 100%; height: auto;">
                         </div>
                        @else
                            <p>N/A</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
