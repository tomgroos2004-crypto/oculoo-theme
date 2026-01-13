<?php
if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;
use Elementor\Repeater;

class LS_Uitleg_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-uitleg';
  }

  public function get_title() {
    return 'LS – Uitleg / Aanpak';
  }

  public function get_icon() {
    return 'eicon-editor-list-ul';
  }

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'Inhoud'
    ]);

    $this->add_control('title', [
      'label'   => 'Titel',
      'type'    => Controls_Manager::TEXT,
      'default' => 'Zo pakken wij dit aan',
    ]);

    $this->add_control('intro', [
      'label' => 'Intro tekst',
      'type'  => Controls_Manager::TEXTAREA,
    ]);

    $repeater = new Repeater();

    $repeater->add_control('item_title', [
      'label' => 'Stap / punt titel',
      'type'  => Controls_Manager::TEXT,
    ]);

    $repeater->add_control('item_text', [
      'label' => 'Uitleg',
      'type'  => Controls_Manager::TEXTAREA,
    ]);

    $this->add_control('items', [
      'label'       => 'Stappen / punten',
      'type'        => Controls_Manager::REPEATER,
      'fields'      => $repeater->get_controls(),
      'title_field' => '{{{ item_title }}}',
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {
    $settings = $this->get_settings_for_display();
    include get_stylesheet_directory() . '/components/uitleg.php';
  }
}
