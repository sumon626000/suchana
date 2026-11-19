@extends('layouts.public')
@section('title', 'ভর্তি আবেদন — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <div class="form-card">
      <div class="kicker"><span class="kicker-num">আবেদন</span></div>
      <h1 class="section-title" style="font-size:30px" data-bn="ভর্তির আবেদন" data-en="Admission Application">ভর্তির আবেদন</h1>
      <p class="muted" data-bn="সব তথ্য সঠিকভাবে পূরণ করুন। জমা দেওয়ার পর একটি ইউনিক আবেদন নম্বর পাবেন।" data-en="Fill in all fields correctly. You will receive a unique application number after submission.">সব তথ্য সঠিকভাবে পূরণ করুন। জমা দেওয়ার পরে একটি ইউনিক আবেদন নম্বর পাবেন।</p>

      <form method="POST" action="{{ route('applications.store') }}" class="mt-3">
        @csrf

        <h3 class="form-step-title" style="font-size:17px;font-weight:700;margin-bottom:12px" data-bn="১. কোর্স ও ব্যাচ" data-en="1. Course & Batch">১. কোর্স ও ব্যাচ</h3>
        <div class="field">
          <label data-bn="কোর্স" data-en="Course">কোর্স <span class="req">*</span></label>
          <select name="course_id" required>
            <option value="">নির্বাচন করুন</option>
            @foreach ($courses as $course)
              <option value="{{ $course->id }}" @selected(old('course_id', $selectedCourse) == $course->id)>{{ $course->name_bn }}</option>
            @endforeach
          </select>
        </div>
        <div class="field">
          <label data-bn="পছন্দের ব্যাচ (ঐচ্ছিক)" data-en="Preferred Batch (optional)">পছন্দের ব্যাচ (ঐচ্ছিক)</label>
          <select name="batch_id">
            <option value="">নির্বাচন করুন</option>
            @foreach ($batches as $batch)
              <option value="{{ $batch->id }}" @selected(old('batch_id') == $batch->id)>{{ $batch->course?->name_bn }} — {{ $batch->name_bn }}</option>
            @endforeach
          </select>
        </div>

        <h3 class="form-step-title" style="font-size:17px;font-weight:700;margin:18px 0 12px" data-bn="২. ব্যক্তিগত তথ্য" data-en="2. Personal Information">২. ব্যক্তিগত তথ্য</h3>
        <div class="field">
          <label data-bn="পূর্ণ নাম (NID অনুযায়ী)" data-en="Full Name (as per NID)">পূর্ণ নাম (NID অনুযায়ী) <span class="req">*</span></label>
          <input name="full_name" value="{{ old('full_name', auth()->user()->name) }}" required>
        </div>
        <div class="field">
          <label data-bn="জাতীয় পরিচয়পত্র (NID) নম্বর" data-en="NID Number">জাতীয় পরিচয়পত্র (NID) নম্বর <span class="req">*</span></label>
          <input name="nid" value="{{ old('nid') }}" required>
        </div>
        <div class="field">
          <label data-bn="মোবাইল নম্বর" data-en="Mobile Number">মোবাইল নম্বর <span class="req">*</span></label>
          <input name="mobile" value="{{ old('mobile', auth()->user()->mobile) }}" required inputmode="numeric" placeholder="01XXXXXXXXX">
        </div>
        <div class="field">
          <label data-bn="জিমেইল" data-en="Gmail">জিমেইল <span class="req">*</span></label>
          <input name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <h3 class="form-step-title" style="font-size:17px;font-weight:700;margin:18px 0 12px" data-bn="৩. ঠিকানা" data-en="3. Address">৩. ঠিকানা</h3>
        <div class="field">
          <label data-bn="জেলা" data-en="District">জেলা <span class="req">*</span></label>
          <select name="district" required>
            <option value="">নির্বাচন করুন</option>
            @foreach ($districts as $d)
              <option value="{{ $d->name_bn }}" @selected(old('district') === $d->name_bn)>{{ $d->name_bn }} ({{ $d->name_en }})</option>
            @endforeach
          </select>
        </div>
        <div class="field">
          <label data-bn="উপজেলা / থানা" data-en="Upazila / Thana">উপজেলা / থানা <span class="req">*</span></label>
          <select name="thana" id="thanaSelect" data-old="{{ old('thana') }}" required>
            <option value="">প্রথমে জেলা নির্বাচন করুন</option>
          </select>
        </div>

        <h3 class="form-step-title" style="font-size:17px;font-weight:700;margin:18px 0 12px" data-bn="৪. ব্যাংক তথ্য" data-en="4. Bank Information">৪. ব্যাংক তথ্য</h3>
        <div class="field">
          <label data-bn="ব্যাংকের নাম" data-en="Bank Name">ব্যাংকের নাম <span class="req">*</span></label>
          <input name="bank_name" value="{{ old('bank_name') }}" required>
        </div>
        <div class="field">
          <label data-bn="অ্যাকাউন্ট নম্বর" data-en="Account Number">অ্যাকাউন্ট নম্বর <span class="req">*</span></label>
          <input name="bank_account" value="{{ old('bank_account') }}" required>
        </div>
        <div class="field">
          <label data-bn="শাখা" data-en="Branch">শাখা <span class="req">*</span></label>
          <input name="bank_branch" value="{{ old('bank_branch') }}" required>
        </div>

        <div class="field" style="display:flex;gap:10px;align-items:flex-start;margin-top:8px">
          <input type="checkbox" name="consent" value="1" id="consent" style="width:18px;height:18px;margin-top:4px" @checked(old('consent')) required>
          <label for="consent" style="margin:0;font-weight:500" data-bn="আমি নিশ্চিত করছি যে উপরের সব তথ্য সত্য এবং শর্তাবলীতে সম্মত আছি।" data-en="I confirm all information above is true and I agree to the terms.">আমি নিশ্চিত করছি যে উপরের সব তথ্য সত্য এবং শর্তাবলীতে সম্মত আছি।</label>
        </div>

        <div class="form-actions">
          <button class="btn btn-primary btn-lg" type="submit" data-bn="আবেদন জমা দিন" data-en="Submit Application">আবেদন জমা দিন</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
  var map = @json($thanasByDistrict);
  var dSel = document.querySelector('select[name="district"]');
  var tSel = document.getElementById('thanaSelect');
  if (!dSel || !tSel) return;

  function rebuild(preserve) {
    var list = map[dSel.value] || [];
    tSel.innerHTML = '<option value="">নির্বাচন করুন</option>' + list.map(function (n) {
      return '<option value="' + n + '">' + n + '</option>';
    }).join('');
    if (preserve) tSel.value = preserve;
  }

  dSel.addEventListener('change', function () { rebuild(''); });
  rebuild(tSel.getAttribute('data-old') || '');
})();
</script>
@endpush
