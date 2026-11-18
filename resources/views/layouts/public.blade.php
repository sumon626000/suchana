<!DOCTYPE html>
<html lang="bn" data-theme="light" data-accent="{{ $site['theme_color'] ?? 'sky' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'সুচনা — মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট')</title>
<meta name="description" content="@yield('meta', 'সুচনা মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট (SMTTI) — সরকারি অর্থায়নে বিনামূল্যে দক্ষতা প্রশিক্ষণ ও NSDA সনদ।')">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="icon" href="/images/logo-suchana.jpg">
@php $assetV = fn ($p) => file_exists(public_path($p)) ? filemtime(public_path($p)) : time(); @endphp
<link rel="stylesheet" href="/css/site.css?v={{ $assetV('css/site.css') }}">
<link rel="stylesheet" href="/css/anim.css?v={{ $assetV('css/anim.css') }}">
<noscript><style>.reveal{opacity:1!important;transform:none!important}</style></noscript>
@stack('head')
</head>
<body class="site">

@php
  $logo1 = $site['logo_suchana'] ?? '';
  $logo1Src = $logo1 ? (str_starts_with($logo1, 'http') ? $logo1 : asset('storage/'.$logo1)) : asset('images/logo-suchana.jpg');
  $logo2 = $site['logo_sfdb'] ?? '';
  $logo2Src = $logo2 ? (str_starts_with($logo2, 'http') ? $logo2 : asset('storage/'.$logo2)) : asset('images/logo-sfdb.jpg');
  $authUser = auth()->user();
  $dashUrl = $authUser
      ? ($authUser->isAdmin() ? route('admin.dashboard') : ($authUser->isTrainer() ? route('trainer.dashboard') : route('student.dashboard')))
      : null;
@endphp

<div class="site-progress" id="siteProgress"></div>

