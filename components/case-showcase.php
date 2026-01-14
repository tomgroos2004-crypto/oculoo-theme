<?php
defined('ABSPATH') || exit;

/**
 * Verwachte settings vanuit widget:
 * - title
 * - intro
 * - cases (repeater)
 * - cta_text
 * - cta_link
 */

$title    = $settings['title'] ?? '';
$intro    = $settings['intro'] ?? '';
$items    = is_array($settings['cases'] ?? null) ? $settings['cases'] : [];
$cta_text = $settings['cta_text'] ?? '';
$cta_link = $settings['cta_link']['url'] ?? '';
?>

<section class="ls-case-showcase ls-case-showcase--amplifier ls-widget">
  <div class="ls-container--wide ls-stack">

    <?php if ($title || $intro) : ?>
      <header class="ls-case-showcase__header ls-stack">
        <?php if ($title) : ?>
          <h2 class="h2"><?= esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($intro) : ?>
          <p class="lead"><?= esc_html($intro); ?></p>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <div class="ls-case-showcase__viewport" data-case-showcase>
      <div class="ls-case-showcase__track">
        <?php foreach ($items as $item) :
          $img = $item['image']['url'] ?? '';
          $txt = $item['title'] ?? '';
          $url = $item['link']['url'] ?? '#';
        ?>
          <a class="ls-case-showcase__item" href="<?= esc_url($url); ?>">
            <figure class="ls-case-showcase__frame">
              <?php if ($img) : ?>
                <img src="<?= esc_url($img); ?>" alt="">
              <?php else : ?>
                <div style="aspect-ratio:16/10;background:#eee;"></div>
              <?php endif; ?>
            </figure>

            <?php if ($txt) : ?>
              <h3 class="ls-case-showcase__title"><?= esc_html($txt); ?></h3>
            <?php endif; ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="ls-case-showcase__cta ls-row">
      <?php if ($cta_text && $cta_link) : ?>
        <a href="<?= esc_url($cta_link); ?>" class="btn btn-secondary">
          <?= esc_html($cta_text); ?>
        </a>
      <?php endif; ?>

      <a href="/cases" class="btn btn-secondary">
        Bekijk alle cases
      </a>
    </div>

  </div>
</section>

<script>
(function(){

  /* =========================================================
     LS Case Showcase — V4 (SCOPE SAFE)
  ========================================================= */

  const SPEED = 0.95;
  const MAX_BLUR  = 0.65;
  const MAX_SCALE = 0.085;
  const MAX_Y     = 8;
  const MAX_FADE  = 0.22;

  function initCaseShowcase(scope){

    /* ---------------------------------------------------------
       Normalize scope (Elementor = jQuery → DOM)
    --------------------------------------------------------- */

    if (scope && scope[0]) {
      scope = scope[0];
    }

    if (!scope || !scope.querySelectorAll) {
      scope = document;
    }

    const showcases = scope.querySelectorAll('[data-case-showcase]');
    if (!showcases.length) return;

    showcases.forEach(viewport => {

      if (viewport.__lsInit) return;
      viewport.__lsInit = true;

      const track = viewport.querySelector('.ls-case-showcase__track');
      if (!track) return;

      const originals = Array.from(track.children);
      const total = originals.length;
      if (total < 2) return;

      /* Clone once */
      originals.forEach((el, i) => {
        el.dataset.idx = i;
        const c = el.cloneNode(true);
        c.dataset.idx = i;
        c.setAttribute('aria-hidden', 'true');
        c.tabIndex = -1;
        track.appendChild(c);
      });

      const items = Array.from(track.children);

      /* Progress bar */
      const rail = document.createElement('div');
      rail.className = 'ls-case-showcase__rail';
      rail.innerHTML = '<span></span>';
      viewport.appendChild(rail);
      const fill = rail.firstChild;

      /* Geometry */
      let vpCenter = 0;
      let cardW = 0;
      let gap = 0;
      let step = 0;
      let roundLength = 0;
      let cycleW = 0;
      let centers = [];

      function measure(){
        const r = viewport.getBoundingClientRect();
        vpCenter = r.width / 2;

        const a = originals[0];
        const b = originals[1];

        cardW = a.offsetWidth;
        gap = b.offsetLeft - a.offsetLeft - cardW;
        step = cardW + gap;

        cycleW = total * step;
        roundLength = (total - 1) * step;

        centers = originals.map((_, i) =>
          i * step + cardW / 2
        );

        startRound();
      }

      let pos = 0;
      let startPos = 0;
      let roundDone = false;

      function startRound(){
        startPos = pos;
        roundDone = false;
        fill.style.transform = 'scaleX(0)';
      }

      function mod(n, m){
        return ((n % m) + m) % m;
      }

      function updateProgress(){
        const traveled = mod(startPos - pos, cycleW);
        const progress = Math.min(1, traveled / roundLength);

        fill.style.transform = `scaleX(${progress})`;

        if (progress >= 1 && !roundDone){
          roundDone = true;
          pos = startPos;
          startRound();
        }
      }

      function updateDepth(){
        const phase = mod(-pos, cycleW);
        const centerTrack = phase + vpCenter;

        for (let k = 0; k < items.length; k++){
          const el = items[k];
          const idx = +el.dataset.idx;
          const base = centers[idx];
          const isClone = k >= total;
          const center = isClone ? base + cycleW : base;

          const dist = Math.abs(center - centerTrack);
          const norm = Math.min(dist / vpCenter, 1);

          const scale = 1 + (1 - norm) * MAX_SCALE;
          const y = (1 - norm) * -MAX_Y;
          const opacity = 1 - norm * MAX_FADE;
          const blur = norm > 0.55 ? norm * MAX_BLUR : 0;

          el.style.transform = `translateY(${y}px) scale(${scale})`;
          el.style.opacity = opacity;
          el.style.zIndex = Math.round((1 - norm) * 10);
          el.style.filter = blur ? `blur(${blur}px)` : 'none';
        }
      }

      function loop(){
        pos -= SPEED;
        track.style.transform = `translate3d(${pos}px,0,0)`;
        updateProgress();
        updateDepth();
        requestAnimationFrame(loop);
      }

      window.addEventListener('resize', measure);
      measure();
      requestAnimationFrame(loop);
    });
  }

  /* Elementor + fallback init */
  if (window.elementorFrontend){
    elementorFrontend.hooks.addAction(
      'frontend/element_ready/global',
      initCaseShowcase
    );
  } else {
    document.addEventListener('DOMContentLoaded', () =>
      initCaseShowcase(document)
    );
  }

})();
</script>
