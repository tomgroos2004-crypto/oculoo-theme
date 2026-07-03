<?php
if (!defined('ABSPATH')) exit;

/* =========================================================
   RETOUR AANMELDEN — admin-post form handler
   ---------------------------------------------------------
   Verwerkt het formulier op /retour-aanmelden/.
   Stuurt een e-mailnotificatie naar het retour-adres en
   redirect terug naar de pagina met een status-querystring.
========================================================= */

function ls_retour_form_submit() {

  // Honeypot
  if (!empty($_POST['retour_website'])) {
    wp_safe_redirect(home_url('/retour-aanmelden/?retour_status=success#formulier'));
    exit;
  }

  // Nonce
  if (!isset($_POST['retour_nonce']) || !wp_verify_nonce($_POST['retour_nonce'], 'ls_retour_form')) {
    wp_die('Beveiligingscheck mislukt. Probeer het opnieuw.');
  }

  $buyer_type     = isset($_POST['retour_buyer_type'])     ? sanitize_text_field(wp_unslash($_POST['retour_buyer_type']))     : '';
  $name           = isset($_POST['retour_name'])           ? sanitize_text_field(wp_unslash($_POST['retour_name']))           : '';
  $email          = isset($_POST['retour_email'])          ? sanitize_email(wp_unslash($_POST['retour_email']))               : '';
  $order          = isset($_POST['retour_order'])          ? sanitize_text_field(wp_unslash($_POST['retour_order']))          : '';
  $received_at    = isset($_POST['retour_received_at'])    ? sanitize_text_field(wp_unslash($_POST['retour_received_at']))    : '';
  $product        = isset($_POST['retour_product'])        ? sanitize_text_field(wp_unslash($_POST['retour_product']))        : '';
  $reason         = isset($_POST['retour_reason'])         ? sanitize_text_field(wp_unslash($_POST['retour_reason']))         : '';
  $opened         = isset($_POST['retour_opened'])         ? sanitize_text_field(wp_unslash($_POST['retour_opened']))         : '';
  $note           = isset($_POST['retour_note'])           ? sanitize_textarea_field(wp_unslash($_POST['retour_note']))       : '';
  $consent        = isset($_POST['retour_consent'])        ? '1' : '';
  $consent_policy = isset($_POST['retour_consent_policy']) ? '1' : '';

  // Validatie verplichte velden
  if (!$buyer_type || !$name || !$email || !$order || !$received_at || !$product || !$reason || !$opened || !$note || !$consent || !$consent_policy) {
    wp_safe_redirect(home_url('/retour-aanmelden/?retour_status=error#formulier'));
    exit;
  }

  if (!is_email($email)) {
    wp_safe_redirect(home_url('/retour-aanmelden/?retour_status=error#formulier'));
    exit;
  }

  // Server-side blokkade: geopende verpakking is niet retourneerbaar
  if (strcasecmp($opened, 'Ja') === 0) {
    wp_safe_redirect(home_url('/retour-aanmelden/?retour_status=blocked#formulier'));
    exit;
  }

  // Termijn-check (informatief, geen harde blokkade — support team beslist)
  $deadline_note = '';
  $received_ts   = strtotime($received_at);
  if ($received_ts) {
    $days = (int) floor((current_time('timestamp') - $received_ts) / DAY_IN_SECONDS);

    if (stripos($reason, 'Herroepingsrecht') !== false && $days > 14) {
      $deadline_note = sprintf('LET OP: bedenktijd van 14 dagen overschreden (%d dagen na ontvangst).', $days);
    } elseif (stripos($reason, 'Transportschade') !== false && $days > 2) {
      $deadline_note = sprintf('LET OP: transportschade dient binnen 48 uur gemeld te worden (%d dagen na ontvangst).', $days);
    } elseif (stripos($reason, 'defect') !== false && $days > 14) {
      $deadline_note = sprintf('LET OP: defect dient binnen 14 dagen gemeld te worden (%d dagen na ontvangst).', $days);
    }
  }

  // Zakelijke afnemers hebben geen herroepingsrecht
  if (strcasecmp($buyer_type, 'Zakelijk') === 0 && stripos($reason, 'Herroepingsrecht') !== false) {
    wp_safe_redirect(home_url('/retour-aanmelden/?retour_status=business-no-withdrawal#formulier'));
    exit;
  }

  // Optionele upload
  $attachments = [];
  if (!empty($_FILES['retour_photo']['name']) && empty($_FILES['retour_photo']['error'])) {
    require_once ABSPATH . 'wp-admin/includes/file.php';

    $file = $_FILES['retour_photo'];

    // Alleen afbeeldingen, max 8 MB
    $allowed_types = ['image/jpeg', 'image/png', 'image/webp', 'image/heic', 'image/heif'];
    $size_ok       = ($file['size'] <= 8 * 1024 * 1024);
    $type_ok       = in_array(mime_content_type($file['tmp_name']), $allowed_types, true);

    if ($size_ok && $type_ok) {
      $overrides = ['test_form' => false];
      $moved     = wp_handle_upload($file, $overrides);
      if (!empty($moved['file']) && empty($moved['error'])) {
        $attachments[] = $moved['file'];
      }
    }
  }

  // E-mail samenstellen
  $support_email = get_field('oculoo_support_email', 'option') ?: 'support@oculoo.nl';
  $to            = apply_filters('ls_retour_form_to', $support_email);
  $subject       = sprintf('[Oculoo retour] %s — %s — order %s', $buyer_type, $name, $order);

  $body  = "Nieuwe retouraanmelding via de website.\n\n";
  if ($deadline_note) {
    $body .= $deadline_note . "\n\n";
  }
  $body .= "Type afnemer:       {$buyer_type}\n";
  $body .= "Naam:               {$name}\n";
  $body .= "E-mail:             {$email}\n";
  $body .= "Bestelnummer:       {$order}\n";
  $body .= "Datum ontvangst:    {$received_at}\n";
  $body .= "Product:            {$product}\n";
  $body .= "Reden:              {$reason}\n";
  $body .= "Verpakking geopend: {$opened}\n";
  $body .= "Akkoord retourbeleid: " . ($consent_policy ? 'Ja' : 'Nee') . "\n";
  $body .= "Akkoord privacy:    " . ($consent ? 'Ja' : 'Nee') . "\n";
  $body .= "Bijlage:            " . (empty($attachments) ? 'geen' : basename($attachments[0])) . "\n\n";
  $body .= "Toelichting:\n" . ($note ?: '-') . "\n";

  $headers = [
    'Content-Type: text/plain; charset=UTF-8',
    'Reply-To: ' . $name . ' <' . $email . '>',
  ];

  wp_mail($to, $subject, $body, $headers, $attachments);

  // Optionele hook voor logging / CRM
  do_action('ls_retour_form_received', [
    'buyer_type'  => $buyer_type,
    'name'        => $name,
    'email'       => $email,
    'order'       => $order,
    'received_at' => $received_at,
    'product'     => $product,
    'reason'      => $reason,
    'opened'      => $opened,
    'note'        => $note,
  ]);

  wp_safe_redirect(home_url('/retour-aanmelden/?retour_status=success#formulier'));
  exit;
}
add_action('admin_post_nopriv_ls_retour_form_submit', 'ls_retour_form_submit');
add_action('admin_post_ls_retour_form_submit',        'ls_retour_form_submit');
