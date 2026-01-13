<?php
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

/**
 * LeadSprint – Hero Widget
 */
class LS_Hero_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-hero';
  }

  public function get_title() {
    return 'LS – Hero';
  }

  public function get_icon() {
    return 'eicon-banner';
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
      'default' => 'Hero titel (hoofdboodschap)',
    ]);

    $this->add_control('text', [
      'label'   => 'Tekst',
      'type'    => Controls_Manager::TEXTAREA,
      'default' => 'Korte toelichting of subheadline.',
    ]);

    /* =====================
       Primaire knop
    ===================== */

    $this->add_control('button_primary', [
      'label'   => 'Primaire knop – tekst',
      'type'    => Controls_Manager::TEXT,
      'default' => 'Primaire actie',
    ]);

    $this->add_control('button_primary_url', [
      'label' => 'Primaire knop – link',
      'type'  => Controls_Manager::URL,
    ]);

    /* =====================
       Secundaire knop
    ===================== */

    $this->add_control('button_secondary', [
      'label'   => 'Secundaire knop – tekst',
      'type'    => Controls_Manager::TEXT,
      'default' => '',
    ]);

    $this->add_control('button_secondary_url', [
      'label' => 'Secundaire knop – link',
      'type'  => Controls_Manager::URL,
    ]);

    /* =====================
       Visual
    ===================== */

    $this->add_control('image', [
      'label' => 'Afbeelding',
      'type'  => Controls_Manager::MEDIA,
    ]);

    /* =====================
       Variants
    ===================== */

    $this->add_control('layout', [
      'label'   => 'Hero layout',
      'type'    => Controls_Manager::SELECT,
      'options' => [
        'split'      => 'Tekst + afbeelding',
        'background' => 'Achtergrondafbeelding',
      ],
      'default' => 'split',
    ]);

    $this->add_control('height', [
      'label'   => 'Hero hoogte',
      'type'    => Controls_Manager::SELECT,
      'options' => [
        'compact' => 'Compact',
        'normal'  => 'Normaal',
        'large'   => 'Groot',
      ],
      'default' => 'normal',
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {

    $s = $this->get_settings_for_display();

    $title  = $s['title'] ?? '';
    $text   = $s['text'] ?? '';

    $button_primary = $s['button_primary'] ?? '';
    $button_primary_url = $s['button_primary_url']['url'] ?? '';

    $button_secondary = $s['button_secondary'] ?? '';
    $button_secondary_url = $s['button_secondary_url']['url'] ?? '';

    $image  = $s['image']['url'] ?? '';

    $layout = $s['layout'] ?? 'split';
    $height = $s['height'] ?? 'normal';

    $variant = trim($layout . ' ' . $height);

    include get_stylesheet_directory() . '/components/hero.php';
  }
}
