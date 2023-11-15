<?php
/**
 * Plugin Name:       Team Slider Block
 * Description:       Display Team Slider Block.
 * Requires at least: 5.7
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Lorem Ipsum
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       team-slider
 *
 * @package           blocks-course
 */


include_once('member-cpt.php');



function render_team_slider_block($attributes) {

	global $post;

	$numberOfPosts = isset($attributes['numberOfPosts']) ? $attributes['numberOfPosts'] : 6;
	$order = isset($attributes['order']) ? $attributes['order'] : 'DESC';
	$selectedMembers = isset($attributes['selectedMembers']) ? $attributes['selectedMembers'] : [];

	$args = array(
		'post_type'      => 'member',
		'post_status'    => 'publish',
		'posts_per_page' => $numberOfPosts,
		'order'          => $order,
	);

	if ( !empty($selectedMembers ) ) {
		$args['post__in'] = $selectedMembers;
	}

	$query = new WP_Query($args);

	$posts = '<div ' . get_block_wrapper_attributes() . '>';

	$posts .= '<div class="swiper">';

	$posts .= '<ul class="swiper-wrapper">';

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$title = get_the_title();
			$title = $title ? $title : __('( No title )', 'team-slider');
			$permalink = get_permalink();
			$content = get_the_content();
			$position = get_field('position');

			$status = get_post_meta( $post->ID, '_member_status', true);


			$posts .= '<li class="swiper-slide">';

			if (has_post_thumbnail()) {
					$posts .= get_the_post_thumbnail(get_the_ID(), 'large');
			}
			$posts .= '<h3><a href="' . esc_url($permalink) . '">' . $title . '</a></h3>';

			$posts .= '<p>' . $status . '</p>';

			if (!empty($content)) {
					$posts .= '<p>' . $content . '</p>';
			}

			$posts .= '</li>';
		}
		wp_reset_postdata();
	}

	$posts  .= '</ul';
	$posts  .= '</div';
	$posts .= '</div>';

	return $posts;
}

/**
 * Block_team_slider_block_init.
 *
 * @return void
 */
function block_team_slider_block_init() {
	register_block_type_from_metadata( __DIR__, array(
			'render_callback' => 'render_team_slider_block'
	) );

	// wp_enqueue_script( 'blocks-course-team-slider-view-script' );
	wp_enqueue_script('swiper-script', plugins_url( (basename(__DIR__) ) ) . '/node_modules/swiper/swiper-bundle.js', '', '', true);
	wp_enqueue_style('swiper-style', plugins_url( (basename(__DIR__) ) ) . '/node_modules/swiper/swiper-bundle.min.css', '', '');
	wp_enqueue_script( 'team_slider', plugins_url( (basename(__DIR__) ) ) . '/script.js', 'swiper-script', '', true );

}

add_action( 'init', 'block_team_slider_block_init' );

function add_member_status_meta_box() {
	add_meta_box(
		 'member_status_meta_box',
		 'Member Status',
		 'display_member_status_meta_box',
		 'member',
		 'normal',
		 'high'
	);
}

add_action('add_meta_boxes', 'add_member_status_meta_box');

function display_member_status_meta_box($post) {
	$status = get_post_meta($post->ID, '_member_status', true);

	echo '<label for="member_status">Status:</label>';
	echo '<input type="text" id="member_status" name="member_status" value="' . esc_attr($status) . '">';
}

function save_member_status_meta_box($post_id) {
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		 return;
	}

	if (isset($_POST['member_status'])) {
		 update_post_meta($post_id, '_member_status', sanitize_text_field($_POST['member_status']));
	}
}

add_action('save_post_member', 'save_member_status_meta_box');