<header class="header" id="header">
  <div class="container header-inner">
    <a href="{{ route('home') }}" class="brand" aria-label="Suchana">
      <span class="brand-logos">
        <img src="{{ $logo1Src }}" alt="Suchana Development Bangladesh" width="44" height="44">
        <img src="{{ $logo2Src }}" alt="SFDB" width="66" height="44">
      </span>
      <span class="brand-text">
        <span class="brand-name" data-bn="{{ $site['name_bn'] }} মেডিকেল এন্ড টেকনিক্যাল" data-en="{{ $site['name'] }} Medical &amp; Technical">{{ $site['name_bn'] }} মেডিকেল এন্ড টেকনিক্যাল</span>
        <span class="brand-sub" data-bn="ট্রেনিং ইনস্টিটিউট (SMTTI)" data-en="Training Institute (SMTTI)">ট্রেনিং ইনস্টিটিউট (SMTTI)</span>
      </span>
    </a>

    <nav class="nav" aria-label="Main navigation">
      <a href="{{ route('courses.index') }}" class="{{ request()->routeIs('courses.*') ? 'active' : '' }}" data-bn="কোর্স" data-en="Courses">কোর্স</a>
      <a href="{{ route('branches.index') }}" class="{{ request()->routeIs('branches.*') ? 'active' : '' }}" data-bn="ব্রাঞ্চ" data-en="Branches">ব্রাঞ্চ</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}" data-bn="আমাদের সম্পর্কে" data-en="About">আমাদের সম্পর্কে</a>
      <a href="{{ route('notices.index') }}" class="{{ request()->routeIs('notices.*') ? 'active' : '' }}" data-bn="নোটিশ" data-en="Notices">নোটিশ</a>
      <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}" data-bn="যোগাযোগ" data-en="Contact">যোগাযোগ</a>
    </nav>

    <div class="header-actions">
      <button class="icon-btn" data-theme-toggle aria-label="Toggle dark mode" aria-pressed="false">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z"/></svg>
      </button>
      <button class="icon-btn" id="langToggle" aria-label="Switch language" style="width:auto;padding:0 12px;font-size:12px;font-weight:700">EN</button>
      @auth
        <a href="{{ $dashUrl }}" class="user-chip hide-mobile" title="{{ auth()->user()->name }}">
          <span class="user-chip-avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
        </a>
      @endauth
      @if (! $authUser || $authUser->isStudent())
        <a href="{{ url('/apply') }}" class="btn btn-primary hide-mobile" data-bn="আবেদন করুন" data-en="Apply">আবেদন করুন</a>
      @endif
      <div class="more-wrap">
        <button class="icon-btn" id="moreToggle" aria-label="More menu" aria-expanded="false" aria-controls="moreMenu" aria-haspopup="true">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><circle cx="5" cy="12" r="1.8"/><circle cx="12" cy="12" r="1.8"/><circle cx="19" cy="12" r="1.8"/></svg>
        </button>
        <div class="more-menu" id="moreMenu" hidden>
          <div class="more-menu-label" data-bn="মেনু" data-en="Menu">মেনু</div>
          <a href="{{ route('courses.index') }}" data-bn="আমাদের কোর্সসমূহ" data-en="Our Courses">আমাদের কোর্সসমূহ</a>
          <a href="{{ route('branches.index') }}" data-bn="আমাদের ব্রাঞ্চসমূহ" data-en="Our Branches">আমাদের ব্রাঞ্চসমূহ</a>
          <a href="{{ route('about') }}" data-bn="আমাদের সম্পর্কে" data-en="About Us">আমাদের সম্পর্কে</a>
          <a href="{{ route('contact') }}" data-bn="যোগাযোগ" data-en="Contact">যোগাযোগ</a>
          <div class="more-menu-sep"></div>
          <a href="{{ route('privacy') }}" data-bn="গোপনীয়তা নীতি" data-en="Privacy Policy">গোপনীয়তা নীতি</a>
          <a href="{{ route('terms') }}" data-bn="শর্তাবলী" data-en="Terms &amp; Conditions">শর্তাবলী</a>
          <a href="{{ route('faq') }}" data-bn="সাধারণ প্রশ্নোত্তর" data-en="FAQ">সাধারণ প্রশ্নোত্তর</a>
          <div class="more-menu-sep"></div>
          @auth
            <a href="{{ $dashUrl }}" data-bn="আমার ড্যাশবোর্ড" data-en="My Dashboard">আমার ড্যাশবোর্ড</a>
            @if (auth()->user()->isStudent())
              <a href="{{ route('student.profile') }}" data-bn="প্রোফাইল" data-en="Profile">প্রোফাইল</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="more-logout">
              @csrf
              <button type="submit" data-bn="লগআউট" data-en="Logout">লগআউট</button>
            </form>
          @else
            <a href="{{ url('/login') }}" data-bn="লগইন" data-en="Login">লগইন</a>
            <a href="{{ url('/register') }}" data-bn="রেজিস্ট্রেশন" data-en="Register">রেজিস্ট্রেশন</a>
          @endauth
          <a href="{{ url('/apply') }}" data-bn="আবেদন করুন" data-en="Apply Now">আবেদন করুন</a>
        </div>
      </div>
      <button class="icon-btn" id="menuToggle" aria-label="Open menu" aria-expanded="false" aria-controls="mobileNav">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/></svg>
      </button>
    </div>
  </div>

  <nav class="mobile-nav" id="mobileNav" hidden aria-label="Mobile navigation">
    @auth
      @php $mnavUser = auth()->user(); $mnavPhoto = $mnavUser->photo ? (str_starts_with($mnavUser->photo, 'http') ? $mnavUser->photo : asset('storage/'.$mnavUser->photo)) : null; @endphp
      <div class="mnav-user">
        <div class="mnav-avatar">
          @if ($mnavPhoto)<img src="{{ $mnavPhoto }}" alt="">@else{{ mb_substr($mnavUser->name, 0, 1) }}@endif
        </div>
        <div class="mnav-user-info">
          <div class="mnav-name">{{ $mnavUser->name }}</div>
          <div class="mnav-role">{{ '@'.$mnavUser->username }} · {{ $mnavUser->isAdmin() ? 'অ্যাডমিন' : ($mnavUser->isTrainer() ? 'ট্রেইনার' : 'শিক্ষার্থী') }}</div>
        </div>
        <a href="{{ $dashUrl }}" class="mnav-user-link" data-bn="ড্যাশবোর্ড →" data-en="Dashboard →">ড্যাশবোর্ড →</a>
      </div>
    @endauth

    <div class="mnav-group">
      <div class="mnav-label" data-bn="নেভিগেশন" data-en="Navigation">নেভিগেশন</div>
      <a class="mnav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}" href="{{ route('courses.index') }}">
        <span class="mnav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.5C10.5 4.9 8.3 4 6 4H3v14h3c2.3 0 4.5.9 6 2.5M12 6.5c1.5-1.6 3.7-2.5 6-2.5h3v14h-3c-2.3 0-4.5.9-6 2.5M12 6.5v14"/></svg></span>
        <span data-bn="কোর্স" data-en="Courses">কোর্স</span><span class="mnav-arrow">›</span>
      </a>
      <a class="mnav-link {{ request()->routeIs('branches.*') ? 'active' : '' }}" href="{{ route('branches.index') }}">
        <span class="mnav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-6.2-7-11a7 7 0 1 1 14 0c0 4.8-7 11-7 11Z"/><circle cx="12" cy="10" r="2.6"/></svg></span>
        <span data-bn="ব্রাঞ্চ" data-en="Branches">ব্রাঞ্চ</span><span class="mnav-arrow">›</span>
      </a>
      <a class="mnav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
        <span class="mnav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 11v5"/><circle cx="12" cy="8" r="1" fill="currentColor" stroke="none"/></svg></span>
        <span data-bn="আমাদের সম্পর্কে" data-en="About">আমাদের সম্পর্কে</span><span class="mnav-arrow">›</span>
      </a>
      <a class="mnav-link {{ request()->routeIs('notices.*') ? 'active' : '' }}" href="{{ route('notices.index') }}">
        <span class="mnav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/><path stroke-linecap="round" d="M10 21h4"/></svg></span>
        <span data-bn="নোটিশ" data-en="Notices">নোটিশ</span><span class="mnav-arrow">›</span>
      </a>
      <a class="mnav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
        <span class="mnav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M21 16.9v2.6a2 2 0 0 1-2.2 2 19.4 19.4 0 0 1-8.5-3 19.1 19.1 0 0 1-5.9-5.9 19.4 19.4 0 0 1-3-8.5A2 2 0 0 1 3.6 2h2.6a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.6a2 2 0 0 1-.5 2.1L7 9.7a15.6 15.6 0 0 0 5.9 5.9l1.3-1.3a2 2 0 0 1 2.1-.5c.8.3 1.7.5 2.6.6A2 2 0 0 1 21 16.9Z"/></svg></span>
        <span data-bn="যোগাযোগ" data-en="Contact">যোগাযোগ</span><span class="mnav-arrow">›</span>
      </a>
    </div>

    <div class="mnav-group">
      <div class="mnav-label" data-bn="আমার অ্যাকাউন্ট" data-en="My Account">আমার অ্যাকাউন্ট</div>
      @auth
        <a class="mnav-link" href="{{ $dashUrl }}">
          <span class="mnav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="3" width="7" height="7" rx="1.6"/><rect x="14" y="3" width="7" height="7" rx="1.6"/><rect x="3" y="14" width="7" height="7" rx="1.6"/><rect x="14" y="14" width="7" height="7" rx="1.6"/></svg></span>
          <span data-bn="আমার ড্যাশবোর্ড" data-en="My Dashboard">আমার ড্যাশবোর্ড</span><span class="mnav-arrow">›</span>
        </a>
        @if (auth()->user()->isStudent())
          <a class="mnav-link" href="{{ route('student.profile') }}">
            <span class="mnav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="8" r="3.6"/><path stroke-linecap="round" d="M4.5 20.5a7.5 7.5 0 0 1 15 0"/></svg></span>
            <span data-bn="প্রোফাইল" data-en="Profile">প্রোফাইল</span><span class="mnav-arrow">›</span>
          </a>
        @endif
        <form method="POST" action="{{ route('logout') }}" class="mnav-form">
          @csrf
          <button class="mnav-link mnav-logout" type="submit">
            <span class="mnav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 17l5-5-5-5"/><path stroke-linecap="round" d="M21 12H9"/></svg></span>
            <span data-bn="লগআউট" data-en="Logout">লগআউট</span>
          </button>
        </form>
      @else
        <a class="mnav-link" href="{{ url('/login') }}">
          <span class="mnav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path stroke-linecap="round" stroke-linejoin="round" d="M10 17l5-5-5-5"/><path stroke-linecap="round" d="M15 12H3"/></svg></span>
          <span data-bn="লগইন" data-en="Login">লগইন</span><span class="mnav-arrow">›</span>
        </a>
        <a class="mnav-link" href="{{ url('/register') }}">
          <span class="mnav-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="9" cy="8" r="3.6"/><path stroke-linecap="round" d="M2.5 20.5a6.5 6.5 0 0 1 13 0"/><path stroke-linecap="round" d="M19 8v6M16 11h6"/></svg></span>
          <span data-bn="রেজিস্ট্রেশন" data-en="Register">রেজিস্ট্রেশন</span><span class="mnav-arrow">›</span>
        </a>
      @endauth
    </div>

    <a href="{{ url('/apply') }}" class="btn btn-primary mnav-apply" data-bn="আবেদন করুন" data-en="Apply Now">আবেদন করুন</a>
  </nav>
