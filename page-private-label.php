<?php
/**
 * Template: Private Label
 * Auto-geladen door WordPress voor pagina met slug `private-label`.
 * Alle teksten komen uit ACF (group_pl_page). Het aanvraagformulier
 * blijft hardcoded zodat de submit handler werkt.
 */
defined('ABSPATH') || exit;

get_header();

$pl_status = isset($_GET['pl_status']) ? sanitize_key($_GET['pl_status']) : '';
$pid       = (int) get_the_ID();

/* ---------- HERO ---------- */
$hero_title_main   = get_field('pl_hero_title_main', $pid)   ?: 'Oculoo, in';
$hero_title_accent = get_field('pl_hero_title_accent', $pid) ?: 'jouw';
$hero_title_suffix = get_field('pl_hero_title_suffix', $pid) ?: 'merk.';
$hero_sub          = get_field('pl_hero_sub', $pid)          ?: 'De gepatenteerde oogdruppelbril. Jouw logo, jouw kleur. Voor groothandels, oogklinieken, zorginstellingen en leveranciers die hun klanten écht verder willen helpen.';
$hero_btn1_text    = get_field('pl_hero_btn1_text', $pid)    ?: 'Vraag een offerte aan';
$hero_btn1_url     = get_field('pl_hero_btn1_url', $pid)     ?: '#contact';
$hero_btn2_text    = get_field('pl_hero_btn2_text', $pid)    ?: 'Bekijk voorbeelden';
$hero_btn2_url     = get_field('pl_hero_btn2_url', $pid)     ?: '#voorbeelden';

/* ---------- INTRO ---------- */
$intro_enabled       = get_field('pl_intro_enabled', $pid);
if ($intro_enabled === null || $intro_enabled === '') $intro_enabled = true;
$intro_eyebrow       = get_field('pl_intro_eyebrow', $pid)       ?: 'Wat is private label?';
$intro_title_main    = get_field('pl_intro_title_main', $pid)    ?: 'Hetzelfde product.';
$intro_title_accent  = get_field('pl_intro_title_accent', $pid)  ?: 'Helemaal';
$intro_title_suffix  = get_field('pl_intro_title_suffix', $pid)  ?: 'van jou.';
$intro_paragraphs    = get_field('pl_intro_paragraphs', $pid);
if (empty($intro_paragraphs) || !is_array($intro_paragraphs)) {
  $intro_paragraphs = [
    ['text' => 'Oculoo blijft Oculoo. Hetzelfde gepatenteerde knijpsysteem, dezelfde MDR klasse 1 keurmerk, dezelfde 4 stappen tot een geslaagde druppel. Alleen ziet je klant straks jouw merk: je eigen kleur, je eigen logo op de bril.'],
    ['text' => 'Jij ontvangt een afgewerkt product dat klaar is voor je schap, je webshop of je zorgproces. Easy as that.'],
  ];
}

/* ---------- SHOWCASE ---------- */
$showcase_enabled         = get_field('pl_showcase_enabled', $pid);
if ($showcase_enabled === null || $showcase_enabled === '') $showcase_enabled = true;
$showcase_eyebrow         = get_field('pl_showcase_eyebrow', $pid)         ?: 'Voorbeelden';
$showcase_title_main      = get_field('pl_showcase_title_main', $pid)      ?: 'Kies een kleur.';
$showcase_title_accent    = get_field('pl_showcase_title_accent', $pid)    ?: 'Wij maken hem.';
$showcase_intro           = get_field('pl_showcase_intro', $pid)           ?: 'Vier voorbeelden van hoe een Oculoo in jouw huisstijl eruit kan zien. Ter illustratie — elke kleur is mogelijk.';
$showcase_caption_before  = get_field('pl_showcase_caption_before', $pid)  ?: 'Renders ter illustratie.';
$showcase_caption_strong  = get_field('pl_showcase_caption_strong', $pid)  ?: 'Elke kleur is mogelijk';
$showcase_caption_after   = get_field('pl_showcase_caption_after', $pid)   ?: '— eindresultaat in overleg met onze designers.';
$showcase_variants        = get_field('pl_showcase_variants', $pid);
if (empty($showcase_variants) || !is_array($showcase_variants)) {
  $showcase_variants = [
    ['label' => 'Rood',  'tone' => 'red',    'image' => null],
    ['label' => 'Groen', 'tone' => 'green',  'image' => null],
    ['label' => 'Blauw', 'tone' => 'blue',   'image' => null],
    ['label' => 'Paars', 'tone' => 'purple', 'image' => null],
  ];
}

