@extends('backend.layouts.app')
@section('title', 'Admin panel - SDN 1 Karangkobar')
@section('title-dashboard', 'Update Berita Sekolah')
{{-- @include('backend.layouts.navbar') --}}
@section('content-backend')

<div class="container">

  <update-event :event="{{ $event }}"></update-event>
  
</div>
@endsection