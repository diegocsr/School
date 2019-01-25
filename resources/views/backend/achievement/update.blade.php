@extends('backend.layouts.app')
@section('title', 'Admin panel - SDN 1 Karangkobar')
@section('title-dashboard', 'Ubah Data Prestasi')
{{-- @include('backend.layouts.navbar') --}}
@section('content-backend')

<div class="container">
  
  <update-achievement :data="{{ $data }}"></update-achievement>
  
</div>
@endsection