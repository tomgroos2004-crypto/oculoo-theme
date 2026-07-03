<?php
if (!defined('ABSPATH')) exit;
if (!function_exists('acf_add_local_field_group')) return;

if (!function_exists('ls_acf_page_location_by_slugs')) {
  function ls_acf_page_location_by_slugs(array $slugs) {
    $locations = [];

    foreach ($slugs as $slug) {
      $page = get_page_by_path($slug);
      if ($page && isset($page->ID)) {
        $locations[] = [
          [
            'param'    => 'page',
            'operator' => '==',
            'value'    => (string) $page->ID,
          ],
        ];
      }
    }

    if (empty($locations)) {
      $locations[] = [
        [
          'param'    => 'page',
          'operator' => '==',
          'value'    => '-1',
        ],
      ];
    }

    return $locations;
  }
}

/* =========================================================
   LOCATION FILTER
   Verbergt de generieke paginavelden (hero, CTA, page builder)
   op pagina's die een eigen template hebben en die velden
   dus niet renderen: Private label, Feedback, Retour aanmelden.
   Slug-gebaseerd zodat het portable blijft na een deploy.
========================================================= */
if (!function_exists('ls_acf_hide_generic_groups_on_custom_pages')) {
  function ls_acf_hide_generic_groups_on_custom_pages($group) {
    $target_keys = [
      'group_page_hero_fields',     // Pagina hero
      'group_page_cta_visibility',  // Pagina CTA (toggle)
      'group_page_cta_content',     // Pagina CTA inhoud
      'group_698999d297737',        // Ls- page builder (JSON)
    ];

    if (empty($group['key']) || !in_array($group['key'], $target_keys, true)) {
      return $group;
    }

    if (empty($group['location']) || !is_array($group['location'])) {
      return $group;
    }

    $exclude_slugs = ['private-label', 'feedback', 'retour-aanmelden'];

    $exclusions = [];
    foreach ($exclude_slugs as $slug) {
      $page = get_page_by_path($slug);
      if ($page && isset($page->ID)) {
        $exclusions[] = [
          'param'    => 'page',
          'operator' => '!=',
          'value'    => (string) $page->ID,
        ];
      }
    }

    if (empty($exclusions)) {
      return $group;
    }

    // Voeg de uitsluitingen toe aan elk OR-blok (AND binnen het blok).
    foreach ($group['location'] as &$block) {
      if (is_array($block)) {
        foreach ($exclusions as $rule) {
          $block[] = $rule;
        }
      }
    }
    unset($block);

    return $group;
  }
  add_filter('acf/load_field_group', 'ls_acf_hide_generic_groups_on_custom_pages');
}

