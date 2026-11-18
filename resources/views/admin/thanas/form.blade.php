@extends('layouts.admin')
@section('title', $thana->exists ? 'উপজেলা এডিট' : 'নতুন উপজেলা')

@section('content')
<form method="POST" action="{{ $thana->exists ? route('admin.thanas.update', $thana) : route('admin.thanas.store') }}">
  @csrf
  @if ($thana->exists) @method('PUT') @endif

  <div class="form-grid two">
    <div class="field">
      <label>জেলা *</label>
      <select name="district_id" required>
        <option value="">নির্বাচন করুন</option>
        @foreach ($districts as $d)
          <option value="{{ $d->id }}" @selected(old('district_id', $selectedDistrict) == $d->id)>{{ $d->name_bn }} ({{ $d->name_en }})</option>
        @endforeach
      </select>
    </div>
    <div class="field"><label>উপজেলা (বাংলা) *</label><input name="name_bn" value="{{ old('name_bn', $thana->name_bn) }}" required></div>
    <div class="field"><label>Thana (English) *</label><input name="name_en" value="{{ old('name_en', $thana->name_en) }}" required></div>
  </div>

  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">সেভ করুন</button>
    <a href="{{ route('admin.thanas.index') }}" class="btn btn-outline">বাতিল</a>
  </div>
</form>
@endsection
