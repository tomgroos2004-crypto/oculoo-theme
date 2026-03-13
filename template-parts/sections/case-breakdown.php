<?php
$enabled = get_sub_field('case_breakdown_enabled');
if (!$enabled) return;

$title  = get_sub_field('case_breakdown_title') ?: 'Ons Assortiment';
$kicker = get_sub_field('case_breakdown_kicker') ?: 'Opties die we aanbieden';
$tabs   = get_sub_field('case_breakdown_tabs');

if (empty($tabs)) return;
?>

<section class="ls-case-breakdown dark-section-sm">

  <div class="ls-container">

    <h2 class="ls-case-titel h2">
      <?= esc_html($title); ?>
    </h2>

    <?php if ($kicker): ?>
      <p class="ls-case-kicker">
        <?= esc_html($kicker); ?>
      </p>
    <?php endif; ?>

    <div class="ls-case-tabs" role="tablist">
      <?php foreach ($tabs as $index => $tab): ?>
        <button
          class="<?= $index === 0 ? 'is-active' : ''; ?>"
          data-tab="tab-<?= $index; ?>"
          type="button"
        >
          <?= esc_html($tab['label']); ?>
        </button>
      <?php endforeach; ?>
    </div>

    <div class="ls-case-panels">
      <?php foreach ($tabs as $index => $tab): ?>
        <div
          class="ls-case-panel <?= $index === 0 ? 'is-active' : ''; ?>"
          data-panel="tab-<?= $index; ?>"
        >

          <div class="ls-case-visual">
  <?php if (!empty($tab['image']['ID'])): ?>
    <?= wp_get_attachment_image(
      $tab['image']['ID'],
      'large',
      false,
      [
        'loading' => 'lazy',
        'alt' => esc_attr($tab['image']['alt'] ?: $tab['label'])
      ]
    ); ?>
  <?php endif; ?>
</div>

          <div class="ls-case-content">
            <h3 class="h3">
              <?= esc_html($tab['label']); ?>
            </h3>

            <?php
            $points = array_filter(array_map('trim', explode("\n", $tab['points'])));
            if ($points): ?>
              <ul>
                <?php foreach ($points as $point): ?>
                  <li><?= esc_html($point); ?></li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>

          </div>

        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>
<script>
(function () {

  function initCaseBreakdowns(root = document) {

    const sections = root.querySelectorAll('.ls-case-breakdown');
    if (!sections.length) return false;

    let didInit = false;

    sections.forEach((section) => {

      if (section.dataset.caseInit === 'true') return;

      const tabsWrap = section.querySelector('.ls-case-tabs');
      if (!tabsWrap) return;

      const tabs = Array.from(tabsWrap.querySelectorAll('button[data-tab]'));
      const panels = Array.from(section.querySelectorAll('.ls-case-panel[data-panel]'));

      if (!tabs.length || !panels.length) return;

      section.dataset.caseInit = 'true';
      didInit = true;

      function activateById(id) {
        tabs.forEach(btn =>
          btn.classList.toggle('is-active', btn.dataset.tab === id)
        );

        panels.forEach(panel =>
          panel.classList.toggle('is-active', panel.dataset.panel === id)
        );
      }

      function activateByIndex(index) {
        const btn = tabs[index];
        if (!btn) return;
        activateById(btn.dataset.tab);
      }

      /* ======================================================
         Initial state
      ====================================================== */

      const initial =
        tabs.find(b => b.classList.contains('is-active')) ||
        tabs[0];

      if (initial) activateById(initial.dataset.tab);

      /* ======================================================
         Click handling (ALWAYS PRIMARY)
      ====================================================== */

      tabsWrap.addEventListener('click', function (e) {
        const btn = e.target.closest('button[data-tab]');
        if (!btn) return;

        e.preventDefault();
        activateById(btn.dataset.tab);
      });

      /* ======================================================
         Keyboard support
      ====================================================== */

      tabsWrap.addEventListener('keydown', function (e) {

        const current = e.target.closest('button[data-tab]');
        if (!current) return;

        const index = tabs.indexOf(current);
        if (index < 0) return;

        if (e.key === 'ArrowRight') {
          e.preventDefault();
          const next = Math.min(index + 1, tabs.length - 1);
          tabs[next].focus();
          activateByIndex(next);
        }

        if (e.key === 'ArrowLeft') {
          e.preventDefault();
          const prev = Math.max(index - 1, 0);
          tabs[prev].focus();
          activateByIndex(prev);
        }

      });

      /* ======================================================
         ScrollTrigger (OPTIONAL)
         - Desktop only
         - Never blocks clicking
      ====================================================== */

      if (!(window.gsap && window.ScrollTrigger)) return;

      const prefersReduced =
        window.matchMedia &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

      if (prefersReduced) return;

      if (section.dataset.caseSTInit === 'true') return;
      section.dataset.caseSTInit = 'true';

      window.gsap.registerPlugin(window.ScrollTrigger);

      const mqDesktop = window.matchMedia('(min-width: 1024px)');
      const mqTabletUp = window.matchMedia('(min-width: 768px)');

      const st = window.ScrollTrigger.create({

        trigger: section,

        start: mqDesktop.matches ? 'top 15%' : 'top 70%',

        end: function () {
          if (!mqDesktop.matches) return 'bottom bottom';
          return '+=' + Math.max(section.offsetHeight, tabs.length * 420);
        },

        pin: mqDesktop.matches,
        scrub: false,
        anticipatePin: mqDesktop.matches ? 1 : 0,

        snap:
          mqDesktop.matches && tabs.length > 1
            ? {
                snapTo: 1 / (tabs.length - 1),
                duration: { min: 0.25, max: 0.35 },
                ease: 'power2.out'
              }
            : false,

        invalidateOnRefresh: true,

        onUpdate(self) {

          if (!mqTabletUp.matches) return;
          if (tabs.length <= 1) return;

          const index = Math.round(self.progress * (tabs.length - 1));
          activateByIndex(index);

        }

      });

      /* Refresh after images load */

      const images = section.querySelectorAll('img');
      let pending = 0;

      images.forEach(function (img) {
        if (img.complete) return;
        pending++;

        img.addEventListener('load', function () {
          pending--;
          if (pending <= 0) window.ScrollTrigger.refresh();
        }, { once: true });
      });

      setTimeout(function () {
        window.ScrollTrigger.refresh();
      }, 300);

      setTimeout(function () {
        window.ScrollTrigger.refresh();
      }, 900);

    });

    return didInit;
  }

  /* ======================================================
     Async-safe init loop
  ====================================================== */

  let tries = 0;

  const interval = setInterval(function () {
    tries++;
    const ok = initCaseBreakdowns(document);
    if (ok || tries > 30) clearInterval(interval);
  }, 200);

})();
</script>
