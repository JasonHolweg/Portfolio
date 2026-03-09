/**
 * Portfolio Jason Holweg – Premium Visual Effects
 * Elegant Ribbon & Antigravity animations with Apple-level refinement.
 * 
 * CONFIGURATION:
 * Adjust these values to fine-tune the visual effects.
 */
(function () {
  'use strict';

  /* ════════════════════════════════════════════════════════════
     GLOBAL CONFIGURATION
     ════════════════════════════════════════════════════════════ */
  const CONFIG = {
    // Brand Colors (derived from CSS variables)
    colors: {
      primary: '#ff6b6b',
      secondary: '#a855f7', 
      tertiary: '#4ecdc4',
    },

    // Ribbon Effect Settings
    ribbon: {
      enabled: true,
      count: 3,                    // Number of ribbon strands (keep low for elegance)
      pointCount: 80,              // Points per ribbon (smoothness)
      speed: 0.0003,               // Movement speed (lower = slower, more luxurious)
      amplitude: 0.15,             // Wave amplitude (relative to canvas height)
      thickness: { min: 1, max: 3 }, // Ribbon thickness range
      opacity: 0.12,               // Maximum opacity (keep low for subtlety)
      blur: 40,                    // Gaussian blur amount
      flowDirection: 1,            // 1 = left-to-right, -1 = right-to-left
    },

    // Antigravity Effect Settings
    antigravity: {
      enabled: true,
      particleCount: 24,           // Number of particles (keep minimal for premium feel)
      sizeRange: { min: 2, max: 8 }, // Particle size range
      speedRange: { min: 0.08, max: 0.25 }, // Float speed range
      opacityRange: { min: 0.08, max: 0.35 }, // Opacity range
      driftStrength: 0.3,          // Horizontal drift intensity
      riseStrength: 0.15,          // Vertical rise intensity
      glowIntensity: 0.6,          // Glow strength (0-1)
      blurRange: { min: 0, max: 2 }, // Motion blur range
      interactionRadius: 120,      // Mouse interaction radius
      interactionStrength: 0.02,   // Mouse push strength
    },

    // Performance & Accessibility
    performance: {
      mobileParticleReduction: 0.5,   // Reduce particles on mobile (50%)
      mobileRibbonReduction: 0.66,    // Reduce ribbons on mobile
      lowPowerMode: false,            // Auto-detected
      targetFPS: 60,
      respectReducedMotion: true,
    },

    // Responsive breakpoints
    breakpoints: {
      mobile: 768,
      tablet: 1024,
    },
  };

  /* ════════════════════════════════════════════════════════════
     UTILITY FUNCTIONS
     ════════════════════════════════════════════════════════════ */
  
  function lerp(a, b, t) {
    return a + (b - a) * t;
  }

  function clamp(val, min, max) {
    return Math.min(Math.max(val, min), max);
  }

  function hexToRgba(hex, alpha) {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
  }

  function easeInOutSine(t) {
    return -(Math.cos(Math.PI * t) - 1) / 2;
  }

  function easeOutQuart(t) {
    return 1 - Math.pow(1 - t, 4);
  }

  function randomInRange(min, max) {
    return min + Math.random() * (max - min);
  }

  function isMobile() {
    return window.innerWidth <= CONFIG.breakpoints.mobile;
  }

  function isTablet() {
    return window.innerWidth <= CONFIG.breakpoints.tablet && window.innerWidth > CONFIG.breakpoints.mobile;
  }

  function prefersReducedMotion() {
    return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  }

  /* ════════════════════════════════════════════════════════════
     RIBBON EFFECT
     Elegant flowing ribbons with premium material aesthetics
     ════════════════════════════════════════════════════════════ */
  
  class RibbonEffect {
    constructor(canvas) {
      this.canvas = canvas;
      this.ctx = canvas.getContext('2d');
      this.ribbons = [];
      this.time = 0;
      this.isRunning = false;
      this.animationId = null;

      this.resize();
      this.init();
    }

    init() {
      const cfg = CONFIG.ribbon;
      let count = cfg.count;

      // Reduce for mobile
      if (isMobile()) {
        count = Math.max(1, Math.floor(count * CONFIG.performance.mobileRibbonReduction));
      }

      // Create ribbons with staggered depths
      const colors = [
        { primary: CONFIG.colors.tertiary, secondary: CONFIG.colors.secondary },
        { primary: CONFIG.colors.secondary, secondary: CONFIG.colors.primary },
        { primary: CONFIG.colors.primary, secondary: CONFIG.colors.tertiary },
      ];

      for (let i = 0; i < count; i++) {
        const depth = (i + 1) / count; // 0.33, 0.66, 1.0 for 3 ribbons
        const colorSet = colors[i % colors.length];
        
        this.ribbons.push({
          points: this.generateRibbonPoints(i, count),
          color: colorSet,
          depth: depth,
          phase: (i / count) * Math.PI * 2,
          thickness: lerp(cfg.thickness.min, cfg.thickness.max, depth),
          opacity: cfg.opacity * depth,
          speed: cfg.speed * (0.7 + depth * 0.3),
        });
      }
    }

    generateRibbonPoints(index, total) {
      const cfg = CONFIG.ribbon;
      const points = [];
      const baseY = this.height * (0.3 + (index / total) * 0.4);

      for (let i = 0; i < cfg.pointCount; i++) {
        const t = i / (cfg.pointCount - 1);
        points.push({
          x: t * this.width * 1.4 - this.width * 0.2,
          y: baseY,
          baseY: baseY,
          offsetPhase: t * Math.PI * 2 + index,
        });
      }

      return points;
    }

    resize() {
      const dpr = Math.min(window.devicePixelRatio || 1, 2);
      
      // Get dimensions from the parent wrapper element for accurate sizing
      const wrapper = this.canvas.parentElement;
      const section = wrapper ? wrapper.parentElement : null;
      
      // Use section dimensions if available, otherwise fall back to viewport
      let width, height;
      if (section && section.classList.contains('premium-effects-section')) {
        const rect = section.getBoundingClientRect();
        width = rect.width;
        height = rect.height;
      } else {
        width = window.innerWidth;
        height = window.innerHeight;
      }
      
      // Clamp to maximum dimensions to prevent infinite growth
      width = Math.min(width, 2560);
      height = Math.min(height, 1440);
      
      // Only resize if dimensions actually changed
      if (this.width === width && this.height === height) {
        return;
      }
      
      this.width = width;
      this.height = height;
      
      // Set canvas buffer size with DPR
      this.canvas.width = width * dpr;
      this.canvas.height = height * dpr;
      
      // IMPORTANT: Reset transform before scaling to prevent accumulation
      this.ctx.setTransform(1, 0, 0, 1, 0, 0);
      this.ctx.scale(dpr, dpr);

      // Regenerate ribbons on resize
      if (this.ribbons.length > 0) {
        this.ribbons = [];
        this.init();
      }
    }

    update(deltaTime) {
      const cfg = CONFIG.ribbon;
      this.time += deltaTime;

      this.ribbons.forEach((ribbon, ri) => {
        ribbon.points.forEach((point, pi) => {
          // Multi-frequency wave for organic movement
          const t = this.time * ribbon.speed;
          const wave1 = Math.sin(t * 1000 + point.offsetPhase) * cfg.amplitude * this.height * 0.6;
          const wave2 = Math.sin(t * 600 + point.offsetPhase * 1.5 + ribbon.phase) * cfg.amplitude * this.height * 0.3;
          const wave3 = Math.sin(t * 300 + point.offsetPhase * 0.7) * cfg.amplitude * this.height * 0.15;
          
          point.y = point.baseY + wave1 + wave2 + wave3;

          // Subtle horizontal drift
          const drift = Math.sin(t * 400 + ri) * 10 * ribbon.depth;
          point.x = (pi / (cfg.pointCount - 1)) * this.width * 1.4 - this.width * 0.2 + drift;
        });
      });
    }

    draw() {
      this.ctx.clearRect(0, 0, this.width, this.height);

      this.ribbons.forEach(ribbon => {
        if (ribbon.points.length < 2) return;

        this.ctx.save();

        // Create gradient along ribbon
        const gradient = this.ctx.createLinearGradient(0, 0, this.width, 0);
        gradient.addColorStop(0, hexToRgba(ribbon.color.primary, 0));
        gradient.addColorStop(0.2, hexToRgba(ribbon.color.primary, ribbon.opacity * 0.6));
        gradient.addColorStop(0.5, hexToRgba(ribbon.color.secondary, ribbon.opacity));
        gradient.addColorStop(0.8, hexToRgba(ribbon.color.primary, ribbon.opacity * 0.6));
        gradient.addColorStop(1, hexToRgba(ribbon.color.primary, 0));

        this.ctx.strokeStyle = gradient;
        this.ctx.lineWidth = ribbon.thickness;
        this.ctx.lineCap = 'round';
        this.ctx.lineJoin = 'round';

        // Draw smooth curve through points
        this.ctx.beginPath();
        this.ctx.moveTo(ribbon.points[0].x, ribbon.points[0].y);

        for (let i = 1; i < ribbon.points.length - 2; i++) {
          const p0 = ribbon.points[i];
          const p1 = ribbon.points[i + 1];
          const cpX = (p0.x + p1.x) / 2;
          const cpY = (p0.y + p1.y) / 2;
          this.ctx.quadraticCurveTo(p0.x, p0.y, cpX, cpY);
        }

        // Last segment
        const last = ribbon.points[ribbon.points.length - 1];
        const secondLast = ribbon.points[ribbon.points.length - 2];
        this.ctx.quadraticCurveTo(secondLast.x, secondLast.y, last.x, last.y);

        this.ctx.stroke();
        this.ctx.restore();
      });
    }

    start() {
      if (this.isRunning) return;
      this.isRunning = true;
      this.lastTime = performance.now();
      this.loop();
    }

    loop() {
      if (!this.isRunning) return;

      const now = performance.now();
      const deltaTime = (now - this.lastTime) / 1000;
      this.lastTime = now;

      this.update(deltaTime);
      this.draw();

      this.animationId = requestAnimationFrame(() => this.loop());
    }

    stop() {
      this.isRunning = false;
      if (this.animationId) {
        cancelAnimationFrame(this.animationId);
        this.animationId = null;
      }
    }

    destroy() {
      this.stop();
      this.ribbons = [];
    }
  }

  /* ════════════════════════════════════════════════════════════
     ANTIGRAVITY EFFECT
     Elegant floating particles with magnetic interaction
     ════════════════════════════════════════════════════════════ */
  
  class AntigravityEffect {
    constructor(canvas) {
      this.canvas = canvas;
      this.ctx = canvas.getContext('2d');
      this.particles = [];
      this.mouse = { x: null, y: null, active: false };
      this.isRunning = false;
      this.animationId = null;

      this.resize();
      this.init();
      this.bindEvents();
    }

    init() {
      const cfg = CONFIG.antigravity;
      let count = cfg.particleCount;

      // Reduce for mobile
      if (isMobile()) {
        count = Math.floor(count * CONFIG.performance.mobileParticleReduction);
      } else if (isTablet()) {
        count = Math.floor(count * 0.75);
      }

      // Generate color palette from brand gradient
      const colorStops = this.generateColorPalette();

      for (let i = 0; i < count; i++) {
        this.particles.push(this.createParticle(colorStops, i, count));
      }
    }

    generateColorPalette() {
      // Create smooth gradient stops between brand colors
      const colors = [];
      const brandColors = [
        CONFIG.colors.primary,
        CONFIG.colors.secondary,
        CONFIG.colors.tertiary,
      ];

      // Generate 12 intermediate color stops
      for (let i = 0; i < 12; i++) {
        const t = i / 11;
        const colorIndex = t * (brandColors.length - 1);
        const idx = Math.floor(colorIndex);
        const frac = colorIndex - idx;
        
        if (idx >= brandColors.length - 1) {
          colors.push(brandColors[brandColors.length - 1]);
        } else {
          colors.push(this.lerpColor(brandColors[idx], brandColors[idx + 1], frac));
        }
      }

      return colors;
    }

    lerpColor(color1, color2, t) {
      const r1 = parseInt(color1.slice(1, 3), 16);
      const g1 = parseInt(color1.slice(3, 5), 16);
      const b1 = parseInt(color1.slice(5, 7), 16);
      const r2 = parseInt(color2.slice(1, 3), 16);
      const g2 = parseInt(color2.slice(3, 5), 16);
      const b2 = parseInt(color2.slice(5, 7), 16);

      const r = Math.round(lerp(r1, r2, t));
      const g = Math.round(lerp(g1, g2, t));
      const b = Math.round(lerp(b1, b2, t));

      return `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
    }

    createParticle(colors, index, total) {
      const cfg = CONFIG.antigravity;
      const depth = 0.3 + Math.random() * 0.7; // Depth layer (0.3 to 1.0)
      
      // Distribute particles with some clustering bias toward center
      const centerBias = 0.3;
      let x, y;
      
      if (Math.random() < centerBias) {
        // Cluster toward center
        x = this.width * 0.3 + Math.random() * this.width * 0.4;
        y = this.height * 0.2 + Math.random() * this.height * 0.6;
      } else {
        // Random distribution
        x = Math.random() * this.width;
        y = Math.random() * this.height;
      }

      return {
        x: x,
        y: y,
        originalX: x,
        originalY: y,
        size: lerp(cfg.sizeRange.min, cfg.sizeRange.max, depth),
        color: colors[Math.floor(Math.random() * colors.length)],
        opacity: lerp(cfg.opacityRange.min, cfg.opacityRange.max, depth),
        depth: depth,
        speed: lerp(cfg.speedRange.max, cfg.speedRange.min, depth), // Deeper = slower
        phase: Math.random() * Math.PI * 2,
        phaseSpeed: 0.0005 + Math.random() * 0.001,
        driftPhase: Math.random() * Math.PI * 2,
        blur: lerp(cfg.blurRange.max, cfg.blurRange.min, depth),
        glowSize: lerp(cfg.sizeRange.min * 2, cfg.sizeRange.max * 3, depth),
      };
    }

    bindEvents() {
      // Mouse tracking with throttling
      let throttleTimer = null;
      
      this.canvas.addEventListener('mousemove', (e) => {
        if (throttleTimer) return;
        throttleTimer = setTimeout(() => { throttleTimer = null; }, 16);
        
        const rect = this.canvas.getBoundingClientRect();
        this.mouse.x = e.clientX - rect.left;
        this.mouse.y = e.clientY - rect.top;
        this.mouse.active = true;
      });

      this.canvas.addEventListener('mouseleave', () => {
        this.mouse.active = false;
      });

      // Touch support
      this.canvas.addEventListener('touchmove', (e) => {
        if (e.touches.length > 0) {
          const rect = this.canvas.getBoundingClientRect();
          this.mouse.x = e.touches[0].clientX - rect.left;
          this.mouse.y = e.touches[0].clientY - rect.top;
          this.mouse.active = true;
        }
      }, { passive: true });

      this.canvas.addEventListener('touchend', () => {
        this.mouse.active = false;
      });
    }

    resize() {
      const dpr = Math.min(window.devicePixelRatio || 1, 2);
      
      // Get dimensions from the parent wrapper element for accurate sizing
      const wrapper = this.canvas.parentElement;
      const section = wrapper ? wrapper.parentElement : null;
      
      // Use section dimensions if available, otherwise fall back to viewport
      let width, height;
      if (section && section.classList.contains('premium-effects-section')) {
        const rect = section.getBoundingClientRect();
        width = rect.width;
        height = rect.height;
      } else {
        width = window.innerWidth;
        height = window.innerHeight;
      }
      
      // Clamp to maximum dimensions to prevent infinite growth
      width = Math.min(width, 2560);
      height = Math.min(height, 1440);
      
      const oldWidth = this.width || width;
      const oldHeight = this.height || height;
      
      // Only resize if dimensions actually changed
      if (this.width === width && this.height === height) {
        return;
      }
      
      this.width = width;
      this.height = height;
      
      // Set canvas buffer size with DPR
      this.canvas.width = width * dpr;
      this.canvas.height = height * dpr;
      
      // IMPORTANT: Reset transform before scaling to prevent accumulation
      this.ctx.setTransform(1, 0, 0, 1, 0, 0);
      this.ctx.scale(dpr, dpr);

      // Update particle positions proportionally
      if (this.particles.length > 0) {
        this.particles.forEach(p => {
          p.x = (p.x / oldWidth) * this.width;
          p.y = (p.y / oldHeight) * this.height;
          p.originalX = (p.originalX / oldWidth) * this.width;
          p.originalY = (p.originalY / oldHeight) * this.height;
          p._containerWidth = this.width;
          p._containerHeight = this.height;
        });
      }
    }

    update(deltaTime, time) {
      const cfg = CONFIG.antigravity;

      this.particles.forEach(p => {
        // Organic floating motion
        p.phase += p.phaseSpeed * deltaTime * 1000;
        p.driftPhase += p.phaseSpeed * deltaTime * 500;

        // Vertical rise (antigravity)
        const rise = Math.sin(p.phase) * cfg.riseStrength * p.speed * deltaTime * 100;
        p.y -= rise + (p.speed * cfg.riseStrength * deltaTime * 30);

        // Horizontal drift
        const drift = Math.sin(p.driftPhase) * cfg.driftStrength * deltaTime * 50;
        p.x += drift;

        // Mouse interaction (gentle push)
        if (this.mouse.active && this.mouse.x != null) {
          const dx = p.x - this.mouse.x;
          const dy = p.y - this.mouse.y;
          const dist = Math.sqrt(dx * dx + dy * dy);
          
          if (dist < cfg.interactionRadius) {
            const force = (1 - dist / cfg.interactionRadius) * cfg.interactionStrength;
            const angle = Math.atan2(dy, dx);
            p.x += Math.cos(angle) * force * deltaTime * 1000;
            p.y += Math.sin(angle) * force * deltaTime * 1000;
          }
        }

        // Wrap around edges with smooth transition
        const margin = p.size * 2;
        if (p.y < -margin) {
          p.y = this.height + margin;
          p.x = Math.random() * this.width;
        }
        if (p.x < -margin) p.x = this.width + margin;
        if (p.x > this.width + margin) p.x = -margin;
      });
    }

    draw() {
      this.ctx.clearRect(0, 0, this.width, this.height);

      // Sort by depth for proper layering
      const sorted = [...this.particles].sort((a, b) => a.depth - b.depth);

      sorted.forEach(p => {
        this.ctx.save();

        // Apply blur for depth
        if (p.blur > 0) {
          this.ctx.filter = `blur(${p.blur}px)`;
        }

        // Outer glow
        const glowGradient = this.ctx.createRadialGradient(
          p.x, p.y, 0,
          p.x, p.y, p.glowSize
        );
        glowGradient.addColorStop(0, hexToRgba(p.color, p.opacity * CONFIG.antigravity.glowIntensity * 0.5));
        glowGradient.addColorStop(0.5, hexToRgba(p.color, p.opacity * CONFIG.antigravity.glowIntensity * 0.15));
        glowGradient.addColorStop(1, hexToRgba(p.color, 0));

        this.ctx.fillStyle = glowGradient;
        this.ctx.beginPath();
        this.ctx.arc(p.x, p.y, p.glowSize, 0, Math.PI * 2);
        this.ctx.fill();

        // Core particle
        this.ctx.filter = 'none';
        const coreGradient = this.ctx.createRadialGradient(
          p.x - p.size * 0.2, p.y - p.size * 0.2, 0,
          p.x, p.y, p.size
        );
        coreGradient.addColorStop(0, hexToRgba('#ffffff', p.opacity * 0.8));
        coreGradient.addColorStop(0.3, hexToRgba(p.color, p.opacity));
        coreGradient.addColorStop(1, hexToRgba(p.color, p.opacity * 0.3));

        this.ctx.fillStyle = coreGradient;
        this.ctx.beginPath();
        this.ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
        this.ctx.fill();

        this.ctx.restore();
      });
    }

    start() {
      if (this.isRunning) return;
      this.isRunning = true;
      this.lastTime = performance.now();
      this.loop();
    }

    loop() {
      if (!this.isRunning) return;

      const now = performance.now();
      const deltaTime = (now - this.lastTime) / 1000;
      this.lastTime = now;

      this.update(deltaTime, now);
      this.draw();

      this.animationId = requestAnimationFrame(() => this.loop());
    }

    stop() {
      this.isRunning = false;
      if (this.animationId) {
        cancelAnimationFrame(this.animationId);
        this.animationId = null;
      }
    }

    destroy() {
      this.stop();
      this.particles = [];
    }
  }

  /* ════════════════════════════════════════════════════════════
     PREMIUM EFFECTS MANAGER
     Orchestrates all effects with lifecycle management
     ════════════════════════════════════════════════════════════ */
  
  class PremiumEffectsManager {
    constructor() {
      this.ribbon = null;
      this.antigravity = null;
      this.isInitialized = false;
      this.resizeDebounce = null;
    }

    init() {
      // Respect reduced motion preference
      if (CONFIG.performance.respectReducedMotion && prefersReducedMotion()) {
        console.log('PremiumEffects: Reduced motion preferred, effects disabled.');
        return;
      }

      // Initialize Ribbon Effect
      const ribbonCanvas = document.getElementById('premium-ribbon-canvas');
      if (ribbonCanvas && CONFIG.ribbon.enabled) {
        this.ribbon = new RibbonEffect(ribbonCanvas);
        this.ribbon.start();
      }

      // Initialize Antigravity Effect
      const antigravityCanvas = document.getElementById('premium-antigravity-canvas');
      if (antigravityCanvas && CONFIG.antigravity.enabled) {
        this.antigravity = new AntigravityEffect(antigravityCanvas);
        this.antigravity.start();
      }

      // Handle resize
      window.addEventListener('resize', () => this.handleResize());

      // Handle visibility change (pause when tab is hidden)
      document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
          this.pause();
        } else {
          this.resume();
        }
      });

      this.isInitialized = true;
    }

    handleResize() {
      clearTimeout(this.resizeDebounce);
      this.resizeDebounce = setTimeout(() => {
        if (this.ribbon) this.ribbon.resize();
        if (this.antigravity) this.antigravity.resize();
      }, 150);
    }

    pause() {
      if (this.ribbon) this.ribbon.stop();
      if (this.antigravity) this.antigravity.stop();
    }

    resume() {
      if (this.ribbon) this.ribbon.start();
      if (this.antigravity) this.antigravity.start();
    }

    destroy() {
      if (this.ribbon) this.ribbon.destroy();
      if (this.antigravity) this.antigravity.destroy();
      this.isInitialized = false;
    }

    // Public API for parameter adjustments
    updateRibbonConfig(newConfig) {
      Object.assign(CONFIG.ribbon, newConfig);
      if (this.ribbon) {
        this.ribbon.destroy();
        const canvas = document.getElementById('premium-ribbon-canvas');
        if (canvas) {
          this.ribbon = new RibbonEffect(canvas);
          this.ribbon.start();
        }
      }
    }

    updateAntigravityConfig(newConfig) {
      Object.assign(CONFIG.antigravity, newConfig);
      if (this.antigravity) {
        this.antigravity.destroy();
        const canvas = document.getElementById('premium-antigravity-canvas');
        if (canvas) {
          this.antigravity = new AntigravityEffect(canvas);
          this.antigravity.start();
        }
      }
    }
  }

  /* ════════════════════════════════════════════════════════════
     INITIALIZATION
     ════════════════════════════════════════════════════════════ */
  
  // Create global instance
  window.PremiumEffects = new PremiumEffectsManager();

  // Auto-initialize when DOM is ready and intro is complete
  function waitForIntroComplete() {
    const intro = document.getElementById('intro');
    const mainContent = document.getElementById('main-content');
    
    // If no intro (about page, etc.), start after a short delay to ensure CSS is applied
    if (!intro) {
      // Use requestAnimationFrame to ensure DOM is painted
      requestAnimationFrame(() => {
        setTimeout(() => window.PremiumEffects.init(), 100);
      });
      return;
    }

    // Wait for intro to be hidden or main content to be visible
    const checkIntro = () => {
      const introHidden = intro.classList.contains('hide') || 
                          intro.style.display === 'none' ||
                          getComputedStyle(intro).visibility === 'hidden';
      const mainVisible = mainContent && parseFloat(getComputedStyle(mainContent).opacity) > 0.5;
      
      if (introHidden || mainVisible) {
        // Small delay for smooth transition after intro
        setTimeout(() => window.PremiumEffects.init(), 300);
      } else {
        requestAnimationFrame(checkIntro);
      }
    };
    
    // Start checking after a reasonable delay
    setTimeout(checkIntro, 500);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', waitForIntroComplete);
  } else {
    waitForIntroComplete();
  }

})();
