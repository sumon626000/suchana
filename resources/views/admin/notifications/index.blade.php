@extends('layouts.admin')
@section('title', 'নোটিফিকেশন টেমপ্লেট')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:12px">
  <p class="muted" style="font-size:13px;margin:0">SMS/ইমেইল টেমপ্লেট সম্পাদনা করুন। প্লেসহোল্ডার: {name}, {app_no}, {course}, {status}, {cert_no}</p>
  <a href="{{ route('admin.notifications.logs') }}" class="btn btn-outline btn-sm">পাঠানো লগ</a>
</div>

<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>কী</th><th>চ্যানেল</th><th>বিষয়</th><th>বার্তা (বাংলা)</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($templates as $tpl)
        <tr>
          <td><code>{{ $tpl->key }}</code></td>
          <td>{{ $tpl->channel }}</td>
          <td>{{ $tpl->subject ?? '—' }}</td>
          <td style="max-width:340px">{{ \Illuminate\Support\Str::limit($tpl->body_bn, 90) }}</td>
          <td><span class="badge badge-{{ $tpl->is_active ? 'approved' : 'cancelled' }}">{{ $tpl->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span></td>
          <td class="admin-actions"><a href="{{ route('admin.notifications.edit', $tpl) }}" class="btn btn-outline btn-xs">এডিট</a></td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty">কোনো টেমপ্লেট নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
