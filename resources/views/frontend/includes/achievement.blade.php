<div class="border rounded border-grey px-6 py-4 mb-6">
  <div class="text-base font-semibold pb-4 border-b border-grey-light">Daftar prestasi</div>
  <div class="mt-4">
    @foreach ($achievements as $item)
      <a href="{{ url('prestasi/'.$item->slug.'/detail') }}" class="flex items-center no-underline text-black mb-4">
        <img src="{{ $item->image_thumbnail }}" alt="" class="w-1/5">
        <div class="text-sm w-4/5 pl-4">
          <div class="hover:text-indigo">{{ substr($item->title, 0, 60) }}...</div>
          <span class="block text-xs text-grey mt-2">{{ date('d-m-Y', strtotime($item->created_at)) }}</span>
        </div>
      </a>
    @endforeach
  </div>
</div>