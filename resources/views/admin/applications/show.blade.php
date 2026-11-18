@extends('layouts.admin')
@section('title', 'আবেদন ' . $application->application_no)

@section('content')
<div class="card" style="max-width:820px">
  <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
    <h2 style="font-size:22px;font-weight:700;margin:0">{{ $application->application_no }}</h2>
    <span class="badge badge-{{ $application->status }}">{{ $application->status }}</span>
  </div>

  <table class="mt-3" style="font-size:14px">
    <tr><td class="muted" style="padding:5px 0;width:170px">আবেদনকারী</td><td>{{ $application->full_name }}</td></tr>
    <tr><td class="muted" style="padding:5px 0">মোবাইল</td><td>{{ $application->mobile }}</td></tr>
    <tr><td class="muted" style="padding:5px 0">ইমেইল</td><td>{{ $application->email }}</td></tr>
    <tr><td class="muted" style="padding:5px 0">NID</td><td>{{ $application->nid }}</td></tr>
    <tr><td class="muted" style="padding:5px 0">জেলা / উপজেলা</td><td>{{ $application->district }} / {{ $application->thana }}</td></tr>
    <tr><td class="muted" style="padding:5px 0">কোর্স</td><td>{{ $application->course->name_bn ?? '—' }}</td></tr>
    <tr><td class="muted" style="padding:5px 0">ব্যাচ</td><td>{{ $application->batch->name_bn ?? '—' }}</td></tr>
    <tr><td class="muted" style="padding:5px 0">ব্যাংক</td><td>{{ $application->bank_name }} · {{ $application->bank_account }} · {{ $application->bank_branch }}</td></tr>
    <tr><td class="muted" style="padding:5px 0">জমা দেওয়ার তারিখ</td><td>{{ $application->created_at->format('d M Y, h:i A') }}</td></tr>
    @if ($application->reviewed_at)
      <tr><td class="muted" style="padding:5px 0">যাচাই করেছেন</td><td>{{ $application->reviewer?->name ?? '—' }} · {{ $application->reviewed_at->format('d M Y') }}</td></tr>
    @endif
  </table>

  <hr class="hr">

  <form method="POST" action="{{ route('admin.applications.status', $application) }}">
    @csrf
    <h3 style="font-size:16px;font-weight:700;margin-bottom:10px">স্ট্যাটাস পরিবর্তন</h3>
    <div class="form-grid two">
      <div class="field">
        <label>নতুন স্ট্যাটাস</label>
        <select name="status" required>
          @foreach (['pending' => 'অপেক্ষমাণ', 'verified' => 'যাচাইকৃত', 'approved' => 'অনুমোদিত', 'cancelled' => 'বাতিল', 'waitlist' => 'অপেক্ষমাণ তালিকা'] as $val => $label)
            <option value="{{ $val }}" @selected($application->status === $val)>{{ $label }} ({{ $val }})</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label>বাতিলের কারণ (যদি বাতিল হয়)</label>
        <input name="rejection_reason" value="{{ old('rejection_reason', $application->rejection_reason) }}">
      </div>
    </div>
    <div class="admin-actions">
      <button class="btn btn-primary" type="submit">আপডেট করুন</button>
      <a href="{{ route('admin.applications.index') }}" class="btn btn-outline">ফিরে যান</a>
    </div>
  </form>
</div>
@endsection
