@extends('frontend.layouts.app')

@section('title', 'Prestasi Sekolah')

@section('content-frontend')

<div class="bg-grey-lighter w-full">
  <div class="mx-32 text-4xl py-16 text-base font-semibold ">
    Detail Album {{ $album_name->name }}
  </div>
</div>
<div class="mx-32 my-24 flex">
  <div class="w-full">
    <div class="content">
      <div class="flex flex-wrap items-stretch content-start">
        @foreach ($galleries as $key => $item)

          @if ($key % 2 == 0)
          <div class="self-auto w-1/2 pr-5 no-underline h-auto mb-10 text-black">
            <a href="{{ $item->image }}" target="_blank" class="no-underline">
              <img src="{{ $item->image }}" alt="" class="w-full object-cover" style="height: 350px; object-fit: cover;">
            </a>
          </div>
          @else
          <div class="self-auto w-1/2 pl-5 no-underline h-auto mb-10 text-black">
            <a href="{{ $item->image }}" target="_blank" class="no-underline">
              <img src="{{ $item->image }}" alt="" class="w-full object-cover" style="height: 350px; object-fit: cover;">
            </a>
          </div>
          @endif

        @endforeach
      </div>
    </div>
  </div>
</div>
<div class="mx-32 my-24 flex justify-between items-center">
  <a href="{{ $galleries->previousPageUrl() }}" class="py-4 px-6 text-grey-darker bg-grey-light no-underline "><i class="fa fa-arrow-left"></i></a>
  <a href="{{ $galleries->nextPageUrl() }}" class="py-4 px-6 text-grey-darker bg-grey-light no-underline "><i class="fa fa-arrow-right"></i></a> 
</div>

@endsection