</header>
<div class="mnav-backdrop" id="mnavBackdrop" hidden></div>

<main>
  <div class="container">
    @if (session('success'))
      <div class="alert alert-success mt-2" data-auto-dismiss>{{ session('success') }}</div>
    @endif
    @if (session('error'))
      <div class="alert alert-error mt-2" data-auto-dismiss>{{ session('error') }}</div>
    @endif
    @if ($errors->any())
      <div class="alert alert-error mt-2">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>
  @yield('content')
</main>

<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-brand" data-bn="{{ $site['name_bn'] }} মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট" data-en="{{ $site['name'] }} Medical &amp; Technical Training Institute">{{ $site['name_bn'] }} মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট</div>
        <p class="footer-desc" data-bn="{{ $site['tagline_bn'] }}" data-en="{{ $site['tagline_en'] }}">{{ $site['tagline_bn'] }}</p>
      </div>
      <div>
        <div class="footer-heading" data-bn="দ্রুত লিংক" data-en="Quick Links">দ্রুত লিংক</div>
        <ul class="footer-list">
          <li><a href="{{ route('courses.index') }}" data-bn="কোর্স" data-en="Courses">কোর্স</a></li>
          <li><a href="{{ route('branches.index') }}" data-bn="ব্রাঞ্চ" data-en="Branches">ব্রাঞ্চ</a></li>
          <li><a href="{{ route('about') }}" data-bn="আমাদের সম্পর্কে" data-en="About">আমাদের সম্পর্কে</a></li>
          <li><a href="{{ route('notices.index') }}" data-bn="নোটিশ" data-en="Notices">নোটিশ</a></li>
        </ul>
      </div>
      <div>
        <div class="footer-heading" data-bn="শিক্ষার্থী" data-en="Students">শিক্ষার্থী</div>
        <ul class="footer-list">
          @auth
            <li><a href="{{ $dashUrl }}" data-bn="আমার ড্যাশবোর্ড" data-en="My Dashboard">আমার ড্যাশবোর্ড</a></li>
            <li>
              <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit" data-bn="লগআউট" data-en="Logout">লগআউট</button>
              </form>
            </li>
          @else
            <li><a href="{{ url('/register') }}" data-bn="রেজিস্ট্রেশন" data-en="Register">রেজিস্ট্রেশন</a></li>
            <li><a href="{{ url('/login') }}" data-bn="লগইন" data-en="Login">লগইন</a></li>
          @endauth
          <li><a href="{{ url('/apply') }}" data-bn="আবেদন" data-en="Apply">আবেদন</a></li>
          <li><a href="{{ url('/track') }}" data-bn="আবেদন ট্র্যাকিং" data-en="Track Application">আবেদন ট্র্যাকিং</a></li>
        </ul>
      </div>
      <div>
        <div class="footer-heading" data-bn="যোগাযোগ" data-en="Contact">যোগাযোগ</div>
        <ul class="footer-list">
          <li><a href="tel:{{ preg_replace('/\s+/', '', (string) $site['phone']) }}">{{ $site['phone'] }}</a></li>
          <li><a href="mailto:{{ $site['email'] }}">{{ $site['email'] }}</a></li>
          <li data-bn="{{ $site['address_bn'] }}" data-en="{{ $site['address_en'] }}">{{ $site['address_bn'] }}</li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <div data-bn="© {{ date('Y') }} সুচনা মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট। সর্বস্বত্ব সংরক্ষিত।" data-en="© {{ date('Y') }} Suchana Medical &amp; Technical Training Institute. All rights reserved.">© {{ date('Y') }} সুচনা মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট। সর্বস্বত্ব সংরক্ষিত।</div>
      <div style="margin-top:8px;font-size:13px">
        <a href="{{ route('privacy') }}" data-bn="গোপনীয়তা নীতি" data-en="Privacy Policy">গোপনীয়তা নীতি</a>
        <span style="opacity:.45;margin:0 6px">·</span>
        <a href="{{ route('terms') }}" data-bn="শর্তাবলী" data-en="Terms &amp; Conditions">শর্তাবলী</a>
        <span style="opacity:.45;margin:0 6px">·</span>
        <a href="{{ route('faq') }}" data-bn="সাধারণ প্রশ্নোত্তর" data-en="FAQ">সাধারণ প্রশ্নোত্তর</a>
      </div>
      <div style="margin-top:6px;font-size:12px">
        <a href="{{ route('admin.login') }}" style="color:#9fb0c3" data-bn="অ্যাডমিন প্যানেল" data-en="Admin Panel">অ্যাডমিন প্যানেল</a>
      </div>
    </div>
  </div>
</footer>

@include('partials.support-widget')

<button class="site-top" id="siteTop" aria-label="Back to top">↑</button>

<div class="site-lightbox" id="siteLightbox" hidden>
  <button class="site-lightbox-close" id="siteLightboxClose" aria-label="Close">✕</button>
  <img id="siteLightboxImg" src="" alt="">
</div>

<script src="/js/site.js?v={{ $assetV('js/site.js') }}"></script>
<script src="/js/anim.js?v={{ $assetV('js/anim.js') }}"></script>
@if (! empty($site['live_chat_script']))
{!! $site['live_chat_script'] !!}
@endif
@stack('scripts')
</body>
</html>
