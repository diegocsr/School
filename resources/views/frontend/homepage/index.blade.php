@extends('frontend.layouts.app')

@section('title', 'SDN 1 Karangkobar')

@section('content-frontend')

<homepage-header></homepage-header>

<div class="mx-32">
  <section class="relative" style="height: 170px;">
    <div class="flex absolute pin-b w-full">
      <a href="{{ route('index-event') }}" class="no-underline main-link flex-1 px-10 py-10 main-blue text-right">
        <img class="w-1/5 h-16" src="{{ asset('storage/image/event-icon.svg') }}" alt="">
        <div class="text-4xl text-white font-bold text-left w-1/3 mt-5 no-underline">Event Sekolah</div>
      </a>
      <a href="{{ route('index-achievement') }}" class="no-underline main-link flex-1 px-10 py-10 main-sky text-right">
        <img class="w-1/5 h-16" src="{{ asset('storage/image/announcement-icon.svg') }}" alt="">
        <div class="text-4xl text-white font-bold text-left w-1/3 mt-5 no-underline">Prestasi sekolah</div>
      </a>
      <a href="{{ route('index-teacher') }}" class="no-underline main-link flex-1 px-10 py-10 main-green text-right">
        <img class="w-1/5 h-16" src="{{ asset('storage/image/profil-icon.svg') }}" alt="">
        <div class="text-4xl text-white font-bold text-left w-1/3 mt-5 no-underline">Profil Guru</div>
      </a>
    </div>
  </section>

  <section class="my-32">
    <div class="flex">
      <div class="w-2/3 pr-32">
        <div class="text-4xl font-bold text-black mb-16">Tentang sekolah</div>
        
        <homepage-intro></homepage-intro>

      </div>
      <div class="w-1/3">
        <img class="w-full" src="{{ asset('storage/image/dump-1.jpg') }}" alt="">
      </div>
    </div>
  </section>

</div>
<div class="bg-grey-lighter">
  <section class="mx-32 py-32">
    <div>
      <div class="text-4xl font-bold text-black mb-16">Program sekolah</div>
      
      <homepage-program></homepage-program>

    </div>
  </section>
  <section class="mx-32 py-32">
    <div>
      <div class="flex justify-between items-center mb-16">
        <div class="text-4xl font-bold text-black">Prestasi</div>
        <a href="{{route('index-achievement')}}" class="no-underline text-grey-dark inline-block btn-arrow">
          Lihat semua prestasi <img src="{{ asset('storage/image/arrow-icon.svg') }}" class="inline-block w-4 ml-2" alt="">
        </a>
      </div>
      
      <homepage-achievement></homepage-achievement>

    </div>
  </section>
</div>

  <section class="mx-32 py-32">
    <div>
      <div class="flex justify-between items-center mb-16">
        <div class="text-4xl font-bold text-black">Berita dan Pengumuman</div>
        <a href="{{route('index-event')}}" class="no-underline text-grey-dark inline-block btn-arrow">
          Lihat semua berita <img src="{{ asset('storage/image/arrow-icon.svg') }}" class="inline-block w-4 ml-2" alt="">
        </a>
      </div>
      
      <homepage-event></homepage-event>

    </div>
  </section>

@endsection