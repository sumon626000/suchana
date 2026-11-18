@extends('layouts.public')
@section('title', 'QR উপস্থিতি — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <div class="form-card" style="max-width:520px;text-align:center">
      @if ($session && $course)
        <div class="kicker center"><span class="kicker-num">QR উপস্থিতি</span></div>
        <h1 class="section-title" style="font-size:26px">উপস্থিতি নিশ্চিত করুন</h1>
        <p class="muted">
          কোর্স: <strong>{{ $course->name_bn }}</strong><br>
          তারিখ: {{ \Carbon\Carbon::parse($session['date'])->format('d M Y') }}
          @if ($batch) · {{ $batch->name_bn }} @endif
        </p>

        @if ($already)
          <div class="alert alert-success mt-3">আপনি ইতিমধ্যে এই ক্লাসে উপস্থিতি দিয়েছেন।</div>
          <a href="{{ route('student.dashboard') }}" class="btn btn-outline mt-2">ড্যাশবোর্ডে ফিরুন</a>
        @else
          <form method="POST" action="{{ route('attendance.scan.store') }}" class="mt-3">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <button class="btn btn-primary btn-lg" type="submit">উপস্থিতি দিন</button>
          </form>
          <p class="muted mt-2" style="font-size:12px">বাটনে ক্লিক করলে এই ক্লাসের উপস্থিতি রেকর্ড হবে।</p>
        @endif
      @else
        <div class="alert alert-error">QR কোডটি অবৈধ বা মেয়াদোত্তীর্ণ।</div>
        <a href="{{ route('student.dashboard') }}" class="btn btn-outline mt-2">ড্যাশবোর্ডে ফিরুন</a>
      @endif
    </div>
  </div>
</section>
@endsection
