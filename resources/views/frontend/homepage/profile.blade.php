@extends('frontend.layouts.app')

@section('title', 'Profil Sekolah')

@section('content-frontend')

<div class="bg-grey-lighter w-full">
  <div class="mx-32 text-4xl py-16 text-base font-semibold ">
    Profil Sekolah SDN 1 Karangkobar
  </div>
</div>
<div class="mx-32 my-24 flex">
  <div class="w-2/3 pr-10">
    <div class="content">
      {!! $profile->body !!}
    </div>
  </div>
  <div class="w-1/3">
    <div class="w-full">
      @include('frontend.includes.achievement', ['achievements' => $achievements])
      @include('frontend.includes.event', ['events' => $events])
    </div>
  </div>
</div>

@endsection