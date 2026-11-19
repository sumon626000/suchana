@extends('layouts.public')

@section('title', 'সুচনা — মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট')

@section('content')
@php
  $heroImage = $courses->first()?->image ?? 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=1200&q=80&auto=format&fit=crop';
@endphp

<section class="hero">
  <div class="hero-blob blob-1"></div>
  <div class="hero-blob blob-2"></div>
  <div class="hero-blob blob-3"></div>
  <div class="container">
    <div class="hero-grid">
      <div>
        <div class="hero-badge" data-bn="{{ $site['hero_badge_bn'] }}" data-en="{{ $site['hero_badge_en'] }}">{{ $site['hero_badge_bn'] }}</div>
        <h1 class="hero-title">
          <span data-bn="{{ $site['hero_title_line1_bn'] }}" data-en="{{ $site['hero_title_line1_en'] }}">{{ $site['hero_title_line1_bn'] }}</span><br>
          <em data-bn="{{ $site['hero_title_line2_bn'] }}" data-en="{{ $site['hero_title_line2_en'] }}">{{ $site['hero_title_line2_bn'] }}</em>
        </h1>
        <p class="hero-subtitle" data-bn="{{ $site['hero_subtitle_bn'] }}" data-en="{{ $site['hero_subtitle_en'] }}">{{ $site['hero_subtitle_bn'] }}</p>
        <div class="hero-ctas">
          <a href="{{ url('/apply') }}" class="btn btn-primary btn-lg" data-bn="ভর্তি হোন" data-en="Apply Now">ভর্তি হোন</a>
          <a href="{{ route('courses.index') }}" class="btn btn-outline btn-lg" data-bn="কোর্স দেখুন" data-en="View Courses">কোর্স দেখুন</a>
        </div>
      </div>
      <div class="hero-photo">
        <img src="{{ $heroImage }}" alt="Suchana training" loading="eager" referrerpolicy="no-referrer">
      </div>
    </div>
  </div>
</section>

<div class="marquee" aria-hidden="true">
  <div class="marquee-track">
    @foreach (['সরকারি অর্থায়নে বিনামূল্যে', 'NSDA জাতীয় সনদ', 'দৈনিক উপবৃত্তি', 'চাকরির সুযোগ', '৬৪ জেলার ব্রাঞ্চ', 'অভিজ্ঞ প্রশিক্ষক'] as $tag)
      <span class="marquee-item">{{ $tag }}</span><span class="marquee-dot">◆</span>
    @endforeach
    @foreach (['সরকারি অর্থায়নে বিনামূল্যে', 'NSDA জাতীয় সনদ', 'দৈনিক উপবৃত্তি', 'চাকরির সুযোগ', '৬৪ জেলার ব্রাঞ্চ', 'অভিজ্ঞ প্রশিক্ষক'] as $tag)
      <span class="marquee-item">{{ $tag }}</span><span class="marquee-dot">◆</span>
    @endforeach
  </div>
</div>

