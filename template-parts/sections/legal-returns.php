<?php if (!defined('ABSPATH')) exit; ?>

<?php
$company_name  = get_field('oculoo_company_name', 'option') ?: 'Oculoo B.V.';
$address       = get_field('oculoo_address', 'option') ?: '';
$support_email = get_field('oculoo_support_email', 'option') ?: 'support@oculoo.nl';
$kvk           = get_field('oculoo_kvk', 'option') ?: '99070847';

$version = get_field('returns_version') ?: '22 april 2026';
$intro   = get_field('returns_intro');

/**
 * Fallback artikelen op basis van de PDF
 * "Retourbeleid Oculoo B.V."
 * Wordt alleen gebruikt wanneer de ACF-repeater leeg is.
 */
$fallback_articles = [
  [
    'number'  => '1',
    'title'   => 'Definities',
    'content' => '<p>1.1 In dit retourbeleid wordt verstaan onder:</p>
<ul>
  <li><strong>Afnemer</strong>: iedere natuurlijke persoon of rechtspersoon die met Oculoo een overeenkomst is aangegaan;</li>
  <li><strong>Consument</strong>: een Afnemer die een natuurlijke persoon is en die niet handelt in de uitoefening van een beroep of bedrijf;</li>
  <li><strong>Herroepingsrecht</strong>: het recht van de Consument om een overeenkomst op afstand binnen de wettelijke bedenktijd te ontbinden zonder opgave van redenen;</li>
  <li><strong>Product</strong>: de Oculoo oogdruppelbril, de Oculoo Minim bril en alle overige door Oculoo geleverde zaken, zoals nader omschreven in de Algemene Voorwaarden;</li>
  <li><strong>Verzegeling</strong>: de buisfolie waarin het Product per stuk is geseald en die slechts éénmalig kan worden gesloten. Het verbreken of beschadigen van deze buisfolie geldt als aantoonbaar bewijs dat het Product is geopend;</li>
  <li><strong>Zakelijke Afnemer</strong>: een Afnemer die handelt in de uitoefening van een beroep of bedrijf, waaronder mede begrepen apotheken, zorgwinkels, thuiszorgorganisaties en oogartspraktijken.</li>
</ul>',
  ],
  [
    'number'  => '2',
    'title'   => 'Toepasselijkheid',
    'content' => '<p>2.1 Dit retourbeleid is van toepassing op alle verkopen van Producten door Oculoo, ongeacht het verkoopkanaal.</p>
<p>2.2 Voor zover dit retourbeleid afwijkt van de Algemene Verkoop- en Leveringsvoorwaarden van Oculoo, prevaleert dit retourbeleid ten aanzien van retouren.</p>
<p>2.3 Op Consumenten zijn tevens de dwingende bepalingen van Boek 6 en Boek 7 van het Burgerlijk Wetboek van toepassing. Niets in dit beleid doet afbreuk aan de wettelijke rechten van de Consument.</p>',
  ],
  [
    'number'  => '3',
    'title'   => 'Herroepingsrecht Consument (webshop / verkoop op afstand)',
    'content' => '<p><strong>3.1 Bedenktijd</strong></p>
<p>3.1 Een Consument die een Product heeft aangeschaft via de webshop of een andere vorm van verkoop op afstand, heeft het recht de overeenkomst zonder opgave van redenen te ontbinden binnen veertien (14) kalenderdagen na ontvangst van het Product.</p>
<p>3.2 Om gebruik te maken van het herroepingsrecht dient de Consument Oculoo hiervan ondubbelzinnig en schriftelijk in kennis te stellen, bijvoorbeeld per e-mail via het daartoe beschikbaar gestelde contactformulier of e-mailadres.</p>
<p>3.3 De Consument dient het Product uiterlijk veertien (14) kalenderdagen na kennisgeving van herroeping aan Oculoo terug te zenden. De bewijslast voor tijdige verzending ligt bij de Consument.</p>
<p><strong>3.2 Uitsluiting herroepingsrecht bij geopende verzegeling</strong></p>
<p>3.4 De Oculoo oogdruppelbril en overige Producten kwalificeren als medisch hulpmiddel in de zin van Verordening (EU) 2017/745 (MDR). Vanwege de hygiënische aard van het Product en de gezondheidsrisico\'s verbonden aan hergebruik door een derde, is het herroepingsrecht op grond van artikel 6:230p sub e van het Burgerlijk Wetboek uitdrukkelijk uitgesloten zodra de Verzegeling (de eenmalig te sluiten buisfolie) na levering is geopend of beschadigd.</p>
<p>3.5 De uitsluiting van het herroepingsrecht treedt in werking op het moment dat de Consument de Verzegeling verbreekt. Een geopend Product kan om hygiënische redenen niet worden teruggenomen en niet opnieuw worden verhandeld.</p>
<p>3.6 De Consument wordt vóór het voltooien van de aankoop uitdrukkelijk geïnformeerd over deze uitsluiting en dient hiermee akkoord te gaan door middel van een actieve bevestiging (aanvinkvakje) bij de afronding van de bestelling. Zonder deze bevestiging kan de bestelling niet worden voltooid.</p>
<p>3.7 De exacte tekst van de checkout-bevestiging is opgenomen in artikel 5 van dit retourbeleid.</p>
<p><strong>3.3 Retour bij ongeopende verzegeling</strong></p>
<p>3.8 Indien de Consument het herroepingsrecht tijdig en rechtsgeldig uitoefent en de Verzegeling aantoonbaar ongeopend is, heeft de Consument recht op terugbetaling van de aankoopprijs.</p>
<p>3.9 De kosten van retourzending komen voor rekening van de Consument.</p>
<p>3.10 Terugbetaling vindt plaats binnen veertien (14) kalenderdagen na ontvangst van het geretourneerde Product door Oculoo, mits het Product ongeopend en onbeschadigd is ontvangen.</p>
<p>3.11 Oculoo is gerechtigd terugbetaling op te schorten totdat het Product is ontvangen dan wel de Consument heeft aangetoond dat het Product is teruggezonden.</p>',
  ],
  [
    'number'  => '4',
    'title'   => 'Retouren Zakelijke Afnemers',
    'content' => '<p>4.1 Zakelijke Afnemers hebben geen wettelijk herroepingsrecht. Retouren door Zakelijke Afnemers zijn uitsluitend mogelijk in de volgende gevallen:</p>
<ul>
  <li><strong>Aantoonbaar productdefect</strong>: het Product functioneert niet conform de productspecificaties bij eerste gebruik, zonder beschadiging door de Zakelijke Afnemer of eindgebruiker;</li>
  <li><strong>Foutieve levering</strong>: er is een verkeerd Product of een verkeerde hoeveelheid geleverd door Oculoo;</li>
  <li><strong>Transportschade</strong>: zichtbare beschadiging bij aflevering, gemeld binnen achtenveertig (48) uur na ontvangst.</li>
</ul>
<p>4.2 Retourmeldingen dienen schriftelijk, voorzien van een beschrijving en fotomateriaal van het defect, te worden ingediend binnen veertien (14) dagen na constatering, per e-mail aan het daartoe bestemde contactadres van Oculoo.</p>
<p>4.3 Retouren zonder voorafgaande schriftelijke toestemming van Oculoo worden niet geaccepteerd.</p>
<p>4.4 Creditering vindt plaats na beoordeling en acceptatie van het retour, binnen veertien (14) werkdagen.</p>
<p>4.5 Gebruikte, geopende of beschadigde Producten komen niet voor retour in aanmerking, tenzij het defect reeds bij eerste opening aanwezig was.</p>',
  ],
  [
    'number'  => '5',
    'title'   => 'Checkout-bevestiging (tekst aanvinkvakje webshop)',
    'content' => '<p>De navolgende tekst wordt aan de Consument gepresenteerd bij de afronding van de bestelling via de webshop, voorafgaand aan de definitieve betalingsstap. De Consument dient dit aanvinkvakje actief aan te vinken. Het vakje is standaard niet aangevinkt. Zonder aanvinken kan de bestelling niet worden voltooid.</p>
<p><strong>Tekst aanvinkvakje (weergave in webshop):</strong></p>
<p>☐ Ik ga akkoord met het retourbeleid van Oculoo en begrijp dat retourneren niet mogelijk is na het openen van de verzegeling.</p>
<p><strong>Toelichting:</strong></p>
<ul>
  <li>Het aanvinkvakje is standaard niet aangevinkt (opt-in, conform art. 6:230p BW).</li>
  <li>De tekst bevat een klikbare link naar de volledige retourbeleidspagina op de website van Oculoo.</li>
  <li>De bevestiging wordt opgeslagen in de orderadministratie als bewijs van kennisgeving en acceptatie.</li>
  <li>Zonder aanvinken is de bestelknop ("Bestelling plaatsen") niet actief.</li>
</ul>',
  ],
  [
    'number'  => '6',
    'title'   => 'Defecte of niet-conforme Producten',
    'content' => '<p>5.1 Ontvangt de Consument of Zakelijke Afnemer een Product dat bij levering aantoonbaar beschadigd, defect of niet conform de productomschrijving is, dan dient dit binnen veertien (14) dagen na ontvangst schriftelijk te worden gemeld bij Oculoo.</p>
<p>5.2 Oculoo zal, naar eigen keuze, overgaan tot kosteloze vervanging of terugbetaling van het aankoopbedrag.</p>
<p>5.3 De Afnemer wordt verzocht het defect te omschrijven en indien mogelijk te fotograferen. Deze documentatie is mede noodzakelijk voor de wettelijk verplichte klachtenregistratie in het kader van de MDR post-market surveillance.</p>
<p>5.4 Op een defect Product is de garantietermijn van artikel 8 van de Algemene Verkoop- en Leveringsvoorwaarden van toepassing. Voor Consumenten geldt onverminderd de wettelijke conformiteitsgarantie van twee (2) jaar op grond van artikel 7:21 BW.</p>',
  ],
  [
    'number'  => '7',
    'title'   => 'MDR-registratieplicht en kwaliteitsborging',
    'content' => '<p>5.5 Iedere retourzending en iedere klacht over een Product wordt door Oculoo geregistreerd in het interne klachten- en retourregister, overeenkomstig de vereisten van Verordening (EU) 2017/745 (MDR) en het kwaliteitsmanagementsysteem van Oculoo.</p>
<p>5.6 Geretourneerde Producten worden na ontvangst beoordeeld. Geopende of gebruikte Producten worden om hygiënische en veiligheidsredenen vernietigd en niet opnieuw in de handel gebracht.</p>
<p>5.7 Indien bij beoordeling van een retour aanwijzingen bestaan voor een ernstig incident in de zin van artikel 87 MDR, zal Oculoo de Inspectie Gezondheidszorg en Jeugd (IGJ) hiervan in kennis stellen.</p>',
  ],
  [
    'number'  => '8',
    'title'   => 'Slotbepaling',
    'content' => '<p>5.8 Dit retourbeleid is voor het laatste herzien op 22 april 2026.</p>
<p>5.9 Oculoo behoudt zich het recht voor dit retourbeleid te wijzigen. De meest actuele versie is te raadplegen op de website van Oculoo.</p>
<p>5.10 Op dit retourbeleid is uitsluitend Nederlands recht van toepassing. Geschillen worden voorgelegd aan de bevoegde rechter van de Rechtbank Overijssel, locatie Almelo.</p>',
  ],
];

