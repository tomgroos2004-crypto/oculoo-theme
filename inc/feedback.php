<?php
if (!defined('ABSPATH')) exit;

/* =========================================================
   FEEDBACK – Custom Post Type + AJAX endpoint + Admin UI
   =========================================================
   Beheer: WP Admin → Feedback
   Alle ingevulde formulieren komen hier binnen als post.
   ========================================================= */


/* ---------------------------------------------------------
   1. Custom Post Type registratie
--------------------------------------------------------- */
function ls_register_feedback_cpt() {

  register_post_type('feedback', [
    'labels' => [
      'name'               => 'Feedback',
      'singular_name'      => 'Feedback',
      'menu_name'          => 'Feedback',
      'all_items'          => 'Alle reacties',
      'add_new'            => 'Handmatig toevoegen',
      'add_new_item'       => 'Reactie toevoegen',
      'edit_item'          => 'Reactie bekijken',
      'new_item'           => 'Nieuwe reactie',
      'view_item'          => 'Reactie bekijken',
      'search_items'       => 'Reacties zoeken',
      'not_found'          => 'Geen reacties gevonden',
      'not_found_in_trash' => 'Geen reacties in prullenbak',
    ],
    'public'              => false,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 25,
    'menu_icon'           => 'dashicons-feedback',
    'capability_type'     => 'post',
    'map_meta_cap'        => true,
    'capabilities'        => [
      // niemand kan handmatig nieuwe aanmaken (alleen via formulier)
      // wel bewerken/verwijderen
    ],
    'supports'            => ['title'],
    'has_archive'         => false,
    'rewrite'             => false,
    'show_in_rest'        => false,
    'exclude_from_search' => true,
    'publicly_queryable'  => false,
  ]);
}
add_action('init', 'ls_register_feedback_cpt');


/* ---------------------------------------------------------
   2. Veldlabels voor weergave in admin
--------------------------------------------------------- */
function ls_feedback_field_labels() {
  return [
    'rating'           => 'Algemene rating (1-5)',
    'gemak'            => 'Gemak van druppelen',
    'model'            => 'Model',
    'frequentie'       => 'Gebruiksfrequentie',
    'druppel'          => 'Druppel in oog',
    'flesje'           => 'Flesje past',
    'problemen'        => 'Problemen tijdens gebruik',
    'problemen_uitleg' => 'Toelichting problemen',
    'klacht'           => 'Klachten aan oog',
    'klacht_uitleg'    => 'Toelichting klachten',
    'verpakking'       => 'Verpakking onbeschadigd',
    'uitleg'           => 'Gebruiksaanwijzing duidelijk',
    'kanaal'           => 'Aankoopkanaal',
    'opmerking'        => 'Opmerking',
    'email'            => 'E-mailadres',
    'user_agent'       => 'Browser',
    'ip_hash'          => 'IP hash',
  ];
}


/* ---------------------------------------------------------
   3. AJAX endpoint – formulier opslaan
--------------------------------------------------------- */
function ls_feedback_submit() {

  check_ajax_referer('ls_feedback_nonce', 'nonce');

  $fields = array_keys(ls_feedback_field_labels());
  $data   = [];

  foreach ($fields as $key) {
    if ($key === 'ip_hash') continue;
    $value = isset($_POST[$key]) ? wp_unslash($_POST[$key]) : '';
    $data[$key] = sanitize_textarea_field($value);
  }

  // Verplichte AVG-toestemming
  $consent = isset($_POST['consent']) ? sanitize_text_field($_POST['consent']) : '';
  if ($consent !== '1') {
    wp_send_json_error(['message' => 'AVG-toestemming ontbreekt.'], 400);
  }

  // Validatie e-mail (optioneel)
  if (!empty($data['email'])) {
    if (!is_email($data['email'])) {
      $data['email'] = '';
    } else {
      $data['email'] = sanitize_email($data['email']);
    }
  }

  // IP-hash (privacy-vriendelijk, niet het IP zelf)
  $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
  $ip_hash = $ip ? substr(hash('sha256', $ip . wp_salt()), 0, 16) : '';

  // Titel = rating + datum + eerste 30 tekens opmerking
  $title_parts = [];
  if (!empty($data['rating'])) $title_parts[] = $data['rating'] . '★';
  $title_parts[] = date_i18n('d-m-Y H:i');
  if (!empty($data['opmerking'])) {
    $title_parts[] = '— ' . wp_trim_words($data['opmerking'], 6, '…');
  }
  $title = implode(' ', $title_parts);

  $post_id = wp_insert_post([
    'post_type'   => 'feedback',
    'post_status' => 'publish',
    'post_title'  => $title,
  ], true);

  if (is_wp_error($post_id) || !$post_id) {
    wp_send_json_error(['message' => 'Opslaan mislukt.'], 500);
  }

  foreach ($data as $key => $value) {
    update_post_meta($post_id, $key, $value);
  }
  if ($ip_hash) update_post_meta($post_id, 'ip_hash', $ip_hash);

  /**
   * Actie hook zodat je optioneel een e-mailnotificatie kunt
   * toevoegen via een snippet of plugin.
   */
  do_action('ls_feedback_received', $post_id, $data);

  wp_send_json_success(['message' => 'Bedankt!']);
}
add_action('wp_ajax_ls_feedback_submit',        'ls_feedback_submit');
add_action('wp_ajax_nopriv_ls_feedback_submit', 'ls_feedback_submit');


