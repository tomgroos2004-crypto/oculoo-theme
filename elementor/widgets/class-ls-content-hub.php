<?php
if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;

class LS_Content_Hub_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-content-hub';
  }

  public function get_title() {
    return 'LS – Content Hub';
  }

  public function get_icon() {
    return 'eicon-library-books';
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
      'default' => 'Alles over deze dienst',
    ]);

    $this->add_control('intro', [
      'label' => 'Intro tekst',
      'type'  => Controls_Manager::TEXTAREA,
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {
    $settings = $this->get_settings_for_display();
    include get_stylesheet_directory() . '/components/content-hub.php';
  }
}
