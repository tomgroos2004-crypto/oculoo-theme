<?php
use Elementor\Controls_Manager;

class LS_CTA_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-cta';
  }

  public function get_title() {
    return 'LS – CTA';
  }

  public function get_icon() {
    return 'eicon-call-to-action';
  }

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'CTA'
    ]);

    $this->add_control('title', [
      'type' => Controls_Manager::TEXT,
      'label' => 'Titel',
      'default' => 'Klaar om te starten?'
    ]);

    $this->add_control('text', [
      'type' => Controls_Manager::TEXTAREA,
      'label' => 'Tekst',
      'default' => 'Plan een gesprek en ontdek hoe we samen voorspelbare groei realiseren.'
    ]);

    $this->add_control('button', [
      'type' => Controls_Manager::TEXT,
      'label' => 'Button label',
      'default' => 'Plan een gesprek'
    ]);

    $this->add_control('url', [
      'type' => Controls_Manager::URL,
      'label' => 'Button link'
    ]);

    $this->add_control('variant', [
      'type' => Controls_Manager::SELECT,
      'label' => 'Variant',
      'options' => [
        'normal' => 'Normaal',
        'boxed'  => 'Boxed',
        'minimal' => 'Minimal'
      ],
      'default' => 'normal'
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {

    $s = $this->get_settings_for_display();

    $title   = $s['title'] ?? '';
    $text    = $s['text'] ?? '';
    $button  = $s['button'] ?? '';
    $url     = $s['url']['url'] ?? '';

    $variant = 'variant-' . ($s['variant'] ?? 'normal');

    include get_stylesheet_directory() . '/components/cta.php';
  }
}
