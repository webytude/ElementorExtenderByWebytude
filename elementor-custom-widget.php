<?php

/**
 * Plugin Name: Elementor Custom Slider Add-on
 * Description: We developed this plugin specifically for the non-pro version of Elementor to create custom slider models. It integrates seamlessly with Elementor's default widgets and follows Elementor's coding standards to ensure compatibility with future updates.
 * Version: 2.0
 * Author: Webytude Team
 * Author URI: https://www.webytude.com/
 * Text Domain: elementor-custom
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function custom_register_widget($widgets_manager)
{
    require_once(plugin_dir_path(__FILE__) . 'widgets/testimonials.php');
    $widgets_manager->register(new \Elementor\Testimonials());

    require_once(plugin_dir_path(__FILE__) . 'widgets/post-slider-widget.php');
    $widgets_manager->register( new \Elementor_Post_Slider_Widget() );

}
add_action('elementor/widgets/register', 'custom_register_widget');

function enqueue_slider_assets() {
    wp_enqueue_style( 'swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css', [], null );

    // Swiper JS
    wp_enqueue_script( 'swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', [], null, true );

    // Your Custom Slider Script
    wp_enqueue_script( 'post-slider-script', plugins_url( '/assets/js/slider.js', __FILE__ ), array( 'jquery', 'swiper-js' ), false, true );
}

add_action( 'wp_enqueue_scripts', 'enqueue_slider_assets' );
