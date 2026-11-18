@extends('layouts.admin')
@section('title', 'ব্যাচ ব্যবস্থাপনা')

@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:12px">
  <a href="{{ route('admin.batches.create') }}" class="btn btn-primary btn-sm">+ নতুন ব্যাচ</a>
</div>
<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>#</th><th>ব্যাচ</th><th>কোর্স</th><th>প্রশিক্ষক</th><th>সময়</th><th>আসন</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($batches as $batch)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><strong>{{ $batch->name_bn }}</strong><div class="muted" style="font-size:12px">{{ $batch->name_en }}</div></td>
          <td>{{ $batch->course?->name_bn ?? '—' }}</td>
          <td>{{ $batch->trainer?->name ?? '—' }}</td>
          <td>{{ $batch->time_bn ?? '—' }}</td>
          <td>{{ $batch->seats }}</td>
          <td><span class="badge badge-{{ $batch->is_active ? 'approved' : 'cancelled' }}">{{ $batch->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span></td>
          <td class="admin-actions">
            <a href="{{ route('admin.batches.edit', $batch) }}" class="btn btn-outline btn-xs">এডিট</a>
            <form method="POST" action="{{ route('admin.batches.destroy', $batch) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="8" class="empty">কোনো ব্যাচ নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
