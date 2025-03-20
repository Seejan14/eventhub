@extends('layouts.index', [
    'title' => 'Show Contact',
    'activePage' => 'Show Contact',
    'subPage' => 'Show Contact',
])

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="bg-light p-4 rounded shadow-sm">
                    <h4 class="text-center font-weight-bold mb-4">Contact Details</h4>
                    <div class="mb-3">
                        <p><strong>Name:</strong> {{ $contacts->full_name }}</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Phone:</strong> {{ $contacts->phone }}</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Email:</strong> {{ $contacts->email }}</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Address:</strong> {{ $contacts->address?: 'No address available' }}</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Message:</strong> <br> {{ $contacts->message }}</p>
                    </div>
                
                    <div class="text-center mt-4">
                        <a href="{{ route('contacts') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to contacts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
