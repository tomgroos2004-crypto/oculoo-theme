<?php
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class LS_Content_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-content';
  }

  public function get_title() {
    return 'LS – Content';
  }

  public function get_icon() {
    return 'eicon-editor-align-left';
  }

  public function get_categories() {
    return ['leadsprint'];
  }

  protected function register_controls() {

    /* =============================
       Content
    ============================= */

    $this->start_controls_section('content', [
      'label' => 'Inhoud'
    ]);

    $this->add_control('title', [
      'type'  => Controls_Manager::TEXT,
      'label' => 'Titel (optioneel)',
    ]);

    $this->add_control('lead', [
      'type'  => Controls_Manager::TEXTAREA,
      'label' => 'Intro / lead (optioneel)',
    ]);

    $this->add_control('text', [
      'type'  => Controls_Manager::WYSIWYG,
      'label' => 'Tekst',
    ]);

    $this->add_control('image', [
      'type'  => Controls_Manager::MEDIA,
      'label' => 'Afbeelding (optioneel)',
    ]);

    $this->end_controls_section();

    /* =============================
       Layout
    ============================= */

    $this->start_controls_section('layout', [
      'label' => 'Layout'
    ]);

    $this->add_control('text_only', [
      'type'         => Controls_Manager::SWITCHER,
      'label'        => 'Alleen tekst (editorial)',
      'description'  => 'Gebruik voor probleem/herkenning, visie of tekstblokken zonder afbeelding.',
      'return_value' => 'yes',
      'default'      => '',
    ]);

    $this->add_control('spacing', [
      'type'    => Controls_Manager::SELECT,
      'label'   => 'Sectie hoogte',
      'options' => [
        'normal'   => 'Normaal',
        'compact'  => 'Compact',
        'spacious' => 'Ruim',
      ],
      'default' => 'normal',
    ]);

    $this->add_control('width', [
      'type'    => Controls_Manager::SELECT,
      'label'   => 'Tekstbreedte',
      'options' => [
        'normal' => 'Normaal',
        'narrow' => 'Smal',
        'wide'   => 'Breed',
      ],
      'default' => 'normal',
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {

    $s = $this->get_settings_for_display();

    /* =============================
       Content
    ============================= */

    $title = $s['title'] ?? '';
    $lead  = $s['lead'] ?? '';
    $text  = $s['text'] ?? '';

    $image_url = $s['image']['url'] ?? '';
    $image_alt = '';

    /* =============================
       Variants (ONE SOURCE OF TRUTH)
    ============================= */

    $variants = [];

    // spacing
    if (($s['spacing'] ?? 'normal') !== 'normal') {
      $variants[] = $s['spacing'];
    }

    // width
    if (($s['width'] ?? 'normal') !== 'normal') {
      $variants[] = $s['width'];
    }

    // text-only: alleen als expliciet gekozen én geen image
    if (
      ($s['text_only'] ?? '') === 'yes'
      && empty($image_url)
    ) {
      $variants[] = 'text-only';
    }

    $variant = implode(' ', $variants);

    /* =============================
       Render component
    ============================= */

    include get_stylesheet_directory() . '/components/content.php';
  }
}
