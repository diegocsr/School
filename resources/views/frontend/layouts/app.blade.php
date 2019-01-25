<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="{{ asset('css/line-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('frontend.layouts.navbar')
            
            @auth
                <a href="{{route('dashboard')}}" class="fixed opacity-50 w-1/4 pin-b pin-r bg-orange px-10 py-6 rounded z-20 no-underline hover:opacity-100">
                    <div class="font-bold text-lg no-underline text-white">Hi, {{ Auth::user()->name }}</div>
                    <div class="text-sm mt-2 no-underline text-white">Anda sedang login ke sistem, Klik untuk kembali ke dashboard</div>
                </a>
            @endauth

        @yield('content-frontend')

        @include('frontend.layouts.footer')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
