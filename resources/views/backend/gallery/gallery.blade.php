@extends('backend.layouts.app')
@section('title', 'Admin panel - SDN 1 Karangkobar')
@section('title-dashboard', 'Galeri Sekolah')
{{-- @include('backend.layouts.navbar') --}}
@section('content-backend')

<div class="container">

  <list-gallery :gallery="{{ $galleries }}" :album_id="{{ $id }}"></list-gallery>
  
</div>
@endsection