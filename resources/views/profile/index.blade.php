@extends('layouts.index',[
'title' => 'Profile',
'activePage' => 'Profile'
])

@section('content')
<div class="container-fluid ">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit Profile</p>
                        {{-- <button class="btn btn-primary btn-sm ms-auto">Settings</button> --}}
                    </div>
                </div>
                <div class="card-body">
                    {{-- <p class="text-uppercase text-sm">User Information</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Name</label>
                                <input class="form-control" type="text" name="name"
                                value="{{$data->name}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email</label>
                                <input class="form-control" type="email" name="email" value="{{$data->email}}">
                            </div>
                        </div>
                    </div>
                    <hr class="horizontal dark"> --}}
                    <p class="text-uppercase text-sm">Password</p>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
            
                    <div class="row">
                        <form method="POST" action="{{route('change-password')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="addtional-contact" class="form-control-label">Old Password</label>
                                    <input id="additional-contact"
                                        class="form-control @error('old_password') is-invalid @enderror"
                                        type="password" name="old_password">
                                </div>
                                @error('old_password')
                                <span class="text-danger text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="addtional-contact" class="form-control-label">New Password</label>
                                    <input id="additional-contact"
                                        class="form-control @error('password') is-invalid @enderror"
                                        type="password" name="password">
                                </div>
                                @error('password')
                                <span class="text-danger text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="addtional-contact" class="form-control-label">Confirm Password</label>
                                    <input id="additional-contact"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        type="password" name="password_confirmation">
                                </div>
                                @error('password_confirmation')
                                <span class="text-danger text-sm" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        <input class="btn btn-primary" type="submit">
                    </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="card card-profile">
                <img src="{{ asset('assets/img/bg-profile.jpg') }}" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-4 col-lg-4 order-lg-2">
                        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                            <a href="javascript:;">
                                <img src="{{ asset('assets/img/team-2.jpg') }}"
                                    class="rounded-circle img-fluid border border-2 border-white">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                    <div class="d-flex justify-content-between">
                        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-none d-lg-block">Connect</a>
                        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none"><i
                                class="ni ni-collection"></i></a>
                        <a href="javascript:;"
                            class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block">Message</a>
                        <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none"><i
                                class="ni ni-email-83"></i></a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-center">
                                <div class="d-grid text-center">
                                    <span class="text-lg font-weight-bolder">22</span>
                                    <span class="text-sm opacity-8">Friends</span>
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
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <h5>
                            Mark Davis<span class="font-weight-light">, 35</span>
                        </h5>
                        <div class="h6 font-weight-300">
                            <i class="ni location_pin mr-2"></i>Bucharest, Romania
                        </div>
                        <div class="h6 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>Solution Manager - Creative Tim Officer
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>University of Computer Science
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

@endsection