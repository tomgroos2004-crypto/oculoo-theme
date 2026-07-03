<?php if (!defined('ABSPATH')) exit; ?>

<?php
$support_email  = get_field('oculoo_support_email', 'option') ?: 'support@oculoo.nl';
$company_name   = get_field('oculoo_company_name', 'option') ?: 'Oculoo B.V.';
$address        = get_field('oculoo_address', 'option') ?: '';
$email          = get_field('oculoo_email', 'option') ?: $support_email;
$kvk            = get_field('oculoo_kvk', 'option') ?: '';
$btw            = get_field('oculoo_btw', 'option') ?: '';
?>

<div class="ls-privacy">

  <header class="ls-privacy__header">
    <span class="ls-privacy__label">Juridisch document</span>
    <h1 class="ls-privacy__title">
      Privacyverklaring<br><?= esc_html($company_name); ?>
    </h1>

    <div class="ls-privacy__meta">
      <div class="ls-privacy__meta-item">
        <span class="ls-privacy__meta-label">Versie</span>
        <span class="ls-privacy__meta-value">2026</span>
      </div>
      <div class="ls-privacy__meta-item">
        <span class="ls-privacy__meta-label">Van toepassing op</span>
        <span class="ls-privacy__meta-value">oculoo.com</span>
      </div>
      <div class="ls-privacy__meta-item">
        <span class="ls-privacy__meta-label">Wetgeving</span>
        <span class="ls-privacy__meta-value">AVG / GDPR</span>
      </div>
    </div>
  </header>

  <p class="ls-privacy__intro">
    Oculoo B.V. is verantwoordelijk voor de verwerking van persoonsgegevens zoals weergegeven in deze privacyverklaring. Wij hechten grote waarde aan een zorgvuldige omgang met uw gegevens en houden ons bij alle verwerkingen aan de Algemene Verordening Gegevensbescherming (AVG).
  </p>

  <!-- ALLES HIERBOVEN ONGEWIJZIGD GELATEN -->

  <!-- JE HELE CONTENT BLIJFT EXACT HETZELFDE -->

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 1</span>
    <h2 class="ls-privacy__section-title">Persoonsgegevens die wij verwerken</h2>
    <p>Wij verwerken de volgende persoonsgegevens wanneer u een bestelling plaatst, zich aanmeldt voor onze nieuwsbrief of contact met ons opneemt.</p>
    <table class="ls-privacy__table">
      <thead>
        <tr>
          <th>Categorie</th>
          <th>Gegevens</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Identificatie</td>
          <td>Voor- en achternaam</td>
        </tr>
        <tr>
          <td>Contactgegevens</td>
          <td>Adresgegevens, e-mailadres, telefoonnummer</td>
        </tr>
        <tr>
          <td>Transactiegegevens</td>
          <td>Betalingsgegevens, bestelgegevens, factuuradres</td>
        </tr>
        <tr>
          <td>Technische gegevens</td>
          <td>IP-adres</td>
        </tr>
      </tbody>
    </table>
  </section>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 2</span>
    <h2 class="ls-privacy__section-title">Doeleinden van verwerking</h2>
    <p>Wij gebruiken uw persoonsgegevens uitsluitend voor de volgende doeleinden.</p>
    <table class="ls-privacy__table">
      <thead>
        <tr>
          <th>Doeleinde</th>
          <th>Toelichting</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Orderverwerking</td>
          <td>Het verwerken, verzenden en afhandelen van uw bestelling</td>
        </tr>
        <tr>
          <td>Betaling</td>
          <td>Het afhandelen van uw betaling</td>
        </tr>
        <tr>
          <td>Communicatie</td>
          <td>U informeren over de status van uw bestelling en contact opnemen indien nodig</td>
        </tr>
        <tr>
          <td>Nieuwsbrief</td>
          <td>Het verzenden van commerciele e-mails, uitsluitend na uw expliciete toestemming</td>
        </tr>
        <tr>
          <td>Klantenservice</td>
          <td>Het beantwoorden van vragen via contactformulier of e-mail</td>
        </tr>
        <tr>
          <td>Wettelijke verplichtingen</td>
          <td>Het voldoen aan fiscale en andere wettelijke verplichtingen</td>
        </tr>
      </tbody>
    </table>
  </section>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 3</span>
    <h2 class="ls-privacy__section-title">Rechtsgrondslag voor verwerking</h2>
    <p>Voor iedere verwerking van persoonsgegevens is een wettelijke grondslag vereist op grond van artikel 6 AVG. Wij verwerken uw gegevens op basis van de volgende grondslagen.</p>
    <div class="ls-privacy__list">
      <div class="ls-privacy__list-item">
        <span class="ls-privacy__term">Uitvoering van een overeenkomst</span>
        <span class="ls-privacy__desc">Voor het verwerken van uw bestelling en de levering van producten.</span>
      </div>
      <div class="ls-privacy__list-item">
        <span class="ls-privacy__term">Wettelijke verplichting</span>
        <span class="ls-privacy__desc">Voor fiscale bewaarplichten en andere wettelijke verplichtingen.</span>
      </div>
      <div class="ls-privacy__list-item">
        <span class="ls-privacy__term">Toestemming</span>
        <span class="ls-privacy__desc">Voor het verzenden van nieuwsbrieven en commerciele e-mails. U kunt uw toestemming te allen tijde intrekken via de afmeldlink in elke e-mail of door contact met ons op te nemen.</span>
      </div>
      <div class="ls-privacy__list-item">
        <span class="ls-privacy__term">Gerechtvaardigd belang</span>
        <span class="ls-privacy__desc">Voor het beantwoorden van vragen en het verbeteren van onze dienstverlening.</span>
      </div>
    </div>
  </section>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 4</span>
    <h2 class="ls-privacy__section-title">Beveiliging van persoonsgegevens</h2>
    <p>Oculoo B.V. neemt de bescherming van uw gegevens serieus en treft passende technische en organisatorische maatregelen ter beveiliging van uw persoonsgegevens tegen verlies, misbruik, onbevoegde toegang, ongewenste openbaarmaking en ongeoorloofde wijziging.</p>
    <p>Onze website maakt gebruik van een beveiligde SSL/TLS-verbinding. Alle gegevens die worden uitgewisseld tussen uw browser en onze server zijn versleuteld.</p>
  </section>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 5</span>
    <h2 class="ls-privacy__section-title">Nieuwsbrief en e-mailmarketing</h2>
    <p>Wij bieden een nieuwsbrief aan waarmee wij geinteresseerden informeren over onze producten en diensten. Uw e-mailadres wordt uitsluitend met uw expliciete en aantoonbare toestemming toegevoegd aan onze mailinglijst. Iedere e-mail bevat een afmeldlink waarmee u zich op elk moment kunt uitschrijven. Na afmelding verwijderen wij uw e-mailadres direct uit onze lijst.</p>
  </section>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 6</span>
    <h2 class="ls-privacy__section-title">Verstrekking aan derde partijen</h2>
    <p>Oculoo B.V. verstrekt uw persoonsgegevens uitsluitend aan derden wanneer dit noodzakelijk is voor de uitvoering van de overeenkomst, bijvoorbeeld aan onze logistieke partner voor de bezorging van uw bestelling, of wanneer wij hiertoe wettelijk verplicht zijn.</p>
    <p>Wij verstrekken uw gegevens niet aan derden voor commerciele doeleinden zonder uw uitdrukkelijke toestemming. In geval van een vermoeden van fraude of misbruik kunnen persoonsgegevens worden overgedragen aan de bevoegde autoriteiten.</p>
    <p>Deze privacyverklaring is niet van toepassing op websites van derden die via links op onze website bereikbaar zijn. Wij adviseren u de privacyverklaring van deze websites te raadplegen alvorens er gebruik van te maken.</p>
  </section>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 7</span>
    <h2 class="ls-privacy__section-title">Bewaartermijnen</h2>
    <p>Wij bewaren uw persoonsgegevens niet langer dan strikt noodzakelijk voor de doeleinden waarvoor zij zijn verzameld.</p>
    <div class="ls-privacy__list">
      <div class="ls-privacy__list-item">
        <span class="ls-privacy__term">Bestel- en klantgegevens</span>
        <span class="ls-privacy__desc">Bewaard zolang nodig voor de afhandeling van de bestelling en eventuele garantie, daarna verwijderd.</span>
      </div>
      <div class="ls-privacy__list-item">
        <span class="ls-privacy__term">Financiele gegevens</span>
        <span class="ls-privacy__desc">7 jaar op grond van de wettelijke fiscale bewaarplicht (artikel 52 AWR).</span>
      </div>
      <div class="ls-privacy__list-item">
        <span class="ls-privacy__term">Nieuwsbriefabonnees</span>
        <span class="ls-privacy__desc">Tot het moment van afmelding.</span>
      </div>
      <div class="ls-privacy__list-item">
        <span class="ls-privacy__term">Contactberichten</span>
        <span class="ls-privacy__desc">Maximaal 2 jaar na volledige afhandeling.</span>
      </div>
    </div>
  </section>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 8</span>
    <h2 class="ls-privacy__section-title">Cookies</h2>
    <p>Onze website maakt uitsluitend gebruik van functionele cookies. Deze cookies zijn noodzakelijk voor het correct functioneren van de webwinkel, zoals het bijhouden van uw winkelwagen en het onthouden van uw sessie. Voor functionele cookies is op grond van de Telecommunicatiewet geen toestemming vereist.</p>
    <p>Wij plaatsen geen tracking- of advertentiecookies zonder uw voorafgaande toestemming.</p>
  </section>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 9</span>
    <h2 class="ls-privacy__section-title">Minderjarigen</h2>
    <p>Onze website heeft niet de intentie persoonsgegevens te verzamelen van bezoekers jonger dan 16 jaar, tenzij zij daarvoor toestemming hebben van een ouder of wettelijk voogd. Bent u ervan overtuigd dat wij zonder die toestemming gegevens van een minderjarige hebben verzameld, neem dan contact met ons op via contact@oculoo.com. Wij verwijderen deze gegevens zo spoedig mogelijk.</p>
  </section>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 10</span>
    <h2 class="ls-privacy__section-title">Uw rechten als betrokkene</h2>
    <p>Op grond van de AVG heeft u de volgende rechten met betrekking tot uw persoonsgegevens. U kunt uw rechten uitoefenen door een schriftelijk verzoek te sturen naar contact@oculoo.com. Wij reageren binnen 30 dagen. Om misbruik te voorkomen kunnen wij u vragen uzelf adequaat te identificeren.</p>
    <div class="ls-privacy__rights">
      <div class="ls-privacy__right">
        <div class="ls-privacy__right-title">Recht op inzage</div>
        <div class="ls-privacy__right-desc">U kunt opvragen welke persoonsgegevens wij van u verwerken.</div>
      </div>
      <div class="ls-privacy__right">
        <div class="ls-privacy__right-title">Recht op rectificatie</div>
        <div class="ls-privacy__right-desc">U kunt onjuiste of onvolledige gegevens laten corrigeren.</div>
      </div>
      <div class="ls-privacy__right">
        <div class="ls-privacy__right-title">Recht op verwijdering</div>
        <div class="ls-privacy__right-desc">U kunt verzoeken uw gegevens te laten wissen, voor zover de wet dit toestaat.</div>
      </div>
      <div class="ls-privacy__right">
        <div class="ls-privacy__right-title">Recht op beperking</div>
        <div class="ls-privacy__right-desc">U kunt verzoeken de verwerking van uw gegevens te beperken.</div>
      </div>
      <div class="ls-privacy__right">
        <div class="ls-privacy__right-title">Recht van bezwaar</div>
        <div class="ls-privacy__right-desc">U kunt bezwaar maken tegen verwerking op basis van gerechtvaardigd belang.</div>
      </div>
      <div class="ls-privacy__right">
        <div class="ls-privacy__right-title">Recht op overdraagbaarheid</div>
        <div class="ls-privacy__right-desc">U kunt een gestructureerde export opvragen van gegevens die wij met uw toestemming verwerken.</div>
      </div>
    </div>
  </section>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 11</span>
    <h2 class="ls-privacy__section-title">Klachten en toezichthouder</h2>
    <p>Wij helpen u graag als u klachten heeft over de verwerking van uw persoonsgegevens. Neemt u in dat geval eerst contact met ons op via onderstaande contactgegevens.</p>
    <p>U heeft daarnaast het recht een klacht in te dienen bij de Nederlandse toezichthouder, de Autoriteit Persoonsgegevens, via www.autoriteitpersoonsgegevens.nl.</p>
  </section>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Artikel 12</span>
    <h2 class="ls-privacy__section-title">Wijzigingen in deze privacyverklaring</h2>
    <p>Oculoo B.V. behoudt zich het recht voor deze privacyverklaring te wijzigen. Wijzigingen worden gepubliceerd op onze website. De datum van de meest recente versie is vermeld onderaan dit document. Wij adviseren u deze verklaring periodiek te raadplegen.</p>
  </section>

  <section class="ls-privacy__section">
  <span class="ls-privacy__number">Contactgegevens</span>
  <h2 class="ls-privacy__section-title">Verantwoordelijke voor de verwerking</h2>

  <div class="ls-privacy__contact">
    <strong><?= esc_html($company_name); ?></strong>

    <p>
      <?php if ($address): ?>
        <?= esc_html($address); ?><br>
      <?php endif; ?>

      <?php if ($kvk): ?>
        KvK-nummer: <?= esc_html($kvk); ?><br>
      <?php else: ?>
        KvK-nummer: 99070847<br>
      <?php endif; ?>

      E-mail:
      <a href="mailto:<?= esc_attr($support_email); ?>">
        <?= esc_html($support_email); ?>
      </a><br>

      Website:
      <a href="https://www.oculoo.com">
        www.oculoo.com
      </a>
    </p>
  </div>
</section>

  <footer class="ls-privacy__footer">
    <span class="ls-privacy__footer-brand">Oculoo B.V.</span>
    <span class="ls-privacy__footer-version">Privacyverklaring - Versie 2026</span>
  </footer>
</div>
