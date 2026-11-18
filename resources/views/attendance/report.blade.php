@extends('layouts.admin')
@section('title', 'উপস্থিতি রিপোর্ট')

@section('content')
<form method="GET" action="{{ route('admin.attendance.report') }}" class="card" style="margin-bottom:14px">
  <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end">
    <div class="field" style="margin:0;min-width:200px">
      <label>কোর্স</label>
      <select name="course">
        <option value="">সব কোর্স</option>
        @foreach ($courses as $c)
          <option value="{{ $c->id }}" @selected($courseId == $c->id)>{{ $c->name_bn }}</option>
        @endforeach
      </select>
    </div>
    <div class="field" style="margin:0;min-width:150px">
      <label>শুরুর তারিখ</label>
      <input type="date" name="from" value="{{ $from }}">
    </div>
    <div class="field" style="margin:0;min-width:150px">
      <label>শেষ তারিখ</label>
      <input type="date" name="to" value="{{ $to }}">
    </div>
    <button class="btn btn-primary btn-sm" type="submit">রিপোর্ট দেখুন</button>
  </div>
</form>

<div style="display:flex;gap:8px;margin-bottom:10px">
  <a href="{{ route('admin.attendance.export', request()->only(['course','from','to'])) }}" class="btn btn-outline btn-sm">CSV এক্সপোর্ট</a>
  <button type="button" class="btn btn-outline btn-sm" onclick="window.print()">প্রিন্ট / PDF</button>
</div>

<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>শিক্ষার্থী</th><th>মোবাইল</th><th>উপস্থিত</th><th>অনুপস্থিত</th><th>দেরি</th><th>মোট</th></tr></thead>
    <tbody>
      @forelse ($summary as $row)
        <tr>
          <td>{{ $row['name'] }}</td>
          <td>{{ $row['mobile'] ?? '—' }}</td>
          <td><span class="badge badge-approved">{{ $row['present'] }}</span></td>
          <td><span class="badge badge-cancelled">{{ $row['absent'] }}</span></td>
          <td>{{ $row['late'] }}</td>
          <td>{{ $row['total'] }}</td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty">এই সময়ে কোনো উপস্থিতি রেকর্ড নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<a href="{{ route('attendance.index') }}" class="btn btn-outline btn-sm mt-2">উপস্থিতি পেজে ফিরুন</a>
@endsection
