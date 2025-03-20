@extends('layouts.index',[
'title' => 'Event',
'activePage' =>'Event Categories',
'subPage' => 'Create',
])

@section('content')
<div class="container-fluid ">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{route('store-event-category')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Event Category Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Title</label>
                                    <span class="text-danger">*</span>
                                    <input id="title" class="form-control @error('title') is-invalid @enderror"
                                        type="text" name="title" value="{{old('title')}}">

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile-picture" class="form-control-label">Image</label>
                                    <span class="text-danger">*</span>
                                    <input id="profile-picture"
                                        class="form-control @error('image') is-invalid @enderror" type="file"
                                        accept="image/*" name="image" value="{{ old('image') }}">
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-control-label">Detailed Description</label>
                                    <span class="text-danger">*</span>
                                    <textarea id="description"
                                        class="ckeditor form-control @error('description') is-invalid @enderror" rows="3"
                                        name="description"
                                        placeholder="Enter a information text here...">{{ old('description')}}</textarea>
                                    @error('description')
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
@endsection