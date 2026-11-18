@extends('layouts.admin')
@section('title', $certificate->exists ? 'সার্টিফিকেট এডিট' : 'নতুন সার্টিফিকেট')

@section('content')
<form method="POST" action="{{ $certificate->exists ? route('admin.showcase-certificates.update', $certificate) : route('admin.showcase-certificates.store') }}" enctype="multipart/form-data">
  @csrf
  @if ($certificate->exists) @method('PUT') @endif

  @if ($certificate->exists)
    <div style="margin-bottom:12px">
      <img src="{{ $certificate->imageUrl() }}" alt="" style="max-height:180px;border-radius:12px;border:1px solid var(--line);background:#f6f3ea;padding:8px">
    </div>
  @endif

  <div class="form-grid two">
    <div class="field"><label>শিরোনাম (বাংলা)</label><input name="title_bn" value="{{ old('title_bn', $certificate->title_bn) }}"></div>
    <div class="field"><label>Title (English)</label><input name="title_en" value="{{ old('title_en', $certificate->title_en) }}"></div>
    <div class="field"><label>সাবটাইটেল (বাংলা)</label><input name="subtitle_bn" value="{{ old('subtitle_bn', $certificate->subtitle_bn) }}" placeholder="যেমন: NSDA অনুমোদিত · Level 2"></div>
    <div class="field"><label>Subtitle (English)</label><input name="subtitle_en" value="{{ old('subtitle_en', $certificate->subtitle_en) }}"></div>
    <div class="field">
      <label>সার্টিফিকেট ছবি {{ $certificate->exists ? '(নতুন দিলে পরিবর্তন হবে)' : '*' }}</label>
      <input type="file" name="image" accept="image/*" id="showcaseCertInput" data-upload-preview="#showcaseCertPreview" @if(!$certificate->exists) required @endif>
      <div class="upload-preview" id="showcaseCertPreview" hidden></div>
    </div>
    <div class="field"><label>ক্রম (sort order)</label><input type="number" name="sort_order" value="{{ old('sort_order', $certificate->sort_order ?? 0) }}"></div>
  </div>

  <div class="field" style="display:flex;align-items:center;gap:8px">
    <input type="checkbox" name="is_active" value="1" style="width:18px;height:18px" @checked(old('is_active', $certificate->exists ? $certificate->is_active : true))>
    <label style="margin:0">হোমে দেখাবে (সক্রিয়)</label>
  </div>

  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">সেভ করুন</button>
    <a href="{{ route('admin.showcase-certificates.index') }}" class="btn btn-outline">বাতিল</a>
  </div>
</form>
@endsection
