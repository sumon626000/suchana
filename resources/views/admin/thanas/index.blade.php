@extends('layouts.admin')
@section('title', 'উপজেলা ব্যবস্থাপনা')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:12px">
  <form method="GET" action="{{ route('admin.thanas.index') }}">
    <select name="district" onchange="this.form.submit()">
      <option value="">সব জেলা</option>
      @foreach ($districts as $d)
        <option value="{{ $d->id }}" @selected($districtId == $d->id)>{{ $d->name_bn }}</option>
      @endforeach
    </select>
  </form>
  <a href="{{ route('admin.thanas.create', ['district' => $districtId]) }}" class="btn btn-primary btn-sm">+ নতুন উপজেলা</a>
</div>

<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>#</th><th>উপজেলা (বাংলা)</th><th>Thana (English)</th><th>জেলা</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($thanas as $t)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $t->name_bn }}</td>
          <td>{{ $t->name_en }}</td>
          <td>{{ $t->district->name_bn ?? '—' }}</td>
          <td class="admin-actions">
            <a href="{{ route('admin.thanas.edit', $t) }}" class="btn btn-outline btn-xs">এডিট</a>
            <form method="POST" action="{{ route('admin.thanas.destroy', $t) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="empty">কোনো উপজেলা নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
