@extends('layouts.admin')
@section('title', 'কোর্স ব্যবস্থাপনা')

@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:12px">
  <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">+ নতুন কোর্স</a>
</div>
<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>#</th><th>নাম</th><th>লেভেল</th><th>আসন</th><th>ফি</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($courses as $course)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><strong>{{ $course->name_bn }}</strong><div class="muted" style="font-size:12px">{{ $course->name_en }}</div></td>
          <td>{{ $course->level }}</td>
          <td>{{ $course->seats_available }}/{{ $course->seats_total }}</td>
          <td>৳{{ number_format($course->fee) }}</td>
          <td><span class="badge badge-{{ $course->is_active ? 'approved' : 'cancelled' }}">{{ $course->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span></td>
          <td class="admin-actions">
            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-outline btn-xs">এডিট</a>
            <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" class="empty">কোনো কোর্স নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
