@extends('backend.layouts.app')
@section('title', 'Admin panel - SDN 1 Karangkobar')
@section('title-dashboard', 'Detail Berita Sekolah')
{{-- @include('backend.layouts.navbar') --}}
@section('content-backend')

<div class="container">

  <show-event :event="{{ $event }}"></show-event>
  
</div>
@endsection