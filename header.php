<?php if (!defined('ABSPATH')) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
/* Eén header voor alle pagina's — transparante overloop over de hero
   met scroll-state (witte glass pill) zodra de gebruiker scrolt. */
get_template_part('components/header-home');
?>