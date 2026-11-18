@extends('layouts.admin')
@section('title', 'শিক্ষার্থী ব্যবস্থাপনা')

@section('content')
<form method="GET" action="{{ route('admin.students.index') }}" class="card" style="margin-bottom:14px">
  <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end">
    <div class="field" style="margin:0;flex:1;min-width:200px">
      <label>অনুসন্ধান</label>
      <input name="q" value="{{ $q }}" placeholder="নাম / মোবাইল / ইমেইল / ইউজারনেম">
    </div>
    <button class="btn btn-primary btn-sm" type="submit">খুঁজুন</button>
  </div>
</form>

<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>#</th><th>নাম</th><th>ইউজারনেম</th><th>মোবাইল</th><th>ইমেইল</th><th>আবেদন</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($students as $student)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $student->name }}</td>
          <td>{{ $student->username }}</td>
          <td>{{ $student->mobile }}</td>
          <td>{{ $student->email }}</td>
          <td>{{ $student->applications_count }}</td>
          <td><span class="badge badge-{{ $student->is_active ? 'approved' : 'cancelled' }}">{{ $student->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span></td>
          <td class="admin-actions"><a href="{{ route('admin.students.show', $student) }}" class="btn btn-outline btn-xs">বিস্তারিত</a></td>
        </tr>
      @empty
        <tr><td colspan="8" class="empty">কোনো শিক্ষার্থী পাওয়া যায়নি।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
