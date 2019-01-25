@extends('frontend.layouts.app')

@section('title', 'Prestasi Sekolah')

@section('content-frontend')

<div class="bg-grey-lighter w-full">
  <div class="mx-32 text-4xl py-16 text-base font-semibold ">
    Album Galeri Sekolah
  </div>
</div>
<div class="mx-32 my-24 flex">
  <div class="w-full pr-10">
    <div class="w-full mb-8 relative">
      <img class="w-full" src="{{ $random->image }}" alt="" style="height: 250px; object-fit: cover;">
    </div>
    <div class="content">
      <div class="text-xl mb-6 font-semibold">Daftar Album</div>
      <div class="flex flex-wrap items-stretch content-start">
        @foreach ($albums as $item)
        <a href="{{ url('detail-album/'.$item->id.'/detail') }}" class="self-auto w-1/3 pr-10 no-underline h-auto mb-6 text-black">
          <div class="bg-grey-light py-6 px-8 items-top flex hover:shadow-lg rounded border border-grey-light">
            <div class="flex-2">
              <div class="text-sm font-semibold text-grey-darker">Album</div>
              <div class="text-xl font-semibold mb-2">{{ $item->name }}</div>
            </div>
            <div class="flex-1">
                <div class="text-4xl font-semibold text-right">{{ count($item->galleries) }}</div>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
</div>

@endsection