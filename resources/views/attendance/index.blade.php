@extends('layouts.admin')
@section('title', 'উপস্থিতি')
@section('subtitle', $date)

@section('content')
<form method="GET" action="{{ route('attendance.index') }}" class="card" style="margin-bottom:14px">
  <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end">
    <div class="field" style="margin:0;min-width:180px">
      <label>কোর্স</label>
      <select name="course" onchange="this.form.submit()">
        @foreach ($courses as $c)
          <option value="{{ $c->id }}" @selected($courseId == $c->id)>{{ $c->name_bn }}</option>
        @endforeach
      </select>
    </div>
    <div class="field" style="margin:0;min-width:170px">
      <label>ব্যাচ</label>
      <select name="batch" onchange="this.form.submit()">
        <option value="">সব ব্যাচ</option>
        @foreach ($batches as $b)
          <option value="{{ $b->id }}" @selected($batchId == $b->id)>{{ $b->name_bn }}</option>
        @endforeach
      </select>
    </div>
    <div class="field" style="margin:0;min-width:160px">
      <label>তারিখ</label>
      <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()">
    </div>
    <button class="btn btn-outline btn-sm" type="submit">দেখুন</button>
    <a href="{{ route('admin.attendance.report') }}" class="btn btn-outline btn-sm">রিপোর্ট</a>
    <a href="{{ route('attendance.qr', ['course' => $courseId, 'batch' => $batchId, 'date' => $date]) }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm">QR কোড</a>
  </div>
  <p class="muted" style="font-size:12px;margin-top:8px">QR কোড শিক্ষার্থীদের দেখান — তারা স্ক্যান করে নিজেই উপস্থিতি দিতে পারবে (একই দিনে একবারের বেশি নয়)।</p>
</form>

@if ($students->isEmpty())
  <div class="card empty">এই কোর্স/ব্যাচে অনুমোদিত কোনো শিক্ষার্থী নেই।</div>
@else
  <form method="POST" action="{{ route('attendance.store') }}">
    @csrf
    <input type="hidden" name="course_id" value="{{ $courseId }}">
    <input type="hidden" name="batch_id" value="{{ $batchId }}">
    <input type="hidden" name="date" value="{{ $date }}">

    <div class="table-wrap">
      <table class="data-table">
        <thead>
          <tr>
            <th>শিক্ষার্থী</th>
            <th>উপস্থিত</th>
            <th>অনুপস্থিত</th>
            <th>দেরি</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($students as $student)
            @php $cur = $existing->get($student->id)?->status ?? 'present'; @endphp
            <tr>
              <td>
                <strong>{{ $student->name }}</strong>
                <div class="muted" style="font-size:12px">{{ $student->mobile }}</div>
              </td>
              @foreach (['present', 'absent', 'late'] as $st)
                <td><input type="radio" name="marks[{{ $student->id }}]" value="{{ $st }}" @checked($cur === $st)></td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="admin-actions mt-2">
      <button class="btn btn-primary" type="submit">উপস্থিতি সংরক্ষণ করুন</button>
    </div>
  </form>
@endif
@endsection
