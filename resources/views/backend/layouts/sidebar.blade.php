<div id="sidebar" class="bg-indigo-darker md:w-64 overflow-y-auto sm:w-screen">
  <header class="flex text-center justify-between items-center px-4 py-5">
    <a href="#" class="no-underline text-white text-base">
      Admin Panel
    </a>
  </header>
  <ul id="menu" class="flex flex-col list-reset sm:hidden md:block">
    <li>
      <p class="text-sm mb-1 text-white opacity-50 px-4 py-2">Dashboard</p>
    </li>  
    <li class="block">
        <a href="{{ route('dashboard') }}" class="no-underline text-white text-sm block h-full w-full px-8 py-4 {{ Request::is('dashboard*') ? 'bg-indigo-dark hover:bg-indigo-light' : 'hover:bg-indigo-soft' }}">
            <i class="fa fa-home mr-2" aria-hidden="true"></i>
            <span style="position: relative; top: -2px;" class="text-white">Beranda</span>
        </a>
    </li>
    <li>
      <p class="text-sm mb-1 text-white opacity-50 px-4 py-2">Informasi Sekolah</p>
    </li>
    <li class="block">
        <a href="{{ route('profile') }}" class="no-underline text-white text-sm block h-full w-full px-8 py-4 {{ Request::is('profil-sekolah*') ? 'bg-indigo-dark hover:bg-indigo-light' : 'hover:bg-indigo-soft' }}">
            <i class="fa fa-building mr-2" aria-hidden="true"></i>
            <span style="position: relative; top: -2px;" class="text-white">Profil sekolah</span>
        </a>
    </li>
    <li class="block">
        <a href="{{ route('teacher') }}" class="no-underline text-white text-sm block h-full w-full px-8 py-4 {{ Request::is('daftar-guru*') ? 'bg-indigo-dark hover:bg-indigo-light' : 'hover:bg-indigo-soft' }}">
            <i class="fa fa-bars mr-2" aria-hidden="true"></i>
            <span style="position: relative; top: -2px;" class="text-white">Daftar guru</span>
        </a>
    </li>
    <li class="block">
        <a href="{{ route('program') }}" class="no-underline text-white text-sm block h-full w-full px-8 py-4 {{ Request::is('program-sekolah*') ? 'bg-indigo-dark hover:bg-indigo-light' : 'hover:bg-indigo-soft' }}">
            <i class="fa fa-table mr-2" aria-hidden="true"></i>
            <span style="position: relative; top: -2px;" class="text-white">Program sekolah</span>
        </a>
    </li>
    <li>
    <li class="block">
        <a href="{{ route('student') }}" class="no-underline text-white text-sm block h-full w-full px-8 py-4 {{ Request::is('daftar-siswa*') ? 'bg-indigo-dark hover:bg-indigo-light' : 'hover:bg-indigo-soft' }}">
            <i class="fa fa-users mr-2" aria-hidden="true"></i>
            <span style="position: relative; top: -2px;" class="text-white">Siswa</span>
        </a>
    </li>
    <li>
      <p class="text-sm mb-1 text-white opacity-50 px-4 py-2">Publikasi</p>
    </li>
    <li class="block">
        <a href="{{ route('achievement') }}" class="no-underline text-white text-sm block h-full w-full px-8 py-4 {{ Request::is('daftar-prestasi*') ? 'bg-indigo-dark hover:bg-indigo-light' : 'hover:bg-indigo-soft' }} {{ Request::is('tambah-prestasi*') ? 'bg-indigo-dark hover:bg-indigo-light' : 'hover:bg-indigo-soft' }} {{ Request::is('ubah-prestasi*') ? 'bg-indigo-dark hover:bg-indigo-light' : 'hover:bg-indigo-soft' }}">
            <i class="fa fa-trophy mr-2" aria-hidden="true"></i>
            <span style="position: relative; top: -2px;" class="text-white">Prestasi</span>
        </a>
    </li>
    <li class="block">
        <a href="{{ route('event') }}" class="no-underline text-white text-sm block h-full w-full px-8 py-4 {{ Request::is('event-sekolah*') ? 'bg-indigo-dark hover:bg-indigo-light' : 'hover:bg-indigo-soft' }}">
            <i class="fa fa-newspaper-o mr-2" aria-hidden="true"></i>
            <span style="position: relative; top: -2px;" class="text-white">Berita</span>
        </a>
    </li>
    <li class="block">
        <a href="{{ route('category') }}" class="no-underline text-white text-sm block h-full w-full px-8 py-4 {{ Request::is('kategori-event*') ? 'bg-indigo-dark hover:bg-indigo-light' : 'hover:bg-indigo-soft' }}">
            <i class="fa fa-tags mr-2" aria-hidden="true"></i>
            <span style="position: relative; top: -2px;" class="text-white">Kategori berita</span>
        </a>
    </li>
    <li class="block">
        <a href="{{ route('albums') }}" class="no-underline text-white text-sm block h-full w-full px-8 py-4 {{ Request::is('album*') ? 'bg-indigo-dark hover:bg-indigo-light' : 'hover:bg-indigo-soft' }}">
            <i class="fa fa-image mr-2" aria-hidden="true"></i>
            <span style="position: relative; top: -2px;" class="text-white">Galeri sekolah</span>
        </a>
    </li>
  </ul>
</div>

<div id="content" class="bg-transparent flex-grow flex-shrink flex-auto overflow-y-auto">
  <div id="info" class="py-4 border-b border-grey-light">
    <div class="flex justify-between flex-grow items-center px-8">
      <div class="flex">
          <div>@yield('title-dashboard')</div>
      </div>
      <div class="flex">
        <ul class="flex list-reset text-black">
          <li class="px-4">
            <span class="text-sm">
              <a href="{{ route('homepage') }}" title="Lihat website" class="no-underline" title="Keluar dari admin panel">
                    <i class="fa fa-globe" aria-hidden="true"></i>
              </a>
            </span>
            </li>
            <li class="border-l px-4">
            <span class="text-sm">
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="no-underline" title="Keluar dari admin panel">
                  <span style="position: relative; top: -4px;">Logout</span> <i class="fa fa-sign-out" aria-hidden="true"></i>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="py-4 px-8 bg-grey-lighter">
    @yield('content-backend')
  </div>
    
</div>