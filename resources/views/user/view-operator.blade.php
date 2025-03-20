@extends('layouts.index',[
'title' => 'Users',
'subPage' => 'Details',
])

@section('content')
<div class="container-fluid ">
    <div class="row">
        <div class="col-8">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>User Details</h6>
                </div>
                <hr class="horizontal dark mt-0">

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="d-flex px-4">
                        <div class="flex-1" style="flex:1;align-items:flex-start;">
                            <h6 class="mb-0 text">Name:</h6>

                        </div>
                        <div class="" style="flex:1;align-items:flex-start;">
                                <h6 class="mb-0 text-data">
                                    {{ $user->f_name .' '. $user->l_name }}
                                </h6>
                            </h6>
                        </div>
                    </div>
                    <div class="d-flex px-4">
                        <div class="flex-1" style="flex:1;align-items:flex-start;">
                            <h6 class="mb-0 text">Provider:</h6>

                        </div>
                        <div class="" style="flex:1;align-items:flex-start;">
                                <h6 class="mb-0 text-data">
                                    {{ $details->service_provider->service_provider->business_name }}
                                </h6>
                            </h6>
                        </div>
                    </div>
                    <div class="d-flex px-4">
                        <div class="flex-1" style="flex:1;align-items:flex-start;">
                            <h6 class="mb-0 text">Email:</h6>

                        </div>
                        <div class="" style="flex:1;align-items:flex-start;">
                                <h6 class="mb-0 text-data">
                                    {{ $user->email }}
                                </h6>
                            </h6>
                        </div>
                    </div>

                    <div class="d-flex px-4">
                        <div class="flex-1" style="flex:1;align-items:flex-start;">
                            <h6 class="mb-0 text">Phone:</h6>

                        </div>
                        <div class="" style="flex:1;align-items:flex-start;">
                                <h6 class="mb-0 text-data">
                                    {{ $user->phone }}
                                </h6>
                            </h6>
                        </div>
                    </div>

                    <div class="d-flex px-4">
                        <div class="flex-1" style="flex:1;align-items:flex-start;">
                            <h6 class="mb-0 text">Country:</h6>

                        </div>
                        <div class="" style="flex:1;align-items:flex-start;">
                                <h6 class="mb-0 text-data">
                                    {{ $details->country->name ?? ''}}
                                </h6>
                            </h6>
                        </div>
                    </div>

                    <div class="d-flex px-4">
                        <div class="flex-1" style="flex:1;align-items:flex-start;">
                            <h6 class="mb-0 text">Address:</h6>

                        </div>
                        <div class="" style="flex:1;align-items:flex-start;">
                                <h6 class="mb-0 text-data">
                                    {{ $details->address}}
                                </h6>
                            </h6>
                        </div>
                    </div>

                    <div class="d-flex px-4">
                        <div class="flex-1" style="flex:1;align-items:flex-start;">
                            <h6 class="mb-0 text">Address:</h6>

                        </div>
                        <div class="" style="flex:1;align-items:flex-start;">
                                <h6 class="mb-0 text-data">
                                    {{ $details->address }}
                                </h6>
                            </h6>
                        </div>
                    </div>

                    <div class="d-flex px-4">
                        <div class="flex-1" style="flex:1;align-items:flex-start;">
                            <h6 class="mb-0 text">Dob:</h6>

                        </div>
                        <div class="" style="flex:1;align-items:flex-start;">
                                <h6 class="mb-0 text-data">
                                    {{ $details->dob }}
                                </h6>
                            </h6>
                        </div>
                    </div>
                   
                    
                </div>
                <hr class="horizontal dark mt-0">
            </div>
        </div>
        <div class="col-md-4">
            <div class="">
                <img src="{{ asset('assets/img/bg-profile.jpg') }}" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-4 col-lg-4 order-lg-2">
                        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                            <a href="{{asset($user->profile_picture ?? '/assets/img/user.jpg')}}"
                                data-toggle="lightbox">
                                <img src="{{ asset($user->profile_picture ?? '/assets/img/user.jpg') }} "
                                    class="rounded-circle img-fluid border border-2 border-white">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                   
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col">
                            @if($user->hasRole('provider'))

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

                            @if($user->hasRole('user'))

                            <div class="d-flex justify-content-center">
                                <div class="d-grid text-center">
                                    <span class="text-lg font-weight-bolder">22</span>
                                    <span class="text opacity-8">Bookings</span>
                                </div>
                                <div class="d-grid text-center mx-4">
                                    <span class="text-lg font-weight-bolder">10</span>
                                    <span class="text opacity-8">Photos</span>
                                </div>
                                <div class="d-grid text-center">
                                    <span class="text-lg font-weight-bolder">89</span>
                                    <span class="text opacity-8">Comments</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <h5>
                            {{$user->name}}<span class="font-weight-light"></span>
                        </h5>
                        <div class="h6 font-weight-300">
                            <i class="bi bi-envelope"></i> {{$user->email}}
                        </div>
                        @if($user->phone)
                        <div class="h6 font-weight-300">
                            <i class="bi bi-telephone"></i> {{$user->phone}}
                        </div>
                        @endif
                        @if($details->country)
                        <div class="h6 font-weight-300">
                            <i class="bi bi-flag"></i> {{$details->country->name ?? ''}}
                        </div>
                        @endif
                        <hr class="horizontal dark mt-0">

                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.0/dist/index.bundle.min.js"></script>
@endsection