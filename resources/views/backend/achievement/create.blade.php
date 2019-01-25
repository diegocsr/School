@extends('backend.layouts.app')
@section('title', 'Admin panel - SDN 1 Karangkobar')
@section('title-dashboard', 'Tambah Data Prestasi')
{{-- @include('backend.layouts.navbar') --}}
@section('content-backend')

<div class="container">

  <create-achievement></create-achievement>
  
</div>
@endsection