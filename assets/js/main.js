/**
 * Portfolio Jason Holweg – Main JS
 * Nav scroll effect, fade-up observer, contact form handler.
 */
(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {

    /* ── Section reveal ───────────────────────────────────── */
    initSectionReveals();

    /* ── Scrolled nav ────────────────────────────────────── */
    var nav = document.querySelector('.site-nav');
    if (nav) {
      window.addEventListener('scroll', function () {
        nav.classList.toggle('scrolled', window.scrollY > 40);
      }, { passive: true });
    }

    /* ── Mobile nav toggle ───────────────────────────────── */
    var toggle  = document.getElementById('nav-toggle');
    var mobileNav = document.getElementById('nav-mobile');
    if (toggle && mobileNav) {
      toggle.addEventListener('click', function () {
        mobileNav.classList.toggle('open');
        toggle.setAttribute('aria-expanded', mobileNav.classList.contains('open'));
      });
      document.addEventListener('click', function (e) {
        if (!nav.contains(e.target)) mobileNav.classList.remove('open');
      });
    }

    /* ── Active nav link ─────────────────────────────────── */
    var path = window.location.pathname;
    document.querySelectorAll('.nav-links a, .nav-mobile a').forEach(function (a) {
      if (a.getAttribute('href') && path.endsWith(a.getAttribute('href').replace(/^\.\.\//, '').replace(/^\.\//, ''))) {
        a.classList.add('active');
      }
    });

    /* ── Intersection fade-ups (for non-intro pages) ─────── */
    if (!document.getElementById('intro')) {
      initFadeUps();
    }

    /* ── Stats counter animation ─────────────────────────── */
    initStatCounters();

    /* ── Contact form ────────────────────────────────────── */
    var form = document.getElementById('contact-form');
    if (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        handleContact(form);
      });
    }

    /* ── FAQ accordion ───────────────────────────────────── */
    initFaqAccordions();

  });

  function initSectionReveals() {
    var sections = document.querySelectorAll('.section');
    if (!sections.length) return;

    if (!('IntersectionObserver' in window)) {
      sections.forEach(function (section) { section.classList.add('visible'); });
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

    sections.forEach(function (section) { io.observe(section); });
  }

  function initFadeUps() {
    var items = document.querySelectorAll('.fade-up');
    if (!items.length) return;
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    items.forEach(function (el) { io.observe(el); });
  }

  function initStatCounters() {
    var stats = document.querySelectorAll('.stat-number');
    if (!stats.length) return;

    function runCounter(el) {
      if (el.dataset.animated === 'true') return;

      var raw = (el.textContent || '').trim();
      var match = raw.match(/^(\d+)(.*)$/);
      if (!match) return;

      var target = parseInt(match[1], 10);
      var suffix = match[2] || '';
      var duration = 1400;
      var start = 0;
      var startTime = null;

      function tick(ts) {
        if (!startTime) startTime = ts;
        var progress = Math.min((ts - startTime) / duration, 1);
        var current = Math.floor(start + ((target - start) * progress));
        el.textContent = current + suffix;
        if (progress < 1) {
          window.requestAnimationFrame(tick);
        } else {
          el.textContent = target + suffix;
          el.dataset.animated = 'true';
        }
      }

      window.requestAnimationFrame(tick);
    }

    if (!('IntersectionObserver' in window)) {
      stats.forEach(function (el) { runCounter(el); });
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          runCounter(entry.target);
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.35 });

    stats.forEach(function (el) { io.observe(el); });
  }

  function initFaqAccordions() {
    var groups = document.querySelectorAll('[data-faq-group]');
    if (!groups.length) return;

    groups.forEach(function (group) {
      var items = Array.prototype.slice.call(group.querySelectorAll('[data-faq-item]'));
      if (!items.length) return;

      items.forEach(function (item, index) {
        var trigger = item.querySelector('.contact-faq-trigger');
        var panel = item.querySelector('.contact-faq-panel');
        if (!trigger || !panel) return;

        item.style.setProperty('--faq-delay', (index * 70) + 'ms');
        panel.hidden = true;
        panel.style.height = '0px';
        panel.style.opacity = '0';

        trigger.addEventListener('click', function () {
          var isOpen = trigger.getAttribute('aria-expanded') === 'true';

          items.forEach(function (otherItem) {
            if (otherItem !== item) {
              closeFaqItem(otherItem);
            }
          });

          if (isOpen) {
            closeFaqItem(item);
          } else {
            openFaqItem(item);
          }
        });
      });

      revealFaqItems(items);
    });
  }

  function revealFaqItems(items) {
    if (!('IntersectionObserver' in window)) {
      items.forEach(function (item) { item.classList.add('is-visible'); });
      return;
    }

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -8% 0px' });

    items.forEach(function (item) { io.observe(item); });
  }

  function openFaqItem(item) {
    var trigger = item.querySelector('.contact-faq-trigger');
    var panel = item.querySelector('.contact-faq-panel');
    if (!trigger || !panel) return;

    panel.hidden = false;
    panel.style.visibility = 'visible';
    panel.style.height = 'auto';
    var targetHeight = panel.scrollHeight;
    panel.style.height = '0px';
    panel.offsetHeight;
    item.classList.add('is-open');
    trigger.setAttribute('aria-expanded', 'true');
    panel.style.height = targetHeight + 'px';
    panel.style.opacity = '1';

    window.setTimeout(function () {
      if (trigger.getAttribute('aria-expanded') === 'true') {
        panel.style.height = 'auto';
      }
    }, 420);
  }

  function closeFaqItem(item) {
    var trigger = item.querySelector('.contact-faq-trigger');
    var panel = item.querySelector('.contact-faq-panel');
    if (!trigger || !panel || panel.hidden) {
      if (trigger) trigger.setAttribute('aria-expanded', 'false');
      item.classList.remove('is-open');
      return;
    }

    panel.style.height = panel.scrollHeight + 'px';
    panel.offsetHeight;
    item.classList.remove('is-open');
    trigger.setAttribute('aria-expanded', 'false');
    panel.style.height = '0px';
    panel.style.opacity = '0';

    window.setTimeout(function () {
      if (trigger.getAttribute('aria-expanded') === 'false') {
        panel.hidden = true;
        panel.style.visibility = 'hidden';
      }
    }, 420);
  }

  function handleContact(form) {
    var statusEl  = document.getElementById('form-status');
    var submitBtn = form.querySelector('button[type="submit"]');
    var originalButtonLabel = submitBtn ? submitBtn.textContent : '';
    var endpoint = form.getAttribute('data-endpoint') || 'send_mail.php';
    var data = {
      name:    form.querySelector('[name="name"]').value.trim(),
      email:   form.querySelector('[name="email"]').value.trim(),
      subject: form.querySelector('[name="subject"]') ? form.querySelector('[name="subject"]').value.trim() : '',
      message: form.querySelector('[name="message"]').value.trim(),
    };

    if (!data.name || !data.email || !data.message) {
      showStatus(statusEl, 'error', 'Bitte fülle alle Pflichtfelder aus.');
      return;
    }
    if (!isValidEmail(data.email)) {
      showStatus(statusEl, 'error', 'Bitte gib eine gültige E-Mail-Adresse ein.');
      return;
    }

    submitBtn.disabled = true;
    submitBtn.textContent = 'Wird gesendet…';

    fetch(endpoint, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    })
      .then(function (res) { return res.json(); })
      .then(function (json) {
        if (json.ok) {
          showStatus(statusEl, 'success', '✓ Nachricht gesendet! Ich melde mich bald.');
          form.reset();
        } else {
          throw new Error(json.error || 'Unbekannter Fehler');
        }
      })
      .catch(function () {
        showStatus(statusEl, 'error', 'Fehler beim Senden. Bitte versuche es erneut oder schreib direkt an hallo@jasonholweg.de.');
      })
      .finally(function () {
        submitBtn.disabled = false;
        submitBtn.textContent = originalButtonLabel;
      });
  }

  function showStatus(el, type, msg) {
    if (!el) return;
    el.className = 'form-status ' + type;
    el.textContent = msg;
    setTimeout(function () { el.className = 'form-status'; }, 6000);
  }

  function isValidEmail(v) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
  }

})();
