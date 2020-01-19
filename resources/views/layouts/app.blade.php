<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}',
        }
    </script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito|Indie+Flower" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/fontawesome/css/all.css') }}">
    <script src="{{ asset('libs/ace/ace.js') }}"></script>
</head>
<body>
<div id="app">
    <div id="sidebar">
        <div class="sidebar-title">
            <img src="{{ asset('archaeopteryx.png') }}" alt="" width="200">
            <span>Archaeopteryx</span>
        </div>
        <div id="sidebar-content">
            <hr>
            <ul>
                <li><a href="{{ route('home') }}"><i class="fa fa-list"></i> All domains</a></li>
            </ul>
        </div>
    </div>
    <div id="content">
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @if (session()->has('toast'))
        <div class="position-absolute d-flex flex-column p-4" style="width: 350px">
            <div class="position-fixed" style="bottom: 2rem; right: 2rem">
                @foreach (session()->get('toast') as $toast)
                    <div class="toast" style="min-width: 300px; max-width: 350px;" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
                        <div class="toast-header">
                            <strong class="mr-auto">{{ $toast['title'] ?? 'Archaeopteryx' }}</strong>
                        </div>
                        <div class="toast-body" style="color: #000000">
                            {!! $toast['content'] !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('libs/popper.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function () {
       $('.toast').toast('show');
    });
</script>
</body>
</html>
