@extends('layouts.public')
@section('title', 'সার্টিফিকেট যাচাই — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <div class="form-card" style="max-width:640px">
      <h1 class="section-title" style="font-size:28px" data-bn="সার্টিফিকেট যাচাই" data-en="Verify Certificate">সার্টিফিকেট যাচাই</h1>
      <p class="muted" data-bn="সার্টিফিকেট নম্বর বা যাচাই কোড দিয়ে যাচাই করুন।" data-en="Verify using the certificate number or verification code.">সার্টিফিকেট নম্বর বা যাচাই কোড দিয়ে যাচাই করুন।</p>

      <form method="POST" action="{{ route('verify.post') }}" class="mt-3">
        @csrf
        <div class="field">
          <label data-bn="সার্টিফিকেট নম্বর / কোড" data-en="Certificate No. / Code">সার্টিফিকেট নম্বর / কোড <span class="req">*</span></label>
          <input name="code" value="{{ request('code', $query ?? '') }}" placeholder="SUCHANA-CERT-2026-00001" required>
        </div>
        <div class="form-actions">
          <button class="btn btn-primary" type="submit" data-bn="যাচাই করুন" data-en="Verify">যাচাই করুন</button>
        </div>
      </form>

      @if ($searched)
        @if ($certificate)
          <div class="alert alert-success mt-3">
            <strong>✓ সার্টিফিকেটটি বৈধ।</strong><br>
            {{ $certificate->user->name ?? '—' }} — {{ $certificate->course->name_bn ?? '—' }}<br>
            নং: {{ $certificate->certificate_no }} · ইস্যু: {{ $certificate->issued_at?->format('d M Y') }}
          </div>
          <a href="{{ route('certificate.show', $certificate->certificate_no) }}" class="btn btn-outline mt-2" target="_blank">সার্টিফিকেট দেখুন</a>
        @else
          <div class="alert alert-error mt-3">এই কোডে কোনো সার্টিফিকেট পাওয়া যায়নি।</div>
        @endif
      @endif
    </div>
  </div>
</section>
@endsection