/* ---------- AUDIENCE ---------- */
$audience_enabled       = get_field('pl_audience_enabled', $pid);
if ($audience_enabled === null || $audience_enabled === '') $audience_enabled = true;
$audience_eyebrow       = get_field('pl_audience_eyebrow', $pid)       ?: 'Voor wie';
$audience_title_main    = get_field('pl_audience_title_main', $pid)    ?: 'Voor partijen die';
$audience_title_accent  = get_field('pl_audience_title_accent', $pid)  ?: 'het verschil';
$audience_title_suffix  = get_field('pl_audience_title_suffix', $pid)  ?: 'willen maken.';
$audience_intro         = get_field('pl_audience_intro', $pid)         ?: 'Private label past goed bij organisaties die hun klanten of cliënten een herkenbaar, kwalitatief hulpmiddel willen meegeven.';
$audience_cards         = get_field('pl_audience_cards', $pid);
if (empty($audience_cards) || !is_array($audience_cards)) {
  $audience_cards = [
    ['icon' => 'cart',     'title' => 'Groothandels',           'text' => 'Een eigen merk op het schap dat klanten herkennen en vertrouwen.'],
    ['icon' => 'eye',      'title' => 'Oogklinieken',           'text' => 'Geef patiënten na een staaroperatie een bril mee die voor jouw kliniek staat.'],
    ['icon' => 'building', 'title' => 'Zorginstellingen',       'text' => 'Eigen branding voor cliënten, minder druppelbezoeken voor je medewerkers.'],
    ['icon' => 'package',  'title' => 'Leveranciers oogdruppels','text' => 'Verhoog de gebruikersvriendelijkheid van jouw druppels met een eigen Oculoo.'],
  ];
}

/* Icon library: SVG path content per key (viewBox 0 0 24 24, stroke-based) */
$pl_icons = [
  'cart'     => '<path d="M3 9h18M3 9l2-5h14l2 5M3 9v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9M8 13h8"/>',
  'eye'      => '<circle cx="12" cy="12" r="3"/><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>',
  'building' => '<path d="M3 9.5 12 3l9 6.5V21a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/><path d="M9 22V12h6v10"/>',
  'package'  => '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="M3.3 7 12 12l8.7-5M12 22V12"/>',
  'people'   => '<circle cx="9" cy="8" r="3.5"/><circle cx="17" cy="10" r="2.5"/><path d="M2 20c0-3.3 3.1-6 7-6s7 2.7 7 6"/><path d="M14.5 20c.3-2.5 2.3-4.5 5-4.5 1.4 0 2.6.5 3.5 1.3"/>',
  'heart'    => '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"/>',
  'shield'   => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-4"/>',
  'check'    => '<path d="M20 6 9 17l-5-5"/>',
];