/* =========================================================
   PAGINA HERO – ACF VELDEN
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_page_hero_fields',
  'title'    => 'Hero — binnenpagina',
  'location' => [
    [
      [
        'param'    => 'post_type',
        'operator' => '==',
        'value'    => 'page',
      ],
    ],
  ],
  'menu_order' => -10,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [
    [
      'key'           => 'field_page_hero_enabled',
      'label'         => 'Hero tonen',
      'name'          => 'hero_enabled',
      'type'          => 'true_false',
      'instructions'  => 'Toon of verberg de hero op deze pagina.',
      'default_value' => 1,
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
    ],
    [
      'key'               => 'field_page_hero_variant',
      'label'             => 'Hero variant',
      'name'              => 'hero_variant',
      'type'              => 'select',
      'instructions'      => 'Auto = homepage split hero, andere pagina\'s statement hero.',
      'choices'           => [
        'auto'      => 'Auto',
        'split'     => 'Split (met afbeelding en knoppen)',
        'statement' => 'Statement (gecentreerd, donker)',
      ],
      'default_value'     => 'auto',
      'allow_null'        => 0,
      'multiple'          => 0,
      'ui'                => 1,
      'return_format'     => 'value',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_hero_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_page_hero_eyebrow',
      'label'             => 'Kleine toelichting',
      'name'              => 'hero_eyebrow',
      'type'              => 'text',
      'instructions'      => 'Korte tekst boven de heading.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_hero_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'placeholder'       => 'Bijv. Nieuw - medisch hulpmiddel',
    ],
    [
      'key'               => 'field_page_hero_title_prefix',
      'label'             => 'H1 tekst - deel 1',
      'name'              => 'hero_title_prefix',
      'type'              => 'text',
      'instructions'      => 'Tekst voor het uitgelichte woord of zinsdeel.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_hero_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'placeholder'       => 'Bijv. Eindelijk',
    ],
    [
      'key'               => 'field_page_hero_title_highlight',
      'label'             => 'H1 uitgelichte tekst',
      'name'              => 'hero_title_highlight',
      'type'              => 'text',
      'instructions'      => 'Dit deel wordt als accent in de heading getoond.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_hero_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'placeholder'       => 'Bijv. zelfstandig',
    ],
    [
      'key'               => 'field_page_hero_title_suffix',
      'label'             => 'H1 tekst - deel 2',
      'name'              => 'hero_title_suffix',
      'type'              => 'text',
      'instructions'      => 'Tekst na het uitgelichte woord of zinsdeel.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_hero_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'placeholder'       => 'Bijv. oogdruppelen',
    ],
    [
      'key'               => 'field_page_hero_intro',
      'label'             => 'Intro tekst',
      'name'              => 'hero_intro',
      'type'              => 'textarea',
      'instructions'      => 'Korte intro onder de heading.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_hero_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'rows'              => 4,
      'new_lines'         => 'br',
    ],
    [
      'key'               => 'field_page_hero_usps',
      'label'             => 'USP balkjes',
      'name'              => 'hero_usps',
      'type'              => 'repeater',
      'instructions'      => 'Voeg maximaal 4 USP labels toe.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_hero_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'layout'            => 'table',
      'button_label'      => 'USP toevoegen',
      'min'               => 0,
      'max'               => 4,
      'sub_fields'        => [
        [
          'key'          => 'field_page_hero_usp_label',
          'label'        => 'USP tekst',
          'name'         => 'label',
          'type'         => 'text',
          'required'     => 1,
          'placeholder'  => 'Bijv. Universeel',
          'parent_repeater' => 'field_page_hero_usps',
        ],
      ],
    ],
    [
      'key'               => 'field_page_hero_primary_button',
      'label'             => 'Knop 1',
      'name'              => 'hero_primary_button',
      'type'              => 'link',
      'instructions'      => 'Primaire knop links onder de USP balkjes.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_hero_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'return_format'     => 'array',
    ],
    [
      'key'               => 'field_page_hero_secondary_button',
      'label'             => 'Knop 2',
      'name'              => 'hero_secondary_button',
      'type'              => 'link',
      'instructions'      => 'Secundaire knop naast knop 1.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_hero_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'return_format'     => 'array',
    ],
    [
      'key'               => 'field_page_hero_image',
      'label'             => 'Hero afbeelding rechts',
      'name'              => 'hero_image',
      'type'              => 'image',
      'instructions'      => 'Afbeelding die rechts in de hero wordt getoond.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_hero_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'return_format'     => 'array',
      'preview_size'      => 'medium',
      'library'           => 'all',
    ],
  ],
]);

/* =========================================================
   OVER OCULOO - HET ONTSTAAN
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_over_oculoo_intro',
  'title'    => 'Over Oculoo - Het ontstaan',
  'location' => ls_acf_page_location_by_slugs(['over-oculoo', 'over-ons']),
  'menu_order' => -9,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [
    [
      'key'           => 'field_over_origin_enabled',
      'label'         => 'Sectie tonen',
      'name'          => 'over_origin_enabled',
      'type'          => 'true_false',
      'default_value' => 1,
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
      'instructions'  => 'Wordt direct onder de hero geladen op de pagina Over Oculoo / Over ons.',
    ],
    [
      'key'               => 'field_over_origin_eyebrow',
      'label'             => 'Kleine titel',
      'name'              => 'over_origin_eyebrow',
      'type'              => 'text',
      'default_value'     => 'Het ontstaan',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_origin_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_over_origin_title_main',
      'label'             => 'Titel deel 1',
      'name'              => 'over_origin_title_main',
      'type'              => 'text',
      'default_value'     => 'Gezien in de thuiszorg.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_origin_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_over_origin_title_accent',
      'label'             => 'Titel deel 2 (accent)',
      'name'              => 'over_origin_title_accent',
      'type'              => 'text',
      'default_value'     => 'Niet geaccepteerd.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_origin_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_over_origin_body_before',
      'label'             => 'Tekst boven quoteblok',
      'name'              => 'over_origin_body_before',
      'type'              => 'textarea',
      'rows'              => 8,
      'new_lines'         => '',
      'instructions'      => 'Gebruik een lege regel tussen alineas.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_origin_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_over_origin_pull_quote',
      'label'             => 'Pull quote',
      'name'              => 'over_origin_pull_quote',
      'type'              => 'textarea',
      'rows'              => 3,
      'new_lines'         => '',
      'instructions'      => 'Citaat dat links uitgelicht wordt tussen de alinea\'s.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_origin_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_over_origin_body_after',
      'label'             => 'Tekst onder pull quote',
      'name'              => 'over_origin_body_after',
      'type'              => 'textarea',
      'rows'              => 8,
      'new_lines'         => '',
      'instructions'      => 'Gebruik een lege regel tussen alineas.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_origin_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_over_origin_photo',
      'label'             => 'Foto (rechterkolom)',
      'name'              => 'over_origin_photo',
      'type'              => 'image',
      'return_format'     => 'array',
      'preview_size'      => 'large',
      'library'           => 'all',
      'instructions'      => 'Foto die rechts van de tekst getoond wordt.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_origin_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_over_origin_photo_caption',
      'label'             => 'Fotobijschrift',
      'name'              => 'over_origin_photo_caption',
      'type'              => 'text',
      'placeholder'       => 'Bijv. Het Oculoo team — Amsterdam, 2025',
      'instructions'      => 'Bijschrift dat over de foto getoond wordt.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_origin_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
  ],
]);

/* =========================================================
   OVER OCULOO - HET TEAM
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_over_oculoo_team',
  'title'    => 'Over Oculoo - Het team',
  'location' => ls_acf_page_location_by_slugs(['over-oculoo', 'over-ons']),
  'menu_order' => -8,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [
    [
      'key'           => 'field_over_team_enabled',
      'label'         => 'Sectie tonen',
      'name'          => 'over_team_enabled',
      'type'          => 'true_false',
      'default_value' => 1,
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
    ],
    [
      'key'               => 'field_over_team_eyebrow',
      'label'             => 'Kleine titel',
      'name'              => 'over_team_eyebrow',
      'type'              => 'text',
      'default_value'     => 'Het team',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_team_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_over_team_title_main',
      'label'             => 'Titel deel 1',
      'name'              => 'over_team_title_main',
      'type'              => 'text',
      'default_value'     => 'Vier Nederlanders.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_team_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_over_team_title_accent',
      'label'             => 'Titel deel 2 (accent)',
      'name'              => 'over_team_title_accent',
      'type'              => 'text',
      'default_value'     => 'Een missie.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_team_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_over_team_members',
      'label'             => 'Teamleden',
      'name'              => 'over_team_members',
      'type'              => 'repeater',
      'layout'            => 'block',
      'min'               => 1,
      'max'               => 8,
      'button_label'      => 'Teamlid toevoegen',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_team_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'sub_fields'        => [
        [
          'key'             => 'field_over_team_member_photo',
          'label'           => 'Foto',
          'name'            => 'photo',
          'type'            => 'image',
          'return_format'   => 'array',
          'preview_size'    => 'thumbnail',
          'instructions'    => 'Optioneel. Wordt getoond in plaats van de initialen.',
          'parent_repeater' => 'field_over_team_members',
        ],
        [
          'key'             => 'field_over_team_member_initials',
          'label'           => 'Initialen',
          'name'            => 'initials',
          'type'            => 'text',
          'placeholder'     => 'Bijv. L',
          'instructions'    => 'Fallback als er geen foto is.',
          'parent_repeater' => 'field_over_team_members',
        ],
        [
          'key'             => 'field_over_team_member_name',
          'label'           => 'Naam',
          'name'            => 'name',
          'type'            => 'text',
          'required'        => 1,
          'parent_repeater' => 'field_over_team_members',
        ],
        [
          'key'             => 'field_over_team_member_role',
          'label'           => 'Rol',
          'name'            => 'role',
          'type'            => 'text',
          'parent_repeater' => 'field_over_team_members',
        ],
      ],
    ],
    [
      'key'               => 'field_over_team_mission_quote',
      'label'             => 'Missie quote',
      'name'              => 'over_team_mission_quote',
      'type'              => 'textarea',
      'rows'              => 3,
      'new_lines'         => 'br',
      'default_value'     => '"Een hulpmiddel hoort het probleem op te lossen. Niet gedeeltelijk — maar volledig."',
      'instructions'      => 'De grote quote in het donkere missieblok onderaan de teamsectie.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_team_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_over_team_mission_meta',
      'label'             => 'Missie onderschrift',
      'name'              => 'over_team_mission_meta',
      'type'              => 'text',
      'default_value'     => 'Oculoo — richten + knijpen in één beweging',
      'instructions'      => 'Kleine tekst onder de quote in het missieblok.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_over_team_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
  ],
]);

/* =========================================================
   HOE HET WERKT - STAPPEN SECTIE (PAGINA)
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_how_steps_page_section',
  'title'    => 'Hoe het werkt - Stappen sectie',
  'location' => ls_acf_page_location_by_slugs(['hoe-het-werkt', 'hoe-werkt-het']),
  'menu_order' => -8,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [
    [
      'key'           => 'field_how_steps_enabled',
      'label'         => 'Sectie tonen',
      'name'          => 'how_steps_enabled',
      'type'          => 'true_false',
      'default_value' => 1,
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
      'instructions'  => 'Wordt onder de hero geladen op de pagina Hoe het werkt.',
    ],
    [
      'key'               => 'field_how_steps_products',
      'label'             => 'Product switch bovenaan',
      'name'              => 'how_steps_products',
      'type'              => 'repeater',
      'layout'            => 'block',
      'min'               => 0,
      'max'               => 2,
      'button_label'      => 'Product toevoegen',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_how_steps_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'sub_fields'        => [
        [
          'key'             => 'field_how_steps_product_title',
          'label'           => 'Titel',
          'name'            => 'title',
          'type'            => 'text',
          'parent_repeater' => 'field_how_steps_products',
        ],
        [
          'key'             => 'field_how_steps_product_subtitle',
          'label'           => 'Subtitel',
          'name'            => 'subtitle',
          'type'            => 'text',
          'parent_repeater' => 'field_how_steps_products',
        ],
        [
          'key'             => 'field_how_steps_product_active',
          'label'           => 'Actief',
          'name'            => 'active',
          'type'            => 'true_false',
          'default_value'   => 0,
          'ui'              => 1,
          'parent_repeater' => 'field_how_steps_products',
        ],
        [
          'key'             => 'field_how_steps_product_items',
          'label'           => 'Stappen voor dit product',
          'name'            => 'items',
          'type'            => 'repeater',
          'layout'          => 'block',
          'min'             => 1,
          'max'             => 4,
          'button_label'    => 'Stap toevoegen',
          'parent_repeater' => 'field_how_steps_products',
          'sub_fields'      => [
            [
              'key'             => 'field_how_steps_product_item_media_label',
              'label'           => 'Media tekst (optioneel)',
              'name'            => 'media_label',
              'type'            => 'text',
              'parent_repeater' => 'field_how_steps_product_items',
            ],
            [
              'key'             => 'field_how_steps_product_item_image',
              'label'           => 'Afbeelding (optioneel)',
              'name'            => 'image',
              'type'            => 'image',
              'return_format'   => 'array',
              'preview_size'    => 'medium',
              'library'         => 'all',
              'parent_repeater' => 'field_how_steps_product_items',
            ],
            [
              'key'             => 'field_how_steps_product_item_title',
              'label'           => 'Titel',
              'name'            => 'title',
              'type'            => 'text',
              'required'        => 1,
              'parent_repeater' => 'field_how_steps_product_items',
            ],
            [
              'key'             => 'field_how_steps_product_item_text',
              'label'           => 'Tekst',
              'name'            => 'text',
              'type'            => 'textarea',
              'rows'            => 3,
              'new_lines'       => 'br',
              'parent_repeater' => 'field_how_steps_product_items',
            ],
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_how_steps_eyebrow',
      'label'             => 'Kleine titel',
      'name'              => 'how_steps_eyebrow',
      'type'              => 'text',
      'default_value'     => 'Oculoo oogdruppelbril',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_how_steps_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_how_steps_title',
      'label'             => 'Titel',
      'name'              => 'how_steps_title',
      'type'              => 'text',
      'instructions'      => 'Gebruik {product} als placeholder voor de tabnaam. Bijv. "Hoe gebruik je de {product}?"',
      'default_value'     => 'Hoe gebruik je de {product}?',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_how_steps_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_how_steps_lead',
      'label'             => 'Intro tekst',
      'name'              => 'how_steps_lead',
      'type'              => 'textarea',
      'rows'              => 3,
      'new_lines'         => 'br',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_how_steps_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_how_steps_chip',
      'label'             => 'Chip rechts',
      'name'              => 'how_steps_chip',
      'type'              => 'text',
      'default_value'     => '4 eenvoudige stappen',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_how_steps_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
  ],
]);

/* =========================================================
   HOE HET WERKT - HANDIGE TIPS
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_how_tips_page_section',
  'title'    => 'Hoe het werkt - Handige tips',
  'location' => ls_acf_page_location_by_slugs(['hoe-het-werkt', 'hoe-werkt-het']),
  'menu_order' => -7,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [
    [
      'key'           => 'field_how_tips_enabled',
      'label'         => 'Sectie tonen',
      'name'          => 'how_tips_enabled',
      'type'          => 'true_false',
      'default_value' => 1,
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
      'instructions'  => 'Wordt onder de stappen-sectie geladen op de pagina Hoe het werkt.',
    ],
    [
      'key'               => 'field_how_tips_eyebrow',
      'label'             => 'Kleine titel',
      'name'              => 'how_tips_eyebrow',
      'type'              => 'text',
      'default_value'     => 'Handige tips',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_how_tips_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_how_tips_title',
      'label'             => 'Titel',
      'name'              => 'how_tips_title',
      'type'              => 'text',
      'default_value'     => 'Voor het beste resultaat',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_how_tips_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_how_tips_items',
      'label'             => 'Tips',
      'name'              => 'how_tips_items',
      'type'              => 'repeater',
      'layout'            => 'block',
      'min'               => 1,
      'max'               => 3,
      'button_label'      => 'Tip toevoegen',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_how_tips_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'sub_fields'        => [
        [
          'key'             => 'field_how_tips_item_icon',
          'label'           => 'Icoon (optioneel)',
          'name'            => 'icon',
          'type'            => 'image',
          'return_format'   => 'array',
          'preview_size'    => 'thumbnail',
          'library'         => 'all',
          'parent_repeater' => 'field_how_tips_items',
        ],
        [
          'key'             => 'field_how_tips_item_title',
          'label'           => 'Titel',
          'name'            => 'title',
          'type'            => 'text',
          'required'        => 1,
          'parent_repeater' => 'field_how_tips_items',
        ],
        [
          'key'             => 'field_how_tips_item_text',
          'label'           => 'Tekst',
          'name'            => 'text',
          'type'            => 'textarea',
          'rows'            => 3,
          'new_lines'       => 'br',
          'parent_repeater' => 'field_how_tips_items',
        ],
      ],
    ],
  ],
]);

/* =========================================================
   OPTIES - ERKEND DOOR
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_erkend_door_options',
  'title'    => 'Erkend door',
  'location' => [
    [
      [
        'param'    => 'options_page',
        'operator' => '==',
        'value'    => 'oculoo-erkend-door',
      ],
    ],
  ],
  'menu_order' => -6,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [
    [
      'key'           => 'field_erkend_door_title',
      'label'         => 'Titel',
      'name'          => 'erkend_door_title',
      'type'          => 'text',
      'default_value' => 'Erkend door',
    ],
    [
      'key'          => 'field_erkend_door_logos',
      'label'        => 'Logo\'s',
      'name'         => 'erkend_door_logos',
      'type'         => 'repeater',
      'layout'       => 'block',
      'button_label' => 'Logo toevoegen',
      'min'          => 1,
      'max'          => 20,
      'sub_fields'   => [
        [
          'key'             => 'field_erkend_door_logo_image',
          'label'           => 'Logo',
          'name'            => 'logo',
          'type'            => 'image',
          'required'        => 1,
          'return_format'   => 'array',
          'preview_size'    => 'medium',
          'library'         => 'all',
          'parent_repeater' => 'field_erkend_door_logos',
        ],
        [
          'key'             => 'field_erkend_door_logo_link',
          'label'           => 'Link (optioneel)',
          'name'            => 'link',
          'type'            => 'url',
          'required'        => 0,
          'parent_repeater' => 'field_erkend_door_logos',
        ],
      ],
    ],
  ],
]);

/* =========================================================
   PAGINA - CTA TOON/VERBERG
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_page_cta_visibility',
  'title'    => 'Pagina CTA',
  'location' => [
    [
      [
        'param'    => 'post_type',
        'operator' => '==',
        'value'    => 'page',
      ],
    ],
  ],
  'menu_order' => -3,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [
    [
      'key'           => 'field_page_cta_enabled',
      'label'         => 'CTA sectie tonen',
      'name'          => 'cta_enabled',
      'type'          => 'true_false',
      'instructions'  => 'Zet uit om de CTA-sectie op deze pagina te verbergen.',
      'default_value' => 1,
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
    ],
  ],
]);

/* =========================================================
   PAGINA - CTA INHOUD
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_page_cta_content',
  'title'    => 'Pagina CTA inhoud',
  'location' => [
    [
      [
        'param'    => 'post_type',
        'operator' => '==',
        'value'    => 'page',
      ],
    ],
  ],
  'menu_order' => -2,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [
    [
      'key'               => 'field_page_cta_eyebrow',
      'label'             => 'Eyebrow',
      'name'              => 'cta_eyebrow',
      'type'              => 'text',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_cta_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_page_cta_title',
      'label'             => 'Titel',
      'name'              => 'cta_title',
      'type'              => 'text',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_cta_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_page_cta_text',
      'label'             => 'Tekst',
      'name'              => 'cta_text',
      'type'              => 'textarea',
      'rows'              => 3,
      'new_lines'         => '',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_cta_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_page_cta_btn1_text',
      'label'             => 'Knop 1 - tekst',
      'name'              => 'cta_btn1_text',
      'type'              => 'text',
      'wrapper'           => ['width' => '50'],
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_cta_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_page_cta_btn1_url',
      'label'             => 'Knop 1 - link',
      'name'              => 'cta_btn1_url',
      'type'              => 'link',
      'return_format'     => 'array',
      'wrapper'           => ['width' => '50'],
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_cta_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_page_cta_btn2_text',
      'label'             => 'Knop 2 - tekst',
      'name'              => 'cta_btn2_text',
      'type'              => 'text',
      'wrapper'           => ['width' => '50'],
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_cta_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_page_cta_btn2_url',
      'label'             => 'Knop 2 - link',
      'name'              => 'cta_btn2_url',
      'type'              => 'link',
      'return_format'     => 'array',
      'wrapper'           => ['width' => '50'],
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_cta_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_page_cta_variant',
      'label'             => 'Variant',
      'name'              => 'cta_variant',
      'type'              => 'select',
      'choices'           => [
        'light' => 'Light',
        'dark'  => 'Dark',
      ],
      'default_value'     => 'dark',
      'return_format'     => 'value',
      'ui'                => 1,
      'conditional_logic' => [
        [
          [
            'field'    => 'field_page_cta_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
  ],
]);

/* =========================================================
   HOMEPAGE - PROBLEM SECTIE
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_home_problem_section',
  'title'    => 'Homepage - Probleem sectie',
  'description' => 'De "probleem"-sectie op de homepage. Zet bovenaan aan/uit. De titel wordt in 3 delen ingevuld zodat het middelste deel oranje uitgelicht kan worden.',
  'location' => [
    [
      [
        'param'    => 'page_type',
        'operator' => '==',
        'value'    => 'front_page',
      ],
    ],
  ],
  'menu_order' => -5,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [
    [
      'key'           => 'field_home_problem_enabled',
      'label'         => 'Probleem sectie tonen',
      'name'          => 'problem_enabled',
      'type'          => 'true_false',
      'default_value' => 1,
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
    ],
    [
      'key'               => 'field_home_problem_section_id',
      'label'             => 'Sectie ID',
      'name'              => 'problem_section_id',
      'type'              => 'text',
      'instructions'      => 'Anker ID voor deze sectie (zonder #).',
      'default_value'     => 'probleem',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_problem_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_problem_eyebrow',
      'label'             => 'Eyebrow',
      'name'              => 'problem_eyebrow',
      'type'              => 'text',
      'default_value'     => 'Het probleem',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_problem_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_problem_title_prefix',
      'label'             => 'Titel - deel 1',
      'name'              => 'problem_title_prefix',
      'type'              => 'text',
      'instructions'      => 'De titel bestaat uit 3 delen: deel 1 + uitgelicht (oranje) + deel 2. Voorbeeld: "Bestaande hulpmiddelen lossen slechts" + "de helft" + "op".',
      'default_value'     => 'Bestaande hulpmiddelen lossen slechts',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_problem_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_problem_title_highlight',
      'label'             => 'Titel - uitgelicht',
      'name'              => 'problem_title_highlight',
      'type'              => 'text',
      'default_value'     => 'de helft',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_problem_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_problem_title_suffix',
      'label'             => 'Titel - deel 2',
      'name'              => 'problem_title_suffix',
      'type'              => 'text',
      'default_value'     => 'op',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_problem_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_problem_cards',
      'label'             => 'Probleem kaarten',
      'name'              => 'problem_cards',
      'type'              => 'repeater',
      'layout'            => 'block',
      'button_label'      => 'Kaart toevoegen',
      'min'               => 1,
      'max'               => 6,
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_problem_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'sub_fields'        => [
        [
          'key'             => 'field_home_problem_card_icon',
          'label'           => 'Icoon',
          'name'            => 'icon',
          'type'            => 'text',
          'instructions'    => 'Kort symbool of emoji.',
          'default_value'   => '',
          'parent_repeater' => 'field_home_problem_cards',
        ],
        [
          'key'             => 'field_home_problem_card_title',
          'label'           => 'Titel',
          'name'            => 'title',
          'type'            => 'text',
          'required'        => 1,
          'parent_repeater' => 'field_home_problem_cards',
        ],
        [
          'key'             => 'field_home_problem_card_text',
          'label'           => 'Tekst',
          'name'            => 'text',
          'type'            => 'textarea',
          'rows'            => 3,
          'new_lines'       => 'br',
          'parent_repeater' => 'field_home_problem_cards',
        ],
        [
          'key'             => 'field_home_problem_card_featured',
          'label'           => 'Uitgelichte kaart',
          'name'            => 'is_featured',
          'type'            => 'true_false',
          'default_value'   => 0,
          'ui'              => 1,
          'parent_repeater' => 'field_home_problem_cards',
        ],
      ],
    ],
    [
      'key'               => 'field_home_problem_stat_number',
      'label'             => 'Stat getal links',
      'name'              => 'problem_stat_number',
      'type'              => 'text',
      'default_value'     => '1,9',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_problem_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_problem_stat_highlight',
      'label'             => 'Stat getal uitgelicht',
      'name'              => 'problem_stat_highlight',
      'type'              => 'text',
      'default_value'     => 'M',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_problem_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_problem_stat_desc',
      'label'             => 'Stat beschrijving',
      'name'              => 'problem_stat_desc',
      'type'              => 'textarea',
      'rows'              => 3,
      'new_lines'         => 'br',
      'default_value'     => 'Nederlanders gebruiken dagelijks oogdruppels. Zij verdienen een oplossing die het volledig aanpakt.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_problem_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_problem_stat_list',
      'label'             => 'Stat lijst',
      'name'              => 'problem_stat_list',
      'type'              => 'repeater',
      'layout'            => 'table',
      'button_label'      => 'Punt toevoegen',
      'min'               => 0,
      'max'               => 8,
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_problem_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'sub_fields'        => [
        [
          'key'             => 'field_home_problem_stat_item_text',
          'label'           => 'Tekst',
          'name'            => 'text',
          'type'            => 'text',
          'required'        => 1,
          'parent_repeater' => 'field_home_problem_stat_list',
        ],
      ],
    ],
  ],
]);

/* =========================================================
   HOMEPAGE - HOE HET WERKT
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_home_how_section',
  'title'    => 'Homepage - Hoe het werkt',
  'description' => 'De "hoe het werkt"-sectie op de homepage met genummerde stappen. Zet bovenaan aan/uit en voeg de stappen toe in de herhaler.',
  'location' => [
    [
      [
        'param'    => 'page_type',
        'operator' => '==',
        'value'    => 'front_page',
      ],
    ],
  ],
  'menu_order' => -4,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [
    [
      'key'           => 'field_home_how_enabled',
      'label'         => 'Hoe het werkt sectie tonen',
      'name'          => 'how_enabled',
      'type'          => 'true_false',
      'default_value' => 1,
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
    ],
    [
      'key'               => 'field_home_how_section_id',
      'label'             => 'Sectie ID',
      'name'              => 'how_section_id',
      'type'              => 'text',
      'default_value'     => 'how',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_how_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_how_eyebrow',
      'label'             => 'Eyebrow',
      'name'              => 'how_eyebrow',
      'type'              => 'text',
      'default_value'     => 'Hoe het werkt',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_how_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_how_title',
      'label'             => 'Titel',
      'name'              => 'how_title',
      'type'              => 'text',
      'default_value'     => 'Een beweging. Een druppel.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_how_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_how_lead',
      'label'             => 'Intro tekst',
      'name'              => 'how_lead',
      'type'              => 'textarea',
      'rows'              => 3,
      'new_lines'         => '',
      'default_value'     => 'Oculoo combineert automatisch richten en krachtloos knijpen in een simpele handeling. Geen coordinatie, geen kracht, geen contact met het oog.',
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_how_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
    ],
    [
      'key'               => 'field_home_how_steps',
      'label'             => 'Stappen',
      'name'              => 'how_steps',
      'type'              => 'repeater',
      'layout'            => 'block',
      'button_label'      => 'Stap toevoegen',
      'min'               => 1,
      'max'               => 6,
      'conditional_logic' => [
        [
          [
            'field'    => 'field_home_how_enabled',
            'operator' => '==',
            'value'    => '1',
          ],
        ],
      ],
      'sub_fields'        => [
        [
          'key'             => 'field_home_how_step_title',
          'label'           => 'Titel',
          'name'            => 'title',
          'type'            => 'text',
          'required'        => 1,
          'parent_repeater' => 'field_home_how_steps',
        ],
        [
          'key'             => 'field_home_how_step_text',
          'label'           => 'Tekst',
          'name'            => 'text',
          'type'            => 'textarea',
          'rows'            => 3,
          'new_lines'       => '',
          'parent_repeater' => 'field_home_how_steps',
        ],
      ],
    ],
  ],
]);

/* =========================================================
   BLOG – ACF VELDEN
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_blog_fields',
  'title'    => 'Blog inhoud',
  'location' => [
    [
      [
        'param'    => 'post_type',
        'operator' => '==',
        'value'    => 'blog',
      ],
    ],
  ],
  'menu_order' => 0,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [

    /* ----- Hero afbeelding ----- */
    [
      'key'           => 'field_blog_hero',
      'label'         => 'Hero afbeelding',
      'name'          => 'blog_hero',
      'type'          => 'image',
      'instructions'  => 'Upload een grote header afbeelding voor deze blog. Aanbevolen formaat: 1600×800px.',
      'required'      => 0,
      'return_format' => 'array',
      'preview_size'  => 'medium',
      'library'       => 'all',
    ],

    /* ----- Intro ----- */
    [
      'key'          => 'field_blog_intro',
      'label'        => 'Intro / samenvatting',
      'name'         => 'blog_intro',
      'type'         => 'textarea',
      'instructions' => 'Korte samenvatting van de blog. Dit wordt getoond op de overzichtspagina en bovenaan de blog.',
      'required'     => 0,
      'rows'         => 3,
      'new_lines'    => 'br',
    ],

    /* ----- Inhoud ----- */
    [
      'key'          => 'field_blog_content',
      'label'        => 'Inhoud',
      'name'         => 'blog_content',
      'type'         => 'wysiwyg',
      'instructions' => 'De volledige bloginhoud. Gebruik koppen, afbeeldingen en lijsten voor een goede structuur.',
      'required'     => 0,
      'tabs'         => 'all',
      'toolbar'      => 'full',
      'media_upload' => 1,
    ],

    /* ----- Auteur ----- */
    [
      'key'          => 'field_blog_author',
      'label'        => 'Auteur',
      'name'         => 'blog_author',
      'type'         => 'text',
      'instructions' => 'Naam van de auteur van deze blog.',
      'required'     => 0,
      'placeholder'  => 'Bijv. Jan de Vries',
    ],

    /* ----- Leestijd ----- */
    [
      'key'          => 'field_blog_read_time',
      'label'        => 'Leestijd (minuten)',
      'name'         => 'blog_read_time',
      'type'         => 'number',
      'instructions' => 'Geschatte leestijd in minuten.',
      'required'     => 0,
      'min'          => 1,
      'max'          => 60,
      'step'         => 1,
      'placeholder'  => '5',
    ],

    /* ----- Gerelateerde blogs ----- */
    [
      'key'           => 'field_blog_related',
      'label'         => 'Gerelateerde blogs',
      'name'          => 'blog_related',
      'type'          => 'relationship',
      'instructions'  => 'Selecteer gerelateerde blogs die onderaan worden getoond.',
      'required'      => 0,
      'post_type'     => ['blog'],
      'filters'       => ['search'],
      'max'           => 3,
      'return_format' => 'object',
    ],

    /* ----- CTA groep ----- */
    [
      'key'        => 'field_blog_cta',
      'label'      => 'Call-to-Action sectie',
      'name'       => 'blog_cta',
      'type'       => 'group',
      'instructions' => 'Optionele CTA-sectie die onderaan de blog verschijnt.',
      'layout'     => 'block',
      'sub_fields' => [
        [
          'key'         => 'field_blog_cta_title',
          'label'       => 'CTA titel',
          'name'        => 'title',
          'type'        => 'text',
          'placeholder' => 'Bijv. Meer weten?',
        ],
        [
          'key'   => 'field_blog_cta_text',
          'label' => 'CTA tekst',
          'name'  => 'text',
          'type'  => 'textarea',
          'rows'  => 2,
        ],
        [
          'key'         => 'field_blog_cta_btn_text',
          'label'       => 'Knoptekst',
          'name'        => 'btn_text',
          'type'        => 'text',
          'placeholder' => 'Neem contact op',
        ],
        [
          'key'   => 'field_blog_cta_btn_url',
          'label' => 'Knoplink',
          'name'  => 'btn_url',
          'type'  => 'url',
        ],
      ],
    ],

  ],
]);


