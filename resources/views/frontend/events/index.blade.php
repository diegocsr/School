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
      <div class="flex flex-wrap items-stretch mb-4">
        @foreach ($events as $item)
        <a href="{{ url('berita-sekolah/'.$item->slug.'/detail') }}" class="self-auto w-1/3 pr-10 no-underline h-auto mb-6">
          <div class="bg-white hover:shadow-md rounded">
            <div class="block mr-4 w-full object-cover bg-cover rounded-t" style="background-image: url({{ $item->photo}}); height: 250px; background-size: cover;" alt=""></div>
            <div class="p-6 text-black leading-normal text-sm">
              @if (strlen($item->title) > 60)
                <div class="no-underline text-black hover:text-indigo">{{ substr($item->title, 0, 60) }}...</div>
              @else
                <div class="no-underline text-black hover:text-indigo">{{ $item->title }}</div>
              @endif  
              <div class="mt-2 text-grey text-xs no-underline">{{ date('d-m-Y', strtotime($item->created_at)) }} | Admin | {{ $item->category->name }}</div>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
</div>

@endsection