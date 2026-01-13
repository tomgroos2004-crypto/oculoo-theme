<?php
defined('ABSPATH') || exit;

$intro  = $args['intro'] ?? '';
$people = $args['people'] ?? [];
?>

<?php if (!empty($people)) : ?>
<section class="ls-team-cards">
  <div class="ls-container--narrow">

    <?php if (!empty($intro)) : ?>
      <div class="ls-team-intro">
        <p class="lead"><?= esc_html($intro); ?></p>
      </div>
    <?php endif; ?>

    <div class="ls-cards ls-cards--cols-2">
      <div class="ls-cards-grid">

        <?php foreach ($people as $person) :
          $image = (isset($person['image']) && is_array($person['image'])) ? $person['image'] : [];
          $img_url = $image['url'] ?? '';
          $name = $person['name'] ?? '';
          $role = $person['role'] ?? '';
          $text = $person['text'] ?? '';
        ?>
          <article class="ls-card ls-team-card">

            <?php if (!empty($img_url)) : ?>
              <div class="ls-team-photo">
                <img
                  src="<?= esc_url($img_url); ?>"
                  alt="<?= esc_attr($name); ?>"
                  loading="lazy"
                >
              </div>
            <?php endif; ?>

            <?php if (!empty($name)) : ?>
              <h3 class="ls-card-title"><?= esc_html($name); ?></h3>
            <?php endif; ?>

            <?php if (!empty($role)) : ?>
              <p class="ls-team-role small"><?= esc_html($role); ?></p>
            <?php endif; ?>

            <?php if (!empty($text)) : ?>
              <p class="ls-card-text"><?= esc_html($text); ?></p>
            <?php endif; ?>

          </article>
        <?php endforeach; ?>

      </div>
    </div>

  </div>
</section>
<?php endif; ?>
