@extends('layouts.public')
@section('title', 'নতুন পাসওয়ার্ড সেট করুন — সুচনা SMTTI')
@section('content')
<section class="section">
  <div class="container">
    <div class="form-card">
      <h1 class="section-title center" style="font-size:30px" data-bn="নতুন পাসওয়ার্ড" data-en="Set new password">নতুন পাসওয়ার্ড</h1>
      <p class="muted center" data-bn="নতুন পাসওয়ার্ড দিন (কমপক্ষে ৬ অক্ষর)।" data-en="Enter a new password (at least 6 characters).">নতুন পাসওয়ার্ড দিন (কমপক্ষে ৬ অক্ষর)।</p>

      <form method="POST" action="{{ route('password.update') }}" class="mt-3">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="field">
          <label data-bn="ইমেইল" data-en="Email">ইমেইল <span class="req">*</span></label>
          <input type="email" name="email" value="{{ old('email', $email) }}" required autocomplete="email">
          @error('email')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
          <label data-bn="নতুন পাসওয়ার্ড" data-en="New password">নতুন পাসওয়ার্ড <span class="req">*</span></label>
          <input type="password" name="password" required autocomplete="new-password">
          @error('password')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="field">
          <label data-bn="পাসওয়ার্ড নিশ্চিত করুন" data-en="Confirm password">পাসওয়ার্ড নিশ্চিত করুন <span class="req">*</span></label>
          <input type="password" name="password_confirmation" required autocomplete="new-password">
        </div>
        <div class="form-actions">
          <button class="btn btn-primary" type="submit" data-bn="পাসওয়ার্ড সেভ করুন" data-en="Save password">পাসওয়ার্ড সেভ করুন</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
