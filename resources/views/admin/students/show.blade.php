@extends('layouts.admin')
@section('title', $student->name)

@section('content')
<div class="card" style="max-width:820px">
  <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
    <h2 style="font-size:22px;font-weight:700;margin:0">{{ $student->name }}</h2>
    <span class="badge badge-{{ $student->is_active ? 'approved' : 'cancelled' }}">{{ $student->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span>
  </div>
  <table class="mt-3" style="font-size:14px">
    <tr><td class="muted" style="padding:5px 0;width:150px">ইউজারনেম</td><td>{{ $student->username }}</td></tr>
    <tr><td class="muted" style="padding:5px 0">মোবাইল</td><td>{{ $student->mobile }}</td></tr>
    <tr><td class="muted" style="padding:5px 0">ইমেইল</td><td>{{ $student->email }}</td></tr>
    <tr><td class="muted" style="padding:5px 0">রেজিস্ট্রেশন</td><td>{{ $student->created_at->format('d M Y') }}</td></tr>
  </table>

  <form method="POST" action="{{ route('admin.students.toggle', $student) }}" class="mt-2">
    @csrf
    <button class="btn btn-outline btn-sm" type="submit">{{ $student->is_active ? 'নিষ্ক্রিয় করুন' : 'সক্রিয় করুন' }}</button>
  </form>

  <form method="POST" action="{{ route('admin.students.password', $student) }}" class="mt-2" style="display:flex;gap:8px;flex-wrap:wrap;align-items:flex-end">
    @csrf
    <div class="field" style="margin:0"><label style="font-size:12px">নতুন পাসওয়ার্ড</label><input type="password" name="password" required minlength="6" autocomplete="new-password" style="width:170px"></div>
    <div class="field" style="margin:0"><label style="font-size:12px">নিশ্চিত করুন</label><input type="password" name="password_confirmation" required minlength="6" autocomplete="new-password" style="width:170px"></div>
    <button class="btn btn-outline btn-sm" type="submit">পাসওয়ার্ড রিসেট</button>
  </form>

  <hr class="hr">
  <h3 style="font-size:16px;font-weight:700;margin-bottom:10px">আবেদনসমূহ</h3>
  @forelse ($student->applications as $app)
    <div class="notice-card" style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
      <div><strong>{{ $app->course->name_bn ?? '—' }}</strong><div class="muted" style="font-size:12px">{{ $app->application_no }}</div></div>
      <span class="badge badge-{{ $app->status }}">{{ $app->status }}</span>
    </div>
  @empty
    <p class="muted">কোনো আবেদন নেই।</p>
  @endforelse

  <h3 style="font-size:16px;font-weight:700;margin:16px 0 10px">সার্টিফিকেট</h3>
  @forelse ($student->certificates as $cert)
    <div class="notice-card" style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap">
      <div>{{ $cert->course->name_bn ?? '—' }}</div>
      <div class="muted">{{ $cert->certificate_no }}</div>
    </div>
  @empty
    <p class="muted">কোনো সার্টিফিকেট নেই।</p>
  @endforelse

  <h3 style="font-size:16px;font-weight:700;margin:16px 0 10px">উপস্থিতি</h3>
  @forelse ($student->attendances->take(20) as $att)
    <div class="notice-card" style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap">
      <div>{{ $att->course->name_bn ?? '—' }}</div>
      <div class="muted">{{ $att->date?->format('d M Y') }}</div>
      <span class="badge {{ $att->status === 'present' ? 'badge-approved' : 'badge-cancelled' }}">{{ $att->status }}</span>
    </div>
  @empty
    <p class="muted">কোনো উপস্থিতি নেই।</p>
  @endforelse
</div>
@endsection
