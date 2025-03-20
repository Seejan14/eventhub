@extends('layouts.index',[
'title' => 'Bookings',
'activePage' =>'Bookings',
'subPage' => 'Bookings',
])

@section('content')
    <div class="container-fluid ">
        <div class="row">
            <div class="col-12">
                <div class="p-3 d-flex flex-column gap-4" style="min-height: 60vh">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>Bookings</h6>
                        {{-- <a class="btn btn-primary" href="{{ route('guides.create') }}"> Create Guides</a> --}}

                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table-template dataTable" id="myTable">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">
                                            SN</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Package</th>
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th> --}}
                                        
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            No. of People</th>
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th> --}}
                                        
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Email</th>
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th> --}}
                                        
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $booking->user->name }}</td>
                                            <td>{{ $booking->booking_date }}</td>
                                            <td>{{ $booking->package->title ?? 'N/A'}}</td>
                                            <td>{{ $booking->number_of_people }}</td>
                                            <td>{{ $booking->user->email }}</td>
                                            <td><a href="{{ route('bookings.show', ['id' => $booking->id]) }}" class="btn btn-primary btn-sm shadow rounded-pill px-4">  View </a></td>                                          
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.0/dist/index.bundle.min.js"></script>

@endsection