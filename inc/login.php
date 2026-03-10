<?php
defined('ABSPATH') || exit;

/* =========================================================
   LeadSprint – Login
========================================================= */

function ls_login_styles() {
  wp_enqueue_style(
    'ls-login-style',
    get_stylesheet_directory_uri() . '/assets/css/login.css',
    [],
    filemtime(get_stylesheet_directory() . '/assets/css/login.css')
  );
}
add_action('login_enqueue_scripts', 'ls_login_styles');


function ls_login_logo_url() {
  return home_url();
}
add_filter('login_headerurl', 'ls_login_logo_url');

function ls_login_logo_title() {
  return get_bloginfo('name');
}
add_filter('login_headertext', 'ls_login_logo_title');