<?php

namespace BrodosOnlineshopElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Brodos_Search extends Widget_Base {

    public function get_name() {
        return 'brodos-search';
    }

    public function get_title() {
        return __('Brodos Search', 'brodos-onlineshop');
    }

    public function get_icon() {
        return 'fa fa-search';
    }

    public function get_keywords() {
        return ['brodos', 'onlineshop', 'search'];
    }

    public function is_reload_preview_required() {
        return true;
    }

    public function get_categories() {
        return ['brodos-onlineshop'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
                'section_content', [
            'label' => __('Brodos Onlineshop Search Configuration', 'brodos-onlineshop'),
                ]
        );

        $this->add_control(
                'shortcode', [
            'label' => __('shortcode', 'brodos-onlineshop'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('[BrodosSearch]', 'brodos-onlineshop'),
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $shortcode = $this->get_settings_for_display('shortcode');

        $shortcode = do_shortcode(shortcode_unautop($shortcode));
        ?>
        <div class="elementor-shortcode brodos-elementor-shortcode brodos-elementor-search-shortcode"><?php echo $shortcode; ?></div>
        <?php
    }

    public function render_plain_content() {
        // In plain mode, render without shortcode
        echo $this->get_settings('shortcode');
    }

    protected function content_template() {
        
    }

}
