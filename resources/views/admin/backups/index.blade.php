@extends('layouts.admin')
@section('title', 'ব্যাকআপ')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;gap:10px;flex-wrap:wrap">
  <p class="muted" style="margin:0;font-size:13px">প্রতিদিন রাত ২:০০-এ স্বয়ংক্রিয় ব্যাকআপ হয়। চাইলে এখনই তৈরি করতে পারেন।</p>
  <form method="POST" action="{{ route('admin.backups.create') }}">
    @csrf
    <button class="btn btn-primary btn-sm" type="submit">+ এখনই ব্যাকআপ</button>
  </form>
</div>
<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>ফাইল</th><th>আকার</th><th>সময়</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($files as $f)
        <tr>
          <td><strong>{{ $f['name'] }}</strong></td>
          <td>{{ number_format($f['size'] / 1024, 1) }} KB</td>
          <td>{{ \Carbon\Carbon::createFromTimestamp($f['time'])->format('d M Y, h:i A') }}</td>
          <td class="admin-actions">
            <a class="btn btn-outline btn-xs" href="{{ route('admin.backups.download', $f['name']) }}">ডাউনলোড</a>
            <form method="POST" action="{{ route('admin.backups.destroy', $f['name']) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="4" class="empty">এখনো কোনো ব্যাকআপ নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
