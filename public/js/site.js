(function () {
  'use strict';

  // ---------- Theme ----------
  var savedTheme = localStorage.getItem('smtii-theme');
  var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  var theme = savedTheme || (prefersDark ? 'dark' : 'light');
  applyTheme(theme);

  function applyTheme(t) {
    document.documentElement.setAttribute('data-theme', t);
    document.documentElement.style.colorScheme = t;
    localStorage.setItem('smtii-theme', t);
  }

  document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      applyTheme(next);
      btn.setAttribute('aria-pressed', next === 'dark');
    });
  });

  // ---------- Language toggle (data-bn / data-en) ----------
  var lang = localStorage.getItem('smtii-lang') || 'bn';
  applyLang(lang);

  function applyLang(l) {
    document.documentElement.lang = l;
    document.querySelectorAll('[data-bn]').forEach(function (el) {
      var text = el.getAttribute('data-' + l);
      if (text !== null) el.textContent = text;
    });
    document.querySelectorAll('[data-bn-html]').forEach(function (el) {
      var html = el.getAttribute('data-' + l + '-html');
      if (html !== null) el.innerHTML = html;
    });
    document.querySelectorAll('[data-bn-ph]').forEach(function (el) {
      var ph = el.getAttribute('data-' + l + '-ph');
      if (ph) el.placeholder = ph;
    });
    var t = document.getElementById('langToggle');
    if (t) t.textContent = l === 'bn' ? 'EN' : 'বাং';
    localStorage.setItem('smtii-lang', l);
  }

  document.querySelectorAll('#langToggle').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var l = localStorage.getItem('smtii-lang') === 'en' ? 'bn' : 'en';
      applyLang(l);
    });
  });

  // ---------- Header scroll ----------
  var header = document.getElementById('header');
  var ticking = false;
  window.addEventListener('scroll', function () {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(function () {
      if (header) header.classList.toggle('scrolled', window.scrollY > 8);
      ticking = false;
    });
  }, { passive: true });

  // ---------- Mobile nav ----------
  var menuToggle = document.getElementById('menuToggle');
  var mobileNav = document.getElementById('mobileNav');
  var mnavBackdrop = document.getElementById('mnavBackdrop');
  function closeMobileNav() {
    if (!mobileNav) return;
    mobileNav.hidden = true;
    if (mnavBackdrop) mnavBackdrop.hidden = true;
    if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('mnav-open');
  }
  if (menuToggle && mobileNav) {
    menuToggle.addEventListener('click', function () {
      var open = mobileNav.hidden;
      mobileNav.hidden = !open;
      if (mnavBackdrop) mnavBackdrop.hidden = !open;
      menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.classList.toggle('mnav-open', open);
    });
    mobileNav.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', closeMobileNav);
    });
    if (mnavBackdrop) mnavBackdrop.addEventListener('click', closeMobileNav);
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') closeMobileNav();
    });
  }

  // ---------- Slider ----------
  document.querySelectorAll('[data-slider-prev]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var track = btn.closest('.slider-wrap').querySelector('.slider-track');
      if (track) track.scrollBy({ left: -380, behavior: 'smooth' });
    });
  });
  document.querySelectorAll('[data-slider-next]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var track = btn.closest('.slider-wrap').querySelector('.slider-track');
      if (track) track.scrollBy({ left: 380, behavior: 'smooth' });
    });
  });

  // ---------- Live chat ----------
  var chatToggle = document.getElementById('liveChatToggle');
  var chatPanel = document.getElementById('liveChatPanel');
  var chatClose = document.getElementById('liveChatClose');

  if (chatToggle && chatPanel) {
    chatToggle.addEventListener('click', function () {
      chatPanel.hidden = !chatPanel.hidden;
    });
  }

  if (chatClose && chatPanel) {
    chatClose.addEventListener('click', function () {
      chatPanel.hidden = true;
    });
  }

  var chatForm = document.getElementById('liveChatForm');
  if (chatForm) {
    chatForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var tokenMeta = document.querySelector('meta[name="csrf-token"]');
      var token = tokenMeta ? tokenMeta.getAttribute('content') : '';

      fetch(chatForm.getAttribute('action'), {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
        body: new FormData(chatForm)
      }).then(function (res) {
        if (!res.ok) throw new Error('failed');
        chatForm.reset();
        chatForm.hidden = true;
        var done = document.getElementById('liveChatDone');
        if (done) done.hidden = false;
      }).catch(function () {
        alert('পাঠাতে সমস্যা হয়েছে। আবার চেষ্টা করুন।');
      });
    });
  }

  // ---------- Gallery lightbox ----------
  var slb = document.getElementById('siteLightbox');
  var slbImg = document.getElementById('siteLightboxImg');
  var slbClose = document.getElementById('siteLightboxClose');

  function openSiteLightbox(src) {
    if (!slb || !slbImg) return;
    slbImg.src = src;
    slb.hidden = false;
  }
  function closeSiteLightbox() {
    if (slb) slb.hidden = true;
    if (slbImg) slbImg.src = '';
  }
  document.querySelectorAll('[data-lightbox]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      openSiteLightbox(el.getAttribute('data-lightbox'));
    });
  });
  if (slbClose) slbClose.addEventListener('click', closeSiteLightbox);
  if (slb) slb.addEventListener('click', function (e) { if (e.target === slb) closeSiteLightbox(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeSiteLightbox(); });

  // ---------- Slider autoplay + dots ----------
  document.querySelectorAll('[data-slider]').forEach(function (wrap) {
    var track = wrap.querySelector('.slider-track');
    var dotsWrap = wrap.querySelector('[data-slider-dots]');
    var autoplay = parseInt(wrap.getAttribute('data-autoplay') || '0', 10);
    if (!track) return;
    var cards = Array.prototype.slice.call(track.children);
    var current = 0;
    var timer = null;

    function goto(i) {
      if (!cards.length) return;
      current = Math.max(0, Math.min(cards.length - 1, i));
      var left = cards[current].offsetLeft - track.offsetLeft;
      track.scrollTo({ left: left, behavior: 'smooth' });
      updateDots();
    }

    function updateDots() {
      if (!dotsWrap) return;
      Array.prototype.forEach.call(dotsWrap.children, function (dot, j) {
        dot.classList.toggle('active', j === current);
      });
    }

    if (dotsWrap) {
      cards.forEach(function (c, i) {
        var dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'slider-dot';
        dot.setAttribute('aria-label', 'Slide ' + (i + 1));
        dot.addEventListener('click', function () { stop(); goto(i); });
        dotsWrap.appendChild(dot);
      });
    }

    function next() { goto((current + 1) % cards.length); }
    function start() { stop(); if (autoplay > 0 && cards.length > 1) { timer = setInterval(next, autoplay); } }
    function stop() { if (timer) { clearInterval(timer); timer = null; } }

    track.addEventListener('scroll', function () {
      requestAnimationFrame(function () {
        var w = cards[0] ? cards[0].offsetWidth + 18 : track.clientWidth;
        current = Math.max(0, Math.min(cards.length - 1, Math.round(track.scrollLeft / w)));
        updateDots();
      });
    }, { passive: true });

    wrap.addEventListener('mouseenter', stop);
    wrap.addEventListener('mouseleave', start);
    wrap.addEventListener('touchstart', stop, { passive: true });
    wrap.addEventListener('touchend', start, { passive: true });

    updateDots();
    start();
  });

  // ---------- Three-dot menu ----------
  var moreToggle = document.getElementById('moreToggle');
  var moreMenu = document.getElementById('moreMenu');
  function closeMore() {
    if (moreMenu) moreMenu.hidden = true;
    if (moreToggle) moreToggle.setAttribute('aria-expanded', 'false');
  }
  if (moreToggle && moreMenu) {
    moreToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = moreMenu.hidden;
      moreMenu.hidden = !open;
      moreToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    document.addEventListener('click', function (e) {
      if (!moreMenu.hidden && !moreMenu.contains(e.target) && e.target !== moreToggle) closeMore();
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeMore(); });
    moreMenu.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', closeMore); });
  }

  // ---------- Auto-hide flash messages ----------
  document.querySelectorAll('[data-auto-dismiss]').forEach(function (el) {
    setTimeout(function () { el.style.display = 'none'; }, 5000);
  });
})();
