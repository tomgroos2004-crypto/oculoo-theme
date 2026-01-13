<?php
if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;
use Elementor\Repeater;

class LS_Design_System_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-design-system';
  }

  public function get_title() {
    return 'LS – Design System Aanpak';
  }

  public function get_icon() {
    return 'eicon-code';
  }

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'Design system'
    ]);

    $this->add_control('title', [
      'label' => 'Titel',
      'type' => Controls_Manager::TEXT,
      'default' => 'Webdesign als systeem'
    ]);

    $this->add_control('intro', [
      'label' => 'Intro',
      'type' => Controls_Manager::TEXTAREA,
      'default' => 'We ontwerpen en bouwen websites niet als losse pagina’s, maar als een samenhangend systeem.'
    ]);

    $repeater = new Repeater();

    $repeater->add_control('label', [
      'label' => 'Onderdeel',
      'type' => Controls_Manager::TEXT,
      'default' => 'Structure'
    ]);

    $repeater->add_control('title', [
      'label' => 'Titel',
      'type' => Controls_Manager::TEXT,
    ]);

    $repeater->add_control('text', [
      'label' => 'Uitleg',
      'type' => Controls_Manager::TEXTAREA,
    ]);

    $this->add_control('items', [
      'label' => 'System onderdelen',
      'type' => Controls_Manager::REPEATER,
      'fields' => $repeater->get_controls(),
      'title_field' => '{{{ label }}}',
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {
    $settings = $this->get_settings_for_display();
    include get_stylesheet_directory() . '/components/design-system.php';
  }
}
