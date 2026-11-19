@extends('layouts.admin')
@section('title', 'সার্টিফিকেট ব্যবস্থাপনা')
@section('subtitle', 'জেনারেট বা NSDA PDF আপলোড')

@section('content')
<div class="card" style="margin-bottom:14px">
  <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
    <h3 style="font-size:16px;font-weight:700;margin:0">অটোমেটিক সার্টিফিকেট</h3>
    <form method="POST" action="{{ route('admin.certificates.auto') }}">
      @csrf
      <button class="btn btn-primary btn-sm" type="submit">সব যোগ্য শিক্ষার্থীর সার্টিফিকেট তৈরি করুন</button>
    </form>
  </div>
  <p class="muted" style="font-size:13px;margin-top:8px">অনুমোদিত আবেদন থাকা শিক্ষার্থীদের জন্য রেকর্ড তৈরি হবে। পরে NSDA PDF আপলোড করা যাবে।</p>
</div>

<form method="POST" action="{{ route('admin.certificates.store') }}" enctype="multipart/form-data" class="card" style="margin-bottom:14px">
  @csrf
  <h3 style="font-size:16px;font-weight:700;margin-bottom:10px">নতুন সার্টিফিকেট + PDF আপলোড</h3>
  <p class="muted" style="font-size:13px;margin-bottom:12px">NSDA জাতীয় সনদের PDF (যেমন Certificate_SHIPA BEGUM.pdf) এখানে আপলোড করুন। আপলোড থাকলে ডাউনলোডে সেই PDF যাবে।</p>
  <div class="form-grid two">
    <div class="field">
      <label>শিক্ষার্থী *</label>
      <select name="user_id" required>
        <option value="">নির্বাচন করুন</option>
        @foreach ($students as $s)
          <option value="{{ $s->id }}" @selected(old('user_id') == $s->id)>{{ $s->name }} ({{ $s->mobile }})</option>
        @endforeach
      </select>
    </div>
    <div class="field">
      <label>কোর্স *</label>
      <select name="course_id" required>
        <option value="">নির্বাচন করুন</option>
        @foreach ($courses as $c)
          <option value="{{ $c->id }}" @selected(old('course_id') == $c->id)>{{ $c->name_bn }}</option>
        @endforeach
      </select>
    </div>
    <div class="field">
      <label>সার্টিফিকেট PDF (ঐচ্ছিক)</label>
      <input type="file" name="pdf_file" accept="application/pdf,.pdf">
    </div>
  </div>
  <div class="admin-actions mt-2">
    <button class="btn btn-primary" type="submit">তৈরি / আপলোড করুন</button>
  </div>
</form>

<div class="table-wrap">
  <table class="data-table">
    <thead>
      <tr>
        <th>সার্টিফিকেট নং</th>
        <th>শিক্ষার্থী</th>
        <th>কোর্স</th>
        <th>PDF</th>
        <th>যাচাই কোড</th>
        <th>ইস্যু</th>
        <th>অ্যাকশন</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($certificates as $cert)
        <tr>
          <td>{{ $cert->certificate_no }}</td>
          <td>{{ $cert->user->name ?? '—' }}</td>
          <td>{{ $cert->course->name_bn ?? '—' }}</td>
          <td>
            @if ($cert->hasUploadedPdf())
              <span class="badge badge-approved">আপলোডেড</span>
            @else
              <span class="badge badge-pending">জেনারেটেড</span>
            @endif
          </td>
          <td>{{ $cert->verification_code }}</td>
          <td>{{ $cert->issued_at?->format('d M Y') }}</td>
          <td class="admin-actions" style="flex-wrap:wrap">
            <a href="{{ route('certificate.show', $cert->certificate_no) }}" target="_blank" class="btn btn-outline btn-xs">দেখুন</a>
            <a href="{{ route('certificate.pdf', $cert->certificate_no) }}" target="_blank" class="btn btn-outline btn-xs">PDF</a>
            <form method="POST" action="{{ route('admin.certificates.upload-pdf', $cert) }}" enctype="multipart/form-data" style="display:flex;gap:6px;align-items:center;flex-wrap:wrap">
              @csrf
              <input type="file" name="pdf_file" accept="application/pdf,.pdf" required style="max-width:160px">
              <button class="btn btn-primary btn-xs" type="submit">PDF আপলোড</button>
            </form>
            <form method="POST" action="{{ route('admin.certificates.destroy', $cert) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" class="empty">এখনো কোনো সার্টিফিকেট নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
