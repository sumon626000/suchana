@extends('layouts.admin')
@section('title', $course->exists ? 'কোর্স এডিট' : 'নতুন কোর্স')

@section('content')
<form method="POST" action="{{ $course->exists ? route('admin.courses.update', $course) : route('admin.courses.store') }}">
  @csrf
  @if ($course->exists) @method('PUT') @endif

  <div class="form-grid two">
    <div class="field"><label>নাম (বাংলা) *</label><input name="name_bn" value="{{ old('name_bn', $course->name_bn) }}" required></div>
    <div class="field"><label>Name (English) *</label><input name="name_en" value="{{ old('name_en', $course->name_en) }}" required></div>
    <div class="field"><label>লেভেল</label><input name="level" value="{{ old('level', $course->level ?? 'Level 2') }}"></div>
    <div class="field"><label>মেয়াদ (বাংলা)</label><input name="duration_bn" value="{{ old('duration_bn', $course->duration_bn) }}"></div>
    <div class="field"><label>মেয়াদ (English)</label><input name="duration_en" value="{{ old('duration_en', $course->duration_en) }}"></div>
    <div class="field"><label>ছবি URL</label><input name="image" value="{{ old('image', $course->image) }}" placeholder="https://..."></div>
    <div class="field"><label>মোট আসন *</label><input type="number" name="seats_total" value="{{ old('seats_total', $course->seats_total ?? 40) }}" required></div>
    <div class="field"><label>উপলব্ধ আসন *</label><input type="number" name="seats_available" value="{{ old('seats_available', $course->seats_available ?? 40) }}" required></div>
    <div class="field"><label>কোর্স ফি (৳)</label><input type="number" step="0.01" name="fee" value="{{ old('fee', $course->fee ?? 0) }}"></div>
    <div class="field"><label>ভাতা পুরুষ (৳)</label><input type="number" step="0.01" name="stipend_male" value="{{ old('stipend_male', $course->stipend_male ?? 0) }}"></div>
    <div class="field"><label>ভাতা মহিলা (৳)</label><input type="number" step="0.01" name="stipend_female" value="{{ old('stipend_female', $course->stipend_female ?? 0) }}"></div>
    <div class="field"><label>আবেদনের শেষ তারিখ</label><input type="date" name="application_deadline" value="{{ old('application_deadline', $course->application_deadline?->format('Y-m-d')) }}"></div>
    <div class="field"><label>ক্রম (sort order)</label><input type="number" name="sort_order" value="{{ old('sort_order', $course->sort_order ?? 0) }}"></div>
  </div>

  <div class="form-grid">
    <div class="field"><label>যোগ্যতা (বাংলা)</label><textarea name="eligibility_bn" rows="2">{{ old('eligibility_bn', $course->eligibility_bn) }}</textarea></div>
    <div class="field"><label>Eligibility (English)</label><textarea name="eligibility_en" rows="2">{{ old('eligibility_en', $course->eligibility_en) }}</textarea></div>
    <div class="field"><label>বিবরণ (বাংলা)</label><textarea name="description_bn" rows="3">{{ old('description_bn', $course->description_bn) }}</textarea></div>
    <div class="field"><label>Description (English)</label><textarea name="description_en" rows="3">{{ old('description_en', $course->description_en) }}</textarea></div>
  </div>

  <div class="field" style="display:flex;align-items:center;gap:8px">
    <input type="checkbox" name="is_active" value="1" style="width:18px;height:18px" @checked(old('is_active', $course->exists ? $course->is_active : true))>
    <label style="margin:0">সক্রিয়</label>
  </div>

  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">সেভ করুন</button>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline">বাতিল</a>
  </div>
</form>
@endsection