/* =========================================================
   ONDERZOEK – ACF VELDEN
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_onderzoek_fields',
  'title'    => 'Onderzoek inhoud',
  'location' => [
    [
      [
        'param'    => 'post_type',
        'operator' => '==',
        'value'    => 'onderzoek',
      ],
    ],
  ],
  'menu_order' => 0,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [

    /* ----- Hero afbeelding ----- */
    [
      'key'           => 'field_onderzoek_hero',
      'label'         => 'Hero afbeelding',
      'name'          => 'onderzoek_hero',
      'type'          => 'image',
      'instructions'  => 'Upload een grote header afbeelding. Aanbevolen formaat: 1600×800px.',
      'required'      => 0,
      'return_format' => 'array',
      'preview_size'  => 'medium',
      'library'       => 'all',
    ],

    /* ----- Intro ----- */
    [
      'key'          => 'field_onderzoek_intro',
      'label'        => 'Intro / samenvatting',
      'name'         => 'onderzoek_intro',
      'type'         => 'textarea',
      'instructions' => 'Korte samenvatting van het onderzoek. Wordt getoond op de overzichtspagina.',
      'required'     => 0,
      'rows'         => 3,
      'new_lines'    => 'br',
    ],

    /* ----- Onderzoeksdatum ----- */
    [
      'key'            => 'field_onderzoek_date',
      'label'          => 'Onderzoeksdatum',
      'name'           => 'onderzoek_date',
      'type'           => 'date_picker',
      'instructions'   => 'Wanneer is dit onderzoek uitgevoerd?',
      'required'       => 0,
      'display_format' => 'd/m/Y',
      'return_format'  => 'd/m/Y',
      'first_day'      => 1,
    ],

    /* ----- PDF download ----- */
    [
      'key'           => 'field_onderzoek_pdf',
      'label'         => 'PDF download',
      'name'          => 'onderzoek_pdf',
      'type'          => 'file',
      'instructions'  => 'Upload een PDF van het volledige onderzoek.',
      'required'      => 0,
      'return_format' => 'array',
      'mime_types'    => 'pdf',
    ],

    /* ----- Key findings ----- */
    [
      'key'          => 'field_onderzoek_findings',
      'label'        => 'Key findings',
      'name'         => 'onderzoek_findings',
      'type'         => 'repeater',
      'instructions' => 'Voeg de belangrijkste bevindingen toe.',
      'required'     => 0,
      'min'          => 0,
      'max'          => 10,
      'layout'       => 'block',
      'button_label' => 'Finding toevoegen',
      'sub_fields'   => [
        [
          'key'         => 'field_finding_title',
          'label'       => 'Titel',
          'name'        => 'finding_title',
          'type'        => 'text',
          'placeholder' => 'Bijv. Belangrijkste conclusie',
        ],
        [
          'key'   => 'field_finding_text',
          'label' => 'Toelichting',
          'name'  => 'finding_text',
          'type'  => 'textarea',
          'rows'  => 3,
        ],
      ],
    ],

    /* ----- Inhoud ----- */
    [
      'key'          => 'field_onderzoek_content',
      'label'        => 'Inhoud',
      'name'         => 'onderzoek_content',
      'type'         => 'wysiwyg',
      'instructions' => 'De volledige onderzoeksinhoud.',
      'required'     => 0,
      'tabs'         => 'all',
      'toolbar'      => 'full',
      'media_upload' => 1,
    ],

    /* ----- Auteur ----- */
    [
      'key'          => 'field_onderzoek_author',
      'label'        => 'Auteur',
      'name'         => 'onderzoek_author',
      'type'         => 'text',
      'instructions' => 'Naam van de auteur.',
      'required'     => 0,
      'placeholder'  => 'Bijv. Dr. A. Jansen',
    ],

    /* ----- Leestijd ----- */
    [
      'key'          => 'field_onderzoek_read_time',
      'label'        => 'Leestijd (minuten)',
      'name'         => 'onderzoek_read_time',
      'type'         => 'number',
      'instructions' => 'Geschatte leestijd in minuten.',
      'required'     => 0,
      'min'          => 1,
      'max'          => 60,
      'step'         => 1,
    ],

    /* ----- Bronnen ----- */
    [
      'key'          => 'field_onderzoek_sources',
      'label'        => 'Bronnen',
      'name'         => 'onderzoek_sources',
      'type'         => 'repeater',
      'instructions' => 'Voeg bronvermeldingen toe.',
      'required'     => 0,
      'min'          => 0,
      'max'          => 20,
      'layout'       => 'table',
      'button_label' => 'Bron toevoegen',
      'sub_fields'   => [
        [
          'key'         => 'field_source_name',
          'label'       => 'Naam',
          'name'        => 'source_name',
          'type'        => 'text',
          'placeholder' => 'Bijv. CBS Onderzoek 2025',
        ],
        [
          'key'   => 'field_source_url',
          'label' => 'URL',
          'name'  => 'source_url',
          'type'  => 'url',
        ],
      ],
    ],

    /* ----- Gerelateerde onderzoeken ----- */
    [
      'key'           => 'field_onderzoek_related',
      'label'         => 'Gerelateerde onderzoeken',
      'name'          => 'onderzoek_related',
      'type'          => 'relationship',
      'instructions'  => 'Selecteer gerelateerde onderzoeken.',
      'required'      => 0,
      'post_type'     => ['onderzoek'],
      'filters'       => ['search'],
      'max'           => 3,
      'return_format' => 'object',
    ],

    /* ----- CTA groep ----- */
    [
      'key'          => 'field_onderzoek_cta',
      'label'        => 'Call-to-Action sectie',
      'name'         => 'onderzoek_cta',
      'type'         => 'group',
      'instructions' => 'Optionele CTA-sectie onderaan het onderzoek.',
      'layout'       => 'block',
      'sub_fields'   => [
        [
          'key'         => 'field_onderzoek_cta_title',
          'label'       => 'CTA titel',
          'name'        => 'title',
          'type'        => 'text',
          'placeholder' => 'Bijv. Meer weten over dit onderzoek?',
        ],
        [
          'key'   => 'field_onderzoek_cta_text',
          'label' => 'CTA tekst',
          'name'  => 'text',
          'type'  => 'textarea',
          'rows'  => 2,
        ],
        [
          'key'         => 'field_onderzoek_cta_btn_text',
          'label'       => 'Knoptekst',
          'name'        => 'btn_text',
          'type'        => 'text',
          'placeholder' => 'Neem contact op',
        ],
        [
          'key'   => 'field_onderzoek_cta_btn_url',
          'label' => 'Knoplink',
          'name'  => 'btn_url',
          'type'  => 'url',
        ],
      ],
    ],

  ],
]);


