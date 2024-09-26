<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

class Testimonials extends Widget_Base
{
    public function get_name()
    {
        return 'testimonials';
    }

    public function get_title()
    {
        return esc_html__('Marsha Testimonials', 'elementor');
    }

    public function get_icon()
    {
        return 'eicon-bullet-list';
    }

    public function get_keywords()
    {
        return ['Testimonials', 'image', 'testimonial'];
    }

    public function get_categories()
    {
        return ['basic'];
    }

    public function get_script_depends()
    {
        return ['swiper-js', 'image-repeater-js'];
    }


    public function get_style_depends()
    {
        return ['swiper-css'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_image',
            [
                'label' => esc_html__('Testimonials', 'elementor'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'star',
            [
                'label' => esc_html__('Select Number of star', 'elementor'),
                'type' => Controls_Manager::NUMBER,
                'label_block' => true,
                'min' => 1,
                'max' => 5,
				'default' => 5,
            ]
        );
        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Testimonial Description', 'elementor'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => esc_html__('Duis placerat faucibus nisi, nec lobortis tortor elementum a. Nullam eget dolor luctus, congue nisl sit amet, porta ipsum. Praesent malesuada eros a mi aliquam sollicitudin. Nullam eget dolor luctus, congue nisl sit amet, porta ipsum. Praesent malesuada eros a mi aliquam sollicitudin.', 'elementor'),

            ]
        );
        $repeater->add_control(
            'author_image',
            [
                'label' => esc_html__('Author Image', 'elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'author_name',
            [
                'label' => esc_html__('Author Name', 'elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Jane Doe', 'elementor'),
            ]
        );
        $repeater->add_control(
            'author_description',
            [
                'label' => esc_html__('Author Description', 'elementor'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => esc_html__('Lorem ipsum dolor', 'elementor'),
            ]
        );

        $this->add_control(
            'testimonial',
            [
                'label' => esc_html__('Testimonial', 'elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls()
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="text-center">
            <div class="testimonials-swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($settings['testimonial'] as $item) : 
                        ?>
                        <div class="swiper-slide">
                            <div class="details">
                                <div class="stars">
                                    <?php
                                    for($i = 1; $i<=$item['star'];$i++)
                                    {
                                    echo ' <img src="https://dev.marshaarmstrongmd.com/wp-content/uploads/2024/09/Icon-material-star.png" alt="star">';
                                    } 
                                    ?>
                                </div>
                                <p><?php echo esc_html($item['description']); ?></p>
                                <div class="author-details">
                                    <div>
                                        <img src="<?php echo esc_url($item['author_image']['url']); ?>" alt="<?php echo esc_attr($item['author_name']); ?>">
                                    </div>
                                    <div class="details">
                                        <h6><?php echo esc_html($item['author_name']); ?></h6>
                                        <p><?php echo esc_html($item['author_description']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                 endforeach; ?>
                </div>
                <!-- <div class="swiper-pagination"></div> -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
        <?php
    }

    /*
    protected function _content_template()
    {
        ?>
        <# var settings=settings; #>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <# _.each(settings.list, function(item) { #>
                        <div class="swiper-slide">
                            <a href="{{ item.link.url }}">
                                <img src="{{ item.selected_image.url }}" alt="{{ item.text }}">
                                <h3 class="elementor-image-list-text">{{{ item.text }}}</h3>
                            </a>
                        </div>
                        <# }); #>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

        <?php
    }
    */
}

    ?>