@extends('layouts.admin')
@section('title', 'গ্যালারি ব্যবস্থাপনা')

@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:12px">
  <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary btn-sm">+ নতুন ছবি</a>
</div>
<div class="gallery-grid">
  @forelse ($images as $img)
    @php $src = str_starts_with($img->image, 'http') ? $img->image : asset('storage/'.$img->image); @endphp
    <figure class="gallery-item">
      <img src="{{ $src }}" alt="{{ $img->title_bn }}" class="admin-gallery-thumb" data-lightbox="{{ $src }}" loading="lazy">
      <figcaption>
        <div>{{ $img->title_bn ?? '—' }}</div>
        <div class="admin-actions" style="margin-top:4px">
          <a href="{{ route('admin.gallery.edit', $img) }}" class="btn btn-outline btn-xs">এডিট</a>
          <form method="POST" action="{{ route('admin.gallery.destroy', $img) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
          </form>
        </div>
      </figcaption>
    </figure>
  @empty
    <div class="empty" style="grid-column:1/-1">কোনো ছবি নেই। "নতুন ছবি" দিয়ে আপলোড করুন।</div>
  @endforelse
</div>
@endsection
