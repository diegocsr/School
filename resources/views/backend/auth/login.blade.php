@extends('backend.layouts.app')
@section('title', 'Login - SDN 1 Karangkobar')
@section('content-backend')

<div class="flex justify-center bg-blue-dark items-center h-screen">
  <div class="w-1/3">
    <div class="align-center text-center">
    </div>
    <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
      <div class="bg-white shadow-lg rounded-lg">
        <div class="p-4 pb-0 text-center rounded-t-lg">
          <img class="w-1/5 text-center" src="{{ url('storage/image/logo.png') }}" alt="">
          <div class="text-base text-grey-dark mt-6">Panel Login Administrator</div>
        </div>
        <div class="px-8 pt-6 pb-8">
          <div class="mb-4">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
              Email
            </label>
            <input class="appearance-none border rounded w-full py-3 px-4 text-grey-darker" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @if ($errors->has('email'))
              <div class="text-sm py-2 px-4 border border-red-lighter block text-red bg-red-lightest mt-1 rounded">{{ $errors->first('email') }}</div>
            @endif
          </div>
          <div class="mb-6">
            <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
              Password
            </label>
            <input class="appearance-none border rounded w-full py-3 px-4 text-grey-darker" id="password" type="password" name="password" value="{{ old('email') }}" required>
            @if ($errors->has('password'))
              <div class="text-sm py-2 px-4 block border border-red-lighter text-red bg-red-lightest mt-1 rounded">{{ $errors->first('password') }}</div>
            @endif
          </div>
          {{-- <label class="mb-3 block">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
          </label> --}}
          <div class="w-full text-center">
            <button class="btn-indigo w-full" type="submit">
              Masuk
            </button>
            {{-- {{ route('password.request') }} --}}
            <a class="block text-sm mt-4 text-indigo-dark no-underline hover:text-indigo-darker" href="#">
              Lupa password?
            </a>
          </div>
        </div>
      </div>
    </form>
    <div class="w-full text-center mt-4">
        <a class="text-white opacity-75 no-underline text-sm hover:opacity-100 hover:underline" href="{{ route('homepage') }}">Kembali ke halaman utama</a>
    </div>
  </div>
</div>


{{-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
