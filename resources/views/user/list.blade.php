@extends('layouts.index',[
'title' => 'Users',
'subPage' => 'List',
])

@section('content')
<div class="container-fluid ">
    <div class="row">
        <div class="col-12">
            <div class="p-3" style="min-height: 60vh">
                <div class="card-header">
                    <div class=" d-flex justify-content-between  py-4">
                        <div class="d-flex align-items-center">
                            <h6 class="m-0">Users Table</h6>
                            
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table-template dataTable table-striped " id="myTable">
                            <thead>
                                <tr>
                                    <th>S.N</th>
                                    <th>
                                        Name
                                    </th>
                                    
                                    <th>
                                        Phone Number
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="p-2">
                                    <td>
                                        {{$loop->iteration}}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            {{ $user->phone }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->status == 1)
                                        <span class="badge badge-sm bg-gradient-success">Active</span>
                                        @else
                                        <span class="badge badge-sm bg-gradient-danger">Inctive</span>
                                        @endif
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