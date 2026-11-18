@extends('layouts.admin')
@section('title', 'নোটিফিকেশন লগ')

@section('content')
<a href="{{ route('admin.notifications.index') }}" class="btn btn-outline btn-sm" style="margin-bottom:12px">← টেমপ্লেটে ফিরুন</a>
<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>#</th><th>টেমপ্লেট</th><th>চ্যানেল</th><th>প্রাপক</th><th>বার্তা</th><th>স্ট্যাটাস</th><th>সময়</th></tr></thead>
    <tbody>
      @forelse ($logs as $log)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td><code>{{ $log->template_key }}</code></td>
          <td>{{ $log->channel }}</td>
          <td>{{ $log->recipient }}</td>
          <td style="max-width:360px">{{ $log->message }}</td>
          <td><span class="badge badge-verified">{{ $log->status }}</span></td>
          <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
        </tr>
      @empty
        <tr><td colspan="7" class="empty">কোনো লগ নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
