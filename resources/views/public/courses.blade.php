@extends('layouts.public')
@section('title', 'কোর্সসমূহ — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <div class="kicker"><span class="kicker-num">০১</span> — <span data-bn="কোর্স" data-en="Courses">কোর্স</span></div>
    <h2 class="section-title" data-bn="আমাদের কোর্সসমূহ" data-en="Our Courses">আমাদের কোর্সসমূহ</h2>
    <p class="section-lead" data-bn="সরকারি অর্থায়নে বিনামূল্যে প্রশিক্ষণ — প্রতিটি কোর্সের বিস্তারিত দেখুন।" data-en="Free government-funded training — view details of each course.">সরকারি অর্থায়নে বিনামূল্যে প্রশিক্ষণ — প্রতিটি কোর্সের বিস্তারিত দেখুন।</p>

    <div class="courses-grid">
      @foreach ($courses as $course)
        <a href="{{ route('courses.show', $course) }}" class="course-card">
          <div class="course-photo"><img src="{{ $course->imageUrl() }}" alt="{{ $course->name_bn }}" loading="lazy" referrerpolicy="no-referrer"></div>
          <div class="course-body">
            <h3 class="course-title" data-bn="{{ $course->name_bn }}" data-en="{{ $course->name_en }}">{{ $course->name_bn }}</h3>
            <div class="course-chips">
              <span class="chip">{{ $course->level }}</span>
              <span class="chip chip-green" data-bn="{{ $course->duration_bn }}" data-en="{{ $course->duration_en }}">{{ $course->duration_bn }}</span>
            </div>
            <div class="course-meta" data-bn="আসন {{ $course->seats_available }}/{{ $course->seats_total }}" data-en="Seats {{ $course->seats_available }}/{{ $course->seats_total }}">আসন {{ $course->seats_available }}/{{ $course->seats_total }}</div>
            <span class="course-details" data-bn="বিস্তারিত দেখুন →" data-en="View Details →">বিস্তারিত দেখুন →</span>
          </div>
        </a>
      @endforeach
    </div>
  </div>
</section>
@endsection
