@extends('layouts.public')
@section('title', 'শিক্ষার্থী ড্যাশবোর্ড — সুচনা SMTTI')

@section('content')
@php
  $circ = 2 * M_PI * 52;
  $offset = $circ * (1 - max(0, min(100, $attendanceRate)) / 100);
  $avatar = $user->photo ? (str_starts_with($user->photo, 'http') ? $user->photo : asset('storage/'.$user->photo)) : null;
@endphp
<section class="section">
  <div class="container">

    {{-- Hero --}}
    <div class="dash-hero reveal">
      <div class="dash-hero-left">
        <div class="dash-avatar">
          @if ($avatar)<img src="{{ $avatar }}" alt="{{ $user->name }}">@else{{ mb_substr($user->name, 0, 1) }}@endif
        </div>
        <div>
          <div class="dash-kicker" data-bn="শিক্ষার্থী প্যানেল" data-en="STUDENT PANEL">শিক্ষার্থী প্যানেল</div>
          <h1 data-bn="স্বাগতম, {{ $user->name }}" data-en="Welcome, {{ $user->name }}">স্বাগতম, {{ $user->name }}</h1>
          <p class="dash-sub">{{ '@'.$user->username }} <span class="dash-dot">·</span> <span class="dash-pill" data-bn="শিক্ষার্থী" data-en="Student">শিক্ষার্থী</span></p>
        </div>
      </div>
      <div class="dash-actions">
        <a href="{{ route('applications.create') }}" class="btn" data-bn="+ আবেদন" data-en="+ Apply">+ আবেদন</a>
        <a href="{{ url('/track') }}" class="btn" data-bn="ট্র্যাক" data-en="Track">ট্র্যাক</a>
        <a href="{{ route('student.profile') }}" class="btn" data-bn="প্রোফাইল" data-en="Profile">প্রোফাইল</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn" type="submit" data-bn="লগআউট" data-en="Logout">লগআউট</button>
        </form>
      </div>
    </div>

    {{-- KPI --}}
    <div class="dash-kpis mt-3">
      <div class="dash-card dash-kpi reveal">
        <div class="dash-kpi-icon">✓</div>
        <div class="dash-kpi-value">{{ $attendanceRate }}%</div>
        <div class="dash-kpi-label" data-bn="উপস্থিতি হার" data-en="Attendance Rate">উপস্থিতি হার</div>
        <div class="dash-kpi-note">{{ $attendanceSummary['present'] }} / {{ $attendanceSummary['total'] }}</div>
      </div>
      <div class="dash-card dash-kpi reveal">
        <div class="dash-kpi-icon">◈</div>
        <div class="dash-kpi-value">{{ $applications->count() }}</div>
        <div class="dash-kpi-label" data-bn="আবেদন" data-en="Applications">আবেদন</div>
        <div class="dash-kpi-note">
          <span class="dash-mini-chip">{{ $applicationsPending }} <span data-bn="অপেক্ষমাণ" data-en="pending">অপেক্ষমাণ</span></span>
          <span class="dash-mini-chip">{{ $applicationsApproved }} <span data-bn="অনুমোদিত" data-en="approved">অনুমোদিত</span></span>
        </div>
      </div>
      <div class="dash-card dash-kpi reveal">
        <div class="dash-kpi-icon">♛</div>
        <div class="dash-kpi-value">{{ $certificates->count() }}</div>
        <div class="dash-kpi-label" data-bn="সার্টিফিকেট" data-en="Certificates">সার্টিফিকেট</div>
        <div class="dash-kpi-note" data-bn="ডাউনলোড ও যাচাই করুন" data-en="Download & verify">ডাউনলোড ও যাচাই করুন</div>
      </div>
    </div>

    {{-- Profile + attendance --}}
    <div class="dash-grid mt-3">
      <div class="dash-card reveal">
        <div class="dash-card-head">
          <h2 data-bn="আমার প্রোফাইল" data-en="My Profile">আমার প্রোফাইল</h2>
          <a href="{{ route('student.profile') }}" class="btn btn-outline btn-xs" data-bn="এডিট" data-en="Edit">এডিট</a>
        </div>
        <div class="dash-profile">
          <div class="dash-profile-avatar">
            @if ($avatar)<img src="{{ $avatar }}" alt="">@else{{ mb_substr($user->name, 0, 1) }}@endif
          </div>
          <div class="dash-profile-info">
            <div class="dash-profile-name">{{ $user->name }}</div>
            <div class="dash-profile-role">{{ '@'.$user->username }} · #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
          </div>
        </div>
        <div class="dash-info">
          <div><span data-bn="মোবাইল" data-en="Mobile">মোবাইল</span><strong>{{ $user->mobile ?? '—' }}</strong></div>
          <div><span data-bn="ইমেইল" data-en="Email">ইমেইল</span><strong>{{ $user->email }}</strong></div>
          <div><span data-bn="যোগদান" data-en="Joined">যোগদান</span><strong>{{ $user->created_at?->format('d M Y') }}</strong></div>
          <div><span data-bn="স্ট্যাটাস" data-en="Status">স্ট্যাটাস</span><strong>{{ $user->is_active ? 'সক্রিয়' : 'নিষ্ক্রিয়' }}</strong></div>
        </div>
      </div>

      <div class="dash-card reveal">
        <div class="dash-card-head">
          <h2 data-bn="উপস্থিতি সারসংক্ষেপ" data-en="Attendance Summary">উপস্থিতি সারসংক্ষেপ</h2>
        </div>
        <div class="dash-attendance">
          <div class="dash-ring">
            <svg width="120" height="120" viewBox="0 0 120 120">
              <circle cx="60" cy="60" r="52" fill="none" stroke="var(--line)" stroke-width="10"/>
              <circle cx="60" cy="60" r="52" fill="none" stroke="var(--green)" stroke-width="10" stroke-linecap="round"
                      stroke-dasharray="{{ round($circ, 2) }}" stroke-dashoffset="{{ round($offset, 2) }}"/>
            </svg>
            <div class="dash-ring-label"><strong>{{ $attendanceRate }}%</strong><span data-bn="উপস্থিত" data-en="present">উপস্থিত</span></div>
          </div>
          <div class="dash-mini">
            <div><strong>{{ $attendanceSummary['present'] }}</strong><span data-bn="উপস্থিত" data-en="Present">উপস্থিত</span></div>
            <div><strong>{{ $attendanceSummary['absent'] }}</strong><span data-bn="অনুপস্থিত" data-en="Absent">অনুপস্থিত</span></div>
            <div><strong>{{ $attendanceSummary['total'] }}</strong><span data-bn="মোট" data-en="Total">মোট</span></div>
          </div>
        </div>
        @if ($courseAttendance->count())
          <div class="dash-bars">
            @foreach ($courseAttendance as $row)
              <div class="dash-bar-row">
                <div class="dash-bar-top"><span>{{ $row['course']->name_bn }}</span><span>{{ $row['present'] }}/{{ $row['total'] }}</span></div>
                <div class="dash-bar"><span style="width:{{ $row['rate'] }}%"></span></div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

    {{-- Applications --}}
    <div class="mt-4 reveal">
      <div class="dash-section-head">
        <div>
          <span class="kicker" data-bn="০১ — আবেদন" data-en="01 — APPLICATIONS">০১ — আবেদন</span>
          <h2 class="section-title" data-bn="আমার আবেদনসমূহ" data-en="My Applications">আমার আবেদনসমূহ</h2>
        </div>
        <a href="{{ route('applications.create') }}" class="btn btn-primary btn-sm" data-bn="+ নতুন আবেদন" data-en="+ New Application">+ নতুন আবেদন</a>
      </div>
      @forelse ($applications as $app)
        <div class="dash-item">
          <div class="dash-item-icon">◈</div>
          <div class="dash-item-main">
            <div class="dash-item-title">{{ $app->course->name_bn ?? '—' }}</div>
            <div class="dash-item-meta">{{ $app->application_no }} · {{ $app->created_at?->format('d M Y') }}</div>
          </div>
          <div class="dash-item-side">
            <span class="badge badge-{{ in_array($app->status, ['approved','pending','cancelled','verified']) ? $app->status : 'pending' }}">{{ $app->status }}</span>
            <a href="{{ route('applications.show', $app) }}" class="btn btn-outline btn-xs" data-bn="বিস্তারিত" data-en="Details">বিস্তারিত</a>
          </div>
        </div>
      @empty
        <div class="dash-empty">
          <div class="dash-empty-icon">◈</div>
          <p data-bn="এখনো কোনো আবেদন নেই।" data-en="No application yet.">এখনো কোনো আবেদন নেই।</p>
          <a href="{{ route('applications.create') }}" class="btn btn-primary btn-sm" data-bn="আবেদন করুন" data-en="Apply Now">আবেদন করুন</a>
        </div>
      @endforelse
    </div>

    {{-- Certificates --}}
    <div class="mt-4 reveal">
      <div class="dash-section-head">
        <div>
          <span class="kicker" data-bn="০২ — সার্টিফিকেট" data-en="02 — CERTIFICATES">০২ — সার্টিফিকেট</span>
          <h2 class="section-title" data-bn="আমার সার্টিফিকেট" data-en="My Certificates">আমার সার্টিফিকেট</h2>
        </div>
      </div>
      @if ($certificates->count())
        <div class="dash-cert-grid">
          @foreach ($certificates as $cert)
            <div class="dash-cert">
              <div class="dash-cert-top">
                <span class="dash-cert-badge">♛</span>
                <span class="badge badge-approved">{{ $cert->status }}</span>
              </div>
              <div class="dash-cert-title">{{ $cert->course->name_bn ?? '—' }}</div>
              <div class="dash-cert-meta">{{ $cert->certificate_no }}<br>{{ $cert->issued_at?->format('d M Y') }}</div>
              <div class="dash-cert-actions">
                <a href="{{ route('certificate.pdf', $cert->certificate_no) }}" class="btn btn-primary btn-xs">PDF</a>
                <a href="{{ route('verify.code', $cert->certificate_no) }}" class="btn btn-outline btn-xs" data-bn="যাচাই" data-en="Verify">যাচাই</a>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="dash-empty">
          <div class="dash-empty-icon">♛</div>
          <p data-bn="এখনো কোনো সার্টিফিকেট নেই।" data-en="No certificate yet.">এখনো কোনো সার্টিফিকেট নেই।</p>
        </div>
      @endif
    </div>

    {{-- Recent attendance --}}
    <div class="mt-4 reveal">
      <div class="dash-section-head">
        <div>
          <span class="kicker" data-bn="০৩ — উপস্থিতি" data-en="03 — ATTENDANCE">০৩ — উপস্থিতি</span>
          <h2 class="section-title" data-bn="সাম্প্রতিক উপস্থিতি" data-en="Recent Attendance">সাম্প্রতিক উপস্থিতি</h2>
        </div>
        <span class="dash-hint" data-bn="QR স্ক্যান করে উপস্থিতি দিতে পারেন" data-en="Scan the QR code to check in">QR স্ক্যান করে উপস্থিতি দিতে পারেন</span>
      </div>
      @if ($attendances->count())
        <div class="dash-timeline">
          @foreach ($attendances as $att)
            <div class="dash-tl {{ $att->status === 'present' ? 'ok' : 'no' }}">
              <span class="dash-tl-dot"></span>
              <div class="dash-tl-main">
                <div class="dash-tl-title">{{ $att->course->name_bn ?? '—' }}</div>
                <div class="dash-tl-meta">
                  {{ $att->date?->format('d M Y') }}
                  · {{ $att->batch?->name_bn ?? 'সাধারণ' }}
                  · {{ $att->method === 'qr' ? 'QR' : 'ম্যানুয়াল' }}
                </div>
              </div>
              <span class="badge {{ $att->status === 'present' ? 'badge-approved' : 'badge-cancelled' }}">{{ $att->status }}</span>
            </div>
          @endforeach
        </div>
      @else
        <div class="dash-empty">
          <div class="dash-empty-icon">✓</div>
          <p data-bn="কোনো উপস্থিতি রেকর্ড নেই।" data-en="No attendance records.">কোনো উপস্থিতি রেকর্ড নেই।</p>
        </div>
      @endif
    </div>

  </div>
</section>
@endsection