/* =========================================================
   GLOBALE INSTELLINGEN – OPTIONS PAGE
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_oculoo_global_settings',
  'title'    => 'Oculoo instellingen',
  'location' => [
    [
      [
        'param'    => 'options_page',
        'operator' => '==',
        'value'    => 'oculoo-theme-settings',
      ],
    ],
  ],
  'menu_order' => 0,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [

    /* ── Tab: Algemeen ── */
    [
      'key'   => 'field_oculoo_tab_algemeen',
      'label' => 'Algemeen',
      'type'  => 'tab',
    ],
    [
      'key'           => 'field_oculoo_logo',
      'label'         => 'Logo (standaard)',
      'name'          => 'oculoo_logo',
      'type'          => 'image',
      'return_format' => 'url',
      'preview_size'  => 'medium',
      'instructions'  => 'Het standaard sitelogo. Op de homepage wordt dit logo getoond over de paarse hero — upload bij voorkeur een witte/lichte versie. Op andere pagina\'s wordt dit logo gebruikt in de gewone header.',
    ],
    [
      'key'           => 'field_oculoo_logo_scrolled',
      'label'         => 'Logo (scroll state)',
      'name'          => 'oculoo_logo_scrolled',
      'type'          => 'image',
      'return_format' => 'url',
      'preview_size'  => 'medium',
      'instructions'  => 'Optioneel. Het logo dat wordt getoond zodra de header in de zwevende glass-pill state komt (op de homepage na scroll). Gebruik hier bij voorkeur een donkere/originele versie. Laat leeg om hetzelfde logo te gebruiken.',
    ],
    [
      'key'          => 'field_oculoo_logo_alt',
      'label'        => 'Logo alt-tekst',
      'name'         => 'oculoo_logo_alt',
      'type'         => 'text',
      'instructions' => 'Alt-tekst voor het logo (voor toegankelijkheid).',
      'placeholder'  => 'Oculoo',
    ],

    /* ── Tab: Contactgegevens ── */
    [
      'key'   => 'field_oculoo_tab_contact',
      'label' => 'Contactgegevens',
      'type'  => 'tab',
    ],
    [
      'key'          => 'field_oculoo_email',
      'label'        => 'E-mailadres',
      'name'         => 'oculoo_email',
      'type'         => 'email',
      'instructions' => 'Primair e-mailadres (gebruikt in contactformulieren).',
      'placeholder'  => 'info@oculoo.com',
    ],
    [
      'key'          => 'field_oculoo_support_email',
      'label'        => 'Support e-mail',
      'name'         => 'oculoo_support_email',
      'type'         => 'email',
      'instructions' => 'Support e-mailadres (gebruikt in de footer).',
      'placeholder'  => 'support@oculoo.nl',
    ],
    [
      'key'          => 'field_oculoo_address',
      'label'        => 'Adres',
      'name'         => 'oculoo_address',
      'type'         => 'textarea',
      'rows'         => 3,
      'instructions' => 'Vestigingsadres.',
    ],
    [
      'key'          => 'field_oculoo_company_name',
      'label'        => 'Bedrijfsnaam',
      'name'         => 'oculoo_company_name',
      'type'         => 'text',
      'placeholder'  => 'Oculoo B.V.',
      'instructions' => 'Officiële bedrijfsnaam (informatieplicht).',
    ],
    [
      'key'          => 'field_oculoo_kvk',
      'label'        => 'KvK-nummer',
      'name'         => 'oculoo_kvk',
      'type'         => 'text',
      'placeholder'  => '99070847',
    ],
    [
      'key'          => 'field_oculoo_btw',
      'label'        => 'Btw-nummer',
      'name'         => 'oculoo_btw',
      'type'         => 'text',
      'placeholder'  => 'NL123456789B01',
      'instructions' => 'Btw-identificatienummer.',
    ],

    /* ── Tab: Social Media ── */
    [
      'key'   => 'field_oculoo_tab_socials',
      'label' => 'Social Media',
      'type'  => 'tab',
    ],
    [
      'key'         => 'field_oculoo_social_linkedin',
      'label'       => 'LinkedIn',
      'name'        => 'oculoo_social_linkedin',
      'type'        => 'url',
      'placeholder' => 'https://linkedin.com/company/oculoo',
    ],
    [
      'key'         => 'field_oculoo_social_facebook',
      'label'       => 'Facebook',
      'name'        => 'oculoo_social_facebook',
      'type'        => 'url',
      'placeholder' => 'https://facebook.com/oculoo',
    ],
    [
      'key'         => 'field_oculoo_social_instagram',
      'label'       => 'Instagram',
      'name'        => 'oculoo_social_instagram',
      'type'        => 'url',
      'placeholder' => 'https://instagram.com/oculoo',
    ],
    [
      'key'         => 'field_oculoo_social_twitter',
      'label'       => 'X / Twitter',
      'name'        => 'oculoo_social_twitter',
      'type'        => 'url',
      'placeholder' => 'https://x.com/oculoo',
    ],

    /* ── Tab: Popup ── */
    [
      'key'   => 'field_oculoo_tab_popup',
      'label' => 'Popup',
      'type'  => 'tab',
    ],
    [
      'key'           => 'field_oculoo_popup_enabled',
      'label'         => 'Popup tonen',
      'name'          => 'oculoo_popup_enabled',
      'type'          => 'true_false',
      'instructions'  => 'Schakel de popup in of uit op de hele site.',
      'default_value' => 0,
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
    ],
    [
      'key'               => 'field_oculoo_popup_title',
      'label'             => 'Titel',
      'name'              => 'oculoo_popup_title',
      'type'              => 'text',
      'default_value'     => 'Altijd als eerste op de hoogte',
      'placeholder'       => 'Altijd als eerste op de hoogte',
      'conditional_logic' => [
        [[ 'field' => 'field_oculoo_popup_enabled', 'operator' => '==', 'value' => '1' ]],
      ],
    ],
    [
      'key'               => 'field_oculoo_popup_text',
      'label'             => 'Tekst',
      'name'              => 'oculoo_popup_text',
      'type'              => 'textarea',
      'rows'              => 3,
      'default_value'     => 'Ontvang updates over nieuwe producten, klinisch onderzoek en tips voor correct oogdruppelen — direct in je inbox.',
      'placeholder'       => 'Ontvang updates over nieuwe producten, klinisch onderzoek en tips voor correct oogdruppelen — direct in je inbox.',
      'conditional_logic' => [
        [[ 'field' => 'field_oculoo_popup_enabled', 'operator' => '==', 'value' => '1' ]],
      ],
    ],
    [
      'key'               => 'field_oculoo_popup_image',
      'label'             => 'Afbeelding',
      'name'              => 'oculoo_popup_image',
      'type'              => 'image',
      'return_format'     => 'array',
      'preview_size'      => 'medium',
      'instructions'      => 'Optioneel. Wordt links van de content getoond.',
      'conditional_logic' => [
        [[ 'field' => 'field_oculoo_popup_enabled', 'operator' => '==', 'value' => '1' ]],
      ],
    ],
    [
      'key'               => 'field_oculoo_popup_cta_text',
      'label'             => 'Knoptekst',
      'name'              => 'oculoo_popup_cta_text',
      'type'              => 'text',
      'default_value'     => 'Aanmelden',
      'placeholder'       => 'Aanmelden',
      'conditional_logic' => [
        [[ 'field' => 'field_oculoo_popup_enabled', 'operator' => '==', 'value' => '1' ]],
      ],
    ],
    [
      'key'               => 'field_oculoo_popup_cta_url',
      'label'             => 'Knoplink',
      'name'              => 'oculoo_popup_cta_url',
      'type'              => 'url',
      'placeholder'       => 'https://mailchi.mp/oculoo/nieuwsbrief',
      'conditional_logic' => [
        [[ 'field' => 'field_oculoo_popup_enabled', 'operator' => '==', 'value' => '1' ]],
      ],
    ],
    [
      'key'               => 'field_oculoo_popup_trigger',
      'label'             => 'Wanneer tonen',
      'name'              => 'oculoo_popup_trigger',
      'type'              => 'select',
      'choices'           => [
        'page_load' => 'Direct bij laden',
        'delay'     => 'Na vertraging',
        'scroll'    => 'Bij scrollen',
      ],
      'default_value'     => 'delay',
      'ui'                => 1,
      'return_format'     => 'value',
      'conditional_logic' => [
        [[ 'field' => 'field_oculoo_popup_enabled', 'operator' => '==', 'value' => '1' ]],
      ],
    ],
    [
      'key'               => 'field_oculoo_popup_delay',
      'label'             => 'Vertraging (seconden)',
      'name'              => 'oculoo_popup_delay',
      'type'              => 'number',
      'default_value'     => 3,
      'min'               => 1,
      'max'               => 60,
      'conditional_logic' => [
        [
          [ 'field' => 'field_oculoo_popup_enabled', 'operator' => '==', 'value' => '1' ],
          [ 'field' => 'field_oculoo_popup_trigger',  'operator' => '==', 'value' => 'delay' ],
        ],
      ],
    ],
    [
      'key'               => 'field_oculoo_popup_scroll',
      'label'             => 'Scroll percentage',
      'name'              => 'oculoo_popup_scroll',
      'type'              => 'number',
      'default_value'     => 50,
      'min'               => 10,
      'max'               => 100,
      'append'            => '%',
      'conditional_logic' => [
        [
          [ 'field' => 'field_oculoo_popup_enabled', 'operator' => '==', 'value' => '1' ],
          [ 'field' => 'field_oculoo_popup_trigger',  'operator' => '==', 'value' => 'scroll' ],
        ],
      ],
    ],
    [
      'key'               => 'field_oculoo_popup_frequency',
      'label'             => 'Hoe vaak tonen',
      'name'              => 'oculoo_popup_frequency',
      'type'              => 'select',
      'choices'           => [
        'once'    => 'Eenmalig (nooit meer na sluiten)',
        'session' => 'Eens per sessie',
        'always'  => 'Altijd',
      ],
      'default_value'     => 'once',
      'ui'                => 1,
      'return_format'     => 'value',
      'conditional_logic' => [
        [[ 'field' => 'field_oculoo_popup_enabled', 'operator' => '==', 'value' => '1' ]],
      ],
    ],

  ],
]);


