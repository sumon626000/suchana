@extends('layouts.admin')
@section('title', 'জেলা ব্যবস্থাপনা')

@section('content')
<div style="display:flex;justify-content:flex-end;margin-bottom:12px">
  <a href="{{ route('admin.districts.create') }}" class="btn btn-primary btn-sm">+ নতুন জেলা</a>
</div>
<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>#</th><th>জেলা (বাংলা)</th><th>District (English)</th><th>বিভাগ</th><th>উপজেলা</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($districts as $d)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $d->name_bn }}</td>
          <td>{{ $d->name_en }}</td>
          <td>{{ $d->division_bn }}</td>
          <td><a href="{{ route('admin.thanas.index', ['district' => $d->id]) }}">{{ $d->thanas_count }}</a></td>
          <td class="admin-actions">
            <a href="{{ route('admin.districts.edit', $d) }}" class="btn btn-outline btn-xs">এডিট</a>
            <form method="POST" action="{{ route('admin.districts.destroy', $d) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty">কোনো জেলা নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