<section class="stats">
  <div class="container">
    <div class="stats-grid">
      <div class="stat"><span class="stat-value">{{ $stats['courses'] }}</span><div class="stat-label" data-bn="কোর্স" data-en="Courses">কোর্স</div></div>
      <div class="stat"><span class="stat-value">{{ $stats['seats'] }}</span><div class="stat-label" data-bn="মোট আসন" data-en="Total Seats">মোট আসন</div></div>
      <div class="stat"><span class="stat-value">{{ $stats['branches'] }}</span><div class="stat-label" data-bn="ব্রাঞ্চ" data-en="Branches">ব্রাঞ্চ</div></div>
      <div class="stat"><span class="stat-value">৳{{ number_format($stats['stipend']) }}</span><div class="stat-label" data-bn="সর্বোচ্চ উপবৃত্তি" data-en="Max Stipend">সর্বোচ্চ উপবৃত্তি</div></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="kicker"><span class="kicker-num">০১</span> — <span data-bn="{{ $site['home_running_kicker_bn'] }}" data-en="{{ $site['home_running_kicker_en'] }}">{{ $site['home_running_kicker_bn'] }}</span></div>
    <h2 class="section-title" data-bn="{{ $site['home_running_title_bn'] }}" data-en="{{ $site['home_running_title_en'] }}">{{ $site['home_running_title_bn'] }}</h2>
    <p class="section-lead" data-bn="{{ $site['home_running_lead_bn'] }}" data-en="{{ $site['home_running_lead_en'] }}">{{ $site['home_running_lead_bn'] }}</p>

    <div class="slider-wrap" data-slider data-autoplay="4500">
      <div class="slider-track">
        @foreach ($courses as $course)
          <a href="{{ route('courses.show', $course) }}" class="course-card slide-card">
            <div class="course-photo"><img src="{{ $course->image }}" alt="{{ $course->name_bn }}" loading="lazy" referrerpolicy="no-referrer"></div>
            <div class="course-body">
              <h3 class="course-title" data-bn="{{ $course->name_bn }}" data-en="{{ $course->name_en }}">{{ $course->name_bn }}</h3>
              <p class="slide-desc">{{ \Illuminate\Support\Str::limit($course->description_bn, 78) }}</p>
              <div class="course-chips">
                <span class="chip">{{ $course->level }}</span>
                <span class="chip chip-green" data-bn="{{ $course->duration_bn }}" data-en="{{ $course->duration_en }}">{{ $course->duration_bn }}</span>
              </div>
              <div class="course-meta" data-bn="আসন {{ $course->seats_available }}/{{ $course->seats_total }}" data-en="Seats {{ $course->seats_available }}/{{ $course->seats_total }}">আসন {{ $course->seats_available }}/{{ $course->seats_total }}</div>
              <span class="course-details" data-bn="বিস্তারিত দেখুন →" data-en="View Details →">বিস্তারিত দেখুন →</span>
            </div>
          </a>
        @endforeach
      </div>
      <div class="slider-controls">
        <button class="slider-btn" data-slider-prev aria-label="Previous"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg></button>
        <button class="slider-btn" data-slider-next aria-label="Next"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></button>
      </div>
      <div class="slider-dots" data-slider-dots></div>
    </div>
  </div>
</section>

<section class="section" style="background:var(--surface)">
  <div class="container">
    <div class="kicker"><span class="kicker-num">০২</span> — <span data-bn="{{ $site['home_courses_kicker_bn'] }}" data-en="{{ $site['home_courses_kicker_en'] }}">{{ $site['home_courses_kicker_bn'] }}</span></div>
    <h2 class="section-title" data-bn="{{ $site['home_courses_title_bn'] }}" data-en="{{ $site['home_courses_title_en'] }}">{{ $site['home_courses_title_bn'] }}</h2>
    <p class="section-lead" data-bn="{{ $site['home_courses_lead_bn'] }}" data-en="{{ $site['home_courses_lead_en'] }}">{{ $site['home_courses_lead_bn'] }}</p>

    <div class="courses-grid">
      @foreach ($courses as $course)
        <a href="{{ route('courses.show', $course) }}" class="course-card">
          <div class="course-photo"><img src="{{ $course->image }}" alt="{{ $course->name_bn }}" loading="lazy" referrerpolicy="no-referrer"></div>
          <div class="course-body">
            <h3 class="course-title" data-bn="{{ $course->name_bn }}" data-en="{{ $course->name_en }}">{{ $course->name_bn }}</h3>
            <div class="course-chips">
              <span class="chip">{{ $course->level }}</span>
              <span class="chip chip-green" data-bn="{{ $course->duration_bn }}" data-en="{{ $course->duration_en }}">{{ $course->duration_bn }}</span>
            </div>
            <div class="course-meta">
              <span data-bn="ফি: ৳{{ number_format($course->fee) }}" data-en="Fee: ৳{{ number_format($course->fee) }}">ফি: ৳{{ number_format($course->fee) }}</span> ·
              <span data-bn="ভাতা: ৳{{ number_format($course->stipend_male) }}–{{ number_format($course->stipend_female) }}" data-en="Stipend: ৳{{ number_format($course->stipend_male) }}–{{ number_format($course->stipend_female) }}">ভাতা: ৳{{ number_format($course->stipend_male) }}–{{ number_format($course->stipend_female) }}</span>
            </div>
            <span class="course-details" data-bn="বিস্তারিত দেখুন →" data-en="View Details →">বিস্তারিত দেখুন →</span>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="kicker"><span class="kicker-num">০৩</span> — <span data-bn="কর্তৃপক্ষ" data-en="Authority">কর্তৃপক্ষ</span></div>
    <h2 class="section-title" data-bn="কর্তৃপক্ষ ও কর্মকর্তাবৃন্দ" data-en="Authority & Officers">কর্তৃপক্ষ ও কর্মকর্তাবৃন্দ</h2>
    <div class="staff-grid mt-4">
      @foreach ($staff as $person)
        @php $staffPhoto = $person->photoUrl(); @endphp
        <div class="staff-card">
          <div class="staff-photo">
            @if ($staffPhoto)
              <img src="{{ $staffPhoto }}" alt="{{ $person->name }}" loading="lazy">
            @else
              {{ mb_substr($person->name, 0, 1) }}
            @endif
          </div>
          <div class="staff-name">{{ $person->name }}</div>
          <div class="staff-role">{{ $person->designation }}</div>
          @if ($person->bio)
            <div class="staff-bio">{{ \Illuminate\Support\Str::limit($person->bio, 70) }}</div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>

