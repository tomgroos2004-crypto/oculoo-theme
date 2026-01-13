<?php
if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;
use Elementor\Repeater;

class LS_Cases_List_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-cases-list';
  }

  public function get_title() {
    return 'LS – Cases';
  }

  public function get_icon() {
    return 'eicon-check-circle';
  }

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'Inhoud'
    ]);

    $this->add_control('title', [
      'label'   => 'Titel',
      'type'    => Controls_Manager::TEXT,
      'default' => 'Resultaten uit de praktijk',
    ]);

    $this->add_control('intro', [
      'label' => 'Intro tekst',
      'type'  => Controls_Manager::TEXTAREA,
    ]);

    $this->add_control('columns', [
      'label'   => 'Kolommen',
      'type'    => Controls_Manager::SELECT,
      'options' => [
        '2' => '2 kolommen',
        '3' => '3 kolommen',
        '4' => '4 kolommen',
      ],
      'default' => '3',
    ]);

    $repeater = new Repeater();

    $repeater->add_control('case_title', [
      'label' => 'Case titel',
      'type'  => Controls_Manager::TEXT,
    ]);

    $repeater->add_control('case_result', [
      'label' => 'Resultaat / besparing',
      'type'  => Controls_Manager::TEXT,
      'placeholder' => 'Bijv. €42 p/m bespaard',
    ]);

    $repeater->add_control('case_text', [
      'label' => 'Korte uitleg',
      'type'  => Controls_Manager::TEXTAREA,
    ]);

    $repeater->add_control('case_service', [
      'label' => 'Dienst',
      'type'  => Controls_Manager::TEXT,
      'placeholder' => 'Bijv. Vast internet',
    ]);

    $repeater->add_control('case_location', [
      'label' => 'Locatie',
      'type'  => Controls_Manager::TEXT,
      'placeholder' => 'Bijv. Buurse',
    ]);

    $repeater->add_control('case_image', [
      'label' => 'Afbeelding (optioneel)',
      'type'  => Controls_Manager::MEDIA,
    ]);

    $repeater->add_control('case_url', [
      'label' => 'Link naar case',
      'type'  => Controls_Manager::URL,
    ]);

    $this->add_control('items', [
      'label'       => 'Cases',
      'type'        => Controls_Manager::REPEATER,
      'fields'      => $repeater->get_controls(),
      'title_field' => '{{{ case_title }}}',
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {
    $settings = $this->get_settings_for_display();
    include get_stylesheet_directory() . '/components/cases-list.php';
  }
}
