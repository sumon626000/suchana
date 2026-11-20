@extends('layouts.public')
@section('title', 'পাসওয়ার্ড ভুলে গেছেন — সুচনা SMTTI')
@section('content')
<section class="section">
  <div class="container">
    <div class="form-card">
      <h1 class="section-title center" style="font-size:30px" data-bn="পাসওয়ার্ড ভুলে গেছেন?" data-en="Forgot password?">পাসওয়ার্ড ভুলে গেছেন?</h1>
      <p class="muted center" data-bn="ইমেইল, ইউজারনেম বা মোবাইল দিন। রেজিস্টার্ড ইমেইলে রিসেট লিংক পাঠানো হবে।" data-en="Enter email, username or mobile. A reset link will be sent to your registered email.">ইমেইল, ইউজারনেম বা মোবাইল দিন। রেজিস্টার্ড ইমেইলে রিসেট লিংক পাঠানো হবে।</p>

      <form method="POST" action="{{ route('password.email') }}" class="mt-3">
        @csrf
        <div class="field">
          <label data-bn="ইমেইল / ইউজারনেম / মোবাইল" data-en="Email / Username / Mobile">ইমেইল / ইউজারনেম / মোবাইল <span class="req">*</span></label>
          <input name="login" value="{{ old('login') }}" required autocomplete="username" autofocus>
          @error('login')<div class="error">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
          <button class="btn btn-primary" type="submit" data-bn="রিসেট লিংক পাঠান" data-en="Send reset link">রিসেট লিংক পাঠান</button>
        </div>
      </form>

      <p class="muted center mt-2">
        <a href="{{ route('login') }}" style="color:var(--green);font-weight:600" data-bn="লগইনে ফিরুন" data-en="Back to login">← লগইনে ফিরুন</a>
        <span style="margin:0 8px;opacity:.5">|</span>
        <a href="{{ route('admin.login') }}" style="color:var(--green);font-weight:600" data-bn="অ্যাডমিন লগইন" data-en="Admin login">অ্যাডমিন লগইন</a>
      </p>
    </div>
  </div>
</section>
@endsection
