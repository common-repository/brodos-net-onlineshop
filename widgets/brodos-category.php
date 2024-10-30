<?php

namespace BrodosOnlineshopElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Brodos_Category extends Widget_Base {

    public function get_name() {
        return 'brodos-category';
    }

    public function get_title() {
        return __('Brodos Category', 'brodos-onlineshop');
    }

    public function get_icon() {
        return 'eicon-product-categories';
    }

    public function get_keywords() {
        return ['brodos', 'onlineshop', 'category'];
    }

    public function is_reload_preview_required() {
        return true;
    }

    public function get_categories() {
        return ['brodos-onlineshop'];
    }
    
    public static function get_button_sizes() {
		return [
			'xs' => __( 'Extra Small', 'elementor' ),
			'sm' => __( 'Small', 'elementor' ),
			'md' => __( 'Medium', 'elementor' ),
			'lg' => __( 'Large', 'elementor' ),
			'xl' => __( 'Extra Large', 'elementor' ),
		];
	}

    protected function _register_controls() {
        $this->start_controls_section(
                'section_content', [
            'label' => __('Brodos Onlineshop Category', 'brodos-onlineshop'),
                ]
        );

        $this->add_control(
                'shortcode', [
            'label' => __('shortcode', 'brodos-onlineshop'),
            'type' => Controls_Manager::TEXTAREA,
            'default' => __('[BrodosCategory]', 'brodos-onlineshop'),
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $shortcode = $this->get_settings_for_display('shortcode');

        $shortcode = do_shortcode(shortcode_unautop($shortcode));
        ?>
        <div class="elementor-shortcode brodos-elementor-shortcode brodos-elementor-cart-shortcode"><?php echo $shortcode; ?></div>
        <?php
    }

    public function render_plain_content() {
        // In plain mode, render without shortcode
        echo $this->get_settings('shortcode');
    }

    protected function content_template() {
        
    }

}
