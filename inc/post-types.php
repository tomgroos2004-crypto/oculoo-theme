<?php
if (!defined('ABSPATH')) exit;

/* =========================================================
   CUSTOM POST TYPES
========================================================= */

function es_register_post_types() {

  /* ----- Blog ----- */
  register_post_type('blog', [
    'labels' => [
      'name'               => 'Blogs',
      'singular_name'      => 'Blog',
      'add_new'            => 'Nieuwe blog',
      'add_new_item'       => 'Nieuwe blog toevoegen',
      'edit_item'          => 'Blog bewerken',
      'new_item'           => 'Nieuwe blog',
      'view_item'          => 'Blog bekijken',
      'search_items'       => 'Blogs zoeken',
      'not_found'          => 'Geen blogs gevonden',
      'not_found_in_trash' => 'Geen blogs in prullenbak',
      'all_items'          => 'Alle blogs',
      'menu_name'          => 'Blogs',
    ],
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'blogs', 'with_front' => false],
    'menu_icon'    => 'dashicons-edit-page',
    'menu_position'=> 5,
    'supports'     => ['title', 'thumbnail'],
    'show_in_rest' => true,
  ]);

  /* ----- Onderzoek ----- */
  register_post_type('onderzoek', [
    'labels' => [
      'name'               => 'Onderzoeken',
      'singular_name'      => 'Onderzoek',
      'add_new'            => 'Nieuw onderzoek',
      'add_new_item'       => 'Nieuw onderzoek toevoegen',
      'edit_item'          => 'Onderzoek bewerken',
      'new_item'           => 'Nieuw onderzoek',
      'view_item'          => 'Onderzoek bekijken',
      'search_items'       => 'Onderzoeken zoeken',
      'not_found'          => 'Geen onderzoeken gevonden',
      'not_found_in_trash' => 'Geen onderzoeken in prullenbak',
      'all_items'          => 'Alle onderzoeken',
      'menu_name'          => 'Onderzoeken',
    ],
    'public'       => true,
    'has_archive'  => true,
    'rewrite'      => ['slug' => 'onderzoeken', 'with_front' => false],
    'menu_icon'    => 'dashicons-search',
    'menu_position'=> 6,
    'supports'     => ['title', 'thumbnail'],
    'show_in_rest' => true,
  ]);
}
add_action('init', 'es_register_post_types');


/* =========================================================
   CUSTOM TAXONOMIES
========================================================= */

function es_register_taxonomies() {

  /* ----- Blog categorie ----- */
  register_taxonomy('blog_categorie', 'blog', [
    'labels' => [
      'name'          => 'Blog categorieën',
      'singular_name' => 'Blog categorie',
      'search_items'  => 'Categorieën zoeken',
      'all_items'     => 'Alle categorieën',
      'edit_item'     => 'Categorie bewerken',
      'add_new_item'  => 'Nieuwe categorie toevoegen',
      'menu_name'     => 'Categorieën',
    ],
    'hierarchical' => true,
    'public'       => true,
    'rewrite'      => ['slug' => 'blog-categorie', 'with_front' => false],
    'show_in_rest' => true,
  ]);

  /* ----- Onderzoek categorie ----- */
  register_taxonomy('onderzoek_categorie', 'onderzoek', [
    'labels' => [
      'name'          => 'Onderzoek categorieën',
      'singular_name' => 'Onderzoek categorie',
      'search_items'  => 'Categorieën zoeken',
      'all_items'     => 'Alle categorieën',
      'edit_item'     => 'Categorie bewerken',
      'add_new_item'  => 'Nieuwe categorie toevoegen',
      'menu_name'     => 'Categorieën',
    ],
    'hierarchical' => true,
    'public'       => true,
    'rewrite'      => ['slug' => 'onderzoek-categorie', 'with_front' => false],
    'show_in_rest' => true,
  ]);
}
add_action('init', 'es_register_taxonomies');


/* =========================================================
   FLUSH REWRITE RULES (eenmalig)
========================================================= */

function es_flush_cpt_rewrite() {
  if (get_transient('es_cpt_flush')) return;
  flush_rewrite_rules();
  set_transient('es_cpt_flush', 1, DAY_IN_SECONDS);
}
add_action('init', 'es_flush_cpt_rewrite', 99);
