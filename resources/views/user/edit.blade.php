@extends('layouts.index',[
'title' => 'Users',
'subPage' => 'Edit'
])

@section('content')
<div class="container-fluid ">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{route('update-user',['id'=>$user->id,'page'=>$page])}}"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-body">
                        <p class="text-uppercase text-sm">User Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">First Name</label>
                                    <span class="text-danger">*</span>
                                    <input id="f_name" class="form-control @error('f_name') is-invalid @enderror"
                                        type="text" name="f_name" @if(old('f_name')) value="{{old('f_name')}}" @else
                                        value="{{$user->f_name}}"@endif>

                                    @error('f_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Last Name</label>
                                    <span class="text-danger">*</span>
                                    
                                        <input id="l_name" class="form-control @error('l_name') is-invalid @enderror"
                                        type="text" name="l_name" @if(old('l_name')) value="{{old('l_name')}}" @else
                                        value="{{$user->l_name}}"@endif>

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
                                        type="email" name="email" @if(old('email')) value="{{old('email')}}" @else
                                        value="{{$user->email}}"@endif>
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
                                        type="text" name="phone" @if(old('phone')) value="{{old('phone')}}" @else
                                        value="{{$user->phone}}"@endif>
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
                        </div>
                        <button class="btn btn-primary" type="submit">Submit</button>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@include('layouts.js_loader')
<script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.0/dist/index.bundle.min.js"></script>
<script>
    $(document).ready(function() { 
        var userStatus = "{{$user->status}}";

        if(userStatus == -1)
        {
            $('#approve-btn').show();
        }
        else if(userStatus == 1)
        {
            $('#deactivate-btn').show();
        }
        else
        {
            $('#activate-btn').show();
        }

        $('.change').click(function() {
            var status = $(this).data('status');
            var name = "{{$user->name}}";
            var statusText = status == -1? "unapproved": status==1 ? "active": "inactive";
            var approvalText = status == -1? "approve": status==1 ? "deactivate": "activate";
            $('#staticBackdropLabel').html(`${approvalText} user`);
            $('#modal-text').html(`The user is  currently ${statusText}. This will ${approvalText} ${name}.`);
        });
        $('#confirm-button').click(function(){
            var id = "{{$user->id}}"
            $.ajax({
                url: `{{ url('users/${id}/status') }}`,
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(res) {
                    if(res.status == 1)
                    {
                        $('#deactivate-btn').show();
                        $('#activate-btn').hide();
                        $('#approve-btn').hide();
                    }
                    else if(res.status == -1)
                    {
                        $('#approve-btn').show();
                        $('#activate-btn').hide();
                        $('#deactivate-btn').hide();
                    }
                    else
                    {
                        $('#activate-btn').show();
                        $('#approve-btn').hide();
                        $('#deactivate-btn').hide();
                    }
                    $('#activeStatusModal').modal('hide');
                    $('.change').data('status',res.status);
                    alert("success")

                }
            });
        });
        
        
     })
</script>
@endsection