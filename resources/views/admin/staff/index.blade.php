@extends('layouts.admin')
@section('title', 'কর্তৃপক্ষ ব্যবস্থাপনা')

@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:12px">
  <a href="{{ route('admin.staff.create') }}" class="btn btn-primary btn-sm">+ নতুন কর্মকর্তা</a>
</div>
<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>#</th><th>ছবি</th><th>নাম</th><th>পদবি</th><th>ফোন</th><th>স্ট্যাটাস</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($staff as $person)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>@if($person->photo)<img class="thumb" src="{{ $person->photo }}" alt="">@else — @endif</td>
          <td>{{ $person->name }}</td>
          <td>{{ $person->designation }}</td>
          <td>{{ $person->phone ?? '—' }}</td>
          <td><span class="badge badge-{{ $person->is_active ? 'approved' : 'cancelled' }}">{{ $person->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</span></td>
          <td class="admin-actions">
            <a href="{{ route('admin.staff.edit', $person) }}" class="btn btn-outline btn-xs">এডিট</a>
            <form method="POST" action="{{ route('admin.staff.destroy', $person) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" class="empty">কোনো কর্মকর্তা নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
