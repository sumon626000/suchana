@extends('layouts.public')
@section('title', 'লগইন — সুচনা SMTTI')
@section('content')
<section class="section">
  <div class="container">
    <div class="form-card">
      <h1 class="section-title center" style="font-size:30px" data-bn="শিক্ষার্থী লগইন" data-en="Student Login">শিক্ষার্থী লগইন</h1>
      <p class="muted center" data-bn="ইউজারনেম, মোবাইল বা ইমেইল দিয়ে লগইন করুন।" data-en="Login with username, mobile or email.">ইউজারনেম, মোবাইল বা ইমেইল দিয়ে লগইন করুন।</p>

      <form method="POST" action="{{ route('login') }}" class="mt-3">
        @csrf
        <div class="field">
          <label data-bn="ইউজারনেম / মোবাইল / ইমেইল" data-en="Username / Mobile / Email">ইউজারনেম / মোবাইল / ইমেইল <span class="req">*</span></label>
          <input name="login" value="{{ old('login') }}" required autocomplete="username">
        </div>
        <div class="field">
          <label data-bn="পাসওয়ার্ড" data-en="Password">পাসওয়ার্ড <span class="req">*</span></label>
          <input name="password" type="password" required autocomplete="current-password">
        </div>
        <div class="field" style="display:flex;align-items:center;gap:8px">
          <input type="checkbox" name="remember" value="1" style="width:auto">
          <label style="margin:0" data-bn="মনে রাখুন" data-en="Remember me">মনে রাখুন</label>
        </div>
        <div class="form-actions">
          <button class="btn btn-primary" type="submit" data-bn="লগইন" data-en="Login">লগইন</button>
        </div>
      </form>
      <p class="muted center mt-2"><span data-bn="অ্যাকাউন্ট নেই?" data-en="No account?">অ্যাকাউন্ট নেই?</span> <a href="{{ route('register') }}" style="color:var(--green);font-weight:600" data-bn="রেজাস্ট্রেশন" data-en="Register">রেজাস্ট্রেশন</a></p>
    </div>
  </div>
</section>
@endsection
