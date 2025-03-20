@extends('layouts.index', [
    'title' => 'Event: Create',
    'activePage' => 'Events',
    'subPage' => 'Create',
])

@section('content')
<div class="container-fluid">
    <h2>Create Event</h2>
    <div class="row">
        <div class="col-md-12">
            <form id="main-form" action="{{ route('event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_category_id">Event Category</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" name="event_category_id" required>
                                        <option value="" disabled selected>Select a category</option>
                                        @foreach ($data['eventCategories'] as $category)
                                            <option value="{{$category->id}}" @if ($category->id == old('event_category_id')) selected @endif>
                                                {{$category->title}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description" required>{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <span class="text-danger">*</span>
                                    <input type="file" class="form-control" name="image" accept=".jpg,.png,.jpeg,.gif,.svg,.avif" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <span class="text-danger">*</span>
                                    <input type="date" class="form-control" name="start_date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <span class="text-danger">*</span>
                                    <input type="date" class="form-control" name="end_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_space">Total Space</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" class="form-control" name="total_space" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <span class="text-danger">*</span>
                                    <input type="number" step="0.01" class="form-control" name="price" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Country</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="country" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <span class="text-danger">*</span>
                                    <select class="form-control" name="status" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Event</button>
            </form>
        </div>
    </div>
</div>
@endsection
