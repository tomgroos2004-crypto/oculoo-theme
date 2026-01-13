<?php
use Elementor\Controls_Manager;

class LS_Cards_Widget extends LS_Base_Widget {

  public function get_name() {
    return 'ls-cards';
  }

  public function get_title() {
    return 'LS – Cards';
  }

  public function get_icon() {
    return 'eicon-posts-grid';
  }

  public function get_categories() {
    return ['leadsprint'];
  }

  protected function register_controls() {

    $this->start_controls_section('content', [
      'label' => 'Cards'
    ]);

    $this->add_control('title', [
      'type'  => Controls_Manager::TEXT,
      'label' => 'Titel (optioneel)',
    ]);

    $this->add_control('intro', [
      'type'  => Controls_Manager::TEXTAREA,
      'label' => 'Intro (optioneel)',
    ]);

    $this->add_control('items', [
      'type'  => Controls_Manager::REPEATER,
      'label' => 'Cards',
      'fields' => [

        [
          'name' => 'title',
          'type' => Controls_Manager::TEXT,
          'label'=> 'Titel',
        ],
        [
          'name' => 'text',
          'type' => Controls_Manager::TEXTAREA,
          'label'=> 'Tekst',
        ],
        [
          'name' => 'icon',
          'type' => Controls_Manager::ICONS,
          'label'=> 'Icoon (optioneel)',
        ],

        [
          'name' => 'button_text',
          'type' => Controls_Manager::TEXT,
          'label'=> 'Knop tekst (optioneel)',
        ],
        [
          'name' => 'button_url',
          'type' => Controls_Manager::URL,
          'label'=> 'Knop link',
        ],
        [
          'name' => 'button_style',
          'type' => Controls_Manager::SELECT,
          'label'=> 'Knop stijl',
          'options' => [
            'primary'   => 'Primary',
            'secondary' => 'Secondary',
          ],
          'default' => 'primary',
        ],

        [
          'name' => 'variant',
          'type' => Controls_Manager::SELECT,
          'label'=> 'Card type',
          'options' => [
            ''        => 'Standaard',
            'problem' => 'Problem / Pain point',
            'trust'   => 'Trust / Review',
            'feature' => 'USP / Feature',
          ],
          'default' => '',
        ],

        [
          'name' => 'is_cta',
          'type' => Controls_Manager::SWITCHER,
          'label'=> 'CTA-kaart',
          'return_value' => '1',
        ],
      ],
      'default' => [
        ['title'=>'Card titel','text'=>'Korte uitleg.'],
        ['title'=>'Card titel','text'=>'Korte uitleg.'],
        ['title'=>'Card titel','text'=>'Korte uitleg.'],
      ],
    ]);

    $this->add_control('columns', [
      'type' => Controls_Manager::SELECT,
      'label'=> 'Kolommen',
      'options' => [
        '1'=>'1','2'=>'2','3'=>'3','4'=>'4',
      ],
      'default'=>'3',
    ]);

    $this->add_control('style', [
      'type'=>Controls_Manager::SELECT,
      'label'=>'Cards stijl',
      'options'=>[
        'filled'=>'Filled',
        'outlined'=>'Outlined',
      ],
      'default'=>'filled',
    ]);

    $this->end_controls_section();
  }

  protected function render_component() {
    $s = $this->get_settings_for_display();
    $title = $s['title'] ?? '';
    $intro = $s['intro'] ?? '';
    $items = $s['items'] ?? [];

    $variant = trim(
      'cols-' . ($s['columns'] ?? '3') . ' ' .
      ($s['style'] ?? 'filled')
    );

    include get_stylesheet_directory() . '/components/cards.php';
  }
}