<section class="section" style="background:var(--surface)">
  <div class="container">
    <div class="kicker"><span class="kicker-num">০৪</span> — <span data-bn="ব্রাঞ্চ" data-en="Branches">ব্রাঞ্চ</span></div>
    <h2 class="section-title" data-bn="আমাদের ব্রাঞ্চসমূহ" data-en="Our Branches">আমাদের ব্রাঞ্চসমূহ</h2>
    <div class="branch-grid mt-4">
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
        </div>
      @endforeach
    </div>
    <div class="mt-3"><a href="{{ route('branches.index') }}" class="btn btn-outline" data-bn="সব ব্রাঞ্চ দেখুন" data-en="View All Branches">সব ব্রাঞ্চ দেখুন</a></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="kicker"><span class="kicker-num">০৫</span> — <span data-bn="নোটিশ" data-en="Notices">নোটিশ</span></div>
    <h2 class="section-title" data-bn="নোটিশ ও আপডেট" data-en="Notices & Updates">নোটিশ ও আপডেট</h2>
    <div class="mt-3">
      @foreach ($notices as $notice)
        <div class="notice-card">
          <div class="notice-date">{{ $notice->published_at?->format('d M Y') }}</div>
          <div class="notice-title" data-bn="{{ $notice->title_bn }}" data-en="{{ $notice->title_en }}">{{ $notice->title_bn }}</div>
          <div class="notice-body" data-bn="{{ $notice->body_bn }}" data-en="{{ $notice->body_en }}">{{ $notice->body_bn }}</div>
        </div>
      @endforeach
    </div>
    <a href="{{ route('notices.index') }}" class="btn btn-outline mt-2" data-bn="সব নোটিশ" data-en="All Notices">সব নোটিশ</a>
  </div>
</section>

