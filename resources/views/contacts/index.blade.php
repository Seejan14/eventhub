@extends('layouts.index', [
    'title' => 'Contacts',
    'activePage' => 'Contacts',
    'subPage' => 'Contacts',
])
@section('content')
    <div class="container-fluid ">
        <div class="row">
            <div class="col-12">
                <div class="p-3 d-flex flex-column gap-4" style="min-height: 60vh">
                    <div class="card-header pb-0 d-flex justify-content-between">
                        <h6>Contacts</h6>
                        {{-- <a class="btn btn-primary" href="{{ route('guides.create') }}"> Create Guides</a> --}}

                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table-template dataTable" id="myTable">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">
                                            SN</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Phone</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Email</th>
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th> --}}
                                        
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Address</th>
                                        {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th> --}}
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $contact)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $contact->full_name }}</td>
                                            <td>{{ $contact->phone }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ $contact->address }}</td>
                                            <td><a href="{{ route('contacts.show', ['id' => $contact->id]) }}" class="btn btn-primary btn-sm shadow rounded-pill px-4">  View </a></td>

                                            
                                            <td>
                                                {{-- <div class="dropdown">
                                                    <a id="dropdownMenuButton-{{ $contact->address }}"
                                                        data-bs-toggle="dropdown" type="button" class="px-3"
                                                        aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="17" viewBox="0 0 16 17" fill="none">
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
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-{{ $contact->id }}">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('contacts.show', ['id' => $contact->id]) }}">View</a>
                                                        </li> --}}
                                                        {{-- <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('contacts.edit',$contact->id) }}">
                                                        Edit
                                                    </a>
                                                </li> --}}
                                                        {{-- <li>
                                                    <form action="{{ route('contacts.destroy', $contact->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this guide details?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </li> --}}
                                                    </ul>
                                                </div>
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
@endsection
