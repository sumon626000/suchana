@php
  $logo1Src = \App\Support\Settings::logoUrl($site['logo_suchana'] ?? '', 'images/logo-suchana.jpg');
  $logo2Src = \App\Support\Settings::logoUrl($site['logo_sfdb'] ?? '', 'images/logo-sfdb.jpg');
@endphp
<!DOCTYPE html>
<html lang="bn" data-theme="light" data-accent="{{ $site['theme_color'] ?? 'sky' }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>অ্যাডমিন লগইন — Suchana</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="icon" href="/images/logo-suchana.jpg">
<link rel="stylesheet" href="/css/site.css">
<style>
  body{display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px;background:
    radial-gradient(900px 500px at 90% -10%, color-mix(in srgb,var(--green) 14%,transparent), transparent),
    radial-gradient(700px 400px at -10% 110%, color-mix(in srgb,var(--blue) 12%,transparent), transparent),
    var(--bg);}
  .admin-login{width:100%;max-width:440px}
  .admin-login-card{background:var(--surface);border:1px solid var(--line);border-radius:20px;padding:30px;box-shadow:var(--shadow)}
  .admin-login-brand{display:flex;align-items:center;justify-content:center;gap:12px;margin-bottom:14px}
  .admin-login-brand img{height:52px;width:auto;border-radius:10px}
  .admin-login-title{text-align:center;font-size:22px;font-weight:700;margin-bottom:2px}
  .admin-login-sub{text-align:center;color:var(--muted);font-size:13px;margin-bottom:20px}
  .admin-login .field{margin-bottom:14px}
  .admin-login .field label{display:block;font-size:13px;font-weight:600;margin-bottom:6px}
  .admin-login .field input{width:100%;padding:12px 14px;border:1.5px solid var(--line);border-radius:12px;background:var(--bg);color:var(--text);font-size:15px}
  .admin-login .field input:focus{outline:none;border-color:var(--green);background:var(--surface)}
  .admin-login .btn{width:100%}
  .admin-login-back{text-align:center;margin-top:16px;font-size:13px}
  .admin-login-back a{color:var(--green);font-weight:600}
  .admin-login-badge{display:inline-flex;align-items:center;gap:6px;background:var(--green-soft);color:var(--green);font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:4px 10px;border-radius:999px;margin:0 auto 14px;width:fit-content;display:flex}
</style>
</head>
<body class="site">

<div class="admin-login">
  <div class="admin-login-card">
    <div class="admin-login-brand">
      <img src="{{ $logo1Src }}" alt="Suchana">
      <img src="{{ $logo2Src }}" alt="SFDB">
    </div>
    <div class="admin-login-badge">🔐 Admin Panel</div>
    <div class="admin-login-title">অ্যাডমিন লগইন</div>
    <div class="admin-login-sub">শুধুমাত্র অ্যাডমিন অ্যাকাউন্টের জন্য</div>

    <form method="POST" action="{{ route('admin.login') }}">
      @csrf
      <div class="field">
        <label>ইউজারনেম / ইমেইল / মোবাইল</label>
        <input name="login" value="{{ old('login') }}" required autocomplete="username" autofocus>
      </div>
      <div class="field">
        <label>পাসওয়ার্ড</label>
        <input name="password" type="password" required autocomplete="current-password">
      </div>
      <div class="field" style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
        <label style="margin:0;display:flex;align-items:center;gap:8px">
          <input type="checkbox" name="remember" value="1" style="width:auto">
          <span>মনে রাখুন</span>
        </label>
        <a href="{{ route('password.request') }}" style="color:var(--green);font-weight:600;font-size:13px">পাসওয়ার্ড ভুলে গেছেন?</a>
      </div>
      <button class="btn btn-primary" type="submit">লগইন করুন</button>
    </form>

    <div class="admin-login-back">
      <a href="{{ route('home') }}">← মুল সাইটে ফিরুন</a>
    </div>
  </div>
</div>

@include('partials.flash')

<script>
(function(){
  function hideToast(el){ if(!el) return; el.classList.add('is-hiding'); setTimeout(function(){ el.remove(); }, 260); }
  document.querySelectorAll('[data-flash-close]').forEach(function(btn){
    btn.addEventListener('click', function(){ hideToast(btn.closest('.flash-toast')); });
  });
  document.querySelectorAll('[data-auto-dismiss]').forEach(function(el){
    setTimeout(function(){ hideToast(el); }, 5500);
  });
  document.querySelectorAll('form').forEach(function(form){
    form.addEventListener('submit', function(){
      var btn = form.querySelector('button[type="submit"], .btn-primary');
      if (btn) btn.classList.add('is-busy');
    });
  });
})();
</script>
</body>
</html>