@if ($showcaseCertificates->count())
<section class="section cert-showcase">
  <div class="container">
    <div class="cert-showcase-head">
      <div>
        <div class="kicker"><span class="kicker-num">০৬</span> — <span data-bn="সার্টিফিকেট" data-en="Certificates">সার্টিফিকেট</span></div>
        <h2 class="section-title" data-bn="আমাদের সনদপত্র" data-en="Our Certificates">আমাদের সনদপত্র</h2>
        <p class="section-lead" data-bn="NSDA অনুমোদিত জাতীয় সনদের নমুনা — প্রশিক্ষণ শেষে শিক্ষার্থীরা এই মানের সার্টিফিকেট পান।" data-en="Sample NSDA-approved national certificates — graduates receive certificates of this quality.">NSDA অনুমোদিত জাতীয় সনদের নমুনা — প্রশিক্ষণ শেষে শিক্ষার্থীরা এই মানের সার্টিফিকেট পান।</p>
      </div>
      <a href="{{ route('verify') }}" class="btn btn-outline hide-mobile" data-bn="সনদ যাচাই করুন" data-en="Verify Certificate">সনদ যাচাই করুন</a>
    </div>

    <div class="cert-stage">
      <div class="cert-stage-glow" aria-hidden="true"></div>
      <div class="slider-wrap cert-rail" data-slider data-autoplay="5200">
        <div class="slider-track cert-track">
          @foreach ($showcaseCertificates as $i => $cert)
            @php $src = $cert->imageUrl(); @endphp
            <article class="cert-card slide-card" style="--i:{{ $i }}">
              <button type="button" class="cert-frame" data-lightbox="{{ $src }}" aria-label="{{ $cert->title_bn }}">
                <span class="cert-foil" aria-hidden="true"></span>
                <img src="{{ $src }}" alt="{{ $cert->title_bn }}" loading="lazy">
                <span class="cert-zoom" aria-hidden="true">⌕</span>
              </button>
              <div class="cert-meta">
                <div class="cert-badge">♛ NSDA</div>
                <h3 class="cert-title" data-bn="{{ $cert->title_bn }}" data-en="{{ $cert->title_en }}">{{ $cert->title_bn }}</h3>
                @if ($cert->subtitle_bn)
                  <p class="cert-sub" data-bn="{{ $cert->subtitle_bn }}" data-en="{{ $cert->subtitle_en }}">{{ $cert->subtitle_bn }}</p>
                @endif
              </div>
            </article>
          @endforeach
        </div>
        <div class="slider-controls">
          <button class="slider-btn" data-slider-prev aria-label="Previous"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg></button>
          <button class="slider-btn" data-slider-next aria-label="Next"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg></button>
        </div>
        <div class="slider-dots" data-slider-dots></div>
      </div>
    </div>
  </div>
</section>
@endif

@if ($gallery->count())
<section class="section" style="background:var(--surface)">
  <div class="container">
    <div class="kicker"><span class="kicker-num">০৭</span> — <span data-bn="গ্যালারি" data-en="Gallery">গ্যালারি</span></div>
    <h2 class="section-title" data-bn="আমাদের গ্যালারি" data-en="Our Gallery">আমাদের গ্যালারি</h2>
    <div class="gallery-grid mt-3">
      @foreach ($gallery as $img)
        @php $src = str_starts_with($img->image, 'http') ? $img->image : asset('storage/'.$img->image); @endphp
        <figure class="gallery-item">
          <img src="{{ $src }}" alt="{{ $img->title_bn }}" data-lightbox="{{ $src }}" loading="lazy">
          @if ($img->title_bn)<figcaption>{{ $img->title_bn }}</figcaption>@endif
        </figure>
      @endforeach
    </div>
  </div>
</section>
@endif

<section class="section" style="background:linear-gradient(135deg,var(--green-soft),var(--blue-soft))">
  <div class="container center">
    <h2 class="section-title" data-bn="আজই আবেদন করুন" data-en="Apply Today">আজই আবেদন করুন</h2>
    <p class="section-lead" data-bn="সরকারি অর্থায়নে বিনামূল্যে প্রশিক্ষণ — সীমিত আসন।" data-en="Free government-funded training — limited seats.">সরকারি অর্থায়নে বিনামূল্যে প্রশিক্ষণ — সীমিত আসন।</p>
    <a href="{{ url('/register') }}" class="btn btn-primary btn-lg" data-bn="রেজিস্ট্রেশন করুন" data-en="Register Now">রেজিস্ট্রেশন করুন</a>
  </div>
</section>
@endsection
