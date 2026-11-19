<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<style>
  @page { size: A4 landscape; margin: 8mm; }
  * { box-sizing: border-box; }
  body {
    font-family: 'Hind', DejaVu Sans, sans-serif;
    color: #12202f;
    margin: 0;
    padding: 0;
  }
  .cert {
    position: relative;
    border: 10px solid #0a7a4b;
    padding: 22px 34px 18px;
    background: #fff;
    min-height: 176mm;
  }
  .inner {
    border: 2px solid #c9a227;
    padding: 18px 22px 14px;
    min-height: 160mm;
  }
  .logos { text-align: center; margin-bottom: 6px; }
  .logos img { height: 58px; width: auto; margin: 0 10px; }
  .institute {
    text-align: center;
    font-size: 17px;
    font-weight: bold;
    color: #0a7a4b;
    line-height: 1.35;
  }
  .institute small {
    display: block;
    font-size: 10px;
    color: #5a6b7d;
    font-weight: normal;
    margin-top: 3px;
  }
  .ribbon {
    text-align: center;
    font-size: 11px;
    letter-spacing: 3px;
    color: #c8202f;
    font-weight: bold;
    text-transform: uppercase;
    margin: 14px 0 4px;
  }
  h1 {
    text-align: center;
    font-size: 30px;
    margin: 0 0 4px;
    color: #12202f;
    line-height: 1.2;
  }
  .sub {
    text-align: center;
    color: #5a6b7d;
    font-size: 12px;
    margin-bottom: 14px;
  }
  .body {
    text-align: center;
    font-size: 13px;
    line-height: 1.75;
  }
  .name {
    font-size: 26px;
    font-weight: bold;
    color: #0a7a4b;
    border-bottom: 2px solid #c9a227;
    display: inline-block;
    padding: 0 16px 3px;
    margin: 4px 0 8px;
  }
  .course {
    font-size: 16px;
    font-weight: bold;
    margin: 4px 0;
    color: #12202f;
  }
  table.meta {
    width: 100%;
    margin-top: 24px;
    font-size: 11px;
    border-collapse: collapse;
  }
  table.meta td {
    text-align: center;
    width: 33%;
    vertical-align: top;
  }
  .label {
    color: #5a6b7d;
    font-size: 9px;
    letter-spacing: 1px;
    text-transform: uppercase;
  }
  .value {
    font-weight: bold;
    margin-top: 3px;
    color: #12202f;
  }
  table.sig {
    width: 100%;
    margin-top: 28px;
    font-size: 11px;
    border-collapse: collapse;
  }
  table.sig td {
    text-align: center;
    width: 33%;
    padding-top: 10px;
  }
  .sigline {
    border-top: 1px solid #12202f;
    margin: 0 18px;
    padding-top: 5px;
  }
  .qr {
    text-align: center;
    margin-top: 12px;
  }
  .qr img {
    width: 72px;
    height: 72px;
  }
  .verify {
    text-align: center;
    font-size: 8.5px;
    color: #5a6b7d;
    margin-top: 3px;
  }
</style>
</head>
<body>
<div class="cert">
  <div class="inner">
    <div class="logos">
      <img src="{{ $logo1 }}" alt="Suchana">
      <img src="{{ $logo2 }}" alt="SFDB">
    </div>

    <div class="institute">
      সুচনা মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট
      <small>Suchana Medical &amp; Technical Training Institute (SMTTI) · www.suchana.org</small>
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
        <td>
          <div class="label">Certificate No.</div>
          <div class="value">{{ $certificate->certificate_no }}</div>
        </td>
        <td>
          <div class="label">Issue Date</div>
          <div class="value">{{ $certificate->issued_at?->format('d M Y') }}</div>
        </td>
        <td>
          <div class="label">Verification Code</div>
          <div class="value">{{ $certificate->verification_code }}</div>
        </td>
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
</div>
</body>
</html>
