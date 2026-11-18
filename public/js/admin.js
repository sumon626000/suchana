(function () {
  'use strict';

  var TEXT_MAP = {
    'ড্যাশবোর্ড': 'Dashboard',
    'কোর্স': 'Course',
    'ব্যাচ': 'Batch',
    'কর্তৃপক্ষ': 'Authority',
    'ব্রাঞ্চ': 'Branch',
    'গ্যালারি': 'Gallery',
    'নোটিশ': 'Notice',
    'আবেদন': 'Application',
    'শিক্ষার্থী': 'Student',
    'উপস্থিতি': 'Attendance',
    'সার্টিফিকেট': 'Certificate',
    'নোটিফিকেশন': 'Notifications',
    'সহায়তা বার্তা': 'Support Messages',
    'সেটিংস': 'Settings',
    'লগআউট': 'Logout',
    'নতুন': 'New',
    'নতুন কোর্স': 'New Course',
    'নতুন কর্মকর্তা': 'New Officer',
    'নতুন ব্রাঞ্চ': 'New Branch',
    'নতুন জেলা': 'New District',
    'নতুন উপজেলা': 'New Upazila',
    'নতুন ছবি': 'New Image',
    'নতুন নোটিশ': 'New Notice',
    'নতুন ব্যাচ': 'New Batch',
    'এডিট': 'Edit',
    'মুছুন': 'Delete',
    'দেখুন': 'View',
    'বিস্তারিত': 'Details',
    'বিস্তারিত দেখুন': 'View Details',
    'সেভ করুন': 'Save',
    'বাতিল': 'Cancel',
    'খুঁজুন': 'Search',
    'ফিল্টার': 'Filter',
    'অনুসন্ধান': 'Search',
    'সক্রিয়': 'Active',
    'নিষ্ক্রিয়': 'Inactive',
    'স্ট্যাটাস': 'Status',
    'তারিখ': 'Date',
    'নাম': 'Name',
    'মোবাইল': 'Mobile',
    'ইমেইল': 'Email',
    'ঠিকানা': 'Address',
    'ফোন': 'Phone',
    'আসন': 'Seats',
    'ফি': 'Fee',
    'লেভেল': 'Level',
    'মেয়াদ': 'Duration',
    'উপবৃত্তি': 'Stipend',
    'ভাতা': 'Stipend',
    'যোগ্যতা': 'Eligibility',
    'বিবরণ': 'Description',
    'উপস্থিত': 'Present',
    'অনুপস্থিত': 'Absent',
    'দেরি': 'Late',
    'মোট': 'Total',
    'আবেদন নং': 'App No',
    'জমা দেওয়ার তারিখ': 'Submitted At',
    'আবেদনকারী': 'Applicant',
    'সাম্প্রতিক আবেদন': 'Recent Applications',
    'সব আবেদন': 'All Applications',
    'মোট আবেদন': 'Total Applications',
    'অপেক্ষমাণ আবেদন': 'Pending Applications',
    'অপেক্ষমাণ': 'Pending',
    'যাচাইকৃত': 'Verified',
    'অনুমোদিত': 'Approved',
    'অপেক্ষমাণ তালিকা': 'Waitlist',
    'অ্যাকশন': 'Actions',
    'ছবি': 'Photo',
    'পদবি': 'Designation',
    'ক্রম': 'Order',
    'শিরোনাম': 'Title',
    'টাইপ': 'Type',
    'প্রকাশ': 'Published',
    'প্রকাশের তারিখ ও সময়': 'Publish Date & Time',
    'শিরোনাম (বাংলা)': 'Title (Bangla)',
    'শিরোনাম (বাংলা) *': 'Title (Bangla) *',
    'Title (English) *': 'Title (English) *',
    'বার্তা': 'Message',
    'বার্তা (বাংলা)': 'Message (Bangla)',
    'বার্তা (বাংলা) *': 'Message (Bangla) *',
    'Message (English)': 'Message (English)',
    'কী': 'Key',
    'চ্যানেল': 'Channel',
    'বিষয়': 'Subject',
    'বিষয় (ইমেইলের জন্য)': 'Subject (for email)',
    'প্রাপক': 'Recipient',
    'সময়': 'Time',
    'টেমপ্লেট': 'Template',
    'টেমপ্লেট এডিট': 'Edit Template',
    'নোটিফিকেশন লগ': 'Notification Logs',
    'টেমপ্লেটে ফিরুন': 'Back to Templates',
    'সার্টিফিকেট নং': 'Certificate No',
    'যাচাই কোড': 'Verification Code',
    'ইস্যু': 'Issued',
    'অটোমেটিক সার্টিফিকেট': 'Automatic Certificate',
    'সব যোগ্য শিক্ষার্থীর সার্টিফিকেট তৈরি করুন': 'Generate for All Eligible Students',
    'ম্যানুয়াল সার্টিফিকেট': 'Manual Certificate',
    'তৈরি করুন': 'Create',
    'সাইট সেটিংস': 'Site Settings',
    'পুরো সাইট এক জায়গা থেকে নিয়ন্ত্রণ করুন': 'Control the whole site from one place',
    'সাধারণ তথ্য': 'General Information',
    'সাইটের নাম (English)': 'Site Name (English)',
    'সাইটের নাম (বাংলা)': 'Site Name (Bangla)',
    'ট্যাগলাইন (বাংলা)': 'Tagline (Bangla)',
    'ট্যাগলাইন (English)': 'Tagline (English)',
    'হিরো ব্যাজ (বাংলা)': 'Hero Badge (Bangla)',
    'হিরো ব্যাজ (English)': 'Hero Badge (English)',
    'যোগাযোগ': 'Contact',
    'ঠিকানা (বাংলা)': 'Address (Bangla)',
    'ঠিকানা (English)': 'Address (English)',
    'সোশ্যাল ও সাপোর্ট আইকন': 'Social & Support Icons',
    'WhatsApp নম্বর (দেশের কোড সহ, শুধু সংখ্যা)': 'WhatsApp Number (with country code, digits only)',
    'Facebook পেজ URL': 'Facebook Page URL',
    'YouTube URL (ঐচ্ছিক)': 'YouTube URL (optional)',
    'Instagram URL (ঐচ্ছিক)': 'Instagram URL (optional)',
    'লাইভ চ্যাট': 'Live Chat',
    'লাইভ চ্যাট চালু করুন (বিল্ট-ইন সহায়তা বার্তা)': 'Enable Live Chat (built-in support form)',
    'তৃতীয় পক্ষের লাইভ চ্যাট স্ক্রিপ্ট (ঐচ্ছিক)': 'Third-party Live Chat Script (optional)',
    'আমাদের সম্পর্কে': 'About Us',
    'বিবরণ (বাংলা)': 'Description (Bangla)',
    'Description (English)': 'Description (English)',
    'সেটিংস সংরক্ষণ করুন': 'Save Settings',
    'জেলা': 'District',
    'উপজেলা': 'Upazila',
    'বিভাগ': 'Division',
    'জেলা (বাংলা)': 'District (Bangla)',
    'District (English)': 'District (English)',
    'বিভাগ (বাংলা)': 'Division (Bangla)',
    'Division (English)': 'Division (English)',
    'সব জেলা': 'All Districts',
    'উপজেলা (বাংলা)': 'Upazila (Bangla)',
    'Thana (English)': 'Thana (English)',
    'ছবি URL': 'Image URL',
    'মোট আসন': 'Total Seats',
    'উপলব্ধ আসন': 'Available Seats',
    'কোর্স ফি': 'Course Fee',
    'ভাতা পুরুষ': 'Stipend Male',
    'ভাতা মহিলা': 'Stipend Female',
    'আবেদনের শেষ তারিখ': 'Application Deadline',
    'ক্রম (sort order)': 'Sort Order',
    'যোগ্যতা (বাংলা)': 'Eligibility (Bangla)',
    'Eligibility (English)': 'Eligibility (English)',
    'বায়ো / বিবরণ': 'Bio / Description',
    'কোর্স ব্যবস্থাপনা': 'Course Management',
    'ব্যাচ ব্যবস্থাপনা': 'Batch Management',
    'কর্তৃপক্ষ ব্যবস্থাপনা': 'Authority Management',
    'ব্রাঞ্চ ব্যবস্থাপনা': 'Branch Management',
    'জেলা ব্যবস্থাপনা': 'District Management',
    'উপজেলা ব্যবস্থাপনা': 'Upazila Management',
    'গ্যালারি ব্যবস্থাপনা': 'Gallery Management',
    'নোটিশ ব্যবস্থাপনা': 'Notice Management',
    'আবেদন ব্যবস্থাপনা': 'Application Management',
    'শিক্ষার্থী ব্যবস্থাপনা': 'Student Management',
    'উপস্থিতি রিপোর্ট': 'Attendance Report',
    'সার্টিফিকেট ব্যবস্থাপনা': 'Certificate Management',
    'নোটিফিকেশন টেমপ্লেট': 'Notification Templates',
    'কোর্স এডিট': 'Edit Course',
    'কর্মকর্তা এডিট': 'Edit Officer',
    'ব্রাঞ্চ এডিট': 'Edit Branch',
    'জেলা এডিট': 'Edit District',
    'উপজেলা এডিট': 'Edit Upazila',
    'ছবি এডিট': 'Edit Image',
    'নোটিশ এডিট': 'Edit Notice',
    'ব্যাচ এডিট': 'Edit Batch',
    'নাম *': 'Name *',
    'পদবি *': 'Designation *',
    'মোট আসন *': 'Total Seats *',
    'উপলব্ধ আসন *': 'Available Seats *',
    'আসন *': 'Seats *',
    'রিপোর্ট': 'Report',
    'রিপোর্ট দেখুন': 'View Report',
    'শুরুর তারিখ': 'From Date',
    'শেষ তারিখ': 'To Date',
    'CSV এক্সপোর্ট': 'Export CSV',
    'প্রিন্ট / PDF': 'Print / PDF',
    'উপস্থিতি পেজে ফিরুন': 'Back to Attendance',
    'লগ দেখুন': 'View Logs',
    'পাঠানো লগ': 'Send Logs',
    'উপস্থিতি সংরক্ষণ করুন': 'Save Attendance',
    'স্ট্যাটাস পরিবর্তন': 'Change Status',
    'নতুন স্ট্যাটাস': 'New Status',
    'বাতিলের কারণ (যদি বাতিল হয়)': 'Cancellation Reason (if cancelled)',
    'আপডেট করুন': 'Update',
    'ফিরে যান': 'Go Back',
    'যাচাই করেছেন': 'Reviewed By',
    'ব্যাংক': 'Bank',
    'জেলা / উপজেলা': 'District / Upazila',
    'ইউজারনেম': 'Username',
    'রেজিস্ট্রেশন': 'Registration',
    'নিষ্ক্রিয় করুন': 'Deactivate',
    'সক্রিয় করুন': 'Activate',
    'আবেদনসমূহ': 'Applications',
    'সব': 'All'
  };

  // ---------- Theme ----------
  var themeBtn = document.getElementById('adminThemeBtn');
  function applyTheme(t) {
    document.documentElement.setAttribute('data-theme', t);
    document.documentElement.style.colorScheme = t;
    localStorage.setItem('smtii-theme', t);
  }
  if (themeBtn) {
    themeBtn.addEventListener('click', function () {
      var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      applyTheme(next);
    });
  }

  // ---------- Sidebar (mobile) ----------
  var side = document.getElementById('adminSide');
  var backdrop = document.getElementById('adminBackdrop');
  var menuBtn = document.getElementById('adminMenuBtn');
  if (menuBtn && side) {
    menuBtn.addEventListener('click', function () {
      side.classList.toggle('open');
      if (backdrop) backdrop.classList.toggle('show');
    });
    if (backdrop) {
      backdrop.addEventListener('click', function () {
        side.classList.remove('open');
        backdrop.classList.remove('show');
      });
    }
  }

  // ---------- Language ----------
  var langSel = document.getElementById('adminLang');
  var lang = localStorage.getItem('admin-lang') || 'bn';
  if (langSel) langSel.value = lang;

  function translateNodes(root, map) {
    if (!root) return;
    var walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null);
    var node;
    while ((node = walker.nextNode())) {
      var original = node.nodeValue;
      var trimmed = original.trim();
      if (!trimmed) continue;
      if (Object.prototype.hasOwnProperty.call(map, trimmed)) {
        node.nodeValue = original.replace(trimmed, map[trimmed]);
      }
    }
  }

  function applyLang(l) {
    document.documentElement.lang = l;
    document.querySelectorAll('[data-bn]').forEach(function (el) {
      var t = el.getAttribute('data-' + l);
      if (t !== null) el.textContent = t;
    });
    if (l === 'en') {
      translateNodes(document.querySelector('.admin-main'), TEXT_MAP);
      document.querySelectorAll('[placeholder]').forEach(function (el) {
        var p = el.getAttribute('placeholder');
        if (Object.prototype.hasOwnProperty.call(TEXT_MAP, p)) el.setAttribute('placeholder', TEXT_MAP[p]);
      });
    }
  }

  if (langSel) {
    langSel.addEventListener('change', function () {
      localStorage.setItem('admin-lang', langSel.value);
      window.location.reload();
    });
  }
  applyLang(lang);

  // ---------- Lightbox ----------
  var lb = document.getElementById('adminLightbox');
  var lbImg = document.getElementById('adminLightboxImg');
  var lbClose = document.getElementById('adminLightboxClose');
  function openLightbox(src) {
    if (!lb || !lbImg) return;
    lbImg.src = src;
    lb.hidden = false;
  }
  function closeLightbox() {
    if (lb) lb.hidden = true;
    if (lbImg) lbImg.src = '';
  }
  document.querySelectorAll('[data-lightbox]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      openLightbox(el.getAttribute('data-lightbox'));
    });
  });
  if (lbClose) lbClose.addEventListener('click', closeLightbox);
  if (lb) lb.addEventListener('click', function (e) { if (e.target === lb) closeLightbox(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeLightbox(); });

  // ---------- Upload preview ----------
  document.querySelectorAll('[data-upload-preview]').forEach(function (input) {
    var preview = document.querySelector(input.getAttribute('data-upload-preview'));
    if (!preview) return;
    input.addEventListener('change', function () {
      var file = input.files && input.files[0];
      if (!file) return;
      var url = URL.createObjectURL(file);
      preview.innerHTML = '<img src="' + url + '" alt=""><button type="button" class="preview-remove" aria-label="Remove">✕</button>';
      preview.hidden = false;
      preview.querySelector('.preview-remove').addEventListener('click', function () {
        input.value = '';
        preview.innerHTML = '';
        preview.hidden = true;
      });
    });
  });

  // ---------- Auto-dismiss flash ----------
  document.querySelectorAll('[data-auto-dismiss]').forEach(function (el) {
    setTimeout(function () { el.style.display = 'none'; }, 5000);
  });
})();
