<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit;

class LS_Case_Showcase_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-case-showcase';
  }

  public function get_title() {
    return 'LS – Case Showcase (Amplifier)';
  }

  public function get_icon() {
    return 'eicon-slider-push';
  }

  public function get_categories() {
    return [ 'leadsprint' ];
  }

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'Inhoud'
    ]);

    $this->add_control('title', [
      'label' => 'Titel',
      'type' => Controls_Manager::TEXT,
      'default' => 'Cases die we hebben gedraaid',
    ]);

    $this->add_control('intro', [
      'label' => 'Intro (optioneel)',
      'type' => Controls_Manager::TEXTAREA,
      'rows' => 3,
    ]);

$repeater = new \Elementor\Repeater();

$repeater->add_control(
  'title',
  [
    'label' => 'Titel',
    'type' => \Elementor\Controls_Manager::TEXT,
    'default' => 'Case titel',
  ]
);

$repeater->add_control(
  'image',
  [
    'label' => 'Afbeelding',
    'type' => \Elementor\Controls_Manager::MEDIA,
  ]
);

$repeater->add_control(
  'link',
  [
    'label' => 'Link',
    'type' => \Elementor\Controls_Manager::URL,
    'options' => ['url', 'is_external'],
  ]
);

$this->add_control(
  'cases',
  [
    'label' => 'Cases',
    'type' => \Elementor\Controls_Manager::REPEATER,
    'fields' => $repeater->get_controls(),
    'title_field' => '{{{ title }}}',
  ]
);


    $this->end_controls_section();
  }

 
 /**
 * 👇 DIT IS DE ENIGE RENDERPLAATS
 */
protected function render_component() {
  $settings = $this->get_settings_for_display();

  // JOUW echte component-structuur
  $template = trailingslashit( get_stylesheet_directory() ) . 'components/case-showcase.php';

  if ( ! file_exists( $template ) ) {
    if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
      echo '<div style="padding:14px;border:1px dashed #ccc;border-radius:10px;">
        Case Showcase: template niet gevonden (components/case-showcase.php)
      </div>';
    }
    return;
  }

  include $template;
}
}