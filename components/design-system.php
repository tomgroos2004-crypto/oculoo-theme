<?php
defined('ABSPATH') || exit;

$title = $settings['title'] ?? '';
$intro = $settings['intro'] ?? '';
$items = is_array($settings['items'] ?? null) ? $settings['items'] : [];
?>

<section class="ls-design-system ls-widget">
  <div class="ls-container">

    <header class="ls-design-system-header">
      <h2 class="h2"><?= esc_html($title); ?></h2>
      <p class="lead"><?= esc_html($intro); ?></p>
    </header>

    <div class="ls-design-system-grid">

      <aside class="ls-design-system-nav">
        <?php foreach ($items as $i => $item) : ?>
          <button
            class="ls-ds-tab <?= $i === 0 ? 'is-active' : ''; ?>"
            data-ds-tab="<?= $i; ?>"
          >
            <span class="ls-ds-label"><?= esc_html($item['label']); ?></span>
          </button>
        <?php endforeach; ?>
      </aside>

      <div class="ls-design-system-content">
        <?php foreach ($items as $i => $item) : ?>
          <div
            class="ls-ds-panel <?= $i === 0 ? 'is-active' : ''; ?>"
            data-ds-panel="<?= $i; ?>"
          >
            <div class="ls-ds-meta">
              <code>component.<?= strtolower(preg_replace('/\s+/', '-', $item['label'])); ?></code>
            </div>

            <h3 class="h3"><?= esc_html($item['title']); ?></h3>
            <p><?= esc_html($item['text']); ?></p>

            <ul class="ls-ds-tokens">
              <li><code>layout.grid</code></li>
              <li><code>spacing.md</code></li>
              <li><code>state.hover</code></li>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>

    </div>

  </div>
</section>

<script>
(function(){
  const system = document.currentScript.previousElementSibling;
  if (!system || !system.classList.contains('ls-design-system')) return;

  const tabs = system.querySelectorAll('[data-ds-tab]');
  const panels = system.querySelectorAll('[data-ds-panel]');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const index = tab.dataset.dsTab;

      tabs.forEach(t => t.classList.remove('is-active'));
      panels.forEach(p => p.classList.remove('is-active'));

      tab.classList.add('is-active');
      system.querySelector('[data-ds-panel="' + index + '"]')?.classList.add('is-active');
    });
  });
})();
</script>
