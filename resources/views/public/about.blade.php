@extends('layouts.public')
@section('title', 'আমাদের সম্পর্কে — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <div class="kicker"><span class="kicker-num">০৪</span> — <span data-bn="আমাদের সম্পর্কে" data-en="About Us">আমাদের সম্পর্কে</span></div>
    <h2 class="section-title" data-bn="আমাদের সম্পর্কে" data-en="About Us">আমাদের সম্পর্কে</h2>

    <div class="grid-2">
      <div>
        <p data-bn="{{ $site['about_bn'] }}" data-en="{{ $site['about_en'] }}">{{ $site['about_bn'] }}</p>
        <p class="mt-2" data-bn="আমরা NSDA অনুমোদিত সনদ প্রদান করি এবং প্রশিক্ষণ শেষে চাকরির সুযোগ ও ক্যারিয়ার সহায়তা দিয়ে থাকি।" data-en="We provide NSDA-approved certificates and offer job opportunities and career support after training.">আমরা NSDA অনুমোদিত সনদ প্রদান করি এবং প্রশিক্ষণ শেষে চাকরির সুযোগ ও ক্যারিয়ার সহায়তা দিয়ে থাকি।</p>
      </div>
      <div class="branch-card">
        <div class="branch-name" data-bn="আমাদের উদ্দেশ্য" data-en="Our Objectives">আমাদের উদ্দেশ্য</div>
        <ul class="check-list" style="font-size:14px">
          <li data-bn="সরকারি অর্থায়নে বিনামূল্যে দক্ষতা প্রশিক্ষণ" data-en="Free skills training under government funding">সরকারি অর্থায়নে বিনামূল্যে দক্ষতা প্রশিক্ষণ</li>
          <li data-bn="NSDA অনুমোদিত জাতীয় সনদ" data-en="NSDA-approved national certificate">NSDA অনুমোদিত জাতীয় সনদ</li>
          <li data-bn="অভিজ্ঞ প্রশিক্ষক ও আধুনিক ল্যাব" data-en="Experienced trainers and modern labs">অভিজ্ঞ প্রশিক্ষক ও আধুনিক ল্যাব</li>
          <li data-bn="চাকরির সুযোগ ও ক্যারিয়ার সহায়তা" data-en="Job opportunities and career support">চাকরির সুযোগ ও ক্যারিয়ার সহায়তা</li>
        </ul>
      </div>
    </div>

    <hr class="hr">
    <h2 class="section-title" style="font-size:28px" data-bn="কর্তৃপক্ষ ও কর্মকর্তাবৃন্দ" data-en="Authority & Officers">কর্তৃপক্ষ ও কর্মকর্তাবৃন্দ</h2>
    <div class="staff-grid mt-3">
      @foreach ($staff as $person)
        @php
          $staffPhoto = $person->photo ? (str_starts_with($person->photo, 'http') ? $person->photo : asset('storage/'.$person->photo)) : null;
        @endphp
        <div class="staff-card">
          <div class="staff-photo">
            @if ($staffPhoto)
              <img src="{{ $staffPhoto }}" alt="{{ $person->name }}" loading="lazy">
            @else
              {{ mb_substr($person->name, 0, 1) }}
            @endif
          </div>
          <div class="staff-name">{{ $person->name }}</div>
          <div class="staff-role">{{ $person->designation }}</div>
          @if ($person->bio)
            <div class="staff-bio">{{ \Illuminate\Support\Str::limit($person->bio, 70) }}</div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
