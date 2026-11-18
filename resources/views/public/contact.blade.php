@extends('layouts.public')
@section('title', 'যোগাযোগ — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <div class="kicker"><span class="kicker-num">০৫</span> — <span data-bn="যোগাযোগ" data-en="Contact">যোগাযোগ</span></div>
    <h2 class="section-title" data-bn="যোগাযোগ করুন" data-en="Get in Touch">যোগাযোগ করুন</h2>

    <div class="grid-2 mt-3">
      <div>
        <div class="branch-card" style="margin-bottom:12px">
          <div class="muted" style="font-size:12px" data-bn="ফোন" data-en="Phone">ফোন</div>
          <div style="font-weight:700;font-size:18px"><a href="tel:{{ preg_replace('/\s+/', '', (string) $site['phone']) }}">{{ $site['phone'] }}</a></div>
        </div>
        <div class="branch-card" style="margin-bottom:12px">
          <div class="muted" style="font-size:12px" data-bn="ইমেইল" data-en="Email">ইমেইল</div>
          <div style="font-weight:700;font-size:18px"><a href="mailto:{{ $site['email'] }}">{{ $site['email'] }}</a></div>
        </div>
        <div class="branch-card">
          <div class="muted" style="font-size:12px" data-bn="ঠিকানা" data-en="Address">ঠিকানা</div>
          <div style="font-weight:600" data-bn="{{ $site['address_bn'] }}" data-en="{{ $site['address_en'] }}">{{ $site['address_bn'] }}</div>
        </div>
      </div>
      <div>
        <div class="branch-card">
          <div class="branch-name" data-bn="আমাদের ব্রাঞ্চসমূহ" data-en="Our Branches">আমাদের ব্রাঞ্চসমূহ</div>
          <div class="mt-2">
            @foreach ($branches as $branch)
              <div style="padding:10px 0;border-bottom:1px solid var(--line)">
                <strong>{{ $branch->name_bn }}</strong>
                <div class="muted" style="font-size:13px">{{ $branch->address }}</div>
                @if ($branch->phone)<div class="muted" style="font-size:13px">{{ $branch->phone }}</div>@endif
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