/* =========================================================
   FEEDBACK PAGINA – HERO TEKSTEN (optioneel)
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_feedback_hero',
  'title'    => 'Feedback formulier — hero',
  'location' => ls_acf_page_location_by_slugs(['feedback']),
  'menu_order' => -5,
  'position'   => 'normal',
  'style'      => 'default',
  'instructions_placement' => 'label',
  'fields'   => [
    [
      'key'           => 'field_feedback_hero_title',
      'label'         => 'Hero titel',
      'name'          => 'feedback_hero_title',
      'type'          => 'text',
      'instructions'  => 'Laat leeg voor standaard: "Vertel ons hoe het ging".',
      'placeholder'   => 'Vertel ons hoe het ging',
    ],
    [
      'key'           => 'field_feedback_hero_text',
      'label'         => 'Hero introtekst',
      'name'          => 'feedback_hero_text',
      'type'          => 'textarea',
      'rows'          => 3,
      'new_lines'     => '',
      'instructions'  => 'Korte intro onder de titel. Laat leeg voor standaard.',
      'placeholder'   => 'Jouw ervaring helpt ons om Oculoo nog beter te maken. Het kost je nog geen 2 minuten.',
    ],
    [
      'key'           => 'field_feedback_privacy_url',
      'label'         => 'Privacyverklaring URL',
      'name'          => 'feedback_privacy_url',
      'type'          => 'url',
      'instructions'  => 'Link gebruikt in de AVG-toestemming. Laat leeg voor /privacy.',
    ],
  ],
]);


/* =========================================================
   RETOURBELEID – ARTIKELEN
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_ls_legal_returns',
  'title'    => 'Retourbeleid — artikelen',
  'location' => ls_acf_page_location_by_slugs([
    'retourbeleid',
  ]),
  'menu_order' => -10,
  'position'   => 'normal',
  'style'      => 'default',
  'instructions_placement' => 'label',
  'fields'   => [
    [
      'key'           => 'field_returns_version',
      'label'         => 'Versie / datum',
      'name'          => 'returns_version',
      'type'          => 'text',
      'instructions'  => 'Bv. "22 april 2026". Verschijnt in de header en footer.',
      'placeholder'   => '22 april 2026',
    ],
    [
      'key'           => 'field_returns_intro',
      'label'         => 'Introductietekst',
      'name'          => 'returns_intro',
      'type'          => 'textarea',
      'rows'          => 4,
      'new_lines'     => 'wpautop',
      'instructions'  => 'Korte intro bovenaan. Laat leeg voor de standaardtekst.',
    ],
    [
      'key'           => 'field_returns_articles',
      'label'         => 'Artikelen',
      'name'          => 'returns_articles',
      'type'          => 'repeater',
      'instructions'  => 'Elk artikel als een eigen rij. Laat leeg om de standaardtekst (PDF) te tonen.',
      'layout'        => 'block',
      'button_label'  => 'Artikel toevoegen',
      'sub_fields'    => [
        [
          'key'           => 'field_returns_article_number',
          'label'         => 'Nummer',
          'name'          => 'article_number',
          'type'          => 'text',
          'placeholder'   => '1',
          'wrapper'       => ['width' => '15'],
        ],
        [
          'key'           => 'field_returns_article_title',
          'label'         => 'Titel',
          'name'          => 'article_title',
          'type'          => 'text',
          'placeholder'   => 'Definities',
          'wrapper'       => ['width' => '85'],
        ],
        [
          'key'           => 'field_returns_article_content',
          'label'         => 'Inhoud',
          'name'          => 'article_content',
          'type'          => 'wysiwyg',
          'tabs'          => 'visual',
          'toolbar'       => 'basic',
          'media_upload'  => 0,
        ],
      ],
    ],
  ],
]);


/* =========================================================
   ALGEMENE VOORWAARDEN – ARTIKELEN
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_ls_legal_terms',
  'title'    => 'Algemene voorwaarden — artikelen',
  'location' => ls_acf_page_location_by_slugs([
    'algemene-verkoop-en-leveringsvoorwaarden-oculoo-b-v',
    'algemene-voorwaarden',
  ]),
  'menu_order' => -10,
  'position'   => 'normal',
  'style'      => 'default',
  'instructions_placement' => 'label',
  'fields'   => [
    [
      'key'           => 'field_terms_version',
      'label'         => 'Versie',
      'name'          => 'terms_version',
      'type'          => 'text',
      'instructions'  => 'Bv. "2026". Verschijnt in de header en footer.',
      'placeholder'   => '2026',
    ],
    [
      'key'           => 'field_terms_intro',
      'label'         => 'Introductietekst',
      'name'          => 'terms_intro',
      'type'          => 'textarea',
      'rows'          => 4,
      'new_lines'     => 'wpautop',
      'instructions'  => 'Korte intro bovenaan. Laat leeg voor de standaardtekst.',
    ],
    [
      'key'           => 'field_terms_articles',
      'label'         => 'Artikelen',
      'name'          => 'terms_articles',
      'type'          => 'repeater',
      'instructions'  => 'Elk artikel als een eigen rij. Laat leeg om de standaardtekst (PDF) te tonen.',
      'layout'        => 'block',
      'button_label'  => 'Artikel toevoegen',
      'sub_fields'    => [
        [
          'key'           => 'field_terms_article_number',
          'label'         => 'Nummer',
          'name'          => 'article_number',
          'type'          => 'text',
          'placeholder'   => '1',
          'wrapper'       => ['width' => '15'],
        ],
        [
          'key'           => 'field_terms_article_title',
          'label'         => 'Titel',
          'name'          => 'article_title',
          'type'          => 'text',
          'placeholder'   => 'Definities',
          'wrapper'       => ['width' => '85'],
        ],
        [
          'key'           => 'field_terms_article_content',
          'label'         => 'Inhoud',
          'name'          => 'article_content',
          'type'          => 'wysiwyg',
          'tabs'          => 'visual',
          'toolbar'       => 'basic',
          'media_upload'  => 0,
        ],
      ],
    ],
  ],
]);


/* =========================================================
   CHECKOUT INSTELLINGEN — ACF VELDEN
   Gekoppeld aan de options-subpage "oculoo-checkout-settings"
========================================================= */

