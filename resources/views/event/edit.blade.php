@extends('layouts.index', [
    'title' => 'Event: Edit',
    'activePage' => 'Events',
    'subPage' => 'Edit',
])
@section('content')
    <div class="container-fluid">
        <h2>Edit Event</h2>
        <div class="row">
            <div class="col-md-12">
                <form id="main-form" action="{{ route('event.update', $data['event']->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="title"
                                            value="{{ old('title', $data['event']->title) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="event_category_id">Event Category</label>
                                        <span class="text-danger">*</span>
                                        <select class="form-control" name="event_category_id" required>
                                            <option value="" disabled>Select a category</option>
                                            @foreach ($data['eventCategories'] as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('event_category_id', $data['event']->event_category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <span class="text-danger">*</span>
                                        <textarea class="form-control" name="description" required>{{ old('description', $data['event']->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <span class="text-danger">*</span>
                                        <input type="date" class="form-control" name="start_date" value="{{ old('start_date', $data['event']->start_date) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <span class="text-danger">*</span>
                                        <input type="date" class="form-control" name="end_date" value="{{ old('end_date', $data['event']->end_date) }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total_space">Total Space</label>
                                        <span class="text-danger">*</span>
                                        <input type="number" class="form-control" name="total_space" value="{{ old('total_space', $data['event']->total_space) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="price" value="{{ old('price', $data['event']->price) }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" class="form-control" name="country" value="{{ old('country', $data['event']->country) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <span class="text-danger">*</span>
                                        <select class="form-control" name="status" required>
                                            <option value="1" {{ old('status', $data['event']->status) == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('status', $data['event']->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        @if ($data['event']->image_url)
                                            <div class="mb-2">
                                                <img src="{{ $data['event']->image_url }}" alt="Event Image" style="max-height: 200px;">
                                                <input type="hidden" name="image_url" value="{{ $data['event']->image_url }}">
                                                <input type="hidden" name="image_public_id" value="{{ $data['event']->image_public_id }}">
                                            </div>
                                        @endif
                                        <input type="file" class="form-control" name="image" accept=".jpg,.png,.jpeg,.gif,.svg">
                                        <small class="text-muted">Leave empty to keep current image.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Event</button>
                </form>
            </div>
        </div>
    </div>
@endsection
