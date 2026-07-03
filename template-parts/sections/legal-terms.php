<?php if (!defined('ABSPATH')) exit; ?>

<?php
$company_name  = get_field('oculoo_company_name', 'option') ?: 'Oculoo B.V.';
$address       = get_field('oculoo_address', 'option') ?: '';
$support_email = get_field('oculoo_support_email', 'option') ?: 'support@oculoo.nl';
$kvk           = get_field('oculoo_kvk', 'option') ?: '99070847';

$version = get_field('terms_version') ?: '2026';
$intro   = get_field('terms_intro');

/**
 * Fallback artikelen op basis van de PDF
 * "Algemene verkoop- en leveringsvoorwaarden Oculoo B.V."
 * Wordt alleen gebruikt wanneer de ACF-repeater leeg is.
 */
$fallback_articles = [
  [
    'number'  => '1',
    'title'   => 'Definities',
    'content' => '<p>1.1 In deze algemene voorwaarden (hierna: de <strong>"Algemene Voorwaarden"</strong>) wordt verstaan onder:</p>
<p><strong>Afnemer</strong>: iedere natuurlijke persoon of rechtspersoon die met Oculoo een overeenkomst aangaat dan wel beoogt aan te gaan;</p>
<p><strong>Documentatie</strong>: alle door Oculoo verstrekte informatie, waaronder begrepen maar niet beperkt tot gebruiksaanwijzingen, instructies, productspecificaties en overige begeleidende documentatie;</p>
<p><strong>Overeenkomst</strong>: iedere overeenkomst tussen Oculoo en Afnemer, ongeacht de wijze van totstandkoming, met inbegrip van alle wijzigingen en aanvullingen daarop;</p>
<p><strong>Partijen</strong>: Oculoo en Afnemer gezamenlijk;</p>
<p><strong>Portaal</strong>: het door Oculoo beschikbaar gestelde digitale bestelportaal;</p>
<p><strong>Producten</strong>: alle door Oculoo vervaardigde en/of geleverde zaken, waaronder begrepen maar niet beperkt tot de Oculoo oogdruppelbril, de Oculoo Minim bril, alsmede alle bijbehorende accessoires, onderdelen, uitbreidingen, updates en toekomstige varianten daarvan.</p>
<p>1.2 De in dit artikel opgenomen definities hebben zowel in enkelvoud als in meervoud dezelfde betekenis.</p>',
  ],
  [
    'number'  => '2',
    'title'   => 'Toepasselijkheid',
    'content' => '<p>2.1 Deze Algemene Voorwaarden zijn van toepassing op alle aanbiedingen, offertes, bestellingen, Overeenkomsten en overige rechtsverhoudingen tussen Oculoo en Afnemer.</p>
<p>2.2 Afwijkingen van deze Algemene Voorwaarden zijn slechts geldig indien en voor zover deze uitdrukkelijk en schriftelijk door Oculoo zijn bevestigd.</p>
<p>2.3 De toepasselijkheid van eventuele algemene voorwaarden van de Afnemer wordt uitdrukkelijk van de hand gewezen.</p>
<p>2.4 Indien enige bepaling van deze Algemene Voorwaarden nietig is of vernietigd wordt, blijven de overige bepalingen onverminderd van kracht. Partijen zullen in dat geval in overleg treden teneinde een vervangende bepaling overeen te komen die zoveel mogelijk aansluit bij de strekking van de oorspronkelijke bepaling.</p>
<p>2.5 Oculoo is gerechtigd deze Algemene Voorwaarden eenzijdig te wijzigen. De gewijzigde voorwaarden treden in werking veertien (14) dagen nadat deze aan de Afnemer kenbaar zijn gemaakt, tenzij de Afnemer binnen deze termijn schriftelijk bezwaar maakt.</p>
<p>2.6 Deze Algemene Voorwaarden zijn opgesteld in de Nederlandse taal. In geval van vertaling prevaleert de Nederlandse tekst.</p>',
  ],
  [
    'number'  => '3',
    'title'   => 'Gebruik van het Portaal',
    'content' => '<p>3.1 Bestellingen voor het afnemen van de Producten worden in beginsel geplaatst via het Portaal, tenzij Partijen anders overeenkomen.</p>
<p>3.2 Om bestellingen te kunnen plaatsen, dient de Afnemer zich te registreren en een account aan te maken.</p>
<p>3.3 De Afnemer is gehouden zijn inloggegevens strikt vertrouwelijk te behandelen en alle redelijke maatregelen te treffen ter voorkoming van misbruik.</p>
<p>3.4 Indien de Afnemer vermoedt dat zijn inloggegevens door onbevoegden worden gebruikt, dient hij Oculoo daarvan onverwijld in kennis te stellen.</p>
<p>3.5 Oculoo is niet aansprakelijk voor schade die voortvloeit uit onbevoegd gebruik van inloggegevens.</p>
<p>3.6 De Afnemer staat in voor de juistheid en volledigheid van de door hem verstrekte gegevens. Eventuele gevolgen van onjuiste of onvolledige gegevens komen volledig voor rekening en risico van de Afnemer.</p>',
  ],
  [
    'number'  => '4',
    'title'   => 'Totstandkoming en inhoud van de Overeenkomst',
    'content' => '<p>4.1 Een Overeenkomst komt eerst tot stand op het moment dat een door de Afnemer geplaatste bestelling door Oculoo is bevestigd.</p>
<p>4.2 Een Overeenkomst strekt uitsluitend tot levering van de daarin omschreven Producten en kan niet worden aangemerkt als een raamovereenkomst of duurovereenkomst, tenzij uitdrukkelijk schriftelijk anders is overeengekomen.</p>
<p>4.3 Alle door Oculoo verstrekte informatie, waaronder begrepen maar niet beperkt tot afbeeldingen, specificaties, afmetingen en beschrijvingen, is uitsluitend indicatief en bindt Oculoo niet, tenzij uitdrukkelijk anders is overeengekomen.</p>
<p>4.4 Wijzigingen van of aanvullingen op de Overeenkomst zijn slechts geldig indien deze schriftelijk door Oculoo zijn bevestigd. Oculoo is in dat geval gerechtigd de overeengekomen voorwaarden dienovereenkomstig aan te passen.</p>
<p>4.5 Oculoo zal de Overeenkomst naar beste inzicht en vermogen uitvoeren en is gerechtigd daarbij derden in te schakelen.</p>',
  ],
  [
    'number'  => '5',
    'title'   => 'Prijzen en betaling',
    'content' => '<p>5.1 Alle door Oculoo gehanteerde prijzen zijn uitgedrukt in euro\'s en inclusief omzetbelasting (btw), tenzij uitdrukkelijk anders vermeld. Kosten voor verzending, transport en eventuele andere bijkomende kosten worden afzonderlijk aan de Afnemer in rekening gebracht.</p>
<p>5.2 Betaling dient te geschieden binnen een termijn van dertig (30) kalenderdagen na factuurdatum, op een door Oculoo aan te geven bankrekening.</p>
<p>5.3 Indien de Afnemer niet tijdig aan zijn betalingsverplichtingen voldoet, is hij van rechtswege in verzuim en is hij wettelijke handelsrente verschuldigd over het openstaande bedrag, alsmede alle buitengerechtelijke en gerechtelijke incassokosten, welke minimaal vijftien procent (15%) van het verschuldigde bedrag bedragen.</p>
<p>5.4 Oculoo is gerechtigd om, indien daartoe redelijke gronden bestaan, voorafgaand aan levering volledige of gedeeltelijke vooruitbetaling te verlangen.</p>
<p>5.5 De Afnemer is niet gerechtigd zijn betalingsverplichtingen op te schorten of te verrekenen zonder voorafgaande schriftelijke toestemming van Oculoo.</p>
<p>5.6 Oculoo is nimmer aansprakelijk voor schade die voortvloeit uit fraude, waaronder begrepen maar niet beperkt tot factuurfraude of betalingsfraude, waarbij betalingsgegevens van Oculoo op enigerlei wijze zijn gewijzigd of vervalst. Betaling door de Afnemer dient uitsluitend plaats te vinden op het door Oculoo opgegeven bankrekeningnummer zoals vermeld op de factuur. De Afnemer is gehouden om bij twijfel over de juistheid van de betalingsgegevens, waaronder begrepen een wijziging van bankrekeningnummer, zelfstandig en op eigen initiatief verificatie te verrichten bij Oculoo via de bij haar bekende contactgegevens. Betaling aan een ander dan het door Oculoo opgegeven bankrekeningnummer komt volledig voor rekening en risico van de Afnemer en ontslaat de Afnemer niet van zijn betalingsverplichtingen jegens Oculoo.</p>',
  ],
  [
    'number'  => '6',
    'title'   => 'Eigendomsvoorbehoud',
    'content' => '<p>6.1 Alle door Oculoo geleverde Producten blijven eigendom van Oculoo totdat de Afnemer volledig heeft voldaan aan al zijn verplichtingen uit hoofde van de Overeenkomst.</p>
<p>6.2 Zolang de eigendom van de Producten niet op de Afnemer is overgegaan, is het de Afnemer niet toegestaan de Producten te vervreemden, te verpanden of anderszins te bezwaren.</p>
<p>6.3 Indien de Afnemer tekortschiet in de nakoming van zijn verplichtingen, is Oculoo gerechtigd de Producten zonder nadere ingebrekestelling terug te nemen.</p>
<p>6.4 Zolang de eigendom van de Producten niet op de Afnemer is overgegaan, is de Afnemer verplicht de Producten duidelijk identificeerbaar te houden als eigendom van Oculoo. De Afnemer zal de Producten daartoe afzonderlijk opslaan, althans zodanig administreren en labelen dat deze te allen tijde als eigendom van Oculoo kunnen worden herkend.</p>',
  ],
  [
    'number'  => '7',
    'title'   => 'Levering en risico',
    'content' => '<p>7.1 Levering van de Producten vindt plaats op het door de Afnemer opgegeven afleveradres.</p>
<p>7.2 De opgegeven levertermijnen zijn indicatief en gelden niet als fatale termijn.</p>
<p>7.3 Overschrijding van een levertermijn geeft de Afnemer geen recht op schadevergoeding of ontbinding van de Overeenkomst, tenzij sprake is van opzet of bewuste roekeloosheid aan de zijde van Oculoo.</p>
<p>7.4 Het risico van verlies, diefstal of beschadiging van de Producten gaat over op de Afnemer op het moment dat de Producten zijn geleverd op het door de Afnemer opgegeven afleveradres, dan wel op het moment dat de Producten aan een door of namens de Afnemer ingeschakelde vervoerder zijn overgedragen.</p>
<p>7.5 Oculoo is gerechtigd de Producten in gedeelten te leveren en deze afzonderlijk te factureren.</p>',
  ],
  [
    'number'  => '8',
    'title'   => 'Garantie en gebruik van Producten',
    'content' => '<p>8.1 Oculoo staat ervoor in dat de geleverde Producten voldoen aan de Overeenkomst en aan de op het moment van levering geldende Nederlandse wet- en regelgeving.</p>
<p>8.2 Oculoo verstrekt een garantietermijn van zes (6) maanden, ingaande op de datum van levering.</p>
<p>8.3 Een beroep op garantie dient door de Afnemer onverwijld en schriftelijk te worden gemeld, onder overlegging van een deugdelijke onderbouwing.</p>
<p>8.4 Oculoo zal, naar eigen keuze, overgaan tot herstel of vervanging van gebrekkige Producten.</p>
<p>8.5 De garantie is niet van toepassing indien sprake is van onder meer normale slijtage, onjuist, onzorgvuldig of oneigenlijk gebruik, het niet naleven van de Documentatie of wijzigingen aan de Producten zonder toestemming van Oculoo.</p>
<p>8.6 De Producten zijn bedoeld als hulpmiddel en dienen te worden gebruikt overeenkomstig de door Oculoo verstrekte Documentatie. Oculoo is niet aansprakelijk voor schade die voortvloeit uit onjuist of onzorgvuldig gebruik van de Producten.</p>',
  ],
  [
    'number'  => '9',
    'title'   => 'Klachten en conformiteit',
    'content' => '<p>9.1 De Afnemer is gehouden de geleverde Producten onmiddellijk na ontvangst zorgvuldig te (doen) inspecteren op eventuele zichtbare gebreken en afwijkingen.</p>
<p>9.2 Eventuele klachten met betrekking tot gebreken in de geleverde Producten dienen door de Afnemer uiterlijk binnen veertien (14) dagen na ontdekking daarvan, dan wel binnen veertien (14) dagen nadat deze redelijkerwijs ontdekt hadden behoren te worden, schriftelijk en gemotiveerd aan Oculoo te worden gemeld.</p>
<p>9.3 Indien de Afnemer niet binnen de in het voorgaande lid genoemde termijn heeft geklaagd, worden de Producten geacht door de Afnemer te zijn geaccepteerd en vervallen alle rechten van de Afnemer ter zake, waaronder het recht op herstel, vervanging of schadevergoeding.</p>
<p>9.4 De Afnemer is gehouden volledige en onverwijlde medewerking te verlenen aan een door of namens Oculoo ingesteld onderzoek naar de aard en gegrondheid van de klacht, waaronder begrepen — indien door Oculoo verzocht — het ter beschikking stellen of retourneren van de betreffende Producten.</p>
<p>9.5 Klachten schorten de betalingsverplichtingen van de Afnemer niet op.</p>
<p>9.6 Geringe afwijkingen in kwaliteit, uitvoering, maatvoering of uiterlijk, die binnen de in de branche gebruikelijke toleranties vallen, kunnen nimmer grond opleveren voor afkeuring, ontbinding van de Overeenkomst of schadevergoeding.</p>',
  ],
  [
    'number'  => '10',
    'title'   => 'Productveiligheid en terugroepacties (recall)',
    'content' => '<p>10.1 Indien naar het oordeel van Oculoo sprake is van een gebrek in een (deel van een) batch Producten, dan wel indien Oculoo dit anderszins noodzakelijk acht in verband met de veiligheid, kwaliteit of naleving van toepasselijke wet- en regelgeving, is Oculoo gerechtigd om een terugroepactie (recall) te initiëren.</p>
<p>10.2 De Afnemer is in een dergelijk geval verplicht om op eerste verzoek van Oculoo zijn volledige en onverwijlde medewerking te verlenen aan de uitvoering van de recall, waaronder begrepen maar niet beperkt tot:</p>
<ul>
  <li>het staken van verdere distributie en/of verkoop van de betreffende Producten;</li>
  <li>het afzonderen en identificeren van de betreffende Producten;</li>
  <li>het verstrekken van relevante informatie omtrent afnemers, afzetkanalen en eindgebruikers, voor zover deze gegevens beschikbaar zijn;</li>
  <li>het actief informeren van zijn afnemers en, indien van toepassing, eindgebruikers, overeenkomstig de instructies van Oculoo.</li>
</ul>
<p>10.3 Indien de Afnemer de Producten heeft doorgeleverd aan derden, waaronder begrepen maar niet beperkt tot apotheken, groothandels of eindgebruikers, rust op de Afnemer de verplichting om, in opdracht van en conform de instructies van Oculoo, zorg te dragen voor een tijdige en adequate kennisgeving aan deze derden.</p>
<p>10.4 De Afnemer is niet gerechtigd zelfstandig een recall te initiëren zonder voorafgaande schriftelijke toestemming van Oculoo, tenzij dit op grond van dwingendrechtelijke wet- en regelgeving verplicht is. In dat geval zal de Afnemer Oculoo onverwijld informeren.</p>
<p>10.5 De kosten die verband houden met de uitvoering van een recall komen voor rekening van Oculoo, tenzij de recall het gevolg is van een omstandigheid die aan de Afnemer kan worden toegerekend, in welk geval de kosten volledig voor rekening van de Afnemer komen.</p>
<p>10.6 De Afnemer staat ervoor in dat hij te allen tijde in staat is om aan de in dit artikel 10 opgenomen verplichtingen te voldoen en zal alle redelijkerwijs van hem te verlangen organisatorische, administratieve en technische maatregelen treffen om een doeltreffende en tijdige uitvoering van een recall mogelijk te maken. De Afnemer zal voorts alle redelijkerwijs benodigde medewerking verlenen en de instructies van Oculoo onverwijld en volledig opvolgen.</p>
<p>10.7 De Afnemer vrijwaart Oculoo voor alle aanspraken van derden die het gevolg zijn van het niet, niet tijdig of niet correct naleven van de in dit artikel opgenomen verplichtingen.</p>',
  ],
  [
    'number'  => '11',
    'title'   => 'Retouren',
    'content' => '<p>11.1 Retourzendingen zijn uitsluitend toegestaan na voorafgaande schriftelijke toestemming van Oculoo.</p>
<p>11.2 Producten die beschadigd zijn, gebruikt zijn, gepersonaliseerd zijn of om hygiënische redenen niet opnieuw verhandelbaar zijn, komen niet voor retour in aanmerking.</p>
<p>11.3 Retourzendingen geschieden voor rekening en risico van de Afnemer, tenzij uitdrukkelijk anders overeengekomen.</p>
<p>11.4 Het herroepingsrecht (voor zover van toepassing) en retourrecht zijn uitgesloten voor geleverde Producten die kwalificeren als medisch hulpmiddel, waaronder de oogdruppelbril, indien de verzegeling na levering is geopend of beschadigd. Onder verzegeling wordt verstaan de buisfolie waarin het Product per stuk is geseald en die slechts éénmalig kan worden gesloten. Het verbreken of beschadigen van deze buisfolie geldt als aantoonbaar bewijs dat het Product is geopend.</p>',
  ],
  [
    'number'  => '12',
    'title'   => 'Aansprakelijkheid',
    'content' => '<p>12.1 De totale aansprakelijkheid van Oculoo, ongeacht de grondslag (waaronder begrepen een toerekenbare tekortkoming, onrechtmatige daad of enige andere rechtsgrond), is per schadeveroorzakende gebeurtenis beperkt tot vergoeding van uitsluitend directe schade, tot maximaal het factuurbedrag (exclusief btw) van de Overeenkomst waarop de aansprakelijkheid betrekking heeft. Samenhangende gebeurtenissen worden voor de toepassing van dit artikel als één gebeurtenis beschouwd.</p>
<p>12.2 Onder directe schade wordt uitsluitend verstaan:</p>
<ul>
  <li>redelijke kosten ter vaststelling van de oorzaak en de omvang van de schade, voor zover deze betrekking hebben op schade in de zin van deze voorwaarden;</li>
  <li>redelijke kosten gemaakt ter voorkoming of beperking van schade, voor zover de Afnemer aantoont dat deze kosten hebben geleid tot beperking van directe schade;</li>
  <li>redelijke kosten ter herstel van een toerekenbare tekortkoming van Oculoo.</li>
</ul>
<p>12.3 Iedere aansprakelijkheid van Oculoo voor indirecte schade is uitgesloten. Onder indirecte schade wordt in ieder geval verstaan, maar niet beperkt tot: gevolgschade, gederfde winst, gemiste besparingen, schade door bedrijfsstagnatie, verlies van gegevens, reputatieschade, en schade als gevolg van aanspraken van derden.</p>
<p>12.4 Oculoo is nimmer aansprakelijk voor schade die voortvloeit uit:</p>
<ul>
  <li>onjuist, onzorgvuldig of oneigenlijk gebruik van de Producten;</li>
  <li>het niet naleven van de door Oculoo verstrekte Documentatie;</li>
  <li>wijzigingen of reparaties aan de Producten zonder voorafgaande schriftelijke toestemming van Oculoo;</li>
  <li>onjuiste of onvolledige informatie verstrekt door of namens de Afnemer;</li>
  <li>handelingen of nalaten van derden, waaronder begrepen afnemers van de Afnemer en eindgebruikers.</li>
</ul>
<p>12.5 Ieder recht op schadevergoeding en daarmee samenhangende aanspraak jegens Oculoo vervalt indien de opdrachtgever niet binnen zes (6) maanden na het ontstaan van de schade, althans nadat de opdrachtgever de schade redelijkerwijs had behoren te ontdekken, een schriftelijke en deugdelijk gemotiveerde vordering bij Oculoo heeft ingediend.</p>
<p>12.6 De Afnemer vrijwaart Oculoo voor alle aanspraken van derden, waaronder begrepen maar niet beperkt tot eindgebruikers, afnemers van de Afnemer en toezichthoudende instanties, die voortvloeien uit of verband houden met het gebruik, de distributie of de toepassing van de Producten, tenzij de schade uitsluitend het gevolg is van een aan Oculoo toerekenbare tekortkoming.</p>
<p>12.7 De Afnemer is gehouden om, indien hij een verzekering heeft afgesloten ter dekking van risico\'s die verband houden met de Producten, eventuele schade onder die verzekering te claimen en Oculoo te vrijwaren voor regresvorderingen van de verzekeraar.</p>
<p>12.8 De in dit artikel opgenomen aansprakelijkheidsbeperkingen gelden eveneens ten gunste van door Oculoo ingeschakelde derden.</p>
<p>12.9 De in dit artikel opgenomen beperkingen van aansprakelijkheid gelden niet voor zover sprake is van opzet of bewuste roekeloosheid aan de zijde van Oculoo.</p>',
  ],
  [
    'number'  => '13',
    'title'   => 'Overmacht',
    'content' => '<p>13.1 Oculoo is niet gehouden tot het nakomen van enige verplichting uit hoofde van de Overeenkomst indien zij daartoe wordt verhinderd als gevolg van overmacht.</p>
<p>13.2 Onder overmacht wordt verstaan iedere omstandigheid die buiten de macht van Oculoo ligt en waardoor de nakoming van haar verplichtingen redelijkerwijs niet van haar kan worden verlangd. Onder overmacht wordt in ieder geval, maar niet uitsluitend, begrepen: tekortkomingen van door Oculoo ingeschakelde derden, waaronder toeleveranciers, producenten en transporteurs, storingen in transport of logistieke ketens, vertragingen in levering van materialen of onderdelen, overheidsmaatregelen, import- of exportbeperkingen, pandemieën, epidemieën, stakingen, werkonderbrekingen, storingen in energievoorzieningen of communicatienetwerken, alsmede iedere andere omstandigheid waarop Oculoo redelijkerwijs geen invloed kan uitoefenen.</p>
<p>13.3 In geval van overmacht is Oculoo gerechtigd de nakoming van haar verplichtingen op te schorten voor de duur van de overmachtssituatie.</p>
<p>13.4 Indien de overmachtssituatie langer dan zestig (60) dagen voortduurt, zijn beide Partijen gerechtigd de Overeenkomst geheel of gedeeltelijk te ontbinden, zonder dat daardoor enige verplichting tot schadevergoeding ontstaat.</p>',
  ],
  [
    'number'  => '14',
    'title'   => 'Ontbinding en opschorting',
    'content' => '<p>14.1 Oculoo is gerechtigd de Overeenkomst geheel of gedeeltelijk te ontbinden dan wel de uitvoering daarvan geheel of gedeeltelijk op te schorten, indien de Afnemer tekortschiet in de nakoming van enige verplichting uit de Overeenkomst, dan wel indien Oculoo gegronde redenen heeft om te vrezen dat de Afnemer zijn verplichtingen niet (tijdig) zal nakomen. Voor zover nakoming niet blijvend of tijdelijk onmogelijk is, ontstaat het recht tot ontbinding eerst nadat de Afnemer, na een schriftelijke ingebrekestelling waarbij een redelijke termijn voor nakoming is gesteld, in verzuim is geraakt.</p>
<p>14.2 Oculoo is gerechtigd de Overeenkomst met onmiddellijke ingang, geheel of gedeeltelijk, te ontbinden zonder dat enige ingebrekestelling of rechterlijke tussenkomst is vereist, indien de Afnemer (voorlopige) surseance van betaling aanvraagt of verkrijgt, in staat van faillissement wordt verklaard, zijn onderneming geheel of gedeeltelijk liquideert of staakt, dan wel indien beslag wordt gelegd op een wezenlijk deel van zijn vermogen.</p>
<p>14.3 In geval van ontbinding of opschorting als bedoeld in dit artikel zijn alle vorderingen van Oculoo op de Afnemer onmiddellijk en volledig opeisbaar. Oculoo is niet gehouden tot enige schadevergoeding of ongedaanmaking en behoudt alle overige haar toekomende rechten, waaronder het recht op volledige schadevergoeding.</p>',
  ],
  [
    'number'  => '15',
    'title'   => 'Geheimhouding',
    'content' => '<p>15.1 Partijen zijn verplicht tot geheimhouding van alle vertrouwelijke informatie die zij in het kader van de Overeenkomst van elkaar verkrijgen.</p>
<p>15.2 Deze verplichting blijft ook na beëindiging van de Overeenkomst van kracht.</p>',
  ],
  [
    'number'  => '16',
    'title'   => 'Intellectuele eigendom',
    'content' => '<p>16.1 Alle intellectuele eigendomsrechten, waaronder mede begrepen octrooirechten, auteursrechten, merkrechten, modelrechten en knowhow, met betrekking tot de Producten, de daarbij behorende software, technologie en Documentatie, berusten uitsluitend bij Oculoo of haar licentiegevers.</p>
<p>16.2 Het is de Afnemer niet toegestaan deze rechten, op welke wijze dan ook, te gebruiken, te verveelvoudigen, openbaar te maken, te wijzigen, te analyseren, te decompileren, te reverse engineeren of anderszins te exploiteren zonder voorafgaande schriftelijke toestemming van Oculoo.</p>
<p>16.3 Het is de Afnemer voorts niet toegestaan om (i) aanduidingen betreffende intellectuele eigendomsrechten van of namens Oculoo te verwijderen of te wijzigen, (ii) de Producten te kopiëren, na te maken of te laten namaken, dan wel (iii) de werking, samenstelling of vervaardigingswijze van de Producten te (doen) onderzoeken met het oog op het ontwikkelen van een gelijk of vergelijkbaar product.</p>
<p>16.4 Voor zover in het kader van de levering van de Producten enig gebruiksrecht wordt verleend, betreft dit uitsluitend een niet-exclusief, niet-overdraagbaar en niet-sublicentieerbaar recht, dat beperkt is tot het normale gebruik van de Producten conform de Overeenkomst en de toepasselijke instructies van Oculoo.</p>',
  ],
  [
    'number'  => '17',
    'title'   => 'Gebruik naam en logo',
    'content' => '<p>Oculoo is gerechtigd de naam en het logo van de Afnemer te gebruiken voor marketing- en promotiedoeleinden, tenzij de Afnemer daartegen schriftelijk bezwaar maakt.</p>',
  ],
  [
    'number'  => '18',
    'title'   => 'Overdracht',
    'content' => '<p>18.1 De Afnemer is niet gerechtigd zijn rechten en verplichtingen uit de Overeenkomst over te dragen zonder voorafgaande schriftelijke toestemming van Oculoo.</p>
<p>18.2 Oculoo is gerechtigd haar rechten en verplichtingen uit de Overeenkomst over te dragen aan een derde.</p>',
  ],
  [
    'number'  => '19',
    'title'   => 'Toepasselijk recht en geschillen',
    'content' => '<p>19.1 Op alle Overeenkomsten en rechtsverhoudingen is uitsluitend Nederlands recht van toepassing.</p>
<p>19.2 De toepasselijkheid van het Weens Koopverdrag (CISG) wordt uitdrukkelijk uitgesloten.</p>
<p>19.3 Geschillen zullen in eerste aanleg exclusief worden voorgelegd aan de bevoegde rechter van de Rechtbank Overijssel, locatie Almelo.</p>',
  ],
];

$has_acf_articles = have_rows('terms_articles');
?>

<div class="ls-privacy ls-privacy--terms">

  <header class="ls-privacy__header">
    <span class="ls-privacy__label">Juridisch document</span>
    <h1 class="ls-privacy__title">
      Algemene verkoop- en leveringsvoorwaarden<br><?= esc_html($company_name); ?>
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
      <p>Deze algemene verkoop- en leveringsvoorwaarden worden gehanteerd door de besloten vennootschap met beperkte aansprakelijkheid <?= esc_html($company_name); ?>, statutair gevestigd te Groenlo en ingeschreven in het handelsregister van de Kamer van Koophandel onder nummer <?= esc_html($kvk); ?> (hierna: "Oculoo").</p>
    <?php endif; ?>
  </div>

  <?php if ($has_acf_articles): ?>
    <?php while (have_rows('terms_articles')) : the_row();
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
    <h2 class="ls-privacy__section-title">Vragen over deze voorwaarden?</h2>

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
    <span class="ls-privacy__footer-version">Algemene voorwaarden — Versie <?= esc_html($version); ?></span>
  </footer>
</div>
