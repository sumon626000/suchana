@extends('layouts.admin')
@section('title', 'নোটিশ ব্যবস্থাপনা')

@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:12px">
  <a href="{{ route('admin.notices.create') }}" class="btn btn-primary btn-sm">+ নতুন নোটিশ</a>
</div>
<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>#</th><th>শিরোনাম</th><th>টাইপ</th><th>প্রকাশ</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($notices as $notice)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><strong>{{ $notice->title_bn }}</strong><div class="muted" style="font-size:12px">{{ $notice->title_en }}</div></td>
          <td>{{ $notice->type }}</td>
          <td>{{ $notice->published_at?->format('d M Y') }}</td>
          <td><span class="badge badge-{{ $notice->is_active ? 'approved' : 'cancelled' }}">{{ $notice->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span></td>
          <td class="admin-actions">
            <a href="{{ route('admin.notices.edit', $notice) }}" class="btn btn-outline btn-xs">এডিট</a>
            <form method="POST" action="{{ route('admin.notices.destroy', $notice) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty">কোনো নোটিশ নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
