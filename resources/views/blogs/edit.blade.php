@extends('layouts.index',[
'title' => 'Package',
'activePage' =>'Blogs',
'subPage' => 'Edit',
])

@section('content')
<div class="container-fluid ">
    <div class="row">
        <div class="col-md-12">
            <form id="main-form" method="post" action="{{route('update-blog',['id'=>$blog->id])}}" enctype="multipart/form-data">
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
                                        type="text" name="title" 
                                        @if(old('title')) 
                                            value="{{old('title')}}" 
                                        @else
                                            value="{{$blog->title}}" 
                                        @endif>

                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <label class="form-control-label">
                                Old Media</label>
                            <div class="col-md-12 d-flex flex-row flex-wrap gap-1" id="old-media-preview">
                                @foreach($blog->media as $key => $media)
                                @if(!old('delete_old_media') )
                                <div id="{{'old_media_'.$media->id}}" style="width:100px;position:relative">
                                    <img src="{{asset($media->media)}}" class='img-fluid w-100 mx-auto'>
                                    <i class="bi bi-x-circle-fill delete-icon"
                                        style="position:absolute;top:0;right:0;cursor:pointer;"
                                        onclick="handleDelete('old_media',{{$media->id}})"></i>
                                </div>
                                @elseif(!in_array($media->id,old('delete_old_media')))
                                <div id="{{'old_media_'.$media->id}}" style="width:75px;position:relative">
                                    <img src="{{asset($media->media)}}" class='img-fluid w-100 mx-auto'>
                                    <i class="bi bi-x-circle-fill delete-icon"
                                        style="position:absolute;top:0;right:0;cursor:pointer;"
                                        onclick="handleDelete('old_media',{{$media->id}})"></i>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="media" class="form-control-label">
                                        New Media</label>
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
                                        type="text" name="author" 
                                        @if(old('author')) 
                                            value="{{old('author')}}" 
                                        @else
                                            value="{{$blog->author}}" 
                                        @endif>

                                    @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="author-photo" class="form-control-label">Author Photo</label>
                                        <input id="author-photo" prev="{{ asset($blog->author_photo) }}"
                                            class="form-control @error('author_photo') is-invalid @enderror" type="file"
                                            accept="image/*" name="author_photo" value="{{ old('author_photo') }}">
                                        @error('author_photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div id="author-preview">
                                    @if($blog->author_photo)
                                    <div style="width:75px;position:relative">
                                        <img src="{{ asset($blog->author_photo) }}" class='img-fluid w-100 mx-auto'>
                                        
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-control-label">Description</label>
                                    <span class="text-danger">*</span>
                                    <textarea id="description"
                                        class="ckeditor form-control @error('description') is-invalid @enderror" rows="3"
                                        name="description"
                                        placeholder=""> 
                                        @if(old('description')) 
                                            {{old('description')}} 
                                        @else
                                            {{$blog->description}}
                                        @endif
                                    </textarea>
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

    function handleDelete(elementId,id)
    {
        $(`#${elementId+'_'+id}`).hide();
        $('#main-form').append(`<input type="text" name="delete_${elementId}[]" value=${id} hidden>`)
    }

    $(document).ready(function(){       

        var deleteOldMediaIds = {!! json_encode(old('delete_old_media')) !!};
        if(deleteOldMediaIds)
        {
            deleteOldMediaIds.forEach(id => {
                $('#main-form').append(`<input type="text" name="delete_old_media[]" value=${id} hidden>`)
                
            });
        }

        $('#author-photo').change(function(){
            var blog = {!! json_encode($blog) !!};
            console.log(blog);
            if(event.target.files.length > 0)
            {
                var url = URL.createObjectURL(event.target.files[0]);

                $('#author-preview').html(`
                    <div style="width:75px;position:relative">
                            <img src=${url} class='img-fluid w-100 mx-auto'>
                            
                    </div>
                `)
            }
            else
            {
                var url = $(this).attr('prev') 
                $('#author-preview').html(`
                    <div style="width:75px;position:relative">
                            <img src=${url} class='img-fluid w-100 mx-auto'>
                            
                    </div>
                `);

            }
        })
 
    })
</script>
@include('layouts.js_loader')
@endsection