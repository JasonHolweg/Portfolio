# Ribbon Effect mit Gradient Farben

## Beschreibung
Ein animierter Ribbon (Band) Effekt mit welligen Bewegungen und linearen Gradienten. Multiple überlagerte Bänder mit verschiedenen Farben, Phasen und Tiefenwerten erzeugen einen eleganten, fließenden Hintergrund.

**Ideal für:**
- Portfolio/Hero-Intros
- Fancy Hintergründe
- Loading Screens
- Animierte Landing Pages

---

## HTML Setup

```html
<div id="intro">
  <canvas id="intro-canvas"></canvas>
  <div id="intro-text">
    <!-- Dein Text hier -->
  </div>
</div>
```

---

## CSS

```css
#intro {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1000;
  background: #0a0a0a;
}

#intro-canvas {
  display: block;
  width: 100%;
  height: 100%;
}

#intro-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  opacity: 0;
  transition: opacity 0.6s ease-out;
}

#intro-text.show {
  opacity: 1;
}

#intro.hide {
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.8s ease-out;
}
```

---

## JavaScript

```javascript
/**
 * Ribbon Effect Animation
 * Konfigurierbar für verschiedene Use Cases
 */
(function () {
  'use strict';

  /* ═══════════════════════════════════════════════════════
     KONFIGURATION – HIER ANPASSEN!
  ═══════════════════════════════════════════════════════ */
  const CONFIG = {
    // Timing (in Millisekunden)
    textShowDelay: 300,      // Verzögerung bis Text erscheint
    introHold: 2200,         // Wie lange Intro sichtbar bleibt
    fadeOutDuration: 800,    // Fade-out Dauer

    // Ribbon Effect Parameter
    ribbon: {
      count: 4,              // Anzahl der Bänder
      pointCount: 60,        // Punkte pro Band (höher = glatter)
      speed: 0.0004,         // Animations-Geschwindigkeit
      amplitude: 0.18,       // Wellenföhe (0-1)
      thickness: { min: 2, max: 5 },  // Band-Dicke Range
      opacity: 0.2,          // Transparenz (0-1)
    },

    // Gradient Farben (HEX)
    colors: {
      primary: '#ff6b6b',    // Rot
      secondary: '#a855f7',  // Lila/Purple
      tertiary: '#4ecdc4',   // Türkis/Cyan
    },
  };

  let canvas, ctx, W, H, raf;
  let ribbons = [];
  let time = 0;
  let isRunning = true;

  /* ═══════════════════════════════════════════════════════
     UTILITIES
  ═══════════════════════════════════════════════════════ */
  function lerp(a, b, t) {
    return a + (b - a) * t;
  }

  function hexToRgba(hex, alpha) {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
  }

  /* ═══════════════════════════════════════════════════════
     RIBBON EFFECT – INITIALISIERUNG
  ═══════════════════════════════════════════════════════ */
  function initRibbons() {
    ribbons = [];
    const cfg = CONFIG.ribbon;
    
    // Farbkombinationen pro Band
    const colors = [
      { primary: CONFIG.colors.tertiary, secondary: CONFIG.colors.secondary },
      { primary: CONFIG.colors.secondary, secondary: CONFIG.colors.primary },
      { primary: CONFIG.colors.primary, secondary: CONFIG.colors.tertiary },
      { primary: CONFIG.colors.secondary, secondary: CONFIG.colors.tertiary },
    ];

    for (let i = 0; i < cfg.count; i++) {
      const depth = (i + 1) / cfg.count;  // 0.25, 0.5, 0.75, 1
      const baseY = H * (0.25 + (i / cfg.count) * 0.5);  // Vertikal gestaffelt
      const points = [];

      // Punkte für Bezier-Kurven
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

  /* ═══════════════════════════════════════════════════════
     RIBBON EFFECT – UPDATE (Sine-Wellen)
  ═══════════════════════════════════════════════════════ */
  function updateRibbons(deltaTime) {
    const cfg = CONFIG.ribbon;
    time += deltaTime;

    ribbons.forEach((ribbon, ri) => {
      ribbon.points.forEach((point) => {
        const t = time * ribbon.speed;
        
        // Mehrere überlagerte Sine-Wellen für organische Bewegung
        const wave1 = Math.sin(t * 1000 + point.offsetPhase) * cfg.amplitude * H * 0.5;
        const wave2 = Math.sin(t * 600 + point.offsetPhase * 1.5 + ribbon.phase) * cfg.amplitude * H * 0.25;
        const wave3 = Math.sin(t * 300 + point.offsetPhase * 0.7) * cfg.amplitude * H * 0.12;

        point.y = point.baseY + wave1 + wave2 + wave3;

        // Horizontales Driften
        const drift = Math.sin(t * 400 + ri) * 15 * ribbon.depth;
        point.x = (point.offsetPhase / (cfg.pointCount - 1)) * W * 1.4 - W * 0.2 + drift;
      });
    });
  }

  /* ═══════════════════════════════════════════════════════
     RIBBON EFFECT – RENDERN (LINEAR GRADIENT)
  ═══════════════════════════════════════════════════════ */
  function drawRibbons() {
    ctx.clearRect(0, 0, W, H);

    ribbons.forEach(ribbon => {
      if (ribbon.points.length < 2) return;

      ctx.save();

      // LINEAR GRADIENT: von Primärfarbe zu Sekundärfarbe
      const gradient = ctx.createLinearGradient(0, 0, W, 0);
      gradient.addColorStop(0, hexToRgba(ribbon.color.primary, 0));              // Fade-in
      gradient.addColorStop(0.15, hexToRgba(ribbon.color.primary, ribbon.opacity * 0.5));
      gradient.addColorStop(0.5, hexToRgba(ribbon.color.secondary, ribbon.opacity)); // Center
      gradient.addColorStop(0.85, hexToRgba(ribbon.color.primary, ribbon.opacity * 0.5));
      gradient.addColorStop(1, hexToRgba(ribbon.color.primary, 0));              // Fade-out

      ctx.strokeStyle = gradient;
      ctx.lineWidth = ribbon.thickness;
      ctx.lineCap = 'round';
      ctx.lineJoin = 'round';

      // Quad. Bezier-Kurve für glattes Rendering
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

  /* ═══════════════════════════════════════════════════════
     ANIMATION LOOP
  ═══════════════════════════════════════════════════════ */
  let lastTime = 0;

  function loop(timestamp) {
    if (!isRunning) return;

    const deltaTime = lastTime ? (timestamp - lastTime) / 1000 : 0.016;
    lastTime = timestamp;

    updateRibbons(deltaTime);
    drawRibbons();

    raf = requestAnimationFrame(loop);
  }

  /* ═══════════════════════════════════════════════════════
     INITIALIZATION
  ═══════════════════════════════════════════════════════ */
  function init() {
    canvas = document.getElementById('intro-canvas');
    if (!canvas) return;

    ctx = canvas.getContext('2d');
    W = canvas.width = window.innerWidth;
    H = canvas.height = window.innerHeight;
    
    window.addEventListener('resize', () => {
      W = canvas.width = window.innerWidth;
      H = canvas.height = window.innerHeight;
      if (ribbons.length > 0) initRibbons();
    });

    initRibbons();
    raf = requestAnimationFrame(loop);

    // Text anzeigen nach Verzögerung
    setTimeout(() => {
      const introText = document.getElementById('intro-text');
      if (introText) introText.classList.add('show');
    }, CONFIG.textShowDelay);

    // Intro ausblenden
    setTimeout(() => {
      const intro = document.getElementById('intro');
      if (intro) intro.classList.add('hide');
    }, CONFIG.textShowDelay + CONFIG.introHold);
  }

  // Starten wenn DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
```

