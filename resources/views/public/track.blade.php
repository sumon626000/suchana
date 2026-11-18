@extends('layouts.public')
@section('title', 'আবেদন ট্র্যাকিং — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <div class="form-card" style="max-width:620px">
      <h1 class="section-title" style="font-size:30px" data-bn="আবেদন ট্র্যাকিং" data-en="Application Tracking">আবেদন ট্র্যাকিং</h1>
      <p class="muted" data-bn="আপনার আবেদন নম্বর দিয়ে বর্তমান অবস্থা দেখুন।" data-en="Check the current status with your application number.">আপনার আবেদন নম্বর দিয়ে বর্তমান অবস্থা দেখুন।</p>

      <form method="POST" action="{{ route('track.post') }}" class="mt-3">
        @csrf
        <div class="field">
          <label data-bn="আবেদন নম্বর" data-en="Application Number">আবেদন নম্বর <span class="req">*</span></label>
          <input name="application_no" value="{{ request('application_no') }}" placeholder="SMTTI-2026-00001" required>
        </div>
        <div class="form-actions">
          <button class="btn btn-primary" type="submit" data-bn="খুঁজুন" data-en="Search">খুঁজুন</button>
        </div>
      </form>

      @if ($searched)
        @if ($application)
          <div class="notice-card mt-3">
            <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
              <strong>{{ $application->application_no }}</strong>
              <span class="badge badge-{{ $application->status }}">{{ $application->status }}</span>
            </div>
            <table class="mt-2" style="font-size:14px">
              <tr><td class="muted" style="padding:4px 0">আবেদনকারী</td><td>{{ $application->full_name }}</td></tr>
              <tr><td class="muted" style="padding:4px 0">কোর্স</td><td>{{ $application->course->name_bn }}</td></tr>
              <tr><td class="muted" style="padding:4px 0">জমা দেওয়ার তারিখ</td><td>{{ $application->created_at->format('d M Y') }}</td></tr>
            </table>
          </div>
        @else
          <div class="alert alert-error mt-3" data-bn="এই আবেদন নম্বরে কোনো আবেদন পাওয়া যায়নি।" data-en="No application found with this number.">এই আবেদন নম্বরে কোনো আবেদন পাওয়া যায়নি।</div>
        @endif
      @endif
    </div>
  </div>
</section>
@endsection
