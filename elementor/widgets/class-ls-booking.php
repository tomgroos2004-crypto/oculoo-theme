<?php
if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;

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

    $this->add_control('embed', [
      'label'       => 'Booking embed (Calendly / Cal.com)',
      'type'        => Controls_Manager::TEXTAREA,
      'description' => 'Plak hier de volledige embed code',
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {
    $settings = $this->get_settings_for_display();
    include get_stylesheet_directory() . '/components/booking.php';
  }
}