---

## Farbschemen zum Anpassen

### Modern Gradient
```javascript
colors: {
  primary: '#0ea5e9',    // Sky Blue
  secondary: '#06b6d4',  // Cyan
  tertiary: '#14b8a6',   // Teal
}
```

### Dark Purple
```javascript
colors: {
  primary: '#9333ea',    // Purple
  secondary: '#7c3aed',  // Violet
  tertiary: '#6d28d9',   // Indigo
}
```

### Sunset
```javascript
colors: {
  primary: '#f97316',    // Orange
  secondary: '#f43f5e',  // Rose
  tertiary: '#ec4899',   // Pink
}
```

### Neon Tech
```javascript
colors: {
  primary: '#00ff88',    // Neon Green
  secondary: '#00d4ff',  // Neon Cyan
  tertiary: '#ff006e',   // Neon Pink
}
```

---

## Anpassbar Parameter

| Parameter | Wert | Effekt |
|-----------|------|--------|
| `count` | 1-8 | Mehr Bänder = dichter |
| `pointCount` | 30-100 | Höher = glatter & langsamer |
| `speed` | 0.0001-0.001 | Animations-Tempo |
| `amplitude` | 0-0.5 | Wellenföhe |
| `thickness.min/max` | 1-10 | Band-Dicke |
| `opacity` | 0-1 | Transparenz |

---

## Use Cases

✅ **Portfolio Hero Section**
- Startparameter beibehalten
- Mit Text im Center

✅ **Loading Screen**
- `speed` erhöhen (z.B. 0.0008)
- `count` auf 6-8
- Mit Spinner

✅ **Login Page**
- `opacity` auf 0.1
- `amplitude` auf 0.1
- Subtiler im Hintergrund

✅ **Generative Art Website**
- `count` auf 10+
- `speed` variabel
- Mehrere Canvas überlagern

---

## Performance-Tipps

- **Canvas size**: Ändert sich automatisch mit Fenster
- **Reduce count**: Bei Mobil auf 2-3 senken
- **Use requestAnimationFrame**: Bereits implementiert
- **GPU optimiert**: Nutzt native Canvas 2D API

---

## Browser-Kompatibilität
✅ Alle modernen Browser (Chrome, Firefox, Safari, Edge)
