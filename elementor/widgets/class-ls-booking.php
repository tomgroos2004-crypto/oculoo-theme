<?php
if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;
use Elementor\Repeater;

class LS_Booking_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-booking';
  }

  public function get_title() {
    return 'LS – Booking';
  }

  public function get_icon() {
    return 'eicon-calendar';
  }

  public function get_categories() {
    return ['leadsprint'];
  }

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'Booking'
    ]);

    $this->add_control('title', [
      'label'   => 'Titel',
      'type'    => Controls_Manager::TEXT,
      'default' => 'Plan je gesprek',
    ]);

    $this->add_control('intro', [
      'label' => 'Intro tekst',
      'type'  => Controls_Manager::TEXTAREA,
    ]);

    $repeater = new Repeater();

    $repeater->add_control('name', [
      'label'   => 'Naam',
      'type'    => Controls_Manager::TEXT,
      'default' => 'Naam',
    ]);

    $repeater->add_control('photo', [
      'label' => 'Foto',
      'type'  => Controls_Manager::MEDIA,
    ]);

    $repeater->add_control('embed', [
      'label'       => 'Calendly embed code',
      'type'        => Controls_Manager::TEXTAREA,
      'placeholder' => '<iframe src="https://calendly.com/..." width="100%" height="700"></iframe>',
    ]);

    $this->add_control('people', [
      'label'       => 'Personen',
      'type'        => Controls_Manager::REPEATER,
      'fields'      => $repeater->get_controls(),
      'title_field' => '{{{ name }}}',
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {
    $settings = $this->get_settings_for_display();
    include get_stylesheet_directory() . '/components/booking.php';
  }
}
