@extends('layouts.public')
@section('title', 'নোটিশ — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <div class="kicker"><span class="kicker-num">০৩</span> — <span data-bn="নোটিশ" data-en="Notices">নোটিশ</span></div>
    <h2 class="section-title" data-bn="নোটিশ ও আপডেট" data-en="Notices & Updates">নোটিশ ও আপডেট</h2>

    <div class="mt-3" style="max-width:820px">
      @forelse ($notices as $notice)
        <div class="notice-card">
          <div class="notice-date">{{ $notice->published_at?->format('d M Y') }} · {{ $notice->type }}</div>
          <div class="notice-title" data-bn="{{ $notice->title_bn }}" data-en="{{ $notice->title_en }}">{{ $notice->title_bn }}</div>
          <div class="notice-body" data-bn="{{ $notice->body_bn }}" data-en="{{ $notice->body_en }}">{{ $notice->body_bn }}</div>
        </div>
      @empty
        <p class="muted" data-bn="কোনো নোটিশ নেই।" data-en="No notices yet.">কোনো নোটিশ নেই।</p>
      @endforelse
    </div>
  </div>
</section>
@endsection
