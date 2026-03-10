<?php
defined('ABSPATH') || exit;

$section_classes = [
  'ls-section',
  'dark-section-sm',
  'section-sm'
];
?>

<section class="<?= esc_attr(implode(' ', $section_classes)); ?>" data-partners>
  <div class="ls-container--wide">

    <?php if (have_rows('partners', 'option')) : ?>

      <div class="ls-partners-slider">
		  
       <div class="ls-partners-slider__header">
         <h2 class="h2">Onze Partners</h2>
        </div>
		  
        <div class="ls-partners-slider__viewport">

          <div class="ls-partners-slider__track" data-ls-marquee="true">

            <?php while (have_rows('partners', 'option')) : the_row();

              $logo = get_sub_field('logo');
              $link = get_sub_field('link');

              $logo_url = is_array($logo) ? ($logo['url'] ?? '') : $logo;
              $logo_alt = is_array($logo) ? ($logo['alt'] ?? '') : '';

            ?>

              <div class="ls-partners-slider__item">

                <?php if ($link): ?>
                  <a href="<?= esc_url($link); ?>" target="_blank" rel="noopener">
                <?php endif; ?>

                  <img 
                    src="<?= esc_url($logo_url); ?>"
                    alt="<?= esc_attr($logo_alt); ?>"
                    loading="lazy"
                  >

                <?php if ($link): ?>
                  </a>
                <?php endif; ?>

              </div>

            <?php endwhile; ?>

          </div>
        </div>

      </div>

    <?php endif; ?>

  </div>
</section>