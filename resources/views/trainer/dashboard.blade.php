@extends('layouts.public')
@section('title', 'প্রশিক্ষক ড্যাশবোর্ড — সুচনা SMTTI')

@section('content')
<section class="section">
  <div class="container">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
      <div>
        <h1 class="section-title" style="font-size:30px;margin-bottom:4px" data-bn="প্রশিক্ষক ড্যাশবোর্ড" data-en="Trainer Dashboard">প্রশিক্ষক ড্যাশবোর্ড</h1>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-outline btn-sm" type="submit" data-bn="লগআউট" data-en="Logout">লগআউট</button>
      </form>
    </div>
    <div class="alert alert-success mt-3">Trainer panel — attendance (Phase 8) will live here.</div>
  </div>
</section>
@endsection
