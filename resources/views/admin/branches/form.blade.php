@extends('layouts.admin')
@section('title', $branch->exists ? 'ব্রাঞ্চ এডিট' : 'নতুন ব্রাঞ্চ')

@section('content')
<form method="POST" action="{{ $branch->exists ? route('admin.branches.update', $branch) : route('admin.branches.store') }}" enctype="multipart/form-data">
  @csrf
  @if ($branch->exists) @method('PUT') @endif

  <div class="form-grid two">
    <div class="field"><label>নাম (বাংলা) *</label><input name="name_bn" value="{{ old('name_bn', $branch->name_bn) }}" required></div>
    <div class="field"><label>Name (English) *</label><input name="name_en" value="{{ old('name_en', $branch->name_en) }}" required></div>
    <div class="field"><label>ফোন</label><input name="phone" value="{{ old('phone', $branch->phone) }}"></div>
    <div class="field"><label>ইমেইল</label><input type="email" name="email" value="{{ old('email', $branch->email) }}"></div>
    <div class="field"><label>ছবি URL (ঐচ্ছিক)</label><input name="image" value="{{ old('image', $branch->image) }}"></div>
    <div class="field">
      <label>অথবা ছবি আপলোড</label>
      <input type="file" name="image_file" accept="image/*" data-upload-preview="#branchPhotoPreview">
      <div class="upload-preview" id="branchPhotoPreview" hidden></div>
    </div>
    <div class="field"><label>ম্যাপ URL</label><input name="map_url" value="{{ old('map_url', $branch->map_url) }}"></div>
    <div class="field"><label>ক্রম</label><input type="number" name="sort_order" value="{{ old('sort_order', $branch->sort_order ?? 0) }}"></div>
  </div>

  <div class="field"><label>ঠিকানা *</label><textarea name="address" rows="2" required>{{ old('address', $branch->address) }}</textarea></div>

  <div class="field" style="display:flex;align-items:center;gap:8px">
    <input type="checkbox" name="is_active" value="1" style="width:18px;height:18px" @checked(old('is_active', $branch->exists ? $branch->is_active : true))>
    <label style="margin:0">সক্রিয়</label>
  </div>

  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">সেভ করুন</button>
    <a href="{{ route('admin.branches.index') }}" class="btn btn-outline">বাতিল</a>
  </div>
</form>
@endsection
