/**
 * Portfolio Jason Holweg – Intro Animation
 * Colorful glass geometric shapes that float and morph into the title text.
 */
(function () {
  'use strict';

  /* ── Config ──────────────────────────────────────────────── */
  const FLOAT_DURATION   = 2800;   // ms before converge starts
  const CONVERGE_DURATION = 1200;  // ms for convergence
  const TEXT_DELAY       = 400;    // ms after converge before text appears
  const INTRO_HOLD       = 2400;   // ms to hold intro after text appears
  const FADE_OUT_DURATION = 900;   // ms for overlay fade out

  const SHAPE_COUNT = 7;
  const PALETTES = [
    ['#ff6b6b', '#ff0080'],  // coral → hot-pink
    ['#4ecdc4', '#00d2ff'],  // teal → sky
    ['#a855f7', '#7b2fbe'],  // violet → purple
    ['#fbbf24', '#f97316'],  // amber → orange
    ['#10b981', '#00f260'],  // emerald → green
    ['#3b82f6', '#0ea5e9'],  // blue → cyan
    ['#f472b6', '#e11d48'],  // pink → crimson
  ];
  const TYPES = ['circle', 'triangle', 'hexagon', 'diamond', 'square', 'pentagon', 'star'];

  /* ── State ───────────────────────────────────────────────── */
  let canvas, ctx, W, H, raf;
  let shapes = [];
  let phase  = 'idle';   // idle → float → converge → done
  let phaseStart = 0;
  let skipCalled = false;

  /* ── Init ────────────────────────────────────────────────── */
  function init() {
    canvas = document.getElementById('intro-canvas');
    if (!canvas) return;

    ctx = canvas.getContext('2d');
    resize();
    window.addEventListener('resize', resize);

    buildShapes();
    phase = 'float';
    phaseStart = performance.now();

    raf = requestAnimationFrame(loop);

    // Auto-advance timeline
    setTimeout(startConverge, FLOAT_DURATION);

    // Skip button
    var skipBtn = document.getElementById('skip-btn');
    if (skipBtn) {
      skipBtn.addEventListener('click', function () { skip(); });
    }

    // Click anywhere to skip after a short grace period
    setTimeout(function () {
      document.getElementById('intro').addEventListener('click', function (e) {
        if (e.target.id !== 'skip-btn') skip();
      }, { once: true });
    }, 1200);
  }

  function resize() {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }

  /* ── Shape factory ───────────────────────────────────────── */
  function buildShapes() {
    shapes = [];
    for (var i = 0; i < SHAPE_COUNT; i++) {
      var pal  = PALETTES[i % PALETTES.length];
      var type = TYPES[i % TYPES.length];
      var size = 55 + Math.random() * 45;
      shapes.push({
        type,
        x:    Math.random() * W,
        y:    Math.random() * H,
        size,
        col1: pal[0],
        col2: pal[1],
        vx:   (Math.random() - 0.5) * 1.6,
        vy:   (Math.random() - 0.5) * 1.6,
        rot:  Math.random() * Math.PI * 2,
        rotV: (Math.random() - 0.5) * 0.025,
        alpha: 0,
        targetX: W / 2,
        targetY: H / 2,
      });
    }

    // Stagger fade-in
    shapes.forEach(function (s, i) {
      setTimeout(function () { s._fadeIn = true; }, i * 160);
    });
  }

  /* ── Main loop ───────────────────────────────────────────── */
  function loop(ts) {
    ctx.clearRect(0, 0, W, H);

    var elapsed = ts - phaseStart;
    var t = 0;

    shapes.forEach(function (s) {
      // Fade in
      if (s._fadeIn && s.alpha < 0.92) {
        s.alpha = Math.min(s.alpha + 0.018, 0.92);
      }

      if (phase === 'float') {
        s.x += s.vx;
        s.y += s.vy;
        s.rot += s.rotV;
        // wrap around
        if (s.x < -s.size - 20) s.x = W + s.size;
        if (s.x > W + s.size + 20) s.x = -s.size;
        if (s.y < -s.size - 20) s.y = H + s.size;
        if (s.y > H + s.size + 20) s.y = -s.size;

      } else if (phase === 'converge') {
        t = Math.min(elapsed / CONVERGE_DURATION, 1);
        var ease = easeInOutQuart(t);
        s.x += (s.targetX - s.x) * ease * 0.09;
        s.y += (s.targetY - s.y) * ease * 0.09;
        s.rot += s.rotV * (1 + t * 5);
        s.size = Math.max(s.size - 0.35, 4);
        if (t > 0.85) s.alpha = s.alpha * 0.93;
      }

      draw(s);
    });

    raf = requestAnimationFrame(loop);
  }

  /* ── Drawing ─────────────────────────────────────────────── */
  function draw(s) {
    if (s.alpha < 0.01) return;
    ctx.save();
    ctx.globalAlpha = s.alpha;
    ctx.translate(s.x, s.y);
    ctx.rotate(s.rot);

    // Gradient fill
    var g = ctx.createRadialGradient(0, 0, 0, 0, 0, s.size);
    g.addColorStop(0, hexA(s.col1, 0.72));
    g.addColorStop(0.6, hexA(s.col2, 0.38));
    g.addColorStop(1, hexA(s.col2, 0.04));

    // Glow
    ctx.shadowColor = s.col1;
    ctx.shadowBlur  = 28;

    ctx.beginPath();
    buildPath(s.type, s.size);
    ctx.fillStyle = g;
    ctx.fill();

    // Glass border
    ctx.shadowBlur = 0;
    ctx.strokeStyle = hexA(s.col1, 0.55);
    ctx.lineWidth = 1.5;
    ctx.stroke();

    // Inner highlight (simulates glass refraction)
    ctx.beginPath();
    buildPath(s.type, s.size * 0.65);
    ctx.strokeStyle = hexA('#ffffff', 0.12);
    ctx.lineWidth = 1;
    ctx.stroke();

    ctx.restore();
  }

  function buildPath(type, r) {
    switch (type) {
      case 'circle':
        ctx.arc(0, 0, r, 0, Math.PI * 2);
        break;
      case 'triangle':
        polygon(3, r);
        break;
      case 'square':
        polygon(4, r);
        break;
      case 'pentagon':
        polygon(5, r);
        break;
      case 'hexagon':
        polygon(6, r);
        break;
      case 'diamond':
        ctx.moveTo(0, -r);
        ctx.lineTo(r * 0.65, 0);
        ctx.lineTo(0, r);
        ctx.lineTo(-r * 0.65, 0);
        ctx.closePath();
        break;
      case 'star':
        star(5, r, r * 0.45);
        break;
      default:
        ctx.arc(0, 0, r, 0, Math.PI * 2);
    }
  }

  function polygon(n, r) {
    var step = (Math.PI * 2) / n;
    var start = -Math.PI / 2;
    ctx.moveTo(Math.cos(start) * r, Math.sin(start) * r);
    for (var i = 1; i < n; i++) {
      var a = start + step * i;
      ctx.lineTo(Math.cos(a) * r, Math.sin(a) * r);
    }
    ctx.closePath();
  }

  function star(n, outerR, innerR) {
    var step = Math.PI / n;
    ctx.moveTo(0, -outerR);
    for (var i = 0; i < n * 2; i++) {
      var r = (i % 2 === 0) ? outerR : innerR;
      var a = -Math.PI / 2 + step * i;
      ctx.lineTo(Math.cos(a) * r, Math.sin(a) * r);
    }
    ctx.closePath();
  }

  /* ── Phase transitions ───────────────────────────────────── */
  function startConverge() {
    if (phase === 'done') return;
    phase = 'converge';
    phaseStart = performance.now();

    setTimeout(showText, CONVERGE_DURATION + TEXT_DELAY);
  }

  function showText() {
    if (phase === 'done') return;
    phase = 'done';

    cancelAnimationFrame(raf);
    canvas.style.transition = 'opacity 0.5s';
    canvas.style.opacity = '0';

    var introText = document.getElementById('intro-text');
    if (introText) {
      introText.classList.add('show');
    }

    setTimeout(dismissIntro, INTRO_HOLD);
  }

  function dismissIntro() {
    var introEl = document.getElementById('intro');
    if (!introEl) return;
    introEl.classList.add('hide');

    setTimeout(function () {
      introEl.style.display = 'none';
      revealMain();
    }, FADE_OUT_DURATION);
  }

  function revealMain() {
    var main = document.getElementById('main-content');
    if (main) {
      main.style.transition = 'opacity 0.6s';
      main.style.opacity = '1';
    }
    triggerFadeUps();
  }

  /* ── Skip ────────────────────────────────────────────────── */
  function skip() {
    if (skipCalled) return;
    skipCalled = true;
    cancelAnimationFrame(raf);
    var introEl = document.getElementById('intro');
    if (introEl) {
      introEl.classList.add('hide');
      setTimeout(function () {
        introEl.style.display = 'none';
        revealMain();
      }, FADE_OUT_DURATION);
    }
  }

  /* ── Helpers ─────────────────────────────────────────────── */
  function easeInOutQuart(t) {
    return t < 0.5 ? 8 * t * t * t * t : 1 - Math.pow(-2 * t + 2, 4) / 2;
  }

  function hexA(hex, alpha) {
    var r = parseInt(hex.slice(1, 3), 16);
    var g = parseInt(hex.slice(3, 5), 16);
    var b = parseInt(hex.slice(5, 7), 16);
    return 'rgba(' + r + ',' + g + ',' + b + ',' + alpha + ')';
  }

  /* ── Scroll-triggered fade-ups ───────────────────────────── */
  function triggerFadeUps() {
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

  /* ── Bootstrap ───────────────────────────────────────────── */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
