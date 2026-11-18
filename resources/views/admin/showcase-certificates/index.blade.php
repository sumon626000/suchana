@extends('layouts.admin')
@section('title', 'সার্টিফিকেট শোকেস')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:12px;flex-wrap:wrap">
  <p class="muted" style="margin:0">হোমপেজে দেখানো সার্টিফিকেট ছবি এখান থেকে আপলোড করুন।</p>
  <a href="{{ route('admin.showcase-certificates.create') }}" class="btn btn-primary btn-sm">+ নতুন সার্টিফিকেট</a>
</div>
<div class="gallery-grid">
  @forelse ($certificates as $cert)
    @php $src = $cert->imageUrl(); @endphp
    <figure class="gallery-item">
      <img src="{{ $src }}" alt="{{ $cert->title_bn }}" class="admin-gallery-thumb" data-lightbox="{{ $src }}" loading="lazy" style="aspect-ratio:16/11;object-fit:contain;background:#f6f3ea;padding:8px">
      <figcaption>
        <div><strong>{{ $cert->title_bn ?? '—' }}</strong></div>
        @if ($cert->subtitle_bn)<div class="muted" style="font-size:11px">{{ $cert->subtitle_bn }}</div>@endif
        <div class="admin-actions" style="margin-top:6px">
          <a href="{{ route('admin.showcase-certificates.edit', $cert) }}" class="btn btn-outline btn-xs">এডিট</a>
          <form method="POST" action="{{ route('admin.showcase-certificates.destroy', $cert) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
          </form>
        </div>
      </figcaption>
    </figure>
  @empty
    <div class="empty" style="grid-column:1/-1">কোনো সার্টিফিকেট নেই। "নতুন সার্টিফিকেট" দিয়ে আপলোড করুন।</div>
  @endforelse
</div>
@endsection
