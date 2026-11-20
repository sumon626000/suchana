<!DOCTYPE html>
<html lang="bn" data-theme="light" data-accent="{{ $site['theme_color'] ?? 'sky' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Admin') — Suchana</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="icon" href="/images/logo-suchana.jpg">
@php $adminAssetV = fn ($p) => file_exists(public_path($p)) ? filemtime(public_path($p)) : time(); @endphp
<link rel="stylesheet" href="/css/site.css?v={{ $adminAssetV('css/site.css') }}">
<link rel="stylesheet" href="/css/admin.css?v={{ $adminAssetV('css/admin.css') }}">
<script>
(function(){var t=localStorage.getItem('smtii-theme');if(!t){t=window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light';}document.documentElement.setAttribute('data-theme',t);document.documentElement.style.colorScheme=t;})();
</script>
</head>
<body>

@php
  $logo1Src = \App\Support\Settings::logoUrl($site['logo_suchana'] ?? '', 'images/logo-suchana.jpg');
  $logo2Src = \App\Support\Settings::logoUrl($site['logo_sfdb'] ?? '', 'images/logo-sfdb.jpg');
@endphp

<div class="admin-shell">
  <aside class="admin-side" id="adminSide">
    <div class="admin-brand">
      <img src="{{ $logo1Src }}" alt="Suchana">
      <img src="{{ $logo2Src }}" alt="SFDB">
      <div class="admin-brand-text">
        <div class="admin-brand-name">Suchana</div>
        <div class="admin-brand-sub" data-bn="অ্যাডমিন প্যানেল" data-en="Admin Panel">অ্যাডমিন প্যানেল</div>
      </div>
    </div>

    <nav class="admin-nav">
      @php
        $groups = [
          ['সংক্ষিপ্ত', 'Overview', [
            ['admin.dashboard', 'ড্যাশবোর্ড', 'Dashboard', '◧'],
          ]],
          ['কনটেন্ট', 'Content', [
            ['admin.courses.index', 'কোর্স', 'Courses', '▤'],
            ['admin.batches.index', 'ব্যাচ', 'Batches', '▥'],
            ['admin.staff.index', 'কর্তৃপক্ষ', 'Authority', '◉'],
            ['admin.branches.index', 'ব্রাঞ্চ', 'Branches', '⌂'],
            ['admin.gallery.index', 'গ্যালারি', 'Gallery', '▣'],
            ['admin.showcase-certificates.index', 'সার্টিফিকেট শোকেস', 'Cert Showcase', '♛'],
            ['admin.notices.index', 'নোটিশ', 'Notices', '✉'],
          ]],
          ['ভর্তি', 'Admissions', [
            ['admin.applications.index', 'আবেদন', 'Applications', '◈'],
            ['admin.students.index', 'শিক্ষার্থী', 'Students', '◍'],
            ['attendance.index', 'উপস্থিতি', 'Attendance', '✓'],
            ['admin.certificates.index', 'সার্টিফিকেট', 'Certificates', '♛'],
          ]],
          ['সিস্টেম', 'System', [
            ['admin.districts.index', 'জেলা', 'Districts', '⌘'],
            ['admin.thanas.index', 'উপজেলা', 'Upazilas', '⌘'],
            ['admin.notifications.index', 'নোটিফিকেশন', 'Notifications', '✎'],
            ['admin.backups.index', 'ব্যাকআপ', 'Backups', '⟲'],
            ['admin.support.index', 'সহায়তা বার্তা', 'Support', '✆'],
            ['admin.profile.password.edit', 'পাসওয়ার্ড', 'Password', '⚿'],
            ['admin.settings.index', 'সেটিংস', 'Settings', '⚙'],
          ]],
        ];
      @endphp
      @foreach ($groups as [$labelBn, $labelEn, $items])
        <div class="admin-nav-group">
          <div class="admin-nav-label" data-bn="{{ $labelBn }}" data-en="{{ $labelEn }}">{{ $labelBn }}</div>
          @foreach ($items as [$routeName, $itemBn, $itemEn, $icon])
            @if (Route::has($routeName))
              <a href="{{ route($routeName) }}" class="{{ request()->routeIs(str_replace('.index', '.*', $routeName)) ? 'active' : '' }}">
                <span class="admin-nav-icon">{{ $icon }}</span>
                <span data-bn="{{ $itemBn }}" data-en="{{ $itemEn }}">{{ $itemBn }}</span>
              </a>
            @endif
          @endforeach
        </div>
      @endforeach
    </nav>

    <div class="admin-side-foot">
      <div class="admin-user">
        <div class="admin-avatar">{{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
        <div class="admin-user-text">
          <div class="admin-user-name">{{ auth()->user()->name }}</div>
          <div class="admin-user-role">{{ auth()->user()->role }}</div>
        </div>
      </div>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="btn btn-outline btn-sm" type="submit" style="width:100%" data-bn="লগআউট" data-en="Logout">লগআউট</button>
      </form>
    </div>
  </aside>

  <div class="admin-backdrop" id="adminBackdrop"></div>

  <main class="admin-main">
    <header class="admin-topbar">
      <button class="admin-menu-btn" id="adminMenuBtn" aria-label="Menu">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/></svg>
      </button>
      <div class="admin-topbar-title">
        <div class="admin-title">@yield('title', 'ড্যাশবোর্ড')</div>
        <div class="admin-sub">@yield('subtitle', '')</div>
      </div>
      <div class="admin-topbar-actions">
        <select id="adminLang" class="admin-lang" aria-label="Language">
          <option value="bn">বাংলা</option>
          <option value="en">English</option>
        </select>
        <button class="icon-btn" id="adminThemeBtn" aria-label="Theme" title="Theme">
          <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z"/></svg>
        </button>
      </div>
    </header>

    @yield('content')
  </main>
</div>

@include('partials.flash')

<div class="admin-lightbox" id="adminLightbox" hidden>
  <button class="admin-lightbox-close" id="adminLightboxClose" aria-label="Close">✕</button>
  <img id="adminLightboxImg" src="" alt="">
</div>

<script src="/js/admin.js?v={{ $adminAssetV('js/admin.js') }}"></script>
</body>
</html>
