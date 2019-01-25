@extends('backend.layouts.app')
@section('title', 'Admin panel - SDN 1 Karangkobar')
@section('title-dashboard', 'Beranda')
{{-- @include('backend.layouts.navbar') --}}
@section('content-backend')

<div class="container">
  
  <dashboard-info></dashboard-info>

  <div class="w-full flex ">

    <school-contact></school-contact>

    <school-info></school-info>

  </div>
</div>
@endsection