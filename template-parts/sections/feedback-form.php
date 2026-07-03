<?php
if (!defined('ABSPATH')) exit;

/* =========================================================
   FEEDBACK FORMULIER – section
   ACF velden (optioneel) voor hero-tekst, anders defaults.
========================================================= */

$hero_title = get_field('feedback_hero_title') ?: 'Vertel ons hoe het ging';
$hero_text  = get_field('feedback_hero_text')  ?: 'Jouw ervaring helpt ons om Oculoo nog beter te maken. Het kost je nog geen 2 minuten.';
$privacy_url = get_field('feedback_privacy_url') ?: home_url('/privacy/');
?>

<section class="feedback-section">

  <header class="feedback-hero">
    <div class="ls-container">
      <h1 class="feedback-hero__title"><?= esc_html($hero_title); ?></h1>
      <?php if ($hero_text) : ?>
        <p class="feedback-hero__intro"><?= esc_html($hero_text); ?></p>
      <?php endif; ?>
    </div>
  </header>

  <div class="ls-container feedback-container">
    <div class="feedback-card" id="feedbackCard">

      <div class="feedback-progress" id="feedbackProgress">
        <div class="feedback-progress__step is-current"></div>
        <div class="feedback-progress__step"></div>
        <div class="feedback-progress__step"></div>
        <div class="feedback-progress__step"></div>
      </div>

      <div class="feedback-error" id="feedbackError" role="alert">
        Er ging iets mis met versturen. Probeer het zo nog eens, of mail <a href="mailto:support@oculoo.com">support@oculoo.com</a>.
      </div>

      <form id="feedbackForm" novalidate>

        <!-- STAP 1 -->
        <section class="feedback-step is-active" data-step="1">
          <span class="feedback-step__label">Stap 1 van 4</span>
          <h2 class="feedback-step__title">Hoe beviel je Oculoo?</h2>
          <p class="feedback-step__sub">Eerst even: hoe tevreden ben je over het gebruik?</p>

          <div class="feedback-field">
            <label class="feedback-field__label">Geef Oculoo een rating</label>
            <div class="feedback-stars">
              <input type="radio" name="rating" id="fbr5" value="5"><label for="fbr5">★</label>
              <input type="radio" name="rating" id="fbr4" value="4"><label for="fbr4">★</label>
              <input type="radio" name="rating" id="fbr3" value="3"><label for="fbr3">★</label>
              <input type="radio" name="rating" id="fbr2" value="2"><label for="fbr2">★</label>
              <input type="radio" name="rating" id="fbr1" value="1"><label for="fbr1">★</label>
            </div>
          </div>

          <div class="feedback-field">
            <label class="feedback-field__label">Hoe makkelijk vond je het druppelen met Oculoo?</label>
            <div class="feedback-emoji-row">
              <label>
                <input type="radio" name="gemak" value="zeer_moeilijk">
                <span class="feedback-emoji-icon">😣</span>
                <span class="feedback-emoji-label">Heel moeilijk</span>
              </label>
              <label>
                <input type="radio" name="gemak" value="moeilijk">
                <span class="feedback-emoji-icon">😕</span>
                <span class="feedback-emoji-label">Moeilijk</span>
              </label>
              <label>
                <input type="radio" name="gemak" value="oke">
                <span class="feedback-emoji-icon">😐</span>
                <span class="feedback-emoji-label">Oké</span>
              </label>
              <label>
                <input type="radio" name="gemak" value="makkelijk">
                <span class="feedback-emoji-icon">🙂</span>
                <span class="feedback-emoji-label">Makkelijk</span>
              </label>
              <label>
                <input type="radio" name="gemak" value="heel_makkelijk">
                <span class="feedback-emoji-icon">😄</span>
                <span class="feedback-emoji-label">Heel makkelijk</span>
              </label>
            </div>
          </div>

          <div class="feedback-field">
            <label class="feedback-field__label">Welke Oculoo gebruik je?</label>
            <div class="feedback-choices">
              <label><input type="radio" name="model" value="STD"><span>Oogdruppelbril</span></label>
              <label><input type="radio" name="model" value="Minim"><span>Oculoo Minimbril</span></label>
              <label><input type="radio" name="model" value="beide"><span>Allebei</span></label>
            </div>
          </div>

          <div class="feedback-field">
            <label class="feedback-field__label">Hoe vaak gebruik je je Oculoo?</label>
            <div class="feedback-choices">
              <label><input type="radio" name="frequentie" value="dagelijks"><span>Elke dag</span></label>
              <label><input type="radio" name="frequentie" value="paar_per_week"><span>Een paar keer per week</span></label>
              <label><input type="radio" name="frequentie" value="af_en_toe"><span>Af en toe</span></label>
              <label><input type="radio" name="frequentie" value="eerste_keer"><span>Net voor het eerst</span></label>
            </div>
          </div>

          <div class="feedback-nav">
            <button type="button" class="btn btn-primary feedback-btn-next">Volgende</button>
          </div>
        </section>

        <!-- STAP 2 -->
        <section class="feedback-step" data-step="2">
          <span class="feedback-step__label">Stap 2 van 4</span>
          <h2 class="feedback-step__title">Werkte het zoals het moest?</h2>
          <p class="feedback-step__sub">Vertel ons hoe Oculoo presteerde in de praktijk.</p>

          <div class="feedback-field">
            <label class="feedback-field__label">Kwam de druppel goed in je oog terecht?</label>
            <div class="feedback-choices">
              <label><input type="radio" name="druppel" value="altijd"><span>Altijd</span></label>
              <label><input type="radio" name="druppel" value="meestal"><span>Meestal wel</span></label>
              <label><input type="radio" name="druppel" value="soms"><span>Soms</span></label>
              <label><input type="radio" name="druppel" value="vaak_niet"><span>Vaak niet</span></label>
            </div>
          </div>

          <div class="feedback-field">
            <label class="feedback-field__label">Past jouw oogdruppelflesje in de bril?</label>
            <div class="feedback-choices">
              <label><input type="radio" name="flesje" value="ja"><span>Ja, prima</span></label>
              <label><input type="radio" name="flesje" value="moeite"><span>Met moeite</span></label>
              <label><input type="radio" name="flesje" value="nee"><span>Nee, past niet</span></label>
            </div>
          </div>

          <div class="feedback-field">
            <label class="feedback-field__label">
              Had je problemen tijdens het gebruik?
              <span class="feedback-field__meta">(meerdere mogelijk)</span>
            </label>
            <div class="feedback-choices">
              <label><input type="checkbox" name="problemen[]" value="geen"><span>Nee, geen</span></label>
              <label><input type="checkbox" name="problemen[]" value="positie"><span>Bril zat niet goed</span></label>
              <label><input type="checkbox" name="problemen[]" value="knijpen"><span>Knijpen lukte niet</span></label>
              <label><input type="checkbox" name="problemen[]" value="mikken"><span>Druppel kwam ernaast</span></label>
              <label><input type="checkbox" name="problemen[]" value="hygiene"><span>Bril raakte mijn oog</span></label>
              <label><input type="checkbox" name="problemen[]" value="schade"><span>Bril is beschadigd</span></label>
              <label><input type="checkbox" name="problemen[]" value="anders"><span>Iets anders</span></label>
            </div>
          </div>

          <div class="feedback-field feedback-conditional" id="problemDetail">
            <label class="feedback-field__label">Wil je daar iets meer over zeggen?</label>
            <textarea name="problemen_uitleg" placeholder="Beschrijf kort wat er gebeurde. Hoe vaker je gebruikt, hoe waardevoller jouw antwoord."></textarea>
          </div>

          <div class="feedback-field">
            <label class="feedback-field__label">Heb je last gehad van je oog door het gebruik?</label>
            <p class="feedback-field__hint">Bijvoorbeeld irritatie, pijn, roodheid of een ander vervelend gevoel.</p>
            <div class="feedback-choices">
              <label><input type="radio" name="klacht" value="nee"><span>Nee, geen klachten</span></label>
              <label><input type="radio" name="klacht" value="licht"><span>Een beetje</span></label>
              <label><input type="radio" name="klacht" value="duidelijk"><span>Ja, duidelijk</span></label>
              <label><input type="radio" name="klacht" value="arts"><span>Ja, naar arts geweest</span></label>
            </div>
          </div>

          <div class="feedback-field feedback-conditional" id="klachtDetail">
            <label class="feedback-field__label">Wat heb je gemerkt?</label>
            <textarea name="klacht_uitleg" placeholder="Wat voelde je, hoe lang duurde het, en wat hielp? Dit is belangrijk voor onze productveiligheid."></textarea>
          </div>

          <div class="feedback-nav">
            <button type="button" class="btn btn-secondary feedback-btn-prev">Terug</button>
            <button type="button" class="btn btn-primary feedback-btn-next">Volgende</button>
          </div>
        </section>

        <!-- STAP 3 -->
        <section class="feedback-step" data-step="3">
          <span class="feedback-step__label">Stap 3 van 4</span>
          <h2 class="feedback-step__title">De verpakking en uitleg</h2>
          <p class="feedback-step__sub">Was alles helder vanaf het moment dat je de doos opende?</p>

          <div class="feedback-field">
            <label class="feedback-field__label">Was de verpakking onbeschadigd toen je hem opende?</label>
            <div class="feedback-choices">
              <label><input type="radio" name="verpakking" value="ja"><span>Ja</span></label>
              <label><input type="radio" name="verpakking" value="licht"><span>Een beetje beschadigd</span></label>
              <label><input type="radio" name="verpakking" value="beschadigd"><span>Beschadigd</span></label>
            </div>
          </div>

          <div class="feedback-field">
            <label class="feedback-field__label">Was de gebruiksaanwijzing duidelijk?</label>
            <div class="feedback-choices">
              <label><input type="radio" name="uitleg" value="heel_duidelijk"><span>Heel duidelijk</span></label>
              <label><input type="radio" name="uitleg" value="duidelijk"><span>Duidelijk</span></label>
              <label><input type="radio" name="uitleg" value="niet_helemaal"><span>Niet helemaal</span></label>
              <label><input type="radio" name="uitleg" value="onduidelijk"><span>Onduidelijk</span></label>
            </div>
          </div>

          <div class="feedback-field">
            <label class="feedback-field__label">Waar heb je je Oculoo gekocht?</label>
            <select name="kanaal">
              <option value="">Maak een keuze</option>
              <option value="apotheek">Apotheek</option>
              <option value="zorgwinkel">Zorgwinkel</option>
              <option value="thuiszorg">Via de thuiszorg</option>
              <option value="oogarts">Oogarts of kliniek</option>
              <option value="webshop">Webshop (oculoo.com)</option>
              <option value="anders">Anders</option>
            </select>
          </div>

          <div class="feedback-nav">
            <button type="button" class="btn btn-secondary feedback-btn-prev">Terug</button>
            <button type="button" class="btn btn-primary feedback-btn-next">Volgende</button>
          </div>
        </section>

        <!-- STAP 4 -->
        <section class="feedback-step" data-step="4">
          <span class="feedback-step__label">Stap 4 van 4</span>
          <h2 class="feedback-step__title">Nog iets kwijt?</h2>
          <p class="feedback-step__sub">Tips, complimenten, of iets wat beter kan. We lezen alles.</p>

          <div class="feedback-field">
            <label class="feedback-field__label">Wat zou je willen meegeven?</label>
            <textarea name="opmerking" placeholder="Bijvoorbeeld: wat ging er goed, wat kan beter, wat zou je veranderen?"></textarea>
          </div>

          <div class="feedback-field">
            <label class="feedback-field__label">Mogen we contact opnemen als we vragen hebben?</label>
            <p class="feedback-field__hint">Alleen invullen als dat oké is. Optioneel.</p>
            <input type="email" name="email" placeholder="E-mailadres (optioneel)">
          </div>

          <div class="feedback-field">
            <label class="feedback-consent">
              <input type="checkbox" name="consent" value="1" id="fbConsent">
              <span>Ik ga ermee akkoord dat Oculoo B.V. mijn antwoorden bewaart om het product en de dienstverlening te verbeteren. Lees onze <a href="<?= esc_url($privacy_url); ?>" target="_blank" rel="noopener">privacyverklaring</a>.</span>
            </label>
          </div>

          <div class="feedback-nav">
            <button type="button" class="btn btn-secondary feedback-btn-prev">Terug</button>
            <button type="submit" class="btn btn-primary feedback-btn-submit" id="feedbackSubmit">Versturen</button>
          </div>
        </section>

        <!-- SUCCES -->
        <section class="feedback-step" data-step="5">
          <div class="feedback-success">
            <svg class="feedback-success__mark" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <circle cx="35" cy="50" r="22" fill="none" stroke="var(--color-primary)" stroke-width="9"/>
              <circle cx="65" cy="50" r="22" fill="none" stroke="var(--color-accent)" stroke-width="9"/>
              <path id="feedbackCheckmark" d="M 30 50 L 42 60 L 60 38" fill="none" stroke="var(--color-primary)" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" opacity="0"/>
            </svg>
            <h2 class="feedback-success__title">Bedankt!</h2>
            <p class="feedback-success__text">Je feedback komt direct bij ons team terecht en helpt ons om Oculoo elke dag beter te maken.</p>
            <div class="feedback-success__tagline">Easy as that.</div>
          </div>
        </section>

      </form>
    </div>
  </div>
</section>
