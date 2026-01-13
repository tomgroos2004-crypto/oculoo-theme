<?php
if (empty($settings['tabs'])) return;
?>

<section class="ls-case-breakdown">

  <div class="ls-container">

	  <p class="ls-case-kicker">Onderdelen van deze website</p>

    <div class="ls-case-tabs" role="tablist">
      <?php foreach ($settings['tabs'] as $index => $tab): ?>
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
      <?php foreach ($settings['tabs'] as $index => $tab): ?>
        <div
          class="ls-case-panel <?= $index === 0 ? 'is-active' : ''; ?>"
          data-panel="tab-<?= $index; ?>"
        >

          <div class="ls-case-visual">
            <?php if (!empty($tab['image']['url'])): ?>
              <img
                src="<?= esc_url($tab['image']['url']); ?>"
                alt="<?= esc_attr($tab['label']); ?>"
                loading="lazy"
              >
            <?php endif; ?>
          </div>

          <div class="ls-case-content">
            <h3><?= esc_html($tab['label']); ?></h3>

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
document.addEventListener('click', function (e) {
  const btn = e.target.closest('.ls-case-tabs button');
  if (!btn) return;

  const root = btn.closest('.ls-case-breakdown');
  if (!root) return;

  const tab = btn.dataset.tab;

  root.querySelectorAll('.ls-case-tabs button')
    .forEach(b => b.classList.remove('is-active'));

  root.querySelectorAll('.ls-case-panel')
    .forEach(p => p.classList.remove('is-active'));

  btn.classList.add('is-active');
  root.querySelector('[data-panel="' + tab + '"]')?.classList.add('is-active');
});
</script>
