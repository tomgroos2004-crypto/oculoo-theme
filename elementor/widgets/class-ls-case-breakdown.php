<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;

class LS_Case_Breakdown_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-case-breakdown';
  }

  public function get_title() {
    return 'LS – Case Breakdown';
  }

  public function get_icon() {
    return 'eicon-tabs';
  }

  public function get_categories() {
    return ['leadsprint'];
  }

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'Tabs'
    ]);

    $repeater = new Repeater();

    $repeater->add_control('label', [
      'label' => 'Tab titel',
      'type' => Controls_Manager::TEXT,
      'default' => 'Website'
    ]);

    $repeater->add_control('image', [
      'label' => 'Afbeelding',
      'type' => Controls_Manager::MEDIA,
    ]);

    $repeater->add_control('points', [
      'label' => 'Punten',
      'type' => Controls_Manager::TEXTAREA,
      'description' => 'Elke regel = 1 punt',
      'rows' => 5
    ]);

    $this->add_control('tabs', [
      'type' => Controls_Manager::REPEATER,
      'fields' => $repeater->get_controls(),
      'title_field' => '{{{ label }}}',
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {
    $settings = $this->get_settings_for_display();
    include locate_template('components/case-breakdown.php');
  }
}
