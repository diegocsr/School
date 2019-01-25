@extends('frontend.layouts.app')

@section('title', $detail->title)

@section('content-frontend')

<div class="bg-grey-lighter w-full">
  <div class="mx-32 text-4xl py-16 text-base font-semibold ">
    Detail Prestasi
  </div>
</div>
<div class="mx-32 my-24 flex">
  <div class="w-2/3 pr-10">
    <div class="w-full mb-10 bg-cover no-repeat" style="background-image: url({{ $detail->image }}); height: 300px; background-repeat: no-repeat; background-size: cover;"></div>
    <div class="text-2xl text-black mb-6 font-semibold">{{ $detail->title }}</div>
    <span class="block mb-12 text-grey"><i class="fa fa-info-circle mr-2 text-grey text-base" aria-hidden="true"></i>{{ date('d M Y', strtotime($detail->created_at)) }} · <i class="fa fa-user mr-2 text-grey text-base" aria-hidden="true"></i>Admin</span>
    <div class="block text-lg font-semibold mb-16 text-indigo py-4 px-6 rounded bg-grey-lighter w-full">Diraih oleh : {{ $detail->name }}</div>
    <div class="content">
      {!! $detail->description !!}
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