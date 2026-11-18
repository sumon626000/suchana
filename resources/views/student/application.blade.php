@extends('layouts.public')
@section('title', 'আবেদন নম্বর ' . $application->application_no . ' — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <div class="form-card" style="max-width:720px">
      <div class="kicker"><span class="kicker-num">আবেদন নম্বর</span></div>
      <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
        <h1 class="section-title" style="font-size:26px;margin:0">{{ $application->application_no }}</h1>
        <span class="badge badge-{{ $application->status }}">{{ $application->status }}</span>
      </div>

      <table class="mt-3" style="font-size:14px">
        <tr><td class="muted" style="padding:6px 0">আবেদনকারী</td><td>{{ $application->full_name }}</td></tr>
        <tr><td class="muted" style="padding:6px 0">কোর্স</td><td>{{ $application->course->name_bn }}</td></tr>
        @if ($application->batch)
          <tr><td class="muted" style="padding:6px 0">ব্যাচ</td><td>{{ $application->batch->name_bn }}</td></tr>
        @endif
        <tr><td class="muted" style="padding:6px 0">মোবাইল</td><td>{{ $application->mobile }}</td></tr>
        <tr><td class="muted" style="padding:6px 0">জমা দেওয়ার তারিখ</td><td>{{ $application->created_at->format('d M Y, h:i A') }}</td></tr>
        <tr><td class="muted" style="padding:6px 0">বর্তমান অবস্থা</td><td><span class="badge badge-{{ $application->status }}">{{ $application->status }}</span></td></tr>
      </table>

      @if ($application->status === 'pending')
        <div class="alert alert-success mt-3">আপনার আবেদন যাচাইয়ের অপেক্ষায় আছে। ৭–১৪ কর্মদিবসের মধ্যে SMS/ফোনে যোগাযোগ করা হবে।</div>
      @elseif ($application->status === 'verified')
        <div class="alert alert-success mt-3">আপনার আবেদন যাচাই হয়েছে। interview / পরীক্ষার জন্য অপেক্ষা করুন।</div>
      @elseif ($application->status === 'approved')
        <div class="alert alert-success mt-3">অভিনন্দন! আপনার আবেদন অনুমোদিত হয়েছে। ক্লাসের সময়সূচি অনুযায়ী প্রস্তুত হোন।</div>
      @elseif ($application->status === 'cancelled')
        <div class="alert alert-error mt-3">আপনার আবেদন বাতিল হয়েছে। {{ $application->rejection_reason }}</div>
      @endif

      <div class="mt-3">
        <a href="{{ route('student.dashboard') }}" class="btn btn-outline" data-bn="ড্যাশবোর্ডে ফিরুন" data-en="Back to Dashboard">ড্যাশবোর্ডে ফিরুন</a>
      </div>
    </div>
  </div>
</section>
@endsection
