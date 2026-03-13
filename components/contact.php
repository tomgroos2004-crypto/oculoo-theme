<?php
$title        = $title        ?? 'Neem contact op met Oculoo';
$lead         = $lead         ?? 'Vragen over een product of bestelling? We helpen je graag verder.';
$email_to    = $email_to    ?? 'info@oculoo.com';
$phone       = $phone       ?? '+31 6 12345678';
?>
<section class="ls-contact ls-partnership">

  <div class="ls-container">

    <!-- Intro -->
    <header class="ls-contact-intro">
      <h2 class="h2"><?= esc_html($title); ?></h2>
      <p class="lead"><?= esc_html($lead); ?></p>
    </header>

    <div class="ls-contact-grid">

      <!-- USP / Waarom -->
      <section class="ls-contact-card ls-partnership-usp">
        <h3>Waarom Oculoo?</h3>
        <ul>
          <li>Professionele evenementenproducten, direct leverbaar</li>
          <li>Persoonlijk advies bij jouw specifieke wensen</li>
          <li>Snel en betrouwbaar geleverd</li>
        </ul>
      </section>

      <!-- Conversie -->
      <section class="ls-contact-card ls-partnership-form">
        <h3>Plan een kennismaking</h3>

        <form action="https://formsubmit.co/<?= esc_attr($email_to); ?>" method="POST">
          <input type="text" name="naam" placeholder="Naam" required>
          <input type="email" name="email" placeholder="E-mail" required>
          <input type="text" name="organisatie" placeholder="Organisatie / event">
          <textarea name="bericht" rows="4" placeholder="Waar kunnen we bij helpen?" required></textarea>

          <input type="hidden" name="_captcha" value="false">
          <input type="hidden" name="_template" value="table">
          <input type="hidden" name="_subject" value="Nieuwe samenwerking aanvraag">

          <button class="btn btn-primary">Samenwerken</button>
        </form>

        <p class="small">
          Liever direct contact?
          <a href="mailto:<?= esc_attr($email_to); ?>">Mail ons</a>
          of bel
          <a href="tel:<?= esc_attr($phone); ?>"><?= esc_html($phone); ?></a>
        </p>
      </section>

    </div>

  </div>

</section>
