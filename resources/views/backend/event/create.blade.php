@extends('backend.layouts.app')
@section('title', 'Admin panel - SDN 1 Karangkobar')
@section('title-dashboard', 'Tambah Berita Sekolah')
{{-- @include('backend.layouts.navbar') --}}
@section('content-backend')

<div class="container">

  <create-event></create-event>
  
</div>
@endsection