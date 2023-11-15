<?php
/**
 * Register a custom post type called "book".
 *
 * @see get_post_type_labels() for label keys.
 */
function wpdocs_codex_book_init() {
	$labels = array(
		'name'                  => _x( 'Member', 'Post type general name', 'textdomain' ),
		'singular_name'         => _x( 'Member', 'Post type singular name', 'textdomain' ),
		'menu_name'             => _x( 'Members', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar'        => _x( 'Members', 'Add New on Toolbar', 'textdomain' ),
		'add_new'               => __( 'Add New', 'textdomain' ),
		'add_new_item'          => __( 'Add New Member', 'textdomain' ),
		'new_item'              => __( 'New Member', 'textdomain' ),
		'edit_item'             => __( 'Edit Member', 'textdomain' ),
		'view_item'             => __( 'View Member', 'textdomain' ),
		'all_items'             => __( 'All Members', 'textdomain' ),
		'search_items'          => __( 'Search Members', 'textdomain' ),
		'parent_item_colon'     => __( 'Parent Members:', 'textdomain' ),
		'not_found'             => __( 'No books found.', 'textdomain' ),
		'not_found_in_trash'    => __( 'No books found in Trash.', 'textdomain' ),
		'featured_image'        => _x( 'Feature image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),

	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'member' ),
		// 'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-groups',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
		'show_in_rest'       => true,
	);

	register_post_type( 'member', $args );

}

add_action( 'init', 'wpdocs_codex_book_init' );
