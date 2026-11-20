@extends('layouts.admin')
@section('title', $notice->exists ? 'নোটিশ এডিট' : 'নতুন নোটিশ')

@section('content')
<form method="POST" action="{{ $notice->exists ? route('admin.notices.update', $notice) : route('admin.notices.store') }}">
  @csrf
  @if ($notice->exists) @method('PUT') @endif

  <div class="form-grid two">
    <div class="field"><label>শিরোনাম (বাংলা) *</label><input name="title_bn" value="{{ old('title_bn', $notice->title_bn) }}" required></div>
    <div class="field"><label>Title (English) *</label><input name="title_en" value="{{ old('title_en', $notice->title_en) }}" required></div>
    <div class="field"><label>টাইপ</label>
      <select name="type">
        @foreach (['general' => 'সাধারণ', 'admission' => 'ভর্তি', 'exam' => 'পরীক্ষা', 'result' => 'ফলাফল'] as $val => $label)
          <option value="{{ $val }}" @selected(old('type', $notice->type ?? 'general') === $val)>{{ $label }}</option>
        @endforeach
      </select>
    </div>
    <div class="field"><label>প্রকাশের তারিখ ও সময়</label><input type="datetime-local" name="published_at" value="{{ old('published_at', $notice->published_at?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i')) }}"></div>
  </div>

  <div class="form-grid">
    <div class="field"><label>বিবরণ (বাংলা)</label><textarea name="body_bn" rows="4">{{ old('body_bn', $notice->body_bn) }}</textarea></div>
    <div class="field"><label>Body (English)</label><textarea name="body_en" rows="4">{{ old('body_en', $notice->body_en) }}</textarea></div>
  </div>

  <div class="field" style="display:flex;align-items:center;gap:8px">
    <input type="checkbox" name="is_active" value="1" style="width:18px;height:18px" @checked(old('is_active', $notice->exists ? $notice->is_active : true))>
    <label style="margin:0">সক্রিয়</label>
  </div>

  <div class="field" style="display:flex;align-items:flex-start;gap:8px;margin-top:8px">
    <input type="checkbox" name="notify_users" value="1" style="width:18px;height:18px;margin-top:2px" @checked(old('notify_users', ! $notice->exists))>
    <label style="margin:0">
      সব সক্রিয় ইউজারকে ইমেইল পাঠান
      <span class="muted" style="display:block;font-size:12px;font-weight:400">নোটিশ সেভ হলে রেজিস্টার্ড ইমেইলে নোটিফিকেশন যাবে।</span>
    </label>
  </div>

  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">সেভ করুন</button>
    <a href="{{ route('admin.notices.index') }}" class="btn btn-outline">বাতিল</a>
  </div>
</form>
@endsection
