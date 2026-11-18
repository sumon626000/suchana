@extends('layouts.public')
@section('title', 'ব্রাঞ্চসমূহ — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <div class="kicker"><span class="kicker-num">০২</span> — <span data-bn="ব্রাঞ্চ" data-en="Branches">ব্রাঞ্চ</span></div>
    <h2 class="section-title" data-bn="আমাদের ব্রাঞ্চসমূহ" data-en="Our Branches">আমাদের ব্রাঞ্চসমূহ</h2>

    <div class="branch-grid mt-3">
      @foreach ($branches as $branch)
        <div class="branch-card">
          @if ($branch->image)
            <div class="branch-photo"><img src="{{ str_starts_with($branch->image, 'http') ? $branch->image : asset('storage/'.$branch->image) }}" alt="{{ $branch->name_bn }}" loading="lazy"></div>
          @endif
          <div class="branch-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
          </div>
          <div class="branch-name" data-bn="{{ $branch->name_bn }}" data-en="{{ $branch->name_en }}">{{ $branch->name_bn }}</div>
          <div class="branch-addr">{{ $branch->address }}</div>
          @if ($branch->phone)
            <div class="branch-phone">
              <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
              <a href="tel:{{ preg_replace('/\s+/', '', $branch->phone) }}">{{ $branch->phone }}</a>
            </div>
          @endif
          @if ($branch->email)
            <div class="muted" style="font-size:13px;margin-top:4px"><a href="mailto:{{ $branch->email }}">{{ $branch->email }}</a></div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
