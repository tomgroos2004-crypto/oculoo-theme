<?php
if (empty($settings['tabs'])) return;
?>

<section class="ls-case-breakdown">

  <div class="ls-container">
      <h2 class="ls-case-titel">
		  Ons Assortiment
	  </h2>
	  <p class="ls-case-kicker">Opties die we aanbieden</p>

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


