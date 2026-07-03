<?php
defined('ABSPATH') || exit;

get_header();

if (have_posts()) :
  while (have_posts()) : the_post();

    $hero      = get_field('onderzoek_hero');
    $intro     = get_field('onderzoek_intro');
    $content   = get_field('onderzoek_content');
    $author    = get_field('onderzoek_author');
    $read_time = get_field('onderzoek_read_time');
    $date      = get_field('onderzoek_date');
    $pdf       = get_field('onderzoek_pdf');
    $findings  = get_field('onderzoek_findings');
    $sources   = get_field('onderzoek_sources');
    $related   = get_field('onderzoek_related');
    $cta       = get_field('onderzoek_cta');
    $cats      = get_the_terms(get_the_ID(), 'onderzoek_categorie');
?>

<main id="primary" class="site-main ls-blog-single ls-oz-single">

  <!-- ====================================================
       HERO
  ==================================================== -->

  <section class="ls-blog-hero section-md">
    <?php if (!empty($hero['url'])) : ?>
      <div class="ls-blog-hero__image">
        <img
          src="<?= esc_url($hero['sizes']['large'] ?? $hero['url']); ?>"
          alt="<?= esc_attr($hero['alt'] ?? get_the_title()); ?>"
          loading="eager"
          decoding="async"
        >
      </div>
    <?php endif; ?>

    <div class="ls-container ls-container--narrow">

      <nav class="ls-blog-hero__breadcrumb" aria-label="Kruimelpad">
        <a href="<?= esc_url(home_url('/')); ?>">Home</a>
        <span aria-hidden="true">/</span>
        <a href="<?= esc_url(get_post_type_archive_link('onderzoek')); ?>">Onderzoeken</a>
        <span aria-hidden="true">/</span>
        <span><?php the_title(); ?></span>
      </nav>

      <?php if (!empty($cats) && !is_wp_error($cats)) : ?>
        <p class="ls-blog-hero__cat">
          <?= esc_html($cats[0]->name); ?>
        </p>
      <?php endif; ?>

      <h1 class="ls-blog-hero__title"><?php the_title(); ?></h1>

      <div class="ls-blog-hero__meta">
        <?php if (!empty($author)) : ?>
          <span class="ls-blog-hero__author"><?= esc_html($author); ?></span>
        <?php endif; ?>
        <?php if (!empty($read_time)) : ?>
          <span class="ls-blog-hero__read-time"><?= (int) $read_time; ?> min leestijd</span>
        <?php endif; ?>
        <?php if (!empty($date)) : ?>
          <span class="ls-blog-hero__date">Onderzoeksdatum: <?= esc_html($date); ?></span>
        <?php endif; ?>
      </div>

      <!-- Meta bar: PDF download -->
      <?php if (!empty($pdf['url'])) : ?>
        <div class="ls-oz-meta">
          <a class="ls-oz-meta__pdf" href="<?= esc_url($pdf['url']); ?>" target="_blank" rel="noopener">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
              <polyline points="14,2 14,8 20,8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
              <line x1="16" y1="13" x2="8" y2="13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
              <line x1="16" y1="17" x2="8" y2="17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
            </svg>
            Download PDF
          </a>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <!-- ====================================================
       INTRO
  ==================================================== -->

  <?php if (!empty($intro)) : ?>
    <section class="ls-blog-intro section-sm">
      <div class="ls-container ls-container--narrow">
        <p class="ls-blog-intro__text lead"><?= wp_kses_post($intro); ?></p>
      </div>
    </section>
  <?php endif; ?>

  <!-- ====================================================
       KEY FINDINGS
  ==================================================== -->

  <?php if (!empty($findings) && is_array($findings)) : ?>
    <section class="ls-oz-findings section-sm">
      <div class="ls-container ls-container--narrow">
        <h2 class="ls-oz-findings__heading">Key findings</h2>
        <div class="ls-oz-findings__list">
          <?php foreach ($findings as $i => $finding) :
            $f_title = $finding['finding_title'] ?? '';
            $f_text  = $finding['finding_text'] ?? '';
            if (!$f_title && !$f_text) continue;
          ?>
            <div class="ls-oz-findings__item">
              <span class="ls-oz-findings__number"><?= $i + 1; ?></span>
              <div>
                <?php if ($f_title) : ?>
                  <h3 class="ls-oz-findings__title"><?= esc_html($f_title); ?></h3>
                <?php endif; ?>
                <?php if ($f_text) : ?>
                  <p class="ls-oz-findings__text"><?= esc_html($f_text); ?></p>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- ====================================================
       INHOUD
  ==================================================== -->

  <?php if (!empty($content)) : ?>
    <section class="ls-blog-content section-sm">
      <div class="ls-container ls-container--narrow">
        <div class="ls-blog-content__inner">
          <?= wp_kses_post($content); ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- ====================================================
       BRONNEN
  ==================================================== -->

  <?php if (!empty($sources) && is_array($sources)) : ?>
    <section class="ls-oz-sources section-sm">
      <div class="ls-container ls-container--narrow">
        <h2 class="ls-oz-sources__heading">Bronnen</h2>
        <ul class="ls-oz-sources__list">
          <?php foreach ($sources as $source) :
            $s_name = $source['source_name'] ?? '';
            $s_url  = $source['source_url'] ?? '';
            if (!$s_name) continue;
          ?>
            <li>
              <?php if ($s_url) : ?>
                <a href="<?= esc_url($s_url); ?>" target="_blank" rel="noopener"><?= esc_html($s_name); ?></a>
              <?php else : ?>
                <?= esc_html($s_name); ?>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
  <?php endif; ?>

  <!-- ====================================================
       CTA
  ==================================================== -->

  <?php if (!empty($cta['title']) || !empty($cta['text'])) : ?>
    <section class="ls-blog-cta section-sm">
      <div class="ls-container ls-container--narrow">
        <div class="ls-blog-cta__box">
          <?php if (!empty($cta['title'])) : ?>
            <h2 class="ls-blog-cta__title"><?= esc_html($cta['title']); ?></h2>
          <?php endif; ?>
          <?php if (!empty($cta['text'])) : ?>
            <p class="ls-blog-cta__text"><?= esc_html($cta['text']); ?></p>
          <?php endif; ?>
          <?php if (!empty($cta['btn_url']) && !empty($cta['btn_text'])) : ?>
            <a class="ls-blog-cta__btn btn btn--primary" href="<?= esc_url($cta['btn_url']); ?>">
              <?= esc_html($cta['btn_text']); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <!-- ====================================================
       GERELATEERDE ONDERZOEKEN
  ==================================================== -->

  <?php if (!empty($related)) : ?>
    <section class="ls-blog-related section-md">
      <div class="ls-container">
        <h2 class="ls-blog-related__heading">Gerelateerde onderzoeken</h2>
        <div class="ls-blog-grid">
          <?php foreach ($related as $rel_post) :
            $rel_hero  = get_field('onderzoek_hero', $rel_post->ID);
            $rel_intro = get_field('onderzoek_intro', $rel_post->ID);
            $rel_cats  = get_the_terms($rel_post->ID, 'onderzoek_categorie');
            $rel_date  = get_field('onderzoek_date', $rel_post->ID);
            $rel_pdf   = get_field('onderzoek_pdf', $rel_post->ID);
          ?>
            <a href="<?= esc_url(get_permalink($rel_post->ID)); ?>" class="ls-blog-card">
              <div class="ls-blog-card__media">
                <?php if (!empty($rel_hero['sizes']['medium_large'])) : ?>
                  <img src="<?= esc_url($rel_hero['sizes']['medium_large']); ?>" alt="<?= esc_attr($rel_hero['alt'] ?? $rel_post->post_title); ?>" loading="lazy" decoding="async">
                <?php elseif (has_post_thumbnail($rel_post->ID)) : ?>
                  <?= get_the_post_thumbnail($rel_post->ID, 'medium_large', ['loading' => 'lazy', 'decoding' => 'async']); ?>
                <?php else : ?>
                  <div class="ls-blog-card__no-image"></div>
                <?php endif; ?>
              </div>
              <div class="ls-blog-card__body">
                <?php if (!empty($rel_cats) && !is_wp_error($rel_cats)) : ?>
                  <span class="ls-blog-card__cat"><?= esc_html($rel_cats[0]->name); ?></span>
                <?php endif; ?>
                <h3 class="ls-blog-card__title"><?= esc_html($rel_post->post_title); ?></h3>
                <?php if (!empty($rel_intro)) : ?>
                  <p class="ls-blog-card__excerpt"><?= esc_html(wp_trim_words($rel_intro, 20)); ?></p>
                <?php endif; ?>
                <div class="ls-blog-card__footer">
                  <?php if (!empty($rel_date)) : ?>
                    <span class="ls-blog-card__date"><?= esc_html($rel_date); ?></span>
                  <?php endif; ?>
                  <?php if (!empty($rel_pdf)) : ?>
                    <span class="ls-blog-card__pdf-badge">PDF</span>
                  <?php endif; ?>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

</main>

<?php
  endwhile;
endif;

get_footer();