/* ---------- CONTACT ---------- */
$contact_enabled        = get_field('pl_contact_enabled', $pid);
if ($contact_enabled === null || $contact_enabled === '') $contact_enabled = true;
$contact_eyebrow        = get_field('pl_contact_eyebrow', $pid)        ?: 'Contact';
$contact_title          = get_field('pl_contact_title', $pid)          ?: 'Neem contact met ons op.';
$contact_intro          = get_field('pl_contact_intro', $pid)          ?: 'Stuur het formulier in en je hoort binnen één werkdag van ons. Geen verkoopverhaal, gewoon een goed gesprek over wat we voor je kunnen betekenen.';
$contact_email          = get_field('pl_contact_email', $pid)          ?: 'contact@oculoo.com';
$contact_response_text  = get_field('pl_contact_response_text', $pid)  ?: 'Reactie binnen 1 werkdag';
$form_title             = get_field('pl_form_title', $pid)             ?: 'Private label aanvraag';
$form_intro             = get_field('pl_form_intro', $pid)             ?: 'Vul het formulier in. We nemen snel contact met je op.';
$form_submit_label      = get_field('pl_form_submit_label', $pid)      ?: 'Verstuur aanvraag';
$form_note              = get_field('pl_form_note', $pid)              ?: 'Door dit formulier te versturen ga je akkoord met onze verwerking van je gegevens voor het beantwoorden van jouw aanvraag.';
$form_success           = get_field('pl_form_success', $pid)           ?: 'We nemen binnen één werkdag contact met je op.';
?>