$has_acf_articles = have_rows('returns_articles');
?>

<div class="ls-privacy ls-privacy--terms">

  <header class="ls-privacy__header">
    <span class="ls-privacy__label">Juridisch document</span>
    <h1 class="ls-privacy__title">
      Retourbeleid<br><?= esc_html($company_name); ?>
    </h1>

    <div class="ls-privacy__meta">
      <div class="ls-privacy__meta-item">
        <span class="ls-privacy__meta-label">Versie</span>
        <span class="ls-privacy__meta-value"><?= esc_html($version); ?></span>
      </div>
      <div class="ls-privacy__meta-item">
        <span class="ls-privacy__meta-label">Van toepassing op</span>
        <span class="ls-privacy__meta-value">oculoo.com</span>
      </div>
      <div class="ls-privacy__meta-item">
        <span class="ls-privacy__meta-label">KvK-nummer</span>
        <span class="ls-privacy__meta-value"><?= esc_html($kvk); ?></span>
      </div>
    </div>
  </header>

  <div class="ls-privacy__intro">
    <?php if ($intro): ?>
      <?= wpautop(wp_kses_post($intro)); ?>
    <?php else: ?>
      <p>Dit retourbeleid is opgesteld door de besloten vennootschap met beperkte aansprakelijkheid <?= esc_html($company_name); ?>, statutair gevestigd te Groenlo en ingeschreven in het handelsregister van de Kamer van Koophandel onder nummer <?= esc_html($kvk); ?> (hierna: "Oculoo"). Dit beleid is van toepassing naast en in aanvulling op de Algemene Verkoop- en Leveringsvoorwaarden van Oculoo.</p>
    <?php endif; ?>
  </div>

  <?php if ($has_acf_articles): ?>
    <?php while (have_rows('returns_articles')) : the_row();
      $number  = get_sub_field('article_number');
      $title   = get_sub_field('article_title');
      $content = get_sub_field('article_content');
    ?>
      <section class="ls-privacy__section">
        <?php if ($number): ?>
          <span class="ls-privacy__number">Artikel <?= esc_html($number); ?></span>
        <?php endif; ?>
        <?php if ($title): ?>
          <h2 class="ls-privacy__section-title"><?= esc_html($title); ?></h2>
        <?php endif; ?>
        <div class="ls-privacy__body">
          <?= wp_kses_post($content); ?>
        </div>
      </section>
    <?php endwhile; ?>
  <?php else: ?>
    <?php foreach ($fallback_articles as $article): ?>
      <section class="ls-privacy__section">
        <span class="ls-privacy__number">Artikel <?= esc_html($article['number']); ?></span>
        <h2 class="ls-privacy__section-title"><?= esc_html($article['title']); ?></h2>
        <div class="ls-privacy__body">
          <?= wp_kses_post($article['content']); ?>
        </div>
      </section>
    <?php endforeach; ?>
  <?php endif; ?>

  <section class="ls-privacy__section">
    <span class="ls-privacy__number">Contactgegevens</span>
    <h2 class="ls-privacy__section-title">Vragen over dit retourbeleid?</h2>

    <div class="ls-privacy__contact">
      <strong><?= esc_html($company_name); ?></strong>

      <p>
        <?php if ($address): ?>
          <?= esc_html($address); ?><br>
        <?php endif; ?>

        KvK-nummer: <?= esc_html($kvk); ?><br>

        E-mail:
        <a href="mailto:<?= esc_attr($support_email); ?>">
          <?= esc_html($support_email); ?>
        </a><br>

        Website:
        <a href="https://www.oculoo.com">www.oculoo.com</a>
      </p>
    </div>
  </section>

  <footer class="ls-privacy__footer">
    <span class="ls-privacy__footer-brand"><?= esc_html($company_name); ?></span>
    <span class="ls-privacy__footer-version">Retourbeleid — Versie <?= esc_html($version); ?></span>
  </footer>
</div>
