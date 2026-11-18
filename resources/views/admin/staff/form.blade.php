@extends('layouts.admin')
@section('title', $person->exists ? 'কর্মকর্তা এডিট' : 'নতুন কর্মকর্তা')

@section('content')
<form method="POST" action="{{ $person->exists ? route('admin.staff.update', $person) : route('admin.staff.store') }}" enctype="multipart/form-data">
  @csrf
  @if ($person->exists) @method('PUT') @endif

  <div class="form-grid two">
    <div class="field"><label>নাম *</label><input name="name" value="{{ old('name', $person->name) }}" required></div>
    <div class="field"><label>পদবি *</label><input name="designation" value="{{ old('designation', $person->designation) }}" required></div>
    <div class="field"><label>ছবি URL (ঐচ্ছিক)</label><input name="photo" value="{{ old('photo', $person->photo) }}" placeholder="https://..."></div>
    <div class="field">
      <label>অথবা ছবি আপলোড</label>
      <input type="file" name="photo_file" accept="image/*" data-upload-preview="#staffPhotoPreview">
      <div class="upload-preview" id="staffPhotoPreview" hidden></div>
    </div>
    <div class="field"><label>ফোন</label><input name="phone" value="{{ old('phone', $person->phone) }}"></div>
    <div class="field"><label>ইমেইল</label><input type="email" name="email" value="{{ old('email', $person->email) }}"></div>
    <div class="field"><label>ক্রম</label><input type="number" name="sort_order" value="{{ old('sort_order', $person->sort_order ?? 0) }}"></div>
  </div>

  <div class="field"><label>বায়ো / বিবরণ</label><textarea name="bio" rows="3">{{ old('bio', $person->bio) }}</textarea></div>

  <div class="field" style="display:flex;align-items:center;gap:8px">
    <input type="checkbox" name="is_active" value="1" style="width:18px;height:18px" @checked(old('is_active', $person->exists ? $person->is_active : true))>
    <label style="margin:0">সক্রিয়</label>
  </div>

  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">সেভ করুন</button>
    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline">বাতিল</a>
  </div>
</form>
@endsection