<main id="primary" class="site-main pl-page">

  <?php while (have_posts()) : the_post(); ?>

    <!-- ============ HERO ============ -->
    <section class="pl-hero">
      <div class="pl-hero__mark" aria-hidden="true">
        <svg viewBox="0 0 145.53 78.41" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="pl_hero_grad_l" x1="41.25" y1="-208.39" x2="57.6" y2="-241.61" gradientTransform="translate(0 -166.79) scale(1 -1)" gradientUnits="userSpaceOnUse">
              <stop offset="0" stop-color="#ec6528"/>
              <stop offset="1" stop-color="#ec6528" stop-opacity=".4"/>
            </linearGradient>
            <linearGradient id="pl_hero_grad_r" x1="101.23" y1="-197.5" x2="89.39" y2="-171.74" xlink:href="#pl_hero_grad_l"/>
          </defs>
          <g>
            <path fill="url(#pl_hero_grad_l)" d="M0,39.27c0-5.9.97-11.25,2.9-16.04,1.93-4.79,4.64-8.9,8.14-12.31,3.49-3.5,7.73-6.18,12.69-8.02,4.97-1.94,10.44-2.9,16.42-2.9s11.4.97,16.28,2.9c4.88,1.84,9.06,4.52,12.55,8.02,3.59,3.41,6.35,7.51,8.28,12.31,2.02,4.79,3.04,10.14,3.04,16.04s-1.01,11.02-3.04,15.9c-1.93,4.79-4.69,8.9-8.28,12.31-3.49,3.41-7.68,6.08-12.55,8.02-4.88,1.94-10.3,2.9-16.28,2.9s-11.45-.97-16.42-2.9c-4.97-1.94-9.2-4.61-12.69-8.02-3.49-3.41-6.21-7.51-8.14-12.31-1.93-4.89-2.9-10.19-2.9-15.9ZM15.45,39.27c0,3.69.6,7.1,1.79,10.23,1.2,3.13,2.85,5.81,4.97,8.02,2.21,2.21,4.78,3.96,7.73,5.26,3.04,1.2,6.44,1.8,10.21,1.8s6.9-.6,9.93-1.8c3.04-1.29,5.61-3.04,7.73-5.26,2.21-2.21,3.91-4.89,5.1-8.02,1.2-3.13,1.79-6.55,1.79-10.23s-.6-7.24-1.79-10.37c-1.2-3.23-2.9-5.95-5.1-8.16-2.12-2.21-4.69-3.92-7.73-5.12s-6.35-1.8-9.93-1.8c-3.77,0-7.17.6-10.21,1.8-2.94,1.2-5.52,2.9-7.73,5.12-2.12,2.21-3.77,4.93-4.97,8.16-1.2,3.13-1.79,6.59-1.79,10.37Z"/>
            <path fill="url(#pl_hero_grad_r)" d="M145.53,39.14c0,5.9-.97,11.25-2.92,16.04-1.95,4.79-4.68,8.9-8.2,12.31-3.52,3.5-7.79,6.18-12.79,8.02-5.01,1.94-10.52,2.9-16.55,2.9s-11.49-.97-16.41-2.9c-4.91-1.84-9.13-4.52-12.65-8.02-3.61-3.41-6.4-7.51-8.34-12.31-2.04-4.79-3.06-10.14-3.06-16.04s1.02-11.02,3.06-15.9c1.95-4.79,4.73-8.9,8.34-12.31,3.52-3.41,7.74-6.08,12.65-8.02C93.58.97,99.04,0,105.07,0s11.54.97,16.55,2.9c5.01,1.94,9.27,4.61,12.79,8.02,3.52,3.41,6.26,7.51,8.2,12.31,1.95,4.89,2.92,10.19,2.92,15.9ZM129.96,39.14c0-3.69-.6-7.1-1.81-10.23-1.21-3.13-2.87-5.81-5.01-8.02-2.23-2.21-4.82-3.96-7.79-5.25-3.06-1.2-6.49-1.8-10.29-1.8s-6.95.6-10.01,1.8c-3.06,1.29-5.65,3.04-7.79,5.25-2.22,2.21-3.94,4.89-5.14,8.02-1.21,3.13-1.81,6.55-1.81,10.23s.6,7.24,1.81,10.37c1.2,3.23,2.92,5.95,5.14,8.16,2.13,2.21,4.73,3.92,7.79,5.12,3.06,1.2,6.4,1.8,10.01,1.8,3.8,0,7.23-.6,10.29-1.8,2.97-1.2,5.56-2.9,7.79-5.12,2.13-2.21,3.8-4.93,5.01-8.16,1.2-3.13,1.81-6.59,1.81-10.37Z"/>
          </g>
        </svg>
      </div>

      <div class="ls-container pl-hero__inner">
        <h1 class="pl-hero__title">
          <?= esc_html($hero_title_main); ?>
          <?php if ($hero_title_accent) : ?><em><?= esc_html($hero_title_accent); ?></em><?php endif; ?>
          <?= esc_html($hero_title_suffix); ?>
        </h1>
        <?php if ($hero_sub) : ?>
          <p class="pl-hero__sub"><?= esc_html($hero_sub); ?></p>
        <?php endif; ?>
        <div class="pl-hero__actions">
          <?php if ($hero_btn1_text) : ?>
            <a href="<?= esc_url($hero_btn1_url); ?>" class="btn btn--primary">
              <?= esc_html($hero_btn1_text); ?>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
            </a>
          <?php endif; ?>
          <?php if ($hero_btn2_text) : ?>
            <a href="<?= esc_url($hero_btn2_url); ?>" class="btn btn--ghost"><?= esc_html($hero_btn2_text); ?></a>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- ============ INTRO ============ -->
    <?php if ($intro_enabled) : ?>
    <section class="pl-intro section-md">
      <div class="ls-container ls-container--narrow">
        <?php if ($intro_eyebrow) : ?>
          <span class="pl-eyebrow"><?= esc_html($intro_eyebrow); ?></span>
        <?php endif; ?>
        <h2 class="h2 pl-h2">
          <?= esc_html($intro_title_main); ?>
          <?php if ($intro_title_accent) : ?><em><?= esc_html($intro_title_accent); ?></em><?php endif; ?>
          <?= esc_html($intro_title_suffix); ?>
        </h2>
        <?php foreach ($intro_paragraphs as $p) :
          $txt = is_array($p) ? ($p['text'] ?? '') : '';
          if (!$txt) continue; ?>
          <p class="pl-lead"><?= esc_html($txt); ?></p>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>

    <!-- ============ SHOWCASE ============ -->
    <?php if ($showcase_enabled) : ?>
    <section class="pl-showcase section-md" id="voorbeelden">
      <div class="ls-container">
        <header class="pl-section-head">
          <?php if ($showcase_eyebrow) : ?>
            <span class="pl-eyebrow"><?= esc_html($showcase_eyebrow); ?></span>
          <?php endif; ?>
          <h2 class="h2 pl-h2">
            <?= esc_html($showcase_title_main); ?>
            <?php if ($showcase_title_accent) : ?> <em><?= esc_html($showcase_title_accent); ?></em><?php endif; ?>
          </h2>
          <?php if ($showcase_intro) : ?>
            <p class="pl-lead"><?= esc_html($showcase_intro); ?></p>
          <?php endif; ?>
        </header>

        <div class="pl-showcase__grid">
          <?php foreach ($showcase_variants as $v) :
            $label  = is_array($v) ? ($v['label'] ?? '') : '';
            $tone   = is_array($v) ? ($v['tone']  ?? 'red') : 'red';
            $image  = is_array($v) ? ($v['image'] ?? null) : null;
            $img_url = '';
            $img_alt = $label ? ('Oculoo oogdruppelbril in het ' . strtolower($label)) : '';
            if (is_array($image) && !empty($image['url'])) {
              $img_url = $image['url'];
              if (!empty($image['alt'])) $img_alt = $image['alt'];
            }
          ?>
            <figure class="pl-product pl-product--<?= esc_attr($tone); ?>">
              <?php if ($label) : ?>
                <span class="pl-product__label">Voorbeeld · <?= esc_html($label); ?></span>
              <?php endif; ?>
              <?php if ($img_url) : ?>
                <div class="pl-product__media">
                  <img src="<?= esc_url($img_url); ?>" alt="<?= esc_attr($img_alt); ?>" loading="lazy">
                </div>
              <?php endif; ?>
            </figure>
          <?php endforeach; ?>
        </div>

        <?php if ($showcase_caption_before || $showcase_caption_strong || $showcase_caption_after) : ?>
          <p class="pl-showcase__caption">
            <?= esc_html($showcase_caption_before); ?>
            <?php if ($showcase_caption_strong) : ?> <strong><?= esc_html($showcase_caption_strong); ?></strong><?php endif; ?>
            <?= ' ' . esc_html($showcase_caption_after); ?>
          </p>
        <?php endif; ?>
      </div>
    </section>
    <?php endif; ?>

    <!-- ============ AUDIENCE ============ -->
    <?php if ($audience_enabled) : ?>
    <section class="pl-audience section-md">
      <div class="ls-container">
        <header class="pl-section-head pl-section-head--on-dark">
          <h2 class="h2 pl-h2 pl-h2--on-dark">
            <?= esc_html($audience_title_main); ?>
            <?php if ($audience_title_accent) : ?> <em><?= esc_html($audience_title_accent); ?></em><?php endif; ?>
            <?= ' ' . esc_html($audience_title_suffix); ?>
          </h2>
          <?php if ($audience_intro) : ?>
            <p class="pl-lead pl-lead--on-dark"><?= esc_html($audience_intro); ?></p>
          <?php endif; ?>
        </header>

        <div class="pl-audience__grid">
          <?php foreach ($audience_cards as $c) :
            $icon  = is_array($c) ? ($c['icon']  ?? 'cart') : 'cart';
            $title = is_array($c) ? ($c['title'] ?? '') : '';
            $text  = is_array($c) ? ($c['text']  ?? '') : '';
            $svg   = $pl_icons[$icon] ?? $pl_icons['cart'];
          ?>
            <article class="pl-aud-card">
              <span class="pl-aud-card__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><?= $svg /* hardcoded icon library */ ?></svg>
              </span>
              <?php if ($title) : ?>
                <h3 class="pl-aud-card__title"><?= esc_html($title); ?></h3>
              <?php endif; ?>
              <?php if ($text) : ?>
                <p class="pl-aud-card__text"><?= esc_html($text); ?></p>
              <?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <!-- ============ CONTACT ============ -->
    <?php if ($contact_enabled) : ?>
    <section class="pl-contact section-md" id="contact">
      <div class="ls-container">
        <div class="pl-contact__grid">

          <div class="pl-contact__info">
            <?php if ($contact_eyebrow) : ?>
              <span class="pl-eyebrow"><?= esc_html($contact_eyebrow); ?></span>
            <?php endif; ?>
            <h2 class="h2 pl-h2"><?= esc_html($contact_title); ?></h2>
            <?php if ($contact_intro) : ?>
              <p class="pl-lead"><?= esc_html($contact_intro); ?></p>
            <?php endif; ?>

            <ul class="pl-contact__details">
              <?php if ($contact_email) : ?>
                <li>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2Z"/><polyline points="22,6 12,13 2,6"/></svg>
                  <a href="mailto:<?= esc_attr($contact_email); ?>"><?= esc_html($contact_email); ?></a>
                </li>
              <?php endif; ?>
              <?php if ($contact_response_text) : ?>
                <li>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                  <span><?= esc_html($contact_response_text); ?></span>
                </li>
              <?php endif; ?>
            </ul>
          </div>

          <div class="pl-contact__form-wrap">
            <?php if ($pl_status === 'success') : ?>
              <div class="pl-form-success" role="status">
                <strong>Bedankt!</strong>
                <p><?= esc_html($form_success); ?></p>
              </div>
            <?php else : ?>
              <form class="pl-form" method="post" action="<?= esc_url(admin_url('admin-post.php')); ?>" novalidate>
                <h3 class="pl-form__title"><?= esc_html($form_title); ?></h3>
                <p class="pl-form__intro"><?= esc_html($form_intro); ?></p>

                <input type="hidden" name="action" value="pl_contact_submit">
                <?php wp_nonce_field('pl_contact_form', 'pl_nonce'); ?>
                <input type="text" name="pl_website" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;">

                <div class="pl-form__row">
                  <label class="pl-field">
                    <span class="pl-field__label">Naam</span>
                    <input type="text" name="pl_name" required placeholder="Voor- en achternaam">
                  </label>
                  <label class="pl-field">
                    <span class="pl-field__label">Bedrijf</span>
                    <input type="text" name="pl_company" required placeholder="Bedrijfsnaam">
                  </label>
                </div>

                <div class="pl-form__row">
                  <label class="pl-field">
                    <span class="pl-field__label">E-mail</span>
                    <input type="email" name="pl_email" required placeholder="naam@bedrijf.nl">
                  </label>
                  <label class="pl-field">
                    <span class="pl-field__label">Telefoon <span class="pl-field__opt">(vereist)</span></span>
                    <input type="tel" name="pl_phone" required placeholder="06 12 34 56 78">
                  </label>
                </div>

                <label class="pl-field">
                  <span class="pl-field__label">Type organisatie</span>
                  <select name="pl_type" required>
                    <option value="">Maak een keuze</option>
                    <option>Groothandel</option>
                    <option>Oogkliniek</option>
                    <option>Zorginstelling</option>
                    <option>Leverancier oogdruppels</option>
                    <option>Anders</option>
                  </select>
                </label>

                <label class="pl-field">
                  <span class="pl-field__label">Geschatte afname</span>
                  <select name="pl_volume">
                    <option value="">Maak een keuze</option>
                    <option>1.000 – 5.000 stuks</option>
                    <option>5.000 – 25.000 stuks</option>
                    <option>25.000+ stuks</option>
                    <option>Weet ik nog niet</option>
                  </select>
                </label>

                <label class="pl-field">
                  <span class="pl-field__label">Vertel kort wat je in gedachten hebt</span>
                  <textarea name="pl_message" rows="4" placeholder="Bijvoorbeeld: gewenste kleur, planning, vragen die je hebt..."></textarea>
                </label>

                <button type="submit" class="btn btn--purple pl-form__submit">
                  <?= esc_html($form_submit_label); ?>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                </button>
                <p class="pl-form__note"><?= esc_html($form_note); ?></p>
              </form>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </section>
    <?php endif; ?>

  <?php endwhile; ?>

</main>

<?php get_footer(); ?>
