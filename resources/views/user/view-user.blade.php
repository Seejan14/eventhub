@extends('layouts.index', [
    'title' => 'Users',
    'subPage' => 'Details',
])

@section('content')
    <div class="container-fluid ">
        <div class="card card-profile">
            {{-- <div class="user-image-container">
                        <img src="{{ asset('assets/img/bg-profile.jpg') }}" alt="Image placeholder" class="user-image">
                    </div> --}}
            <div class="user-image-container d-flex justify-content-center">
                <a href="{{ asset($user->profile_picture ?? '/assets/img/user.jpg') }}" data-toggle="lightbox">
                    <img src="{{ asset($user->profile_picture ?? '/assets/img/user.jpg') }} " class="user-image">
                </a>
            </div>
            <div class="user-data">
                <div class="user-details">
                    User Details
                </div>

                <div class="user-body">
                    <div class="data">
                        <div>
                            <strong>Name:</strong>
                        </div>
                        <div>
                            {{ $user->name }}
                        </div>
                    </div>
                    <div class="data">
                        <div>
                            <strong>Email:</strong>

                        </div>
                        <div>
                            {{ $user->email }}
                        </div>
                    </div>
                    <div class="data">
                        <div>
                            <strong>Country:</strong>

                        </div>
                        <div>
                            {{ $details->country->name ?? '' }}
                        </div>
                    </div>
                    <div class="data">
                        <div>
                            <strong>Address:</strong>

                        </div>
                        <div>
                            {{ $details->address }}
                        </div>
                    </div>
                    <div class="data">
                        <div>
                            <strong>Dob:</strong>

                        </div>
                        <div>
                            {{ $details->dob }}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                    </div> --}}
            {{-- <div class="card-body pt-0">
                        <div class="row">
                            <div class="col">
                                @if ($user->hasRole('provider'))
                                    <div class="d-flex justify-content-center">
                                        <div class="d-grid text-center">
                                            <span class="text-lg font-weight-bolder">22</span>
                                            <span class="text-sm opacity-8">Total Programs</span>
                                        </div>
                                        <div class="d-grid text-center mx-4">
                                            <span class="text-lg font-weight-bolder">10</span>
                                            <span class="text-sm opacity-8">Upcoming Programs</span>
                                        </div>
                                        <div class="d-grid text-center">
                                            <span class="text-lg font-weight-bolder">89</span>
                                            <span class="text-sm opacity-8">Total Clients</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($user->hasRole('user'))
                                    <div class="d-flex justify-content-center">
                                        <div class="d-grid text-center">
                                            <span class="text-lg font-weight-bolder">22</span>
                                            <span class="text-sm opacity-8">Bookings</span>
                                        </div>
                                        <div class="d-grid text-center mx-4">
                                            <span class="text-lg font-weight-bolder">10</span>
                                            <span class="text-sm opacity-8">Photos</span>
                                        </div>
                                        <div class="d-grid text-center">
                                            <span class="text-lg font-weight-bolder">89</span>
                                            <span class="text-sm opacity-8">Comments</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <h5>
                                {{ $user->name }}<span class="font-weight-light"></span>
                            </h5>
                            <div class="h6 font-weight-300">
                                <i class="bi bi-envelope"></i> {{ $user->email }}
                            </div>
                            @if ($user->phone)
                                <div class="h6 font-weight-300">
                                    <i class="bi bi-telephone"></i> {{ $user->phone }}
                                </div>
                            @endif
                            @if ($details->country)
                                <div class="h6 font-weight-300">
                                    <i class="bi bi-flag"></i> {{ $details->country->name ?? '' }}
                                </div>
                            @endif
                            <hr class="horizontal dark mt-0">


                        </div>
                    </div> --}}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.0/dist/index.bundle.min.js"></script>
@endsection
