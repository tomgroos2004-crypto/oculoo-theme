<?php
use Elementor\Widget_Base;

if (!defined('ABSPATH')) exit;

/**
 * LeadSprint – Base Elementor Widget
 * Neutraliseert Elementor container gedrag
 */
abstract class LS_Base_Widget extends Widget_Base {

  /**
   * Wrap elke widget in een neutrale wrapper
   */
  protected function render() {

    echo '<div class="ls-widget">';
    $this->render_component();
    echo '</div>';

  }

  /**
   * Elke widget moet z’n eigen component renderen
   */
  abstract protected function render_component();
}
