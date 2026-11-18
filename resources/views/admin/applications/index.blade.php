@extends('layouts.admin')
@section('title', 'আবেদন ব্যবস্থাপনা')

@section('content')
<form method="GET" action="{{ route('admin.applications.index') }}" class="card" style="margin-bottom:14px">
  <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end">
    <div class="field" style="margin:0;flex:1;min-width:180px">
      <label>অনুসন্ধান</label>
      <input name="q" value="{{ $q }}" placeholder="আবেদন নং / নাম / মোবাইল">
    </div>
    <div class="field" style="margin:0;min-width:160px">
      <label>স্ট্যাটাস</label>
      <select name="status">
        <option value="">সব</option>
        @foreach (['pending','verified','approved','cancelled','waitlist'] as $st)
          <option value="{{ $st }}" @selected($status === $st)>{{ $st }}</option>
        @endforeach
      </select>
    </div>
    <button class="btn btn-primary btn-sm" type="submit">ফিল্টার</button>
  </div>
</form>

<div style="display:flex;justify-content:flex-end;margin-bottom:10px">
  <a href="{{ route('admin.applications.export', request()->only('status')) }}" class="btn btn-outline btn-sm">CSV এক্সপোর্ট</a>
</div>

<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>আবেদন নং</th><th>নাম</th><th>কোর্স</th><th>স্ট্যাটাস</th><th>তারিখ</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($applications as $app)
        <tr>
          <td>{{ $app->application_no }}</td>
          <td>{{ $app->full_name }}<div class="muted" style="font-size:12px">{{ $app->mobile }}</div></td>
          <td>{{ $app->course->name_bn ?? '—' }}</td>
          <td><span class="badge badge-{{ $app->status }}">{{ $app->status }}</span></td>
          <td>{{ $app->created_at->format('d M Y') }}</td>
          <td class="admin-actions"><a href="{{ route('admin.applications.show', $app) }}" class="btn btn-outline btn-xs">বিস্তারিত</a></td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty">কোনো আবেদন পাওয়া যায়নি।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
