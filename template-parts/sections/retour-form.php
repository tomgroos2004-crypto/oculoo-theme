<?php
if (!defined('ABSPATH')) exit;

/* =========================================================
   RETOUR AANMELDEN — section
========================================================= */

$retour_status   = isset($_GET['retour_status']) ? sanitize_key($_GET['retour_status']) : '';
$retourbeleid_url = home_url('/retourbeleid/');
?>

<section class="retour-page">

  <header class="retour-hero">
    <div class="ls-container">
      <span class="retour-eyebrow">Retour</span>
      <h1 class="retour-hero__title">Retour aanmelden</h1>
      <p class="retour-hero__intro">
        Wil je een product retourneren? Meld je retour aan via het formulier. We nemen contact met je op zodra we je aanmelding hebben verwerkt.
      </p>
    </div>
  </header>

  <div class="ls-container retour-container" id="formulier">

    <aside class="retour-notice" role="note">
      <strong>Let op:</strong> Oculoo is een medisch hulpmiddel (MDR klasse I). Om hygiënische en veiligheidsredenen kunnen wij geopende verpakkingen niet retour nemen — het herroepingsrecht vervalt zodra de verzegeling is verbroken (art. 6:230p sub e BW).
      <ul class="retour-notice__list">
        <li><strong>Consument:</strong> 14 dagen bedenktijd na ontvangst, mits de verzegeling ongeopend is.</li>
        <li><strong>Zakelijk:</strong> geen herroepingsrecht. Retour alleen bij aantoonbaar productdefect, foutieve levering of transportschade.</li>
        <li><strong>Transportschade</strong> melden binnen 48 uur na ontvangst, defecten binnen 14 dagen.</li>
      </ul>
      Lees voor het aanmelden ons volledige
      <a href="<?= esc_url($retourbeleid_url); ?>">retourbeleid</a>.
    </aside>

    <?php if ($retour_status === 'success') : ?>
      <div class="retour-success" role="status">
        <strong>Bedankt voor je aanmelding.</strong>
        <p>We hebben je retourverzoek ontvangen en nemen binnen één werkdag contact met je op met de vervolgstappen.</p>
        <p><a class="btn btn--purple-outline" href="<?= esc_url(home_url('/')); ?>">Terug naar home</a></p>
      </div>
    <?php else : ?>

      <?php if ($retour_status === 'error') : ?>
        <div class="retour-error" role="alert">
          Niet alle verplichte velden zijn (correct) ingevuld. Controleer het formulier en probeer het opnieuw.
        </div>
      <?php endif; ?>

      <?php if ($retour_status === 'blocked') : ?>
        <div class="retour-error" role="alert">
          <strong>Geopende verpakkingen kunnen niet worden geretourneerd.</strong>
          <p style="margin:6px 0 0;">Om hygiënische en veiligheidsredenen nemen wij alleen producten retour waarvan de verzegeling nog intact is. Lees het volledige <a href="<?= esc_url($retourbeleid_url); ?>">retourbeleid</a>.</p>
        </div>
      <?php endif; ?>

      <?php if ($retour_status === 'business-no-withdrawal') : ?>
        <div class="retour-error" role="alert">
          <strong>Zakelijke afnemers hebben geen wettelijk herroepingsrecht.</strong>
          <p style="margin:6px 0 0;">Voor zakelijke afnemers zijn retouren alleen mogelijk bij een productdefect, foutieve levering of transportschade. Zie het volledige <a href="<?= esc_url($retourbeleid_url); ?>">retourbeleid</a>.</p>
        </div>
      <?php endif; ?>

      <form
        class="retour-form"
        method="post"
        action="<?= esc_url(admin_url('admin-post.php')); ?>"
        enctype="multipart/form-data"
        novalidate
      >
        <input type="hidden" name="action" value="ls_retour_form_submit">
        <?php wp_nonce_field('ls_retour_form', 'retour_nonce'); ?>
        <input type="text" name="retour_website" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;" aria-hidden="true">

        <fieldset class="retour-field retour-field--group">
          <legend class="retour-field__label">Type afnemer *</legend>
          <div class="retour-choices">
            <label class="retour-choice">
              <input type="radio" name="retour_buyer_type" value="Consument" required>
              <span>Consument (particulier)</span>
            </label>
            <label class="retour-choice">
              <input type="radio" name="retour_buyer_type" value="Zakelijk">
              <span>Zakelijke afnemer (apotheek, zorgwinkel, kliniek, e.d.)</span>
            </label>
          </div>
        </fieldset>

        <div class="retour-form__row">
          <label class="retour-field">
            <span class="retour-field__label">Naam *</span>
            <input type="text" name="retour_name" required placeholder="Voor- en achternaam">
          </label>
          <label class="retour-field">
            <span class="retour-field__label">E-mailadres *</span>
            <input type="email" name="retour_email" required placeholder="naam@voorbeeld.nl">
          </label>
        </div>

        <div class="retour-form__row">
          <label class="retour-field">
            <span class="retour-field__label">Bestelnummer *</span>
            <input type="text" name="retour_order" required placeholder="Bijv. 12345">
          </label>
          <label class="retour-field">
            <span class="retour-field__label">Datum van ontvangst *</span>
            <input type="date" name="retour_received_at" required>
          </label>
        </div>

        <label class="retour-field">
          <span class="retour-field__label">Product *</span>
          <select name="retour_product" required>
            <option value="">Maak een keuze</option>
            <option value="Oculoo oogdruppelbril">Oculoo oogdruppelbril</option>
            <option value="Oculoo Minim bril">Oculoo Minim bril</option>
            <option value="Anders">Anders</option>
          </select>
        </label>

        <label class="retour-field">
          <span class="retour-field__label">Reden van retour *</span>
          <select name="retour_reason" required>
            <option value="">Maak een keuze</option>
            <option value="Herroepingsrecht (binnen 14 dagen, consument)">Herroepingsrecht — bedenktijd binnen 14 dagen (alleen consument, ongeopend)</option>
            <option value="Product is defect">Product is defect (binnen 14 dagen melden)</option>
            <option value="Foutieve levering">Foutieve levering (verkeerd product of aantal)</option>
            <option value="Transportschade">Transportschade (binnen 48 uur na ontvangst)</option>
            <option value="Anders">Anders</option>
          </select>
          <span class="retour-field__hint">Voor defecten, foutieve leveringen en transportschade is een foto verplicht (zie hieronder).</span>
        </label>

        <fieldset class="retour-field retour-field--group">
          <legend class="retour-field__label">Is de verpakking geopend? *</legend>
          <div class="retour-choices">
            <label class="retour-choice">
              <input type="radio" name="retour_opened" value="Nee" required data-retour-opened="nee">
              <span>Nee, de verzegeling is nog intact</span>
            </label>
            <label class="retour-choice">
              <input type="radio" name="retour_opened" value="Ja" data-retour-opened="ja">
              <span>Ja, de verpakking is geopend</span>
            </label>
          </div>
          <p class="retour-field__hint">
            Geopende verpakkingen kunnen om hygiënische redenen niet worden teruggenomen.
            Zie ons <a href="<?= esc_url($retourbeleid_url); ?>">retourbeleid</a> voor de voorwaarden.
          </p>
        </fieldset>

        <div class="retour-block" id="retourBlock" hidden role="alert">
          <strong>Helaas, dit retourverzoek kan niet worden aangemeld.</strong>
          <p>Om hygiënische en veiligheidsredenen nemen wij geen producten retour waarvan de verpakking is geopend. Zie ons <a href="<?= esc_url($retourbeleid_url); ?>">retourbeleid</a> voor de voorwaarden.</p>
        </div>

        <label class="retour-field">
          <span class="retour-field__label">Toelichting *</span>
          <textarea name="retour_note" rows="4" required placeholder="Omschrijf de situatie en, bij een defect, wat er niet werkt zoals het hoort."></textarea>
          <span class="retour-field__hint">Bij een defect ben je wettelijk verplicht een omschrijving aan te leveren (MDR post-market surveillance).</span>
        </label>

        <label class="retour-field">
          <span class="retour-field__label">Foto uploaden <span class="retour-field__opt">(verplicht bij defect, schade of foutieve levering)</span></span>
          <input type="file" name="retour_photo" accept="image/*">
          <span class="retour-field__hint">Maximaal 8 MB. JPG, PNG of WebP.</span>
        </label>

        <label class="retour-consent">
          <input type="checkbox" name="retour_consent_policy" value="1" required>
          <span>
            Ik heb het <a href="<?= esc_url($retourbeleid_url); ?>">retourbeleid van Oculoo</a> gelezen en begrijp dat retourneren niet mogelijk is na het openen van de verzegeling.
          </span>
        </label>

        <label class="retour-consent">
          <input type="checkbox" name="retour_consent" value="1" required>
          <span>
            Ik ga akkoord met de verwerking van mijn gegevens voor de afhandeling van dit retourverzoek conform de <a href="<?= esc_url(home_url('/privacybeleid/')); ?>">privacyverklaring</a>.
          </span>
        </label>

        <button type="submit" class="btn btn--purple retour-submit" id="retourSubmit">
          Aanmelding versturen
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
        </button>
      </form>

      <script>
      (function () {
        var form    = document.querySelector('.retour-form');
        if (!form) return;
        var radios  = form.querySelectorAll('input[name="retour_opened"]');
        var block   = document.getElementById('retourBlock');
        var submit  = document.getElementById('retourSubmit');

        function update() {
          var ja = form.querySelector('input[name="retour_opened"]:checked');
          var isBlocked = ja && ja.value === 'Ja';
          if (block)  block.hidden = !isBlocked;
          if (submit) {
            submit.disabled = isBlocked;
            submit.classList.toggle('is-disabled', isBlocked);
          }
        }

        radios.forEach(function (r) { r.addEventListener('change', update); });
        form.addEventListener('submit', function (e) {
          var ja = form.querySelector('input[name="retour_opened"]:checked');
          if (ja && ja.value === 'Ja') {
            e.preventDefault();
            update();
            if (block) block.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
        });
        update();
      })();
      </script>

    <?php endif; ?>

  </div>
</section>
