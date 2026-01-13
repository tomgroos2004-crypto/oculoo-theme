<?php
if (!defined('ABSPATH')) exit;

use Elementor\Controls_Manager;

class LS_Blog_List_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-blog-list';
  }

  public function get_title() {
    return 'LS – Blog / Kennis';
  }

  public function get_icon() {
    return 'eicon-post-list';
  }

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'Inhoud'
    ]);

    $this->add_control('title', [
      'label'   => 'Titel',
      'type'    => Controls_Manager::TEXT,
      'default' => 'Kennis & inzichten',
    ]);

    $this->add_control('intro', [
      'label' => 'Intro tekst',
      'type'  => Controls_Manager::TEXTAREA,
    ]);

    $this->add_control('category', [
      'label'   => 'Categorie',
      'type'    => Controls_Manager::SELECT,
      'options' => $this->get_categories_for_control(),
      'default' => '',
    ]);

    $this->add_control('count', [
      'label'   => 'Aantal artikelen',
      'type'    => Controls_Manager::NUMBER,
      'default' => 3,
      'min'     => 1,
      'max'     => 12,
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

    $this->end_controls_section();
  }

  /**
   * Categorieën voor Elementor select
   */
  private function get_categories_for_control() {

    $cats = get_categories([
      'hide_empty' => false,
    ]);

    $options = [
      '' => '— Selecteer categorie —'
    ];

    foreach ($cats as $cat) {
      $options[$cat->slug] = $cat->name;
    }

    return $options;
  }

  /**
   * Render: data ophalen + settings verrijken
   * VOLLEDIG compatibel met LS_Base_Widget
   */
  protected function render_component() {

    $settings = $this->get_settings_for_display();

    if (empty($settings['category'])) {
      return;
    }

    $query = new WP_Query([
      'post_type'      => 'post',
      'posts_per_page' => (int) $settings['count'],
      'category_name'  => $settings['category'],
      'no_found_rows'  => true,
    ]);

    if (!$query->have_posts()) {
      return;
    }

    // 🔑 single source of truth
    $settings['posts'] = $query->posts;

    include get_stylesheet_directory() . '/components/blog-list.php';
  }
}
