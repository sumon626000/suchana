@extends('layouts.admin')
@section('title', $batch->exists ? 'ব্যাচ এডিট' : 'নতুন ব্যাচ')

@section('content')
<form method="POST" action="{{ $batch->exists ? route('admin.batches.update', $batch) : route('admin.batches.store') }}">
  @csrf
  @if ($batch->exists) @method('PUT') @endif

  <div class="form-grid two">
    <div class="field">
      <label>কোর্স *</label>
      <select name="course_id" required>
        <option value="">নির্বাচন করুন</option>
        @foreach ($courses as $c)
          <option value="{{ $c->id }}" @selected(old('course_id', $batch->course_id) == $c->id)>{{ $c->name_bn }}</option>
        @endforeach
      </select>
    </div>
    <div class="field">
      <label>প্রশিক্ষক</label>
      <select name="trainer_id">
        <option value="">নির্বাচন করুন</option>
        @foreach ($trainers as $tr)
          <option value="{{ $tr->id }}" @selected(old('trainer_id', $batch->trainer_id) == $tr->id)>{{ $tr->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="field"><label>ব্যাচ নাম (বাংলা) *</label><input name="name_bn" value="{{ old('name_bn', $batch->name_bn) }}" required></div>
    <div class="field"><label>Batch Name (English) *</label><input name="name_en" value="{{ old('name_en', $batch->name_en) }}" required></div>
    <div class="field"><label>সময় (বাংলা)</label><input name="time_bn" value="{{ old('time_bn', $batch->time_bn) }}" placeholder="শনি–বৃহঃ, সকাল ৯টা–১২টা"></div>
    <div class="field"><label>Time (English)</label><input name="time_en" value="{{ old('time_en', $batch->time_en) }}" placeholder="Sat–Thu, 9 AM–12 PM"></div>
    <div class="field"><label>আসন *</label><input type="number" name="seats" value="{{ old('seats', $batch->seats ?? 40) }}" required></div>
  </div>

  <div class="field" style="display:flex;align-items:center;gap:8px">
    <input type="checkbox" name="is_active" value="1" style="width:18px;height:18px" @checked(old('is_active', $batch->exists ? $batch->is_active : true))>
    <label style="margin:0">সক্রিয়</label>
  </div>

  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">সেভ করুন</button>
    <a href="{{ route('admin.batches.index') }}" class="btn btn-outline">বাতিল</a>
  </div>
</form>
@endsection
