<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="{{ asset('css/line-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">
</head>
<body>
  <div id="app">
    @auth
      <div id="wrapper" class="flex h-screen bg-grey-lightest sm:flex-col md:flex-row font-light w-full">
        @include('backend.layouts.sidebar')
      </div>
    @else
      @yield('content-backend')
    @endauth
  </div>

  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
