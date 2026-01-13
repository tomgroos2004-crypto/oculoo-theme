# LeadSprint Child Theme

Dit is het WordPress child theme van LeadSprint.

## Doel
- Basis voor maatwerk Elementor widgets
- Modulair opgezet
- Geen page builders of content in code

## Belangrijke afspraken
- Alleen PHP, CSS en JS in deze repo
- Geen database wijzigingen
- Geen hardcoded URLs
- Bestaande patronen volgen

## Structuur (globaal)
- functions.php → setup & hooks
- assets/ → css, js, images
- components/ → herbruikbare PHP onderdelen
- widgets/ → custom Elementor widgets

## Werkwijze
- Wijzigingen eerst testen op staging
- Daarna pas live zetten

check altijd bij het maken van widgets of oplossen van fouten naar hoe de init.php en base widget zijn opgebouwd. en ook naar hoe de import van css naar main.css werkt
