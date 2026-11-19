@extends('layouts.admin')
@section('title', 'ড্যাশবোর্ড')

@section('content')
<div class="quick-actions">
  <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">+ নতুন কোর্স</a>
  <a href="{{ route('admin.applications.index') }}" class="btn btn-outline btn-sm">আবেদন দেখুন</a>
  <a href="{{ route('attendance.index') }}" class="btn btn-outline btn-sm">উপস্থিতি নিন</a>
  <a href="{{ route('admin.gallery.create') }}" class="btn btn-outline btn-sm">ছবি আপলোড</a>
  <a href="{{ route('admin.notices.create') }}" class="btn btn-outline btn-sm">নোটিশ দিন</a>
  <a href="{{ route('admin.settings.index') }}" class="btn btn-outline btn-sm">সেটিংস</a>
</div>

<div class="cards">
  <div class="card-stat"><div class="n">{{ $stats['courses'] }}</div><div class="l">কোর্স</div></div>
  <div class="card-stat"><div class="n">{{ $stats['students'] }}</div><div class="l">শিক্ষার্থী</div></div>
  <div class="card-stat"><div class="n">{{ $stats['applications'] }}</div><div class="l">মোট আবেদন</div></div>
  <div class="card-stat"><div class="n">{{ $stats['pending'] }}</div><div class="l">অপেক্ষমাণ আবেদন</div></div>
  <div class="card-stat"><div class="n">{{ $stats['branches'] }}</div><div class="l">ব্রাঞ্চ</div></div>
  <div class="card-stat"><div class="n">{{ $stats['staff'] }}</div><div class="l">কর্তৃপক্ষ</div></div>
  <div class="card-stat"><div class="n">{{ $stats['notices'] }}</div><div class="l">নোটিশ</div></div>
  <div class="card-stat"><div class="n">{{ $stats['certificates'] }}</div><div class="l">সার্টিফিকেট</div></div>
</div>

<div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin:22px 0 12px">
  <h2 class="admin-title" style="font-size:19px;margin:0">সাম্প্রতিক আবেদন</h2>
  <a href="{{ route('admin.applications.index') }}" class="btn btn-outline btn-sm">সব আবেদন</a>
</div>

<div class="table-wrap">
  <table class="data-table">
    <thead>
      <tr><th>আবেদন নং</th><th>নাম</th><th>কোর্স</th><th>স্ট্যাটাস</th><th>তারিখ</th></tr>
    </thead>
    <tbody>
      @forelse ($recent as $application)
        <tr>
          <td><a href="{{ route('admin.applications.show', $application) }}">{{ $application->application_no }}</a></td>
          <td>{{ $application->full_name }}</td>
          <td>{{ $application->course?->name_bn ?? '—' }}</td>
          <td><span class="badge badge-{{ $application->status }}">{{ $application->status }}</span></td>
          <td>{{ $application->created_at?->format('d M Y') }}</td>
        </tr>
      @empty
        <tr><td colspan="5" class="empty">এখনো কোনো আবেদন নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
