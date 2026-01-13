<?php
$title     = $title     ?? '';
$lead      = $lead      ?? '';
$email_to = $email_to ?? '';
$map_query = urlencode($map_query ?? '');
?>

<section class="ls-contact">

  <div class="ls-container">

    <header class="ls-contact-intro">
      <?php if ($title) : ?>
        <h2><?= esc_html($title); ?></h2>
      <?php endif; ?>

      <?php if ($lead) : ?>
        <p><?= esc_html($lead); ?></p>
      <?php endif; ?>
    </header>

    <div class="ls-contact-grid">

      <!-- Openingstijden -->
      <section class="ls-contact-card ls-contact-hours">
        <h3>Openingstijden</h3>
        <ul>
          <li><span>Maandag</span><span>11:00 – 22:00</span></li>
          <li><span>Dinsdag</span><span>11:00 – 22:00</span></li>
          <li><span>Woensdag</span><span>10:00 – 22:00</span></li>
          <li><span>Donderdag</span><span>11:00 – 00:00</span></li>
          <li><span>Vrijdag</span><span>11:00 – 02:00</span></li>
          <li><span>Zaterdag</span><span>11:00 – 02:00</span></li>
          <li><span>Zondag</span><span>11:00 – 22:00</span></li>
        </ul>
      </section>

      <!-- Formulier -->
      <section class="ls-contact-card ls-contact-form">
        <h3>Stuur een bericht</h3>

        <form action="https://formsubmit.co/<?= esc_attr($email_to); ?>" method="POST">
          <input type="text" name="naam" placeholder="Naam" required>
          <input type="email" name="email" placeholder="E-mail" required>
          <textarea name="bericht" rows="5" placeholder="Bericht" required></textarea>

          <input type="hidden" name="_captcha" value="false">
          <input type="hidden" name="_template" value="table">

          <button class="btn">Verstuur</button>
        </form>
      </section>

      <!-- Kaart -->
      <section class="ls-contact-card ls-contact-map">
        <h3>Vind ons</h3>
        <iframe
          src="https://www.google.com/maps?q=<?= $map_query; ?>&output=embed"
          loading="lazy">
        </iframe>
      </section>

    </div>

  </div>

</section>
