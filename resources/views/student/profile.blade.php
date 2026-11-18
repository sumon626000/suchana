@extends('layouts.public')
@section('title', 'আমার প্রোফাইল — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container" style="max-width:760px">
    <div class="dash-section-head">
      <div>
        <span class="kicker" data-bn="প্রোফাইল" data-en="PROFILE">প্রোফাইল</span>
        <h1 class="section-title" data-bn="আমার প্রোফাইল" data-en="My Profile">আমার প্রোফাইল</h1>
      </div>
      <a href="{{ route('student.dashboard') }}" class="btn btn-outline btn-sm" data-bn="← ড্যাশবোর্ড" data-en="← Dashboard">← ড্যাশবোর্ড</a>
    </div>

    <div class="form-card">
      <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grid two">
          <div class="field"><label data-bn="নাম *" data-en="Name *">নাম *</label><input name="name" value="{{ old('name', $user->name) }}" required></div>
          <div class="field"><label data-bn="ইউজারনেম" data-en="Username">ইউজারনেম</label><input value="{{ $user->username }}" disabled></div>
          <div class="field"><label data-bn="মোবাইল" data-en="Mobile">মোবাইল</label><input name="mobile" value="{{ old('mobile', $user->mobile) }}"></div>
          <div class="field"><label data-bn="ইমেইল *" data-en="Email *">ইমেইল *</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
          <div class="field">
            <label data-bn="ছবি" data-en="Photo">ছবি</label>
            <input type="file" name="photo_file" accept="image/*" data-upload-preview="#profilePhotoPreview">
            <div class="upload-preview" id="profilePhotoPreview" hidden></div>
          </div>
          <div class="field">
            <label data-bn="বর্তমান ছবি" data-en="Current photo">বর্তমান ছবি</label>
            @if ($user->photo)
              <img src="{{ str_starts_with($user->photo, 'http') ? $user->photo : asset('storage/'.$user->photo) }}" alt="" style="width:56px;height:56px;border-radius:50%;object-fit:cover;border:1px solid var(--line)">
            @else
              <span class="muted" data-bn="ছবি নেই" data-en="No photo">ছবি নেই</span>
            @endif
          </div>
        </div>

        <div class="dash-divider"></div>
        <p class="muted" style="font-size:12px;margin:0 0 10px" data-bn="পাসওয়ার্ড পরিবর্তন করতে চাইলে নিচের ঘরগুলো পূরণ করুন।" data-en="Fill the fields below only if you want to change your password.">পাসওয়ার্ড পরিবর্তন করতে চাইলে নিচের ঘরগুলো পূরণ করুন।</p>

        <div class="form-grid two">
          <div class="field"><label data-bn="বর্তমান পাসওয়ার্ড" data-en="Current password">বর্তমান পাসওয়ার্ড</label><input type="password" name="current_password" autocomplete="current-password"></div>
          <div class="field"><label data-bn="নতুন পাসওয়ার্ড" data-en="New password">নতুন পাসওয়ার্ড</label><input type="password" name="password" autocomplete="new-password"></div>
          <div class="field"><label data-bn="নতুন পাসওয়ার্ড (আবার)" data-en="Confirm new password">নতুন পাসওয়ার্ড (আবার)</label><input type="password" name="password_confirmation" autocomplete="new-password"></div>
        </div>

        <div class="admin-actions mt-2">
          <button class="btn btn-primary" type="submit" data-bn="সেভ করুন" data-en="Save">সেভ করুন</button>
          <a href="{{ route('student.dashboard') }}" class="btn btn-outline" data-bn="বাতিল" data-en="Cancel">বাতিল</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
