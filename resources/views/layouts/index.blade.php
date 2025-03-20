<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head',['title'=>$title ?? 'Event Hub'])
</head>

{{-- <body class="g-sidenav-show   bg-gray-100">
    @yield('absolute-header')
    <div class="min-height-75 bg-primary position-absolute w-100"></div>
    @include('layouts.sidebar.index',['activePage'=>$activePage ?? $title ??'Event Hub','title'=>$title])
    <main class="main-content position-relative border-radius-lg ">
        <div style="min-height: 90vh">
            @include('layouts.navbar.index',['subPage' => $subPage ?? $title ?? 'Event Hub'])
            @yield('content')
        </div>
        @include('layouts.footer.index')
    </main>
</body> --}}
{{-- <body class="g-sidenav-show   bg-gray-100">
    @yield('absolute-header')
    <div class="min-height-75 bg-primary position-absolute w-100"></div> --}}
    <div>
    @include('layouts.sidebar.index',['activePage'=>$activePage ?? $title ??'Event Hub','title'=>$title])
    <main class="main-content position-relative border-radius-lg ">
        <div style="min-height: 90vh">
            @include('layouts.navbar.index',['subPage' => $subPage ?? $title ?? 'Event Hub'])
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert">×</button>
                </div>
            @endif

            @if ($messregular_price = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                    <strong>{{ $messregular_price }}</strong>
                    <button type="button" class="close" data-dismiss="alert">×</button>
                </div>
            @endif

            <script>
                setTimeout(function() {
                    $(".alert").alert('close');
                }, 2500);
            </script>

            @yield('content')
        </div>
        @include('layouts.footer.index')
    </main>
</div>
</body>