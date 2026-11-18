@extends('layouts.public')
@section('title', $course->name_bn . ' — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <a href="{{ route('courses.index') }}" class="muted" data-bn="← সব কোর্স" data-en="← All Courses">← সব কোর্স</a>

    <div class="grid-2 mt-3">
      <div>
        <div class="course-photo" style="border-radius:var(--radius);overflow:hidden">
          <img src="{{ $course->image }}" alt="{{ $course->name_bn }}" referrerpolicy="no-referrer" style="width:100%;height:100%;object-fit:cover">
        </div>
      </div>
      <div>
        <div class="kicker"><span class="kicker-num">{{ $course->level }}</span></div>
        <h1 class="section-title" data-bn="{{ $course->name_bn }}" data-en="{{ $course->name_en }}">{{ $course->name_bn }}</h1>
        <p class="section-lead" data-bn="{{ $course->description_bn }}" data-en="{{ $course->description_en }}">{{ $course->description_bn }}</p>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
          <div class="branch-card">
            <div class="muted" style="font-size:12px" data-bn="মেয়াদ" data-en="Duration">মেয়াদ</div>
            <div style="font-weight:700" data-bn="{{ $course->duration_bn }}" data-en="{{ $course->duration_en }}">{{ $course->duration_bn }}</div>
          </div>
          <div class="branch-card">
            <div class="muted" style="font-size:12px" data-bn="আসন" data-en="Seats">আসন</div>
            <div style="font-weight:700">{{ $course->seats_available }} / {{ $course->seats_total }}</div>
          </div>
          <div class="branch-card">
            <div class="muted" style="font-size:12px" data-bn="কোর্স ফি" data-en="Course Fee">কোর্স ফি</div>
            <div style="font-weight:700">৳{{ number_format($course->fee) }}</div>
          </div>
          <div class="branch-card">
            <div class="muted" style="font-size:12px" data-bn="উপবৃত্তি" data-en="Stipend">উপবৃত্তি</div>
            <div style="font-weight:700">৳{{ number_format($course->stipend_male) }} – ৳{{ number_format($course->stipend_female) }}</div>
          </div>
        </div>

        <div class="mt-3">
          <strong data-bn="যোগ্যতা" data-en="Eligibility">যোগ্যতা</strong>
          <p class="muted" data-bn="{{ $course->eligibility_bn }}" data-en="{{ $course->eligibility_en }}">{{ $course->eligibility_bn }}</p>
        </div>

        @if ($course->application_deadline)
          <p class="mt-2"><strong data-bn="আবেদনের শেষ তারিখ:" data-en="Application Deadline:">আবেদনের শেষ তারিখ:</strong> {{ $course->application_deadline->format('d M Y') }}</p>
        @endif

        <div class="mt-3">
          <a href="{{ url('/apply?course=' . $course->id) }}" class="btn btn-primary btn-lg" data-bn="এই কোর্সে আবেদন করুন" data-en="Apply for this Course">এই কোর্সে আবেদন করুন</a>
        </div>
      </div>
    </div>

    @if ($course->batches->count())
      <hr class="hr">
      <h2 class="section-title" style="font-size:26px" data-bn="ব্যাচ সময়সূচি" data-en="Batch Schedule">ব্যাচ সময়সূচি</h2>
      <div class="mt-2">
        @foreach ($course->batches as $batch)
          <div class="notice-card" style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap">
            <strong data-bn="{{ $batch->name_bn }}" data-en="{{ $batch->name_en }}">{{ $batch->name_bn }}</strong>
            <span class="muted" data-bn="{{ $batch->time_bn }}" data-en="{{ $batch->time_en }}">{{ $batch->time_bn }}</span>
            <span class="muted" data-bn="আসন: {{ $batch->seats }}" data-en="Seats: {{ $batch->seats }}">আসন: {{ $batch->seats }}</span>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection
