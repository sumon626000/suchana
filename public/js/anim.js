(function () {
  'use strict';

  if (!document.body.classList.contains('site')) return;

  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ---------- Scroll progress + back-to-top + parallax ----------
  var progress = document.getElementById('siteProgress');
  var topBtn = document.getElementById('siteTop');
  var heroImg = document.querySelector('.hero-photo img');

  function onScroll() {
    var docH = document.documentElement.scrollHeight - window.innerHeight;
    var p = docH > 0 ? (window.scrollY / docH) * 100 : 0;
    if (progress) progress.style.width = p + '%';
    if (topBtn) topBtn.classList.toggle('show', window.scrollY > 500);

    if (heroImg && !reduce) {
      var y = Math.min(window.scrollY, 700);
      heroImg.style.transform = 'translateY(' + (y * 0.12) + 'px) scale(1.06)';
    }
  }

  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  if (topBtn) {
    topBtn.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  if (reduce) return;

  // ---------- Scroll reveal (auto-tag elements, staggered) ----------
  var selectors = [
    '.kicker', '.section-title', '.section-lead',
    '.course-card', '.staff-card', '.branch-card', '.notice-card',
    '.gallery-item', '.stat', '.form-card', '.cert-card'
  ].join(',');

  var els = Array.prototype.slice.call(document.querySelectorAll(selectors));

  els.forEach(function (el) {
    if (el.closest('.hero')) return; // hero has its own entrance
    el.classList.add('reveal');
    var parent = el.parentElement;
    var siblings = parent ? Array.prototype.filter.call(parent.children, function (c) {
      return c.classList && c.classList.contains('reveal');
    }) : [];
    var idx = siblings.indexOf(el);
    el.style.transitionDelay = (Math.min(idx, 6) * 0.06) + 's';
  });

  // Include pre-marked .reveal nodes (e.g. student dashboard), not only auto-tagged ones.
  var reveals = Array.prototype.slice.call(document.querySelectorAll('.reveal'));

  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('in');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -24px 0px' });

    reveals.forEach(function (el) { io.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('in'); });
  }

  // ---------- Stat count-up ----------
  function animateCount(el) {
    var raw = el.textContent.trim();
    var prefix = (raw.match(/^[^\d]*/) || [''])[0];
    var suffix = (raw.match(/[^\d]*$/) || [''])[0];
    var num = parseInt(raw.replace(/[^\d]/g, ''), 10);

    if (isNaN(num)) return;

    var dur = 1300;
    var start = performance.now();

    function tick(now) {
      var p = Math.min((now - start) / dur, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      var val = Math.round(num * eased);
      el.textContent = prefix + val.toLocaleString('en-US') + suffix;
      if (p < 1) requestAnimationFrame(tick);
    }

    requestAnimationFrame(tick);
  }

  var stats = document.querySelector('.stats');
  if (stats && 'IntersectionObserver' in window) {
    var counted = false;
    var io2 = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting && !counted) {
          counted = true;
          document.querySelectorAll('.stats .stat-value').forEach(animateCount);
          io2.disconnect();
        }
      });
    }, { threshold: 0.4 });

    io2.observe(stats);
  }
})();
