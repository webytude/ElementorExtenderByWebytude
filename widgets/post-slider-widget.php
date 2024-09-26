<?php
// namespace WB_PS\POST_SLIDER;
// use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Elementor_Post_Slider_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'post_slider';
    }

    public function get_title() {
        return __( 'Marsha Post Slider', 'elementor' );
    }

    public function get_icon() {
        return 'eicon-slider-album';
    }

    public function get_categories() {
        return [ 'basic' ]; // Choose the correct category
    }


    protected function register_controls() {

		$post_statuses = array();
		$post_statuses['any'] = esc_html__('Any', 'post-slider-for-elementor');
		$post_statuses = get_post_statuses();

		$this->start_controls_section(
			'query_configuration',
			[
				'label' => esc_html( 'Query', 'post-slider-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
			'post_status',
			[
				'label' => esc_html__( 'Post Status', 'post-slider-for-elementor' ),
				'placeholder' => esc_html__( 'Choose Post Status', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => 'publish',
				'multiple' => true,
				'options' => $post_statuses,
			]
		);

        $this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__( 'Limit', 'post-slider-for-elementor' ),
				'placeholder' => esc_html__( 'Default is 10', 'post-slider-for-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => -1,
				'default' => 10,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_configuration',
			[
				'label' => esc_html( 'Item Configurtion', 'post-slider-for-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => __( 'Read More:', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__('Read More', 'post-slider-for-elementor'),
				// 'label_block' => true,
				'description'	=>	'Change Read More Text from Here',
			]
		);

	}

    protected function render() {

		$settings = $this->get_settings_for_display();
		$read_more_text = isset($settings['read_more_text']) && $settings['read_more_text'] ? $settings['read_more_text'] : 'Read More';

		$args = array();

		$args['post_type'] = 'post';
		$args['post_status'] = 'publish';
		if( $settings['post_status'] && is_array($settings['post_status']) ){
			$args['post_status'] = $settings['post_status'];
		}

		if( isset($settings['posts_per_page']) && intval($settings['posts_per_page']) > 0 ){
			$args['posts_per_page'] = $settings['posts_per_page'];
		}

		if( isset($settings['posts_per_page']) && intval($settings['posts_per_page']) == -1 ){
			$args['posts_per_page'] = $settings['posts_per_page'];
		}

	        if( $args['post_type'] && $args['post_type'] != 'none' ){
	        if( $args['post_type'] !== 'page' ) {
	            $args['tax_query'] = [];
	            $taxonomies = get_object_taxonomies('post', 'objects');

	            foreach ($taxonomies as $object) {
	                $setting_key = $object->name . '_ids';

	                if (!empty($settings[$setting_key])) {
	                    $args['tax_query'][] = [
	                        'taxonomy' => $object->name,
	                        'field' => 'term_id',
	                        'terms' => $settings[$setting_key],
	                    ];
	                }
	            }

	            if (!empty($args['tax_query'])) {
	                $args['tax_query']['relation'] = 'AND';
	            }
	        }

	        echo '<div class="swiper-container">';
            echo '<div class="swiper-wrapper">';
	        $post_query = new \WP_Query($args);
	        if( $post_query->have_posts() ){
	        	$count=0;
				while( $post_query->have_posts() ){
                    echo '<div class="post-slide swiper-slide">';
					$post_query->the_post();
                    $post_id = get_the_ID();
                    $thumbnail_image = get_the_post_thumbnail( get_the_ID(), 'large' )
                    ?>
                    <div class="post-column">
                        <?php
                        if (!empty($thumbnail_image)) {
                            ?>
                            <div class="post-image">
                                <a href="<?php echo get_permalink($post_id); ?>">
                                  <?php echo $thumbnail_image; ?>
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="post-information">
                            <a href="<?php echo get_permalink($post_id); ?>">
                                <h3 class="title"><?php echo get_the_title($post_id); ?></h3>
                            </a>
							<div class="p-small">
								<?php 
								$content = get_the_content(null, false, $post_id);
								$trimmed_content = wp_trim_words($content, 20, '...');
								echo $trimmed_content; 
								?>
							</div>
                            <div class="post-btn">
                                <a href="<?php echo get_permalink($post_id); ?>" class="btn-secondary"><?php echo $read_more_text ?></a>
                            </div>
                        </div>
                    </div>
                    <?php


                    echo '</div>';
				}
				wp_reset_postdata();
			}
			echo "</div>";
			echo "</div>";

            echo '<div class="swiper-pagination"></div>';
            echo '<div class="swiper-button-next"></div>';
            echo '<div class="swiper-button-prev"></div>';

			?>

			<?php

		}


	}
}
