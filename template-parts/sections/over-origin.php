<?php
defined('ABSPATH') || exit;

$enabled = get_field('over_origin_enabled');
if ((string) $enabled === '0') return;

$eyebrow      = get_field('over_origin_eyebrow')      ?: 'Het ontstaan';
$title_main   = get_field('over_origin_title_main')   ?: 'Een bekend probleem.';
$title_accent = get_field('over_origin_title_accent') ?: 'Geen oplossing.';
$body_before  = get_field('over_origin_body_before')  ?: "In de thuiszorg zien we het dagelijks gebeuren. Wijkverpleegkundigen rijden langs bij ouderen, niet voor complexe zorg, maar om te helpen met oogdruppels. Een handeling van enkele minuten, meerdere keren per dag, bij duizenden mensen tegelijk.\n\nDe zorg verandert. Organisaties schalen af, budgetten staan onder druk en personeelstekorten nemen toe. Door de vergrijzing groeit de vraag, terwijl de capaciteit juist afneemt. In steeds meer regio's worden oogdruppelbezoeken afgebouwd of volledig stopgezet.";
$pull_quote   = get_field('over_origin_pull_quote')   ?: 'De thuiszorg stopt. Het probleem niet. 1,9 miljoen Nederlanders gebruiken dagelijks oogdruppels, waarvan een groot deel moeite heeft met zelfstandig toedienen.';
$body_after   = get_field('over_origin_body_after')   ?: 'Er bestaan hulpmiddelen die een deel van het probleem aanpakken — sommige helpen bij het richten, andere bij het knijpen. Maar geen enkel hulpmiddel combineert beide functies. Daardoor blijft een groot deel van de gebruikers moeite houden, ook mét hulpmiddelen.';
$photo        = get_field('over_origin_photo');
$caption      = get_field('over_origin_photo_caption') ?: '';

$split_paragraphs = static function ($text) {
  if (!is_string($text)) return [];
  $parts = preg_split('/\R\s*\R/', trim($text));
  if (!is_array($parts)) return [];
  return array_values(array_filter(array_map('trim', $parts)));
};

$before_paragraphs = $split_paragraphs($body_before);
$after_paragraphs  = $split_paragraphs($body_after);

$photo_url = is_array($photo) ? ($photo['url'] ?? '') : '';
$photo_alt = is_array($photo) ? ($photo['alt'] ?? '') : '';
?>

<section class="over-origin section-md">
  <div class="ls-container">
    <div class="over-origin__inner">

      <div class="over-origin__text">
        <?php if ($eyebrow) : ?>
          <p class="over-origin__eyebrow"><?= esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <?php if ($title_main || $title_accent) : ?>
          <h2 class="over-origin__title">
            <?php if ($title_main) : ?><span><?= esc_html($title_main); ?></span><?php endif; ?>
            <?php if ($title_accent) : ?> <em><?= esc_html($title_accent); ?></em><?php endif; ?>
          </h2>
        <?php endif; ?>

        <?php foreach ($before_paragraphs as $paragraph) : ?>
          <p class="over-origin__body"><?= esc_html($paragraph); ?></p>
        <?php endforeach; ?>

        <?php if ($pull_quote) : ?>
          <blockquote class="over-origin__pull-quote">
            <p><?= esc_html($pull_quote); ?></p>
          </blockquote>
        <?php endif; ?>

        <?php foreach ($after_paragraphs as $paragraph) : ?>
          <p class="over-origin__body"><?= esc_html($paragraph); ?></p>
        <?php endforeach; ?>
      </div>

      <div class="over-origin__photo-col">
        <div class="over-origin__photo-wrap">
          <?php if ($photo_url !== '') : ?>
            <img
              src="<?= esc_url($photo_url); ?>"
              alt="<?= esc_attr($photo_alt); ?>"
              loading="lazy"
              decoding="async"
            >
          <?php else : ?>
            <div class="over-origin__photo-placeholder" aria-hidden="true"></div>
          <?php endif; ?>

          <?php if ($caption !== '') : ?>
            <div class="over-origin__photo-caption">
              <p class="over-origin__caption-text"><?= esc_html($caption); ?></p>
            </div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>
