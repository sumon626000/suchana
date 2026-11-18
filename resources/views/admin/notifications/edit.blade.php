@extends('layouts.admin')
@section('title', 'টেমপ্লেট এডিট — ' . $template->key)

@section('content')
<form method="POST" action="{{ route('admin.notifications.update', $template) }}">
  @csrf
  @method('PUT')

  <div class="form-grid two">
    <div class="field">
      <label>চ্যানেল</label>
      <select name="channel">
        @foreach (['sms' => 'SMS', 'email' => 'Email', 'both' => 'SMS + Email'] as $val => $label)
          <option value="{{ $val }}" @selected(old('channel', $template->channel) === $val)>{{ $label }}</option>
        @endforeach
      </select>
    </div>
    <div class="field"><label>বিষয় (ইমেইলের জন্য)</label><input name="subject" value="{{ old('subject', $template->subject) }}"></div>
  </div>

  <div class="form-grid">
    <div class="field"><label>বার্তা (বাংলা) *</label><textarea name="body_bn" rows="4" required>{{ old('body_bn', $template->body_bn) }}</textarea></div>
    <div class="field"><label>Message (English)</label><textarea name="body_en" rows="4">{{ old('body_en', $template->body_en) }}</textarea></div>
  </div>

  <div class="field" style="display:flex;align-items:center;gap:8px">
    <input type="checkbox" name="is_active" value="1" style="width:18px;height:18px" @checked(old('is_active', $template->is_active))>
    <label style="margin:0">সক্রিয়</label>
  </div>

  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">সেভ করুন</button>
    <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline">বাতিল</a>
  </div>
</form>
@endsection
