@extends('layouts.index',[
'title' => 'Users',
'subPage' => 'Create',
])

@section('content')
<div class="container-fluid ">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{route('store-user')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-body">
                        <p class="text-uppercase text-sm">User Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">First Name</label>
                                    <span class="text-danger">*</span>
                                    <input id="f_name" class="form-control @error('f__name') is-invalid @enderror"
                                        type="text" name="f_name" value="{{old('f_name')}}">

                                    @error('f_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">First Name</label>
                                    <span class="text-danger">*</span>
                                    <input id="l_name" class="form-control @error('l__name') is-invalid @enderror"
                                        type="text" name="l_name" value="{{old('l_name')}}">

                                    @error('l_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-control-label">Email</label>
                                    <span class="text-danger">*</span>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror"
                                        type="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-control-label">Phone</label>
                                    <span class="text-danger">*</span>
                                    <input id="phone" class="form-control @error('phone') is-invalid @enderror"
                                        type="text" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile-picture" class="form-control-label">Photo</label>
                                    <input id="profile-picture"
                                        class="form-control @error('profile_picture') is-invalid @enderror" type="file"
                                        accept="image/*" name="profile_picture" value="{{ old('profile_picture') }}">
                                    @error('profile_picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label">User Type</label>
                                    <span class="text-danger">*</span>
                                    <select id="role" class="form-select @error('role') is-invalid @enderror"
                                        aria-label="Default select example" name="role" id="role">
                                        <option selected disabled> Select a Role</option>
                                        @foreach($roles as $key => $role)
                                        <option value="{{$role->name}}" @if ($role->name == old('role'))
                                            selected="selected"
                                            @endif>{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="contact-details" style="display: none;">
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Contact Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country" class="form-control-label">Country</label>
                                        <span class="text-danger">*</span>
                                        <select id="country"
                                            class="form-select @error('country_id') is-invalid @enderror"
                                            aria-label="Default select example" name="country_id">
                                            <option selected disabled> Select a Country</option>
                                            @foreach($countries as $key => $country)
                                            <option value="{{$country->id}} "@if ($country->id == old('country_id'))
                                                selected="selected"
                                                @endif>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address" class="form-control-label">Address</label>
                                        <span class="text-danger">*</span>
                                        <input id="address" class="form-control @error('address') is-invalid @enderror"
                                            type="text" name="address" value="{{ old('address') }}">
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div id="provider-details" style="display: none;">
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Service Provider Details</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="addtional-contact" class="form-control-label">Additional
                                            Contact</label>
                                        <input id="additional-contact"
                                            class="form-control @error('additional_contact') is-invalid @enderror"
                                            type="text" name="additional_contact" value="{{ old('additional_contact')}}">
                                    </div>
                                    @error('additional_contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="document" class="form-control-label">Document</label>
                                        <span class="text-danger">*</span>
                                        <input id="document"
                                            class="form-control @error('document') is-invalid @enderror" type="file"
                                            accept="application/pdf,application/msword" name="document">
                                        @error('document')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="info_text" class="form-control-label">Info</label>
                                        <span class="text-danger">*</span>
                                        <textarea id="info_text"
                                            class="ckeditor form-control @error('info_text') is-invalid @enderror"
                                            rows="3" name="info_text">{{ old('info_text')}}</textarea>
                                        @error('info_text')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="user-details" style="display: none;">
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Service User Details</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob" class="form-control-label">Date of Birth</label>
                                        <span class="text-danger">*</span>
                                        <input id="dob" class="form-control @error('dob') is-invalid @enderror"
                                            type="date" name="dob" value="{{ old('dob') }}">
                                        @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div id="operator-details" style="display: none;">
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Operator Details</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service-provider" class="form-control-label">Service
                                            Provider</label>
                                        <span class="text-danger">*</span>
                                        <select id="service-provider"
                                            class="form-select @error('role') is-invalid @enderror"
                                            aria-label="Default select example" name="service_provider_user_id"
                                            id="service-provider">
                                            <option selected disabled> Select a service provider</option>
                                            @foreach($providers as $key => $provider)
                                            <option value="{{$provider->id}}" @if ($provider->id ==
                                                old('service_provider_user_id'))
                                                selected="selected"
                                                @endif>{{$provider->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('service_provider_user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dob" class="form-control-label">Date of Birth</label>
                                        <span class="text-danger">*</span>
                                        <input id="dob" class="form-control @error('dob') is-invalid @enderror"
                                            type="date" name="dob" value="{{ old('dob') }}">
                                        @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>

                    </div>

                </div>
            </form>
        </div>

    </div>
</div>
@include('layouts.js_loader')
<script>
    $(document).ready(function() { 
        var roleVal = $('#role').val()
        if(roleVal == 'provider')
        {
            $('#contact-details').show();
            $('#provider-details').show();
            $('#user-details').hide();
        }
        else if(roleVal == 'user')
        {
            $('#contact-details').show();
            $('#user-details').show();
            $('#provider-details').hide();
        }
        else if(roleVal == 'operator')
        {
            $('#contact-details').show();
            $('#operator-details').show();
            $('#provider-details').hide();
            $('#user-details').hide();
        }
        else{
            $('#contact-details').hide();
            $('#user-details').hide();
            $('#provider-details').hide();
        }

        $('#role').change(function(){
            val = $(this).val()
            if(val == 'provider')
            {
                $('#contact-details').show();
                $('#provider-details').show();
                $('#user-details').hide();
                $('#operator-details').hide();
            }
            else if(val == 'user')
            {
                $('#contact-details').show();
                $('#user-details').show();
                $('#operator-details').hide();
                $('#provider-details').hide();
            }
            else if(val == 'operator')
            {
                $('#contact-details').show();
                $('#operator-details').show();
                $('#provider-details').hide();
                $('#user-details').hide();
            }
            else{
                $('#contact-details').hide();
                $('#user-details').hide();
                $('#provider-details').hide();
                $('#operator-details').hide();
            }

        });

    })
</script>
@endsection