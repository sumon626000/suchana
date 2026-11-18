@extends('layouts.admin')
@section('title', 'সহায়তা বার্তা')
@section('subtitle', 'লাইভ চ্যাট / সহায়তা ফর্ম থেকে আসা বার্তা')

@section('content')
<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>#</th><th>নাম</th><th>মোবাইল</th><th>বার্তা</th><th>তারিখ</th><th>অ্যাকশন</th></tr></thead>
    <tbody>
      @forelse ($messages as $msg)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $msg->name }}</td>
          <td>{{ $msg->mobile }}</td>
          <td style="max-width:360px">{{ $msg->message }}</td>
          <td>{{ $msg->created_at->format('d M Y, h:i A') }}</td>
          <td class="admin-actions">
            <a href="https://wa.me/88{{ preg_replace('/\D/', '', $msg->mobile) }}" target="_blank" rel="noopener" class="btn btn-outline btn-xs">WhatsApp</a>
            <form method="POST" action="{{ route('admin.support.destroy', $msg) }}" onsubmit="return confirm('মুছে ফেলবেন?')">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" type="submit">মুছুন</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty">এখনো কোনো সহায়তা বার্তা নেই।</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
