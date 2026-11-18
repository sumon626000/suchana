@extends('layouts.admin')
@section('title', 'সার্টিফিকেট ব্যবস্থাপনা')

@section('content')
<div class="card" style="margin-bottom:14px">
  <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
    <h3 style="font-size:16px;font-weight:700;margin:0">অটোমেটিক সার্টিফিকেট</h3>
    <form method="POST" action="{{ route('admin.certificates.auto') }}">
      @csrf
      <button class="btn btn-primary btn-sm" type="submit">সব যোগ্য শিক্ষার্থীর সার্টিফিকেট তৈরি করুন</button>
    </form>
  </div>
  <p class="muted" style="font-size:13px;margin-top:8px">অনুমোদিত আবেদন থাকা শিক্ষার্থীদের জন্য সার্টিফিকেট তৈরি হবে।</p>
</div>

<form method="POST" action="{{ route('admin.certificates.store') }}" class="card" style="margin-bottom:14px">
  @csrf
  <h3 style="font-size:16px;font-weight:700;margin-bottom:10px">ম্যানুয়াল সার্টিফিকেট</h3>
  <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end">
    <div class="field" style="margin:0;min-width:200px">
      <label>শিক্ষার্থী</label>
      <select name="user_id" required>
        <option value="">নির্বাচন করুন</option>
        @foreach ($students as $s)
          <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->mobile }})</option>
        @endforeach
      </select>
    </div>
    <div class="field" style="margin:0;min-width:200px">
      <label>কোর্স</label>
      <select name="course_id" required>
        <option value="">নির্বাচন করুন</option>
        @foreach ($courses as $c)
          <option value="{{ $c->id }}">{{ $c->name_bn }}</option>
        @endforeach
      </select>
    </div>
    <button class="btn btn-outline btn-sm" type="submit">তৈরি করুন</button>
  </div>
</form>

<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>সার্টিফিকেট নং</th><th>শিক্ষার্থী</th><th>কোর্স</th><th>যাচাই কোড</th><th>ইস্যু</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($certificates as $cert)
        <tr>
          <td>{{ $cert->certificate_no }}</td>
          <td>{{ $cert->user->name ?? '—' }}</td>
          <td>{{ $cert->course->name_bn ?? '—' }}</td>
          <td>{{ $cert->verification_code }}</td>
          <td>{{ $cert->issued_at?->format('d M Y') }}</td>
          <td class="admin-actions">
            <a href="{{ route('certificate.show', $cert->certificate_no) }}" target="_blank" class="btn btn-outline btn-xs">দেখুন</a>
            <form method="POST" action="{{ route('admin.certificates.destroy', $cert) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty">এখনো কোনো সার্টিফিকেট নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
