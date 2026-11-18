@extends('layouts.admin')
@section('title', 'ব্রাঞ্চ ব্যবস্থাপনা')

@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:12px">
  <a href="{{ route('admin.branches.create') }}" class="btn btn-primary btn-sm">+ নতুন ব্রাঞ্চ</a>
</div>
<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>#</th><th>নাম</th><th>ঠিকানা</th><th>ফোন</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($branches as $branch)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><strong>{{ $branch->name_bn }}</strong><div class="muted" style="font-size:12px">{{ $branch->name_en }}</div></td>
          <td>{{ $branch->address }}</td>
          <td>{{ $branch->phone ?? '—' }}</td>
          <td><span class="badge badge-{{ $branch->is_active ? 'approved' : 'cancelled' }}">{{ $branch->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span></td>
          <td class="admin-actions">
            <a href="{{ route('admin.branches.edit', $branch) }}" class="btn btn-outline btn-xs">এডিট</a>
            <form method="POST" action="{{ route('admin.branches.destroy', $branch) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty">কোনো ব্রাঞ্চ নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
