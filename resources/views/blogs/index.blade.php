@extends('layouts.index', [
    'title' => 'Package',
    'activePage' => 'Blogs',
    'subPage' => 'Programs',
])

@section('content')
    <div class="container-fluid ">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-column gap-4 p-3" style="min-height: 60vh">
                    <div class="card-header d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Blogs</h6>
                                @if ($search)
                                    <div class=" text-secondary text-xs font-weight-bolder ">
                                        Showing results for "{{ $search }}"
                                    </div>
                                @endif
                            </div>
                            <div class="header d-flex gap-2">
                                <a class="btn btn-primary m-0" href="{{ route('create-blog') }}"> Add Blog</a>
                                <div class="">
                                    <div class="btn btn-primary m-0" id="filter" data-bs-toggle="collapse"
                                        href="#filter-options" role="button" aria-expanded="false"
                                        aria-controls="filter-options">
                                        <i class="bi bi-funnel"></i>
                                    </div>

                                </div>
                            </div>
                        </div>

                        
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
                                            title
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date
                                        </th>
                                        <th class="text-secondary opacity-7">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($blogs as $key => $blog)
                                        <tr>
                                            <td>
                                                <div class="d-flex ps-4">
                                                    <div>
                                                        {{-- {{ ($blogs->currentPage() - 1) * $blogs->perPage() + $key + 1 }} --}}
                                                        {{$loop-> iteration}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="text-truncate" style="max-width: 30ch;" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="{{ $blog->title }}">
                                                    {{ $blog->title }}
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="">
                                                    {{ $blog->created_at }}
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <button class="btn btn-link text-secondary mb-0" id="dropdownMenuButton"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v text-xs"></i>
                                                </button>
                                                <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                                                    aria-labelledby="dropdownMenuButton">
                                                    <li class="mb-2">
                                                        <a class="dropdown-item border-radius-md"
                                                            href="{{ route('edit-blog', ['id' => $blog->id, 'page' => app('request')->input('page')]) }}">
                                                            Edit
                                                        </a>
                                                    </li>
                                                    <li class="mb-2">
                                                        <form
                                                            action="{{ route('delete-blog', ['id' => $blog->id, 'page' => app('request')->input('page')]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button class="dropdown-item border-radius-md" href=>
                                                                Delete
                                                            </button>
                                                        </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.0/dist/index.bundle.min.js"></script>
@endsection