acf_add_local_field_group([
  'key'      => 'group_oculoo_checkout_settings',
  'title'    => 'Checkout instellingen',
  'location' => [
    [
      [
        'param'    => 'options_page',
        'operator' => '==',
        'value'    => 'oculoo-checkout-settings',
      ],
    ],
  ],
  'menu_order' => 0,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [
    [
      'key'           => 'field_oculoo_checkout_terms_label',
      'label'         => 'Label AV/Privacybeleid checkbox',
      'name'          => 'checkout_terms_label',
      'type'          => 'wysiwyg',
      'instructions'  => 'HTML toegestaan. Gebruik <a href="/algemene-voorwaarden" target="_blank" rel="noopener">links</a> naar de juiste pagina\'s. Laat leeg om de standaard NL tekst te gebruiken.',
      'tabs'          => 'visual',
      'toolbar'       => 'basic',
      'media_upload'  => 0,
      'default_value' => '',
    ],
  ],
]);


/* =========================================================
   PRIVATE LABEL — PAGINA VELDEN
   Locatie: pagina met slug `private-label`
   Alle teksten zijn standaard ingevuld zodat eigenaren
   direct kunnen zien welke tekst in welk veld staat.
========================================================= */

acf_add_local_field_group([
  'key'        => 'group_pl_page',
  'title'      => 'Private label — pagina inhoud',
  'location'   => ls_acf_page_location_by_slugs(['private-label']),
  'menu_order' => -10,
  'position'   => 'normal',
  'style'      => 'default',
  'fields'     => [

    /* ============ HERO ============ */
    [
      'key'   => 'field_pl_tab_hero',
      'label' => 'Hero',
      'type'  => 'tab',
    ],
    [
      'key'           => 'field_pl_hero_title_main',
      'label'         => 'Hero — titel deel 1',
      'name'          => 'pl_hero_title_main',
      'type'          => 'text',
      'default_value' => 'Oculoo, in',
    ],
    [
      'key'           => 'field_pl_hero_title_accent',
      'label'         => 'Hero — titel accent (oranje)',
      'name'          => 'pl_hero_title_accent',
      'type'          => 'text',
      'default_value' => 'jouw',
    ],
    [
      'key'           => 'field_pl_hero_title_suffix',
      'label'         => 'Hero — titel deel 3',
      'name'          => 'pl_hero_title_suffix',
      'type'          => 'text',
      'default_value' => 'merk.',
    ],
    [
      'key'           => 'field_pl_hero_sub',
      'label'         => 'Hero — subtekst',
      'name'          => 'pl_hero_sub',
      'type'          => 'textarea',
      'rows'          => 3,
      'new_lines'     => '',
      'default_value' => 'De gepatenteerde oogdruppelbril. Jouw logo, jouw kleur. Voor groothandels, oogklinieken, zorginstellingen en leveranciers die hun klanten écht verder willen helpen.',
    ],
    [
      'key'           => 'field_pl_hero_btn1_text',
      'label'         => 'Hero — primaire knop tekst',
      'name'          => 'pl_hero_btn1_text',
      'type'          => 'text',
      'default_value' => 'Vraag een offerte aan',
    ],
    [
      'key'           => 'field_pl_hero_btn1_url',
      'label'         => 'Hero — primaire knop link',
      'name'          => 'pl_hero_btn1_url',
      'type'          => 'text',
      'default_value' => '#contact',
      'instructions'  => 'Gebruik #contact om naar het formulier te scrollen of een volledige URL.',
    ],
    [
      'key'           => 'field_pl_hero_btn2_text',
      'label'         => 'Hero — secundaire knop tekst',
      'name'          => 'pl_hero_btn2_text',
      'type'          => 'text',
      'default_value' => 'Bekijk voorbeelden',
    ],
    [
      'key'           => 'field_pl_hero_btn2_url',
      'label'         => 'Hero — secundaire knop link',
      'name'          => 'pl_hero_btn2_url',
      'type'          => 'text',
      'default_value' => '#voorbeelden',
    ],

    /* ============ INTRO ============ */
    [
      'key'   => 'field_pl_tab_intro',
      'label' => 'Intro',
      'type'  => 'tab',
    ],
    [
      'key'           => 'field_pl_intro_enabled',
      'label'         => 'Intro sectie tonen',
      'name'          => 'pl_intro_enabled',
      'type'          => 'true_false',
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
      'default_value' => 1,
    ],
    [
      'key'           => 'field_pl_intro_eyebrow',
      'label'         => 'Intro — kleine titel',
      'name'          => 'pl_intro_eyebrow',
      'type'          => 'text',
      'default_value' => 'Wat is private label?',
    ],
    [
      'key'           => 'field_pl_intro_title_main',
      'label'         => 'Intro — titel deel 1',
      'name'          => 'pl_intro_title_main',
      'type'          => 'text',
      'default_value' => 'Hetzelfde product.',
    ],
    [
      'key'           => 'field_pl_intro_title_accent',
      'label'         => 'Intro — titel accent (oranje)',
      'name'          => 'pl_intro_title_accent',
      'type'          => 'text',
      'default_value' => 'Helemaal',
    ],
    [
      'key'           => 'field_pl_intro_title_suffix',
      'label'         => 'Intro — titel deel 3',
      'name'          => 'pl_intro_title_suffix',
      'type'          => 'text',
      'default_value' => 'van jou.',
    ],
    [
      'key'           => 'field_pl_intro_paragraphs',
      'label'         => 'Intro — alineas',
      'name'          => 'pl_intro_paragraphs',
      'type'          => 'repeater',
      'layout'        => 'block',
      'button_label'  => 'Alinea toevoegen',
      'min'           => 1,
      'default_value' => [
        ['text' => 'Oculoo blijft Oculoo. Hetzelfde gepatenteerde knijpsysteem, dezelfde MDR klasse 1 keurmerk, dezelfde 4 stappen tot een geslaagde druppel. Alleen ziet je klant straks jouw merk: je eigen kleur, je eigen logo op de bril.'],
        ['text' => 'Jij ontvangt een afgewerkt product dat klaar is voor je schap, je webshop of je zorgproces. Easy as that.'],
      ],
      'sub_fields'    => [
        [
          'key'             => 'field_pl_intro_paragraph_text',
          'label'           => 'Tekst',
          'name'            => 'text',
          'type'            => 'textarea',
          'rows'            => 4,
          'new_lines'       => '',
          'parent_repeater' => 'field_pl_intro_paragraphs',
        ],
      ],
    ],

    /* ============ SHOWCASE ============ */
    [
      'key'   => 'field_pl_tab_showcase',
      'label' => 'Voorbeelden',
      'type'  => 'tab',
    ],
    [
      'key'           => 'field_pl_showcase_enabled',
      'label'         => 'Voorbeelden sectie tonen',
      'name'          => 'pl_showcase_enabled',
      'type'          => 'true_false',
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
      'default_value' => 1,
    ],
    [
      'key'           => 'field_pl_showcase_eyebrow',
      'label'         => 'Voorbeelden — kleine titel',
      'name'          => 'pl_showcase_eyebrow',
      'type'          => 'text',
      'default_value' => 'Voorbeelden',
    ],
    [
      'key'           => 'field_pl_showcase_title_main',
      'label'         => 'Voorbeelden — titel deel 1',
      'name'          => 'pl_showcase_title_main',
      'type'          => 'text',
      'default_value' => 'Kies een kleur.',
    ],
    [
      'key'           => 'field_pl_showcase_title_accent',
      'label'         => 'Voorbeelden — titel accent (oranje)',
      'name'          => 'pl_showcase_title_accent',
      'type'          => 'text',
      'default_value' => 'Wij maken hem.',
    ],
    [
      'key'           => 'field_pl_showcase_intro',
      'label'         => 'Voorbeelden — intro tekst',
      'name'          => 'pl_showcase_intro',
      'type'          => 'textarea',
      'rows'          => 3,
      'new_lines'     => '',
      'default_value' => 'Vier voorbeelden van hoe een Oculoo in jouw huisstijl eruit kan zien. Ter illustratie — elke kleur is mogelijk.',
    ],
    [
      'key'           => 'field_pl_showcase_variants',
      'label'         => 'Voorbeelden — kleurvarianten',
      'name'          => 'pl_showcase_variants',
      'type'          => 'repeater',
      'layout'        => 'table',
      'button_label'  => 'Variant toevoegen',
      'min'           => 1,
      'max'           => 8,
      'default_value' => [
        ['label' => 'Rood',  'tone' => 'red',    'image' => ''],
        ['label' => 'Groen', 'tone' => 'green',  'image' => ''],
        ['label' => 'Blauw', 'tone' => 'blue',   'image' => ''],
        ['label' => 'Paars', 'tone' => 'purple', 'image' => ''],
      ],
      'sub_fields'    => [
        [
          'key'             => 'field_pl_showcase_variant_label',
          'label'           => 'Label',
          'name'            => 'label',
          'type'            => 'text',
          'parent_repeater' => 'field_pl_showcase_variants',
        ],
        [
          'key'             => 'field_pl_showcase_variant_tone',
          'label'           => 'Achtergrondkleur',
          'name'            => 'tone',
          'type'            => 'select',
          'choices'         => [
            'red'    => 'Rood',
            'green'  => 'Groen',
            'blue'   => 'Blauw',
            'purple' => 'Paars',
            'orange' => 'Oranje',
            'mint'   => 'Mint',
          ],
          'default_value'   => 'red',
          'parent_repeater' => 'field_pl_showcase_variants',
        ],
        [
          'key'             => 'field_pl_showcase_variant_image',
          'label'           => 'Afbeelding',
          'name'            => 'image',
          'type'            => 'image',
          'return_format'   => 'array',
          'preview_size'    => 'medium',
          'parent_repeater' => 'field_pl_showcase_variants',
        ],
      ],
    ],
    [
      'key'           => 'field_pl_showcase_caption_before',
      'label'         => 'Voorbeelden — onderschrift (voor accent)',
      'name'          => 'pl_showcase_caption_before',
      'type'          => 'text',
      'default_value' => 'Renders ter illustratie.',
    ],
    [
      'key'           => 'field_pl_showcase_caption_strong',
      'label'         => 'Voorbeelden — onderschrift (accent paars)',
      'name'          => 'pl_showcase_caption_strong',
      'type'          => 'text',
      'default_value' => 'Elke kleur is mogelijk',
    ],
    [
      'key'           => 'field_pl_showcase_caption_after',
      'label'         => 'Voorbeelden — onderschrift (na accent)',
      'name'          => 'pl_showcase_caption_after',
      'type'          => 'text',
      'default_value' => '— eindresultaat in overleg met onze designers.',
    ],

    /* ============ AUDIENCE ============ */
    [
      'key'   => 'field_pl_tab_audience',
      'label' => 'Voor wie',
      'type'  => 'tab',
    ],
    [
      'key'           => 'field_pl_audience_enabled',
      'label'         => 'Voor wie sectie tonen',
      'name'          => 'pl_audience_enabled',
      'type'          => 'true_false',
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
      'default_value' => 1,
    ],
    [
      'key'           => 'field_pl_audience_eyebrow',
      'label'         => 'Voor wie — kleine titel',
      'name'          => 'pl_audience_eyebrow',
      'type'          => 'text',
      'default_value' => 'Voor wie',
    ],
    [
      'key'           => 'field_pl_audience_title_main',
      'label'         => 'Voor wie — titel deel 1',
      'name'          => 'pl_audience_title_main',
      'type'          => 'text',
      'default_value' => 'Voor partijen die',
    ],
    [
      'key'           => 'field_pl_audience_title_accent',
      'label'         => 'Voor wie — titel accent (oranje)',
      'name'          => 'pl_audience_title_accent',
      'type'          => 'text',
      'default_value' => 'het verschil',
    ],
    [
      'key'           => 'field_pl_audience_title_suffix',
      'label'         => 'Voor wie — titel deel 3',
      'name'          => 'pl_audience_title_suffix',
      'type'          => 'text',
      'default_value' => 'willen maken.',
    ],
    [
      'key'           => 'field_pl_audience_intro',
      'label'         => 'Voor wie — intro tekst',
      'name'          => 'pl_audience_intro',
      'type'          => 'textarea',
      'rows'          => 3,
      'new_lines'     => '',
      'default_value' => 'Private label past goed bij organisaties die hun klanten of cliënten een herkenbaar, kwalitatief hulpmiddel willen meegeven.',
    ],
    [
      'key'           => 'field_pl_audience_cards',
      'label'         => 'Voor wie — doelgroep kaarten',
      'name'          => 'pl_audience_cards',
      'type'          => 'repeater',
      'layout'        => 'block',
      'button_label'  => 'Doelgroep toevoegen',
      'min'           => 1,
      'max'           => 8,
      'default_value' => [
        ['icon' => 'cart',     'title' => 'Groothandels',            'text' => 'Een eigen merk op het schap dat klanten herkennen en vertrouwen.'],
        ['icon' => 'eye',      'title' => 'Oogklinieken',            'text' => 'Geef patiënten na een staaroperatie een bril mee die voor jouw kliniek staat.'],
        ['icon' => 'building', 'title' => 'Zorginstellingen',        'text' => 'Eigen branding voor cliënten, minder druppelbezoeken voor je medewerkers.'],
        ['icon' => 'package',  'title' => 'Leveranciers oogdruppels','text' => 'Verhoog de gebruikersvriendelijkheid van jouw druppels met een eigen Oculoo.'],
      ],
      'sub_fields'    => [
        [
          'key'             => 'field_pl_audience_card_icon',
          'label'           => 'Icoon',
          'name'            => 'icon',
          'type'            => 'select',
          'choices'         => [
            'cart'     => 'Winkel / schap',
            'eye'      => 'Oog',
            'building' => 'Gebouw / instelling',
            'package'  => 'Verpakking / levering',
            'people'   => 'Mensen',
            'heart'    => 'Hart',
            'shield'   => 'Schild / keurmerk',
            'check'    => 'Vinkje',
          ],
          'default_value'   => 'cart',
          'parent_repeater' => 'field_pl_audience_cards',
        ],
        [
          'key'             => 'field_pl_audience_card_title',
          'label'           => 'Titel',
          'name'            => 'title',
          'type'            => 'text',
          'parent_repeater' => 'field_pl_audience_cards',
        ],
        [
          'key'             => 'field_pl_audience_card_text',
          'label'           => 'Tekst',
          'name'            => 'text',
          'type'            => 'textarea',
          'rows'            => 2,
          'new_lines'       => '',
          'parent_repeater' => 'field_pl_audience_cards',
        ],
      ],
    ],

    /* ============ CONTACT ============ */
    [
      'key'   => 'field_pl_tab_contact',
      'label' => 'Contact',
      'type'  => 'tab',
    ],
    [
      'key'           => 'field_pl_contact_enabled',
      'label'         => 'Contact sectie tonen',
      'name'          => 'pl_contact_enabled',
      'type'          => 'true_false',
      'ui'            => 1,
      'ui_on_text'    => 'Aan',
      'ui_off_text'   => 'Uit',
      'default_value' => 1,
    ],
    [
      'key'           => 'field_pl_contact_eyebrow',
      'label'         => 'Contact — kleine titel',
      'name'          => 'pl_contact_eyebrow',
      'type'          => 'text',
      'default_value' => 'Contact',
    ],
    [
      'key'           => 'field_pl_contact_title',
      'label'         => 'Contact — titel',
      'name'          => 'pl_contact_title',
      'type'          => 'text',
      'default_value' => 'Neem contact met ons op.',
    ],
    [
      'key'           => 'field_pl_contact_intro',
      'label'         => 'Contact — intro tekst',
      'name'          => 'pl_contact_intro',
      'type'          => 'textarea',
      'rows'          => 3,
      'new_lines'     => '',
      'default_value' => 'Stuur het formulier in en je hoort binnen één werkdag van ons. Geen verkoopverhaal, gewoon een goed gesprek over wat we voor je kunnen betekenen.',
    ],
    [
      'key'           => 'field_pl_contact_email',
      'label'         => 'Contact — e-mailadres',
      'name'          => 'pl_contact_email',
      'type'          => 'email',
      'default_value' => 'contact@oculoo.com',
      'instructions'  => 'Wordt getoond én ontvangt de aanvragen uit het formulier.',
    ],
    [
      'key'           => 'field_pl_contact_response_text',
      'label'         => 'Contact — reactietijd tekst',
      'name'          => 'pl_contact_response_text',
      'type'          => 'text',
      'default_value' => 'Reactie binnen 1 werkdag',
    ],
    [
      'key'           => 'field_pl_form_title',
      'label'         => 'Formulier — titel',
      'name'          => 'pl_form_title',
      'type'          => 'text',
      'default_value' => 'Private label aanvraag',
    ],
    [
      'key'           => 'field_pl_form_intro',
      'label'         => 'Formulier — introtekst boven velden',
      'name'          => 'pl_form_intro',
      'type'          => 'text',
      'default_value' => 'Vul het formulier in. We nemen snel contact met je op.',
    ],
    [
      'key'           => 'field_pl_form_submit_label',
      'label'         => 'Formulier — knop tekst',
      'name'          => 'pl_form_submit_label',
      'type'          => 'text',
      'default_value' => 'Verstuur aanvraag',
    ],
    [
      'key'           => 'field_pl_form_note',
      'label'         => 'Formulier — onderschrift onder knop',
      'name'          => 'pl_form_note',
      'type'          => 'textarea',
      'rows'          => 2,
      'new_lines'     => '',
      'default_value' => 'Door dit formulier te versturen ga je akkoord met onze verwerking van je gegevens voor het beantwoorden van jouw aanvraag.',
    ],
    [
      'key'           => 'field_pl_form_success',
      'label'         => 'Formulier — succesbericht (na verzenden)',
      'name'          => 'pl_form_success',
      'type'          => 'textarea',
      'rows'          => 2,
      'new_lines'     => '',
      'default_value' => 'We nemen binnen één werkdag contact met je op.',
    ],

  ],
]);
