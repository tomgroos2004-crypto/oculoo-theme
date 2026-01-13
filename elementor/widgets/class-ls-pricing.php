<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

if (!defined('ABSPATH')) exit;

class LS_Pricing_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-pricing';
  }

  public function get_title() {
    return 'LS – Pakketten & Prijzen';
  }

  public function get_icon() {
    return 'eicon-price-table';
  }

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'Inhoud'
    ]);

    $this->add_control('title', [
      'label' => 'Titel',
      'type' => Controls_Manager::TEXT,
      'default' => 'Pakketten & prijzen'
    ]);

    $this->add_control('intro', [
      'label' => 'Intro',
      'type' => Controls_Manager::TEXTAREA,
      'default' => 'Heldere keuzes, zonder verrassingen.'
    ]);

    $repeater = new Repeater();

    $repeater->add_control('label', [
      'label' => 'Pakket naam',
      'type' => Controls_Manager::TEXT,
      'default' => 'Groei'
    ]);

    $repeater->add_control('description', [
      'label' => 'Omschrijving',
      'type' => Controls_Manager::TEXTAREA,
    ]);

    $repeater->add_control('price', [
      'label' => 'Prijs',
      'type' => Controls_Manager::TEXT,
      'default' => 'Vanaf €1.250'
    ]);

    $repeater->add_control('features', [
      'label' => 'Features (1 per regel)',
      'type' => Controls_Manager::TEXTAREA,
    ]);

    $repeater->add_control('button_text', [
      'label' => 'CTA tekst',
      'type' => Controls_Manager::TEXT,
      'default' => 'Meer info'
    ]);

    $repeater->add_control('button_url', [
      'label' => 'CTA link',
      'type' => Controls_Manager::URL,
    ]);

    $repeater->add_control('featured', [
      'label' => 'Uitgelicht',
      'type' => Controls_Manager::SWITCHER,
      'return_value' => 'yes',
    ]);

    $this->add_control('packages', [
      'label' => 'Pakketten',
      'type' => Controls_Manager::REPEATER,
      'fields' => $repeater->get_controls(),
      'title_field' => '{{{ label }}}',
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {
    $settings = $this->get_settings_for_display();
    include get_stylesheet_directory() . '/components/pricing.php';
  }
}
