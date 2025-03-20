@extends('layouts.index', [
    'title' => 'Event',
    'activePage' => 'Event Categories',
    'subPage' => 'Categories',
])

@section('content')
    <div class="container-fluid ">
        <div class="row">
            <div class="col-12">
                <div class="p-3 d-flex flex-column gap-4" style="min-height: 60vh">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>Event Categories Table</h6>
                            <a class="btn btn-primary" href="{{ route('create-event-category') }}"> Add Category</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table-template dataTable" id="myTable">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">
                                            sn
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            image
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            title
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            created_at
                                        </th>
                                        <th class="text-secondary opacity-7">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $category)
                                        <tr>
                                            <td>
                                                <div class="d-flex ps-4">
                                                    <div>
                                                        {{ $key + 1 }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <a href="{{ $category->image_url }}" data-toggle="lightbox">
                                                        <img src="{{ $category->image_url }}"
                                                            class="avatar avatar-sm me-3" alt="{{$category->title}} image">
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex flex-column justify-content-center">
                                                    {{ $category->title }}
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex flex-column justify-content-center">
                                                    {{ $category->created_at }}
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <a id="dropdownMenuButton-{{ $category->id }}" data-bs-toggle="dropdown"
                                                    type="button" class="px-3" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17"
                                                        viewBox="0 0 16 17" fill="none">
                                                        <path
                                                            d="M8 3.75C8.41421 3.75 8.75 3.41421 8.75 3C8.75 2.58579 8.41421 2.25 8 2.25C7.58579 2.25 7.25 2.58579 7.25 3C7.25 3.41421 7.58579 3.75 8 3.75Z"
                                                            stroke="#151515" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M8 9.25C8.41421 9.25 8.75 8.91421 8.75 8.5C8.75 8.08579 8.41421 7.75 8 7.75C7.58579 7.75 7.25 8.08579 7.25 8.5C7.25 8.91421 7.58579 9.25 8 9.25Z"
                                                            stroke="#151515" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M8 14.75C8.41421 14.75 8.75 14.4142 8.75 14C8.75 13.5858 8.41421 13.25 8 13.25C7.58579 13.25 7.25 13.5858 7.25 14C7.25 14.4142 7.58579 14.75 8 14.75Z"
                                                            stroke="#151515" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </a>
                                                <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                                                    aria-labelledby="dropdownMenuButton">
                                                    <li class="mb-2">
                                                        <a class="dropdown-item border-radius-md"
                                                            href="{{ route('edit-event-category', ['id' => $category->id]) }}">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li class="mb-2">
                                                        <a class="dropdown-item border-radius-md viewBtn"
                                                            href="#"onclick="showCategoryDetails({{ $category->id }})">
                                                            View
                                                        </a>
                                                    </li>
                                                </ul>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoryModalLabel">Event Category Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="color: black; font-weight:600">X</button>
                </div>
                <div class="modal-body" id="categoryModalBody">
                    <!-- Category details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function showCategoryDetails(categoryId) {
            $.ajax({
                url: '{{ url('event-categories/') }}/' + categoryId + '/view',
                type: 'GET',
                success: function(response) {
                    // Assuming response contains the category details
                    var modalBody = $('#categoryModal .modal-body');
                    modalBody.empty(); // Clear previous details

                    // Append new details, you might need to adjust based on your actual response structure
                    modalBody.append('<p>Title: ' + response.title + '</p>');
                    modalBody.append('<div style="display:flex; gap:5px">Description: ' + response.description +
                        '</div>');
                    modalBody.append('<div style="display:flex; gap:5px"><img src='+ response.image_url +
                        ' style="height:5rem;" alt="" image></div>');
                    // Add more details as needed

                    $('#categoryModal').modal('show'); // Show the modal
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.0/dist/index.bundle.min.js"></script>
@endsection

