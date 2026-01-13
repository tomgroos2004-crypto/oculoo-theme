<?php
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Plugin;

if (!defined('ABSPATH')) exit;

class LS_Team_Cards_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-team-cards';
  }

  public function get_title() {
    return 'LS – Team cards';
  }

  public function get_icon() {
    return 'eicon-person';
  }

  public function get_categories() {
    return ['leadsprint'];
  }

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'Inhoud',
    ]);

    $this->add_control('intro', [
      'label' => 'Intro tekst',
      'type'  => Controls_Manager::TEXTAREA,
      'rows'  => 3,
    ]);

    $repeater = new Repeater();

    $repeater->add_control('image', [
      'label' => 'Foto',
      'type'  => Controls_Manager::MEDIA,
    ]);

    $repeater->add_control('name', [
      'label' => 'Naam',
      'type'  => Controls_Manager::TEXT,
    ]);

    $repeater->add_control('role', [
      'label' => 'Rol',
      'type'  => Controls_Manager::TEXT,
    ]);

    $repeater->add_control('text', [
      'label' => 'Tekst',
      'type'  => Controls_Manager::TEXTAREA,
      'rows'  => 4,
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

    $args = [
      'intro'  => $settings['intro'] ?? '',
      'people' => $settings['people'] ?? [],
    ];

    // ✅ SINGLE SOURCE OF TRUTH
    $component = get_stylesheet_directory() . '/components/team-cards.php';

    $is_editor = (
      class_exists('\Elementor\Plugin')
      && isset(Plugin::$instance->editor)
      && Plugin::$instance->editor->is_edit_mode()
    );

    // Editor fallback (geen fatal errors)
    if ($is_editor && !file_exists($component)) {
      echo '<section class="ls-team-cards"><div class="ls-container">';
      echo '<p class="small">Team cards component ontbreekt.</p>';
      echo '</div></section>';
      return;
    }

    // Render alleen als er data is
    if (!empty($args['people']) && file_exists($component)) {
      require $component;
    }
  }
}
