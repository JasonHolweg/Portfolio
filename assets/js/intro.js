/**
 * Portfolio Jason Holweg – Intro Animation
 * Clean, premium intro with ribbon effect background and elegant text reveal.
 */
(function () {
  'use strict';

  /* ══════════════════════════════════════════════════════════
     CONFIG
  ══════════════════════════════════════════════════════════ */
  const CONFIG = {
    // Timing
    textShowDelay: 300,      // ms before text starts appearing
    introHold: 2200,         // ms to hold intro after text appears
    fadeOutDuration: 800,    // ms for overlay fade out

    // Ribbon Effect
    ribbon: {
      count: 4,
      pointCount: 60,
      speed: 0.0004,
      amplitude: 0.18,
      thickness: { min: 2, max: 5 },
      opacity: 0.2,
    },

    // Colors
    colors: {
      primary: '#ff6b6b',
      secondary: '#a855f7',
      tertiary: '#4ecdc4',
    },
  };

  const INTRO_STORAGE_KEY = 'jh_intro_seen';

  /* ══════════════════════════════════════════════════════════
     STATE
  ══════════════════════════════════════════════════════════ */
  let canvas, ctx, W, H, raf;
  let ribbons = [];
  let time = 0;
  let isRunning = true;
  let skipCalled = false;

  /* ══════════════════════════════════════════════════════════
     UTILITIES
  ══════════════════════════════════════════════════════════ */
  function lerp(a, b, t) {
    return a + (b - a) * t;
  }

  function hexToRgba(hex, alpha) {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
  }

  /* ══════════════════════════════════════════════════════════
     RIBBON EFFECT
  ══════════════════════════════════════════════════════════ */
  function initRibbons() {
    ribbons = [];
    const cfg = CONFIG.ribbon;
    const colors = [
      { primary: CONFIG.colors.tertiary, secondary: CONFIG.colors.secondary },
      { primary: CONFIG.colors.secondary, secondary: CONFIG.colors.primary },
      { primary: CONFIG.colors.primary, secondary: CONFIG.colors.tertiary },
      { primary: CONFIG.colors.secondary, secondary: CONFIG.colors.tertiary },
    ];

    for (let i = 0; i < cfg.count; i++) {
      const depth = (i + 1) / cfg.count;
      const baseY = H * (0.25 + (i / cfg.count) * 0.5);
      const points = [];

      for (let j = 0; j < cfg.pointCount; j++) {
        const t = j / (cfg.pointCount - 1);
        points.push({
          x: t * W * 1.4 - W * 0.2,
          y: baseY,
          baseY: baseY,
          offsetPhase: t * Math.PI * 2 + i,
        });
      }

      ribbons.push({
        points,
        color: colors[i % colors.length],
        depth,
        phase: (i / cfg.count) * Math.PI * 2,
        thickness: lerp(cfg.thickness.min, cfg.thickness.max, depth),
        opacity: cfg.opacity * depth,
        speed: cfg.speed * (0.7 + depth * 0.3),
      });
    }
  }

  function updateRibbons(deltaTime) {
    const cfg = CONFIG.ribbon;
    time += deltaTime;

    ribbons.forEach((ribbon, ri) => {
      ribbon.points.forEach((point, pi) => {
        const t = time * ribbon.speed;
        const wave1 = Math.sin(t * 1000 + point.offsetPhase) * cfg.amplitude * H * 0.5;
        const wave2 = Math.sin(t * 600 + point.offsetPhase * 1.5 + ribbon.phase) * cfg.amplitude * H * 0.25;
        const wave3 = Math.sin(t * 300 + point.offsetPhase * 0.7) * cfg.amplitude * H * 0.12;

        point.y = point.baseY + wave1 + wave2 + wave3;

        const drift = Math.sin(t * 400 + ri) * 15 * ribbon.depth;
        point.x = (pi / (cfg.pointCount - 1)) * W * 1.4 - W * 0.2 + drift;
      });
    });
  }

  function drawRibbons() {
    ctx.clearRect(0, 0, W, H);

    ribbons.forEach(ribbon => {
      if (ribbon.points.length < 2) return;

      ctx.save();

      // Create gradient along ribbon
      const gradient = ctx.createLinearGradient(0, 0, W, 0);
      gradient.addColorStop(0, hexToRgba(ribbon.color.primary, 0));
      gradient.addColorStop(0.15, hexToRgba(ribbon.color.primary, ribbon.opacity * 0.5));
      gradient.addColorStop(0.5, hexToRgba(ribbon.color.secondary, ribbon.opacity));
      gradient.addColorStop(0.85, hexToRgba(ribbon.color.primary, ribbon.opacity * 0.5));
      gradient.addColorStop(1, hexToRgba(ribbon.color.primary, 0));

      ctx.strokeStyle = gradient;
      ctx.lineWidth = ribbon.thickness;
      ctx.lineCap = 'round';
      ctx.lineJoin = 'round';

      // Draw smooth curve
      ctx.beginPath();
      ctx.moveTo(ribbon.points[0].x, ribbon.points[0].y);

      for (let i = 1; i < ribbon.points.length - 2; i++) {
        const p0 = ribbon.points[i];
        const p1 = ribbon.points[i + 1];
        const cpX = (p0.x + p1.x) / 2;
        const cpY = (p0.y + p1.y) / 2;
        ctx.quadraticCurveTo(p0.x, p0.y, cpX, cpY);
      }

      const last = ribbon.points[ribbon.points.length - 1];
      const secondLast = ribbon.points[ribbon.points.length - 2];
      ctx.quadraticCurveTo(secondLast.x, secondLast.y, last.x, last.y);

      ctx.stroke();
      ctx.restore();
    });
  }

  /* ══════════════════════════════════════════════════════════
     ANIMATION LOOP
  ══════════════════════════════════════════════════════════ */
  let lastTime = 0;

  function loop(timestamp) {
    if (!isRunning) return;

    const deltaTime = lastTime ? (timestamp - lastTime) / 1000 : 0.016;
    lastTime = timestamp;

    updateRibbons(deltaTime);
    drawRibbons();

    raf = requestAnimationFrame(loop);
  }

  /* ══════════════════════════════════════════════════════════
     INTRO FLOW
  ══════════════════════════════════════════════════════════ */
  function init() {
    if (shouldSkipIntro()) {
      skipIntroImmediately();
      return;
    }

    canvas = document.getElementById('intro-canvas');
    if (!canvas) return;

    ctx = canvas.getContext('2d');
    resize();
    window.addEventListener('resize', resize);

    // Initialize ribbon effect
    initRibbons();

    // Start animation
    raf = requestAnimationFrame(loop);

    // Show text after short delay
    setTimeout(showText, CONFIG.textShowDelay);

    // Setup skip functionality
    const skipBtn = document.getElementById('skip-btn');
    if (skipBtn) {
      skipBtn.addEventListener('click', skip);
    }

    // Click anywhere to skip
    setTimeout(() => {
      const intro = document.getElementById('intro');
      if (intro) {
        intro.addEventListener('click', (e) => {
          if (e.target.id !== 'skip-btn') skip();
        }, { once: true });
      }
    }, 800);
  }

  function resize() {
    W = canvas.width = window.innerWidth;
    H = canvas.height = window.innerHeight;

    // Reinitialize ribbons on resize
    if (ribbons.length > 0) {
      initRibbons();
    }
  }

  function showText() {
    const introText = document.getElementById('intro-text');
    if (introText) {
      introText.classList.add('show');
    }

    // Schedule intro dismissal
    setTimeout(dismissIntro, CONFIG.introHold);
  }

  function dismissIntro() {
    if (skipCalled) return;

    markIntroSeen();

    const introEl = document.getElementById('intro');
    if (!introEl) return;

    // Fade out
    introEl.classList.add('hide');

    setTimeout(() => {
      isRunning = false;
      cancelAnimationFrame(raf);
      introEl.style.display = 'none';
      revealMain();
    }, CONFIG.fadeOutDuration);
  }

  function revealMain() {
    const main = document.getElementById('main-content');
    if (main) {
      main.style.transition = 'opacity 0.6s ease';
      main.style.opacity = '1';
    }
    triggerFadeUps();
  }

  function skip() {
    if (skipCalled) return;
    skipCalled = true;

    markIntroSeen();

    isRunning = false;
    cancelAnimationFrame(raf);

    const introEl = document.getElementById('intro');
    if (introEl) {
      introEl.classList.add('hide');
      setTimeout(() => {
        introEl.style.display = 'none';
        revealMain();
      }, CONFIG.fadeOutDuration);
    }
  }

  function shouldSkipIntro() {
    return hasSeenIntro() || hasTargetHash();
  }

  function hasSeenIntro() {
    try {
      return window.localStorage.getItem(INTRO_STORAGE_KEY) === 'true';
    } catch (err) {
      return false;
    }
  }

  function markIntroSeen() {
    try {
      window.localStorage.setItem(INTRO_STORAGE_KEY, 'true');
    } catch (err) {
      // Ignore storage access issues and fall back to default intro behavior.
    }
  }

  function hasTargetHash() {
    if (!window.location.hash) return false;

    const targetId = window.location.hash.slice(1);
    return Boolean(targetId && document.getElementById(targetId));
  }

  function skipIntroImmediately() {
    markIntroSeen();

    const introEl = document.getElementById('intro');
    if (introEl) {
      introEl.classList.add('hide');
      introEl.style.display = 'none';
    }

    revealMain();
  }

  /* ══════════════════════════════════════════════════════════
     FADE-UP OBSERVER
  ══════════════════════════════════════════════════════════ */
  function triggerFadeUps() {
    const items = document.querySelectorAll('.fade-up');
    if (!items.length) return;

    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });

    items.forEach((el) => io.observe(el));
  }

  /* ══════════════════════════════════════════════════════════
     BOOTSTRAP
  ══════════════════════════════════════════════════════════ */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
