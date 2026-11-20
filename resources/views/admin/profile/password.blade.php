@extends('layouts.admin')
@section('title', 'পাসওয়ার্ড পরিবর্তন')
@section('subtitle', 'অ্যাডমিন অ্যাকাউন্টের পাসওয়ার্ড আপডেট করুন')

@section('content')
<form method="POST" action="{{ route('admin.profile.password') }}" class="card" style="max-width:480px">
  @csrf

  <div class="field">
    <label>বর্তমান পাসওয়ার্ড</label>
    <input type="password" name="current_password" required autocomplete="current-password">
    @error('current_password')
      <p class="muted" style="color:#c8202f;font-size:12px;margin-top:4px">{{ $message }}</p>
    @enderror
  </div>

  <div class="field">
    <label>নতুন পাসওয়ার্ড</label>
    <input type="password" name="password" required minlength="6" autocomplete="new-password">
    @error('password')
      <p class="muted" style="color:#c8202f;font-size:12px;margin-top:4px">{{ $message }}</p>
    @enderror
  </div>

  <div class="field">
    <label>নতুন পাসওয়ার্ড নিশ্চিত করুন</label>
    <input type="password" name="password_confirmation" required minlength="6" autocomplete="new-password">
  </div>

  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">পাসওয়ার্ড সেভ করুন</button>
  </div>
</form>
@endsection
