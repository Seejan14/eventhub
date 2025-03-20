@extends('layouts.index',[
'title' => 'Package',
'activePage' =>'Blogs',
'subPage' => 'Create',
])

@section('content')
<div class="container-fluid ">
    <div class="row">
        <div class="col-md-12">
            <form method="post" action="{{route('store-blog')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Blog Details</p>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="media" class="form-control-label">
                                        Media</label>
                                    <span class="text-danger">*</span>
                                    <div class="btn btn-primary" onclick="$('#media').trigger('click')">
                                        <i class="bi bi-upload"></i>
                                    </div>
                                    <input id="media" class="form-control @error('media') is-invalid @enderror"
                                        type="file" name="media[]" multiple hidden
                                        onchange="addNewPhotos('media-preview')">

                                    @error('media')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 d-flex flex-row flex-wrap gap-1" id="media-preview"></div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="author" class="form-control-label">Author</label>
                                    <input id="author" class="form-control @error('author') is-invalid @enderror"
                                        type="text" name="author" value="{{old('author')}}">

                                    @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile-picture" class="form-control-label">Author Photo</label>
                                    <input id="profile-picture"
                                        class="form-control @error('author_photo') is-invalid @enderror" type="file"
                                        accept="image/*" name="author_photo" value="{{ old('author_photo') }}">
                                    @error('author_photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-control-label">Description</label>
                                    <span class="text-danger">*</span>
                                    <textarea id="description"
                                        class="ckeditor form-control @error('description') is-invalid @enderror" rows="3"
                                        name="description"
                                        placeholder="">{{ old('description')}}</textarea>
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
<script>
    var accomodationImageId = 0;
    function addNewPhotos(elementId)
    {
        console.log(elementId)
        var newContent = "";
        for( i = 0; i < event.target.files.length; i++)
        {
            var url = URL.createObjectURL(event.target.files[i]);
        // $('#accomodation-media-preview').html(`<a href=${url} data-toggle='lightbox'><img src={{asset('/assets/img/user.jpg')}} class='img-fluid w-10 mx-auto'></a>`)
            newContent += `
            <div style="width:75px;position:relative" id="media-${accomodationImageId}">
                    <img src=${url} class='img-fluid w-100 mx-auto'>
                    
            </div>
            `
            // <i class="bi bi-x-circle-fill delete-icon" style="position:absolute;top:0;right:0;cursor:pointer;" onclick="handleDelete('media-${accomodationImageId}')" ></i>
            accomodationImageId++;
        }        
        $(`#${elementId}`).html(newContent);

    }

    function handleDelete(id)
    {
        $(`#${id}`).hide();
    }
</script>
@include('layouts.js_loader')
@endsection