<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<style>
  @page { size: A4 landscape; margin: 10mm; }
  * { box-sizing: border-box; }
  body { font-family: 'Hind', sans-serif; color: #12202f; margin: 0; padding: 0; }
  .cert { border: 8px solid #1f6fd6; padding: 20px 30px 16px; }
  .logos { text-align: center; margin-bottom: 4px; }
  .logos img { height: 50px; margin: 0 8px; }
  .institute { text-align: center; font-size: 16px; font-weight: bold; color: #1f6fd6; }
  .institute small { display: block; font-size: 9.5px; color: #5a6b7d; font-weight: normal; margin-top: 2px; }
  .ribbon { text-align: center; font-size: 10px; letter-spacing: 3px; color: #c8202f; font-weight: bold; margin: 12px 0 2px; }
  h1 { text-align: center; font-size: 30px; margin: 0 0 2px; color: #12202f; }
  .sub { text-align: center; color: #5a6b7d; font-size: 11px; margin-bottom: 12px; }
  .body { text-align: center; font-size: 12px; line-height: 1.7; }
  .name { font-size: 24px; font-weight: bold; color: #1f6fd6; border-bottom: 2px solid #c9a227; display: inline-block; padding: 0 14px 2px; }
  .course { font-size: 15px; font-weight: bold; margin: 3px 0; }
  table.meta { width: 100%; margin-top: 22px; font-size: 10.5px; border-collapse: collapse; }
  table.meta td { text-align: center; width: 33%; }
  .label { color: #5a6b7d; font-size: 8.5px; letter-spacing: 1px; }
  .value { font-weight: bold; margin-top: 2px; }
  table.sig { width: 100%; margin-top: 26px; font-size: 10.5px; border-collapse: collapse; }
  table.sig td { text-align: center; width: 33%; padding-top: 14px; }
  .sigline { border-top: 1px solid #12202f; margin: 0 16px; padding-top: 4px; }
  .qr { text-align: center; margin-top: 10px; }
  .qr img { width: 78px; height: 78px; }
  .verify { text-align: center; font-size: 8.5px; color: #5a6b7d; margin-top: 2px; }
</style>
</head>
<body>
<div class="cert">
  <div class="logos">
    <img src="{{ $logo1 }}" alt="Suchana">
    <img src="{{ $logo2 }}" alt="SFDB">
  </div>
  <div class="institute">
    সুচনা মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট
    <small>Suchana Medical &amp; Technical Training Institute (SMTTI)</small>
  </div>
  <div class="ribbon">CERTIFICATE OF COMPLETION</div>
  <h1>সার্টিফিকেট অব কমপ্লিশন</h1>
  <div class="sub">This is to certify that</div>
  <div class="body">
    <div class="name">{{ $certificate->user?->name }}</div>
    <p>successfully completed the course</p>
    <div class="course">{{ $certificate->course?->name_bn }}</div>
    <p>under the government-funded skills training programme.</p>
  </div>

  <table class="meta">
    <tr>
      <td><div class="label">CERTIFICATE NO.</div><div class="value">{{ $certificate->certificate_no }}</div></td>
      <td><div class="label">ISSUE DATE</div><div class="value">{{ $certificate->issued_at?->format('d M Y') }}</div></td>
      <td><div class="label">VERIFICATION CODE</div><div class="value">{{ $certificate->verification_code }}</div></td>
    </tr>
  </table>

  <table class="sig">
    <tr>
      <td><div class="sigline">প্রশিক্ষক / Instructor</div></td>
      <td><div class="sigline">পরিচালক / Director</div></td>
      <td><div class="sigline">চেয়ারম্যান / Chairman</div></td>
    </tr>
  </table>

  <div class="qr">
    <img src="{{ $qr }}" alt="Verify QR">
    <div class="verify">{{ $verifyUrl }}</div>
  </div>
</div>
</body>
</html>
