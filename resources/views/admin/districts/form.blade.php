@extends('layouts.admin')
@section('title', $district->exists ? 'জেলা এডিট' : 'নতুন জেলা')

@section('content')
<form method="POST" action="{{ $district->exists ? route('admin.districts.update', $district) : route('admin.districts.store') }}">
  @csrf
  @if ($district->exists) @method('PUT') @endif

  <div class="form-grid two">
    <div class="field"><label>জেলা (বাংলা) *</label><input name="name_bn" value="{{ old('name_bn', $district->name_bn) }}" required></div>
    <div class="field"><label>District (English) *</label><input name="name_en" value="{{ old('name_en', $district->name_en) }}" required></div>
    <div class="field"><label>বিভাগ (বাংলা) *</label><input name="division_bn" value="{{ old('division_bn', $district->division_bn) }}" required></div>
    <div class="field"><label>Division (English) *</label><input name="division_en" value="{{ old('division_en', $district->division_en) }}" required></div>
  </div>

  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">সেভ করুন</button>
    <a href="{{ route('admin.districts.index') }}" class="btn btn-outline">বাতিল</a>
  </div>
</form>
@endsection
