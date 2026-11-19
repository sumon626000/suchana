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
    <h3 style="font-size:16px;font-weight:700;margin-bottom:10px">হোমপেজ হিরো ছবি</h3>
    <p class="muted" style="font-size:13px;margin-bottom:12px">হোমপেজের উপরের বড় ছবি এখান থেকে আপলোড করে বদলান (JPG/PNG/WebP, সর্বোচ্চ ৫MB)। কোর্স কার্ডের ছবি আলাদা — <strong>কোর্স → এডিট</strong> থেকে বদলাবেন।</p>

    @if (! empty($settings['hero_image']))
      <div style="margin-bottom:12px">
        <img src="{{ \App\Support\Settings::mediaUrl($settings['hero_image']) }}" alt="" style="max-width:360px;max-height:200px;width:100%;object-fit:cover;border-radius:12px;border:1px solid var(--line)">
        <div class="field" style="display:flex;align-items:center;gap:8px;margin-top:8px">
          <input type="checkbox" name="remove_hero_image" value="1" id="removeHeroImage" style="width:18px;height:18px">
          <label for="removeHeroImage" style="margin:0">বর্তমান হিরো ছবি মুছুন</label>
        </div>
      </div>
    @endif

    <div class="form-grid two">
      <div class="field">
        <label>হিরো ছবি আপলোড</label>
        <input type="file" name="hero_image_file" accept="image/*" data-upload-preview="#heroImagePreview">
        <div class="upload-preview" id="heroImagePreview" hidden></div>
      </div>
      <div class="field">
        <label>অথবা ছবি URL (ঐচ্ছিক)</label>
        <input name="hero_image" value="{{ old('hero_image', $settings['hero_image'] ?? '') }}" placeholder="https://... অথবা uploads/home/...">
      </div>
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

  <div class="card" style="margin-bottom:14px">
    <h3 style="font-size:16px;font-weight:700;margin-bottom:8px">হোম পেজ টেক্সট</h3>
    <p class="muted" style="font-size:13px;margin-bottom:12px">হোমপেজের ব্র্যান্ড, হিরো ও কোর্স সেকশনের লেখা এখান থেকে বদলান। সেভ করলে সাইটে সাথে সাথে দেখাবে।</p>

    <h4 style="font-size:14px;font-weight:700;margin:0 0 10px">হেডার লোগো টেক্সট</h4>
    <p class="muted" style="font-size:13px;margin-bottom:10px">লোগোর পাশের নাম ও সাবটাইটেল — হোম হেডারে দেখা যাবে।</p>
    <div class="form-grid two" style="margin-bottom:14px">
      <div class="field"><label>ব্র্যান্ড টাইটেল (বাংলা)</label><input name="brand_title_bn" value="{{ old('brand_title_bn', $settings['brand_title_bn'] ?? 'সুচনা মেডিকেল এন্ড টেকনিক্যাল') }}" placeholder="সুচনা মেডিকেল এন্ড টেকনিক্যাল"></div>
      <div class="field"><label>Brand title (English)</label><input name="brand_title_en" value="{{ old('brand_title_en', $settings['brand_title_en'] ?? 'Suchana Medical & Technical') }}" placeholder="Suchana Medical & Technical"></div>
      <div class="field"><label>সাবটাইটেল (বাংলা)</label><input name="brand_sub_bn" value="{{ old('brand_sub_bn', $settings['brand_sub_bn'] ?? 'ট্রেনিং ইনস্টিটিউট (SMTTI)') }}" placeholder="ট্রেনিং ইনস্টিটিউট (SMTTI)"></div>
      <div class="field"><label>Subtitle (English)</label><input name="brand_sub_en" value="{{ old('brand_sub_en', $settings['brand_sub_en'] ?? 'Training Institute (SMTTI)') }}" placeholder="Training Institute (SMTTI)"></div>
    </div>

    <h4 style="font-size:14px;font-weight:700;margin:0 0 10px">হিরো সেকশন</h4>
    <div class="form-grid two" style="margin-bottom:14px">
      <div class="field"><label>হিরো লাইন ১ (বাংলা)</label><input name="hero_title_line1_bn" value="{{ old('hero_title_line1_bn', $settings['hero_title_line1_bn'] ?? 'দক্ষতাই শক্তি,') }}"></div>
      <div class="field"><label>Hero line 1 (English)</label><input name="hero_title_line1_en" value="{{ old('hero_title_line1_en', $settings['hero_title_line1_en'] ?? 'Skill is Power,') }}"></div>
      <div class="field"><label>হিরো লাইন ২ (বাংলা)</label><input name="hero_title_line2_bn" value="{{ old('hero_title_line2_bn', $settings['hero_title_line2_bn'] ?? 'প্রশিক্ষণই ভবিষ্যৎ') }}"></div>
      <div class="field"><label>Hero line 2 (English)</label><input name="hero_title_line2_en" value="{{ old('hero_title_line2_en', $settings['hero_title_line2_en'] ?? 'Training is the Future') }}"></div>
      <div class="field"><label>হিরো সাবটাইটেল (বাংলা)</label><textarea name="hero_subtitle_bn" rows="3">{{ old('hero_subtitle_bn', $settings['hero_subtitle_bn'] ?? '') }}</textarea></div>
      <div class="field"><label>Hero subtitle (English)</label><textarea name="hero_subtitle_en" rows="3">{{ old('hero_subtitle_en', $settings['hero_subtitle_en'] ?? '') }}</textarea></div>
    </div>

    <h4 style="font-size:14px;font-weight:700;margin:0 0 10px">চলমান কোর্স সেকশন</h4>
    <div class="form-grid two" style="margin-bottom:14px">
      <div class="field"><label>কিকার (বাংলা)</label><input name="home_running_kicker_bn" value="{{ old('home_running_kicker_bn', $settings['home_running_kicker_bn'] ?? 'চলমান কোর্স') }}"></div>
      <div class="field"><label>Kicker (English)</label><input name="home_running_kicker_en" value="{{ old('home_running_kicker_en', $settings['home_running_kicker_en'] ?? 'Running Courses') }}"></div>
      <div class="field"><label>শিরোনাম (বাংলা)</label><input name="home_running_title_bn" value="{{ old('home_running_title_bn', $settings['home_running_title_bn'] ?? 'চলমান কোর্সসমূহ') }}"></div>
      <div class="field"><label>Title (English)</label><input name="home_running_title_en" value="{{ old('home_running_title_en', $settings['home_running_title_en'] ?? 'Running Courses') }}"></div>
      <div class="field"><label>লিড টেক্সট (বাংলা)</label><input name="home_running_lead_bn" value="{{ old('home_running_lead_bn', $settings['home_running_lead_bn'] ?? '') }}"></div>
      <div class="field"><label>Lead text (English)</label><input name="home_running_lead_en" value="{{ old('home_running_lead_en', $settings['home_running_lead_en'] ?? '') }}"></div>
    </div>

    <h4 style="font-size:14px;font-weight:700;margin:0 0 10px">আমাদের কোর্স সেকশন</h4>
    <div class="form-grid two">
      <div class="field"><label>কিকার (বাংলা)</label><input name="home_courses_kicker_bn" value="{{ old('home_courses_kicker_bn', $settings['home_courses_kicker_bn'] ?? 'আমাদের কোর্স') }}"></div>
      <div class="field"><label>Kicker (English)</label><input name="home_courses_kicker_en" value="{{ old('home_courses_kicker_en', $settings['home_courses_kicker_en'] ?? 'Our Courses') }}"></div>
      <div class="field"><label>শিরোনাম (বাংলা)</label><input name="home_courses_title_bn" value="{{ old('home_courses_title_bn', $settings['home_courses_title_bn'] ?? 'আমাদের কোর্সসমূহ') }}"></div>
      <div class="field"><label>Title (English)</label><input name="home_courses_title_en" value="{{ old('home_courses_title_en', $settings['home_courses_title_en'] ?? 'Our Courses') }}"></div>
      <div class="field"><label>লিড টেক্সট (বাংলা)</label><input name="home_courses_lead_bn" value="{{ old('home_courses_lead_bn', $settings['home_courses_lead_bn'] ?? '') }}"></div>
      <div class="field"><label>Lead text (English)</label><input name="home_courses_lead_en" value="{{ old('home_courses_lead_en', $settings['home_courses_lead_en'] ?? '') }}"></div>
    </div>
  </div>

  <div class="admin-actions">
    <button class="btn btn-primary" type="submit">সেটিংস সংরক্ষণ করুন</button>
  </div>
</form>
@endsection
