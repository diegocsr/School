<nav>
  <header-info></header-info>
  
  <div class="w-full bg-white px-32 py-4 border-b border-grey-light">
    <div class="flex justify-between">
      <ul class="list-reset flex">
        <li class="mr-8"><a class="inline-block text-black no-underline hover:text-indigo-dark {{ Request::is('/') ? 'text-indigo-dark hover:text-indigo-light font-semibold' : '' }}" href="/">Beranda</a></li>
        <li class="mr-8"><a class="inline-block text-black no-underline hover:text-indigo-dark {{ Request::is('informasi-sekolah*') ? 'text-indigo-dark hover:text-indigo-light font-semibold' : '' }}" href="{{ route('school.profile') }}">Profil</a></li>
        <li class="mr-8"><a class="inline-block text-black no-underline hover:text-indigo-dark {{ Request::is('prestasi*') ? 'text-indigo-dark hover:text-indigo-light font-semibold' : '' }}" href="{{ route('index-achievement') }}">Prestasi</a></li>
        <li class="mr-8"><a class="inline-block text-black no-underline hover:text-indigo-dark {{ Request::is('berita-sekolah*') ? 'text-indigo-dark hover:text-indigo-light font-semibold' : '' }}" href="{{ route('index-event') }}" href="#">Berita</a></li>
        <li class="mr-8"><a class="inline-block text-black no-underline hover:text-indigo-dark {{ Request::is('daftar-album*') ? 'text-indigo-dark hover:text-indigo-light font-semibold' : '' }} {{ Request::is('detail-album*') ? 'text-indigo-dark hover:text-indigo-light font-semibold' : '' }}" href="{{ route('index-album') }}">Galeri</a></li>
        <li class="mr-8"><a class="inline-block text-black no-underline hover:text-indigo-dark {{ Request::is('informasi-guru*') ? 'text-indigo-dark hover:text-indigo-light font-semibold' : '' }}" href="{{ route('index-teacher') }}">Guru</a></li>
      </ul>
      <ul class="list-reset flex">
        <li class="">
          @auth
            <a class="inline-block text-black no-underline font-bold hover:text-indigo-dark" href="{{ route('dashboard') }}">Dashboard</a>
          @else
            {{-- <a class="inline-block text-black no-underline font-bold hover:text-indigo-dark" href="#">Pendaftaran siswa</a> --}}
          @endauth
        </li>
      </ul>
    </div>
  </div>
</nav>