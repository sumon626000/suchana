@extends('layouts.admin')
@section('title', 'সাইট সেটিংস')
@section('subtitle', 'পুরো সাইট এক জায়গা থেকে নিয়ন্ত্রণ করুন')

@section('content')
<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
  @csrf

  <div class="card" style="margin-bottom:14px">
    <h3 style="font-size:16px;font-weight:700;margin-bottom:12px">সাধারণ তথ্য</h3>
    <div class="form-grid two">
      <div class="field"><label>সাইটের নাম (English)</label><input name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Suchana') }}" required></div>
      <div class="field"><label>সাইটের নাম (বাংলা)</label><input name="site_name_bn" value="{{ old('site_name_bn', $settings['site_name_bn'] ?? 'সুচনা') }}" required></div>
      <div class="field"><label>ট্যাগলাইন (বাংলা)</label><input name="tagline_bn" value="{{ old('tagline_bn', $settings['tagline_bn'] ?? '') }}"></div>
      <div class="field"><label>ট্যাগলাইন (English)</label><input name="tagline_en" value="{{ old('tagline_en', $settings['tagline_en'] ?? '') }}"></div>
      <div class="field"><label>হিরো ব্যাজ (বাংলা)</label><input name="hero_badge_bn" value="{{ old('hero_badge_bn', $settings['hero_badge_bn'] ?? '') }}"></div>
      <div class="field"><label>হিরো ব্যাজ (English)</label><input name="hero_badge_en" value="{{ old('hero_badge_en', $settings['hero_badge_en'] ?? '') }}"></div>
    </div>
  </div>

  <div class="card" style="margin-bottom:14px">
    <h3 style="font-size:16px;font-weight:700;margin-bottom:12px">যোগাযোগ</h3>
    <div class="form-grid two">
      <div class="field"><label>ফোন</label><input name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}"></div>
      <div class="field"><label>ইমেইল</label><input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}"></div>
      <div class="field"><label>ঠিকানা (বাংলা)</label><input name="address_bn" value="{{ old('address_bn', $settings['address_bn'] ?? '') }}"></div>
      <div class="field"><label>ঠিকানা (English)</label><input name="address_en" value="{{ old('address_en', $settings['address_en'] ?? '') }}"></div>
    </div>
  </div>

  <div class="card" style="margin-bottom:14px">
    <h3 style="font-size:16px;font-weight:700;margin-bottom:12px">সোশ্যাল ও সাপোর্ট আইকন</h3>
    <p class="muted" style="font-size:13px;margin-bottom:10px">এই আইকনগুলো পাবলিক সাইটের নিচে ডানে ভাসমান অবস্থায় দেখাবে। খালি রাখলে ওই আইকন দেখাবে না।</p>
    <div class="form-grid two">
      <div class="field"><label>WhatsApp নম্বর (দেশের কোড সহ, শুধু সংখ্যা)</label><input name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" placeholder="8801700000000"></div>
      <div class="field"><label>Facebook পেজ URL</label><input name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" placeholder="https://facebook.com/yourpage"></div>
      <div class="field"><label>YouTube URL (ঐচ্ছিক)</label><input name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}"></div>
      <div class="field"><label>Instagram URL (ঐচ্ছিক)</label><input name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"></div>
    </div>
  </div>

  <div class="card" style="margin-bottom:14px">
    <h3 style="font-size:16px;font-weight:700;margin-bottom:12px">লাইভ চ্যাট</h3>
    <div class="field" style="display:flex;align-items:center;gap:8px">
      <input type="checkbox" name="live_chat_enabled" value="1" style="width:18px;height:18px" @checked(old('live_chat_enabled', ($settings['live_chat_enabled'] ?? '1') === '1'))>
      <label style="margin:0">লাইভ চ্যাট চালু করুন (বিল্ট-ইন সহায়তা বার্তা)</label>
    </div>
    <div class="field">
      <label>তৃতীয় পক্ষের লাইভ চ্যাট স্ক্রিপ্ট (ঐচ্ছিক)</label>
      <textarea name="live_chat_script" rows="4" placeholder="Tawk.to / Crisp / Facebook Messenger স্ক্রিপ্ট এখানে পেস্ট করুন। খালি থাকলে বিল্ট-ইন চ্যাট দেখাবে।">{{ old('live_chat_script', $settings['live_chat_script'] ?? '') }}</textarea>
      <p class="muted" style="font-size:12px;margin-top:4px">এখানে স্ক্রিপ্ট দিলে সেটি সাইটের সব পেজে লোড হবে।</p>
    </div>
  </div>

  <div class="card" style="margin-bottom:14px">
    <h3 style="font-size:16px;font-weight:700;margin-bottom:10px">থিম কালার</h3>
    <p class="muted" style="font-size:13px;margin-bottom:10px">সাইটের মূল রঙ নির্বাচন করুন। ডিফল্ট: আকাশি।</p>
    <div class="theme-swatches">
      @foreach ([
        'sky' => ['আকাশি', '#1f6fd6'],
        'charcoal' => ['গাঢ়', '#333c48'],
        'green' => ['সবুজ', '#0a7a4b'],
        'purple' => ['বেগুনি', '#6a1f8f'],
        'red' => ['লাল', '#c8202f'],
        'teal' => ['টিল', '#0f766e'],
        'orange' => ['কমলা', '#c2560c'],
      ] as $key => $info)
        @php $active = old('theme_color', $settings['theme_color'] ?? 'sky') === $key; @endphp
        <label class="theme-swatch {{ $active ? 'selected' : '' }}">
          <input type="radio" name="theme_color" value="{{ $key }}" @checked($active)>
          <span class="swatch-dot" style="background:{{ $info[1] }}"></span>
          <span>{{ $info[0] }}</span>
        </label>
      @endforeach
    </div>
  </div>

  <div class="card" style="margin-bottom:14px">
    <h3 style="font-size:16px;font-weight:700;margin-bottom:10px">লোগো</h3>
    <p class="muted" style="font-size:13px;margin-bottom:10px">দুটি লোগো আপলোড করুন। না দিলে ডিফল্ট লোগো ব্যবহার হবে।</p>
    <div class="form-grid two">
      <div class="field">
        <label>সুচনা লোগো</label>
        @if (! empty($settings['logo_suchana']))
          <img src="{{ str_starts_with($settings['logo_suchana'], 'http') ? $settings['logo_suchana'] : asset('storage/'.$settings['logo_suchana']) }}" alt="" style="height:54px;margin-bottom:6px;border-radius:8px;border:1px solid var(--line)">
        @endif
        <input type="file" name="logo_suchana_file" accept="image/*" data-upload-preview="#logo1Preview">
        <div class="upload-preview" id="logo1Preview" hidden></div>
      </div>
      <div class="field">
        <label>SFDB লোগো</label>
        @if (! empty($settings['logo_sfdb']))
          <img src="{{ str_starts_with($settings['logo_sfdb'], 'http') ? $settings['logo_sfdb'] : asset('storage/'.$settings['logo_sfdb']) }}" alt="" style="height:54px;margin-bottom:6px;border-radius:8px;border:1px solid var(--line)">
        @endif
        <input type="file" name="logo_sfdb_file" accept="image/*" data-upload-preview="#logo2Preview">
        <div class="upload-preview" id="logo2Preview" hidden></div>
      </div>
    </div>
  </div>

  <div class="card" style="margin-bottom:14px">
    <h3 style="font-size:16px;font-weight:700;margin-bottom:12px">আমাদের সম্পর্কে</h3>
    <div class="form-grid">
      <div class="field"><label>বিবরণ (বাংলা)</label><textarea name="about_bn" rows="3">{{ old('about_bn', $settings['about_bn'] ?? '') }}</textarea></div>
      <div class="field"><label>Description (English)</label><textarea name="about_en" rows="3">{{ old('about_en', $settings['about_en'] ?? '') }}</textarea></div>
    </div>
  </div>

  <div class="admin-actions">
    <button class="btn btn-primary" type="submit">সেটিংস সংরক্ষণ করুন</button>
  </div>
</form>
@endsection
