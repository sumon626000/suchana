<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>সার্টিফিকেট — {{ $certificate->certificate_no }}</title>
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:'Hind Siliguri',system-ui,sans-serif;background:#eef2f5;color:#12202f;padding:24px}
  .actions{max-width:900px;margin:0 auto 16px;display:flex;flex-wrap:wrap;gap:10px;justify-content:flex-end}
  .btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:10px 20px;border-radius:999px;font-weight:600;font-size:14px;background:#0a7a4b;color:#fff;border:0;cursor:pointer;text-decoration:none;line-height:1.2}
  .btn-outline{background:#fff;color:#12202f;border:1.5px solid #e2e8f0}
  @media (max-width:640px){
    body{padding:14px}
    .actions{justify-content:center}
    .btn{flex:1 1 auto;min-width:108px;padding:10px 14px;font-size:13px}
  }
  .cert{max-width:900px;margin:0 auto;background:#fff;border:10px solid #0a7a4b;border-radius:8px;padding:44px 48px;position:relative;box-shadow:0 20px 60px -25px rgba(0,0,0,.35)}
  .cert::after{content:'';position:absolute;inset:8px;border:2px solid #c9a227;border-radius:4px;pointer-events:none}
  .logos{display:flex;align-items:center;justify-content:center;gap:16px;margin-bottom:10px}
  .logos img{height:64px;width:auto}
  .institute{text-align:center;font-size:19px;font-weight:700;color:#0a7a4b;line-height:1.3}
  .institute small{display:block;font-size:12px;color:#5a6b7d;font-weight:500;margin-top:2px}
  .ribbon{text-align:center;margin:22px 0 6px;font-size:13px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:#c8202f}
  h1{text-align:center;font-size:38px;line-height:1.15;margin-bottom:6px;color:#12202f}
  .sub{text-align:center;color:#5a6b7d;font-size:14px;margin-bottom:26px}
  .body{text-align:center;font-size:16px;line-height:1.9}
  .name{font-size:34px;font-weight:700;color:#0a7a4b;margin:8px 0;border-bottom:2px solid #c9a227;display:inline-block;padding:0 18px 4px}
  .course{font-size:20px;font-weight:700;margin:6px 0;color:#12202f}
  .meta{display:flex;justify-content:space-between;gap:20px;margin-top:44px;font-size:13px}
  .meta div{flex:1;text-align:center}
  .meta .label{color:#5a6b7d;font-size:11px;text-transform:uppercase;letter-spacing:.08em}
  .meta .value{font-weight:700;margin-top:2px}
  .sig{border-top:1px solid #12202f;padding-top:6px;text-align:center;margin-top:4px}
  .verify{margin-top:30px;text-align:center;font-size:12px;color:#5a6b7d}
  .verify code{background:#e8f3ee;padding:2px 8px;border-radius:6px;color:#0a7a4b;font-weight:700}
  @media print{
    body{background:#fff;padding:0}
    .actions{display:none}
    .cert{border-width:8px;box-shadow:none;margin:0;max-width:none;width:100%;border-radius:0}
    @page{size:A4 landscape;margin:10mm}
  }
</style>
</head>
<body>
<div class="actions">
  <a class="btn" href="{{ route('certificate.pdf', $certificate->certificate_no) }}" target="_blank">PDF ডাউনলোড</a>
  <button class="btn btn-outline" onclick="window.print()">প্রিন্ট</button>
  <a class="btn btn-outline" href="{{ route('verify.code', $certificate->certificate_no) }}">যাচাই করুন</a>
</div>

@if ($certificate->hasUploadedPdf())
<div style="max-width:900px;margin:0 auto 16px">
  <iframe src="{{ route('certificate.pdf', $certificate->certificate_no) }}" title="Certificate PDF" style="width:100%;min-height:80vh;border:1px solid #d7dee7;border-radius:12px;background:#fff"></iframe>
  <p style="text-align:center;margin-top:10px;font-size:13px;color:#5a6b7d">NSDA আপলোডেড সার্টিফিকেট · Verify: <code>{{ $certificate->verification_code }}</code></p>
</div>
@else
<div class="cert">
  <div class="logos">
    <img src="/images/logo-suchana.jpg" alt="Suchana">
    <img src="/images/logo-sfdb.jpg" alt="SFDB">
  </div>
  <div class="institute">
    সুচনা মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট
    <small>Suchana Medical &amp; Technical Training Institute (SMTTI) · www.suchana.org</small>
  </div>

  <div class="ribbon">Certificate of Completion</div>
  <h1>সার্টিফিকেট অব কমপ্লিশন</h1>
  <p class="sub">This is to certify that</p>

  <div class="body">
    <div class="name">{{ $certificate->user->name ?? $certificate->user?->name }}</div>
    <p>successfully completed the course</p>
    <div class="course">{{ $certificate->course->name_bn ?? $certificate->course?->name_bn }}</div>
    <p>under the government-funded skills training programme.</p>
  </div>

  <div class="meta">
    <div>
      <div class="label">Certificate No.</div>
      <div class="value">{{ $certificate->certificate_no }}</div>
    </div>
    <div>
      <div class="label">Issue Date</div>
      <div class="value">{{ $certificate->issued_at?->format('d M Y') }}</div>
    </div>
    <div>
      <div class="label">Verification Code</div>
      <div class="value">{{ $certificate->verification_code }}</div>
    </div>
  </div>

  <div class="meta" style="margin-top:36px">
    <div>
      <div class="sig">প্রশিক্ষক / Instructor</div>
    </div>
    <div>
      <div class="sig">পরিচালক / Director</div>
    </div>
    <div>
      <div class="sig">চেয়ারম্যান / Chairman</div>
    </div>
  </div>

  <div class="verify">
    Verify at <code>{{ url('/verify') }}</code> using code <code>{{ $certificate->verification_code }}</code>
  </div>
  <div style="text-align:center;margin-top:8px">
    <img src="{{ $qr }}" alt="Verify QR" style="width:86px;height:86px;border:1px solid #e2e8f0;border-radius:8px;padding:3px;background:#fff">
  </div>
</div>
@endif
</body>
</html>
