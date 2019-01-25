@extends('frontend.layouts.app')

@section('title', 'Daftar Guru')

@section('content-frontend')

<div class="bg-grey-lighter w-full">
  <div class="mx-32 text-4xl py-16 text-base font-semibold ">
    Daftar Guru SDN 1 Karangkobar
  </div>
</div>
<div class="mx-32 my-24 flex">
  <div class="w-2/3 pr-10">
    <div class="w-full">
      @foreach ($teachers as $item)
      <div class="flex w-full mb-8 border-b pb-6">
        <div class="w-1/5" style="background-size: cover; height: 100px; background-image: url({{ $item->photo }});"></div>
        <div class="w-4/5 pl-6">
          <div class="text-base text-black mb-4 font-semibold">{{ $item->name }}</div>
          <div class="text-sm text-grey-darker mb-2">NIP : {{ $item->nip }}</div>
          <div class="text-sm text-grey-darker mb-2">Posisi : {{ $item->position->position }}</div>
          <div class="text-sm text-grey-darker mb-2">Mata Pelajaran : <span class="font-semibold">{{ $item->course }}</span></div>
        </div>
      </div>
      @endforeach
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