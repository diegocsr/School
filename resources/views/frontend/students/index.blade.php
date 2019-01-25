@extends('frontend.layouts.app')

@section('title', 'Prestasi Sekolah')

@section('content-frontend')

<div class="bg-grey-lighter w-full">
  <div class="mx-32 text-4xl py-16 text-base font-semibold ">
    Daftar Berita Sekolah
  </div>
</div>
<div class="mx-32 my-24 flex">
  <div class="w-full pr-10">
    <div class="content">
      <div class="w-full">
        @foreach ($events as $item)
        <div class="flex w-full mb-6">
          <div class="w-1/5" style=""></div>
          <div class="w-4/5 pl-6"></div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

@endsection