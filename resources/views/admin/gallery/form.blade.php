@extends('layouts.admin')
@section('title', $image->exists ? 'ছবি এডিট' : 'নতুন ছবি')

@section('content')
<form method="POST" action="{{ $image->exists ? route('admin.gallery.update', $image) : route('admin.gallery.store') }}" enctype="multipart/form-data">
  @csrf
  @if ($image->exists) @method('PUT') @endif

  @if ($image->exists)
    <div style="margin-bottom:12px"><img src="{{ $image->imageUrl() }}" alt="" style="max-height:160px;border-radius:12px;border:1px solid var(--line)"></div>
  @endif

  <div class="form-grid two">
    <div class="field"><label>শিরোনাম (বাংলা)</label><input name="title_bn" value="{{ old('title_bn', $image->title_bn) }}"></div>
    <div class="field"><label>Title (English)</label><input name="title_en" value="{{ old('title_en', $image->title_en) }}"></div>
    <div class="field">
      <label>ছবি {{ $image->exists ? '(নতুন দিলে পরিবর্তন হবে)' : '*' }}</label>
      <p class="muted" style="font-size:12px;margin:0 0 6px">JPG / PNG / WebP / GIF (max ৪MB)</p>
      <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif,.jpg,.jpeg,.png,.webp,.gif" id="galleryImageInput" data-upload-preview="#galleryPreview" @if(!$image->exists) required @endif>
      <div class="upload-preview" id="galleryPreview" hidden></div>
      @error('image')
        <p class="muted" style="color:#c8202f;font-size:12px;margin-top:4px">{{ $message }}</p>
      @enderror
    </div>
    <div class="field"><label>ক্রম (sort order)</label><input type="number" name="sort_order" value="{{ old('sort_order', $image->sort_order ?? 0) }}"></div>
  </div>

  <div class="field" style="display:flex;align-items:center;gap:8px">
    <input type="checkbox" name="is_active" value="1" style="width:18px;height:18px" @checked(old('is_active', $image->exists ? $image->is_active : true))>
    <label style="margin:0">সক্রিয়</label>
  </div>

  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">সেভ করুন</button>
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline">বাতিল</a>
  </div>
</form>
@endsection