/* ---------------------------------------------------------
   4. E-mailnotificatie naar support@oculoo.com
--------------------------------------------------------- */
function ls_feedback_send_notification($post_id, $data) {

  $to     = apply_filters('ls_feedback_notify_email', 'support@oculoo.com');
  $labels = ls_feedback_field_labels();

  $subject = sprintf('[Oculoo feedback] %s ★', !empty($data['rating']) ? $data['rating'] : '-');

  $lines = ["Nieuwe feedback ontvangen via de website.", ""];
  foreach ($labels as $key => $label) {
    if ($key === 'ip_hash' || $key === 'user_agent') continue;
    $val = $data[$key] ?? '';
    if ($val === '') continue;
    $lines[] = $label . ': ' . $val;
  }
  $lines[] = '';
  $lines[] = 'Bekijk in admin: ' . admin_url('post.php?post=' . $post_id . '&action=edit');

  wp_mail($to, $subject, implode("\n", $lines));
}
add_action('ls_feedback_received', 'ls_feedback_send_notification', 10, 2);


/* ---------------------------------------------------------
   5. Admin kolommen
--------------------------------------------------------- */
function ls_feedback_admin_columns($cols) {
  return [
    'cb'         => $cols['cb'],
    'title'      => 'Samenvatting',
    'rating'     => 'Rating',
    'model'      => 'Model',
    'gemak'      => 'Gemak',
    'klacht'     => 'Klachten',
    'email'      => 'E-mail',
    'date'       => 'Ingediend',
  ];
}
add_filter('manage_feedback_posts_columns', 'ls_feedback_admin_columns');

function ls_feedback_admin_column_content($col, $post_id) {
  $val = get_post_meta($post_id, $col, true);

  if ($col === 'rating' && $val) {
    echo str_repeat('★', (int) $val) . str_repeat('☆', max(0, 5 - (int) $val));
    return;
  }

  if ($col === 'email' && $val) {
    echo '<a href="mailto:' . esc_attr($val) . '">' . esc_html($val) . '</a>';
    return;
  }

  echo esc_html($val);
}
add_action('manage_feedback_posts_custom_column', 'ls_feedback_admin_column_content', 10, 2);

function ls_feedback_sortable_columns($cols) {
  $cols['rating'] = 'rating';
  return $cols;
}
add_filter('manage_edit-feedback_sortable_columns', 'ls_feedback_sortable_columns');


/* ---------------------------------------------------------
   6. Metabox – alle velden netjes onder elkaar in detailweergave
--------------------------------------------------------- */
function ls_feedback_add_metabox() {
  add_meta_box(
    'ls_feedback_details',
    'Ingevulde antwoorden',
    'ls_feedback_metabox_render',
    'feedback',
    'normal',
    'high'
  );
}
add_action('add_meta_boxes', 'ls_feedback_add_metabox');

function ls_feedback_metabox_render($post) {
  $labels = ls_feedback_field_labels();
  echo '<table class="form-table" style="margin:0">';
  foreach ($labels as $key => $label) {
    $val = get_post_meta($post->ID, $key, true);
    echo '<tr>';
    echo '<th scope="row" style="width:200px">' . esc_html($label) . '</th>';
    echo '<td>' . nl2br(esc_html($val)) . '</td>';
    echo '</tr>';
  }
  echo '</table>';
}


/* ---------------------------------------------------------
   7. CSV export – knop bovenaan de lijst
--------------------------------------------------------- */
function ls_feedback_export_button() {
  $screen = get_current_screen();
  if (!$screen || $screen->id !== 'edit-feedback') return;

  $url = wp_nonce_url(
    admin_url('admin-post.php?action=ls_feedback_export'),
    'ls_feedback_export'
  );
  echo '<a href="' . esc_url($url) . '" class="page-title-action">CSV exporteren</a>';
}
add_action('admin_notices', 'ls_feedback_export_button');

function ls_feedback_export_csv() {
  if (!current_user_can('edit_posts')) wp_die('Geen toegang.');
  check_admin_referer('ls_feedback_export');

  $posts = get_posts([
    'post_type'      => 'feedback',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);

  $labels = ls_feedback_field_labels();
  $headers = array_merge(['Datum'], array_values($labels));

  nocache_headers();
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename=oculoo-feedback-' . date('Y-m-d') . '.csv');

  $out = fopen('php://output', 'w');
  // BOM voor Excel
  fwrite($out, "\xEF\xBB\xBF");
  fputcsv($out, $headers, ';');

  foreach ($posts as $p) {
    $row = [get_the_date('Y-m-d H:i', $p)];
    foreach (array_keys($labels) as $key) {
      $row[] = get_post_meta($p->ID, $key, true);
    }
    fputcsv($out, $row, ';');
  }
  fclose($out);
  exit;
}
add_action('admin_post_ls_feedback_export', 'ls_feedback_export_csv');
