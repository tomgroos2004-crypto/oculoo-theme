<?php
if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;

require_once __DIR__ . '/../base-widget.php';

class LS_Contact_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-contact';
  }

  public function get_title() {
    return 'LS – Contact';
  }

  public function get_icon() {
    return 'eicon-mail';
  }
public function get_categories() {
  return ['leadsprint'];
}

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'Inhoud'
    ]);

    $this->add_control('title', [
      'label'   => 'Titel',
      'type'    => Controls_Manager::TEXT,
      'default' => 'Contact & openingstijden',
    ]);

    $this->add_control('lead', [
      'label'   => 'Intro tekst',
      'type'    => Controls_Manager::TEXTAREA,
      'default' => 'Vragen, reserveren of gewoon even overleggen?',
    ]);

    $this->add_control('email_to', [
      'label'   => 'Ontvangst e-mail',
      'type'    => Controls_Manager::TEXT,
      'default' => 'info@dekornuiten.com',
    ]);

    $this->add_control('map_query', [
      'label'   => 'Google Maps zoekterm',
      'type'    => Controls_Manager::TEXT,
      'default' => 'De Kornuiten Haaksbergen',
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {

    $s = $this->get_settings_for_display();

    $title     = $s['title'] ?? '';
    $lead      = $s['lead'] ?? '';
    $email_to  = $s['email_to'] ?? '';
    $map_query = $s['map_query'] ?? '';

    include get_stylesheet_directory() . '/components/contact.php';
  }
}
