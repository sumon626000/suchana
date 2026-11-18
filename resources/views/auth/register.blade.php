@extends('layouts.public')
@section('title', 'রেজিস্ট্রেশন — সুচনা SMTTI')
@section('hide-errors')
@section('content')
<section class="section">
  <div class="container">
    <div class="form-card">
      <h1 class="section-title center" style="font-size:30px" data-bn="শিক্ষার্থী রেজিস্ট্রেশন" data-en="Student Registration">শিক্ষার্থী রেজিস্ট্রেশন</h1>
      <p class="muted center" data-bn="আবেদনের আগে অ্যাকাউন্ট তৈরি করুন।" data-en="Create an account before applying.">আবেদনের আগে অ্যাকাউন্ট তৈরি করুন।</p>

      <form method="POST" action="{{ route('register') }}" class="mt-3">
        @csrf
        <div class="field">
          <label data-bn="পূর্ণ নাম" data-en="Full Name">পূর্ণ নাম <span class="req">*</span></label>
          <input name="name" value="{{ old('name') }}" required autocomplete="name">
        </div>
        <div class="field">
          <label data-bn="ইউজারনেম" data-en="Username">ইউজারনেম <span class="req">*</span></label>
          <input name="username" value="{{ old('username') }}" required autocomplete="username">
        </div>
        <div class="field">
          <label data-bn="মোবাইল নম্বর" data-en="Mobile Number">মোবাইল নম্বর <span class="req">*</span></label>
          <input name="mobile" value="{{ old('mobile') }}" required inputmode="numeric" autocomplete="tel" placeholder="01XXXXXXXXX">
        </div>
        <div class="field">
          <label data-bn="জিমেইল" data-en="Gmail">জিমেইল <span class="req">*</span></label>
          <input name="email" type="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@gmail.com">
        </div>
        <div class="field">
          <label data-bn="পাসওয়ার্ড" data-en="Password">পাসওয়ার্ড <span class="req">*</span></label>
          <input name="password" type="password" required autocomplete="new-password">
        </div>
        <div class="field">
          <label data-bn="পাসওয়ার্ড নিশ্চিত করুন" data-en="Confirm Password">পাসওয়ার্ড নিশ্চিত করুন <span class="req">*</span></label>
          <input name="password_confirmation" type="password" required autocomplete="new-password">
        </div>
        <div class="form-actions">
          <button class="btn btn-primary" type="submit" data-bn="রেজিস্টার করুন" data-en="Register">রেজিস্টার করুন</button>
        </div>
      </form>
      <p class="muted center mt-2"><span data-bn="ইতিমধ্যে অ্যাকাউন্ট আছে?" data-en="Already have an account?">ইতিমধ্যে অ্যাকাউন্ট আছে?</span> <a href="{{ route('login') }}" style="color:var(--green);font-weight:600" data-bn="লগইন" data-en="Login">লগইন</a></p>
    </div>
  </div>
</section>
@endsection
