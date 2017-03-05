<?php
/**
 * Custom post type definitions.
 *
 * @link https://lillehummer.nl
 *
 * @package lillehummernl
 */

/**
 * Flush rewrite rules.
 */
function hummer_flush_rewrite_rules() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'hummer_flush_rewrite_rules' );

/**
 * Declare custom post types
 */
function hummer_custom_post_types() {

	$labels = array(
		'name'                  => _x( 'Post Types', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Post Type', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Post Types', 'text_domain' ),
		'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Items', 'text_domain' ),
		'add_new_item'          => __( 'Add New Item', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Item', 'text_domain' ),
		'description'           => __( 'Items', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest' 			=> false,
		'rest_base' 			=> 'item',
		'rewrite'				=> array( 'slug' => 'item', 'with_front' => false ),
		'has_archive' 			=> 'item',
		'menu_icon' 			=> '',
	);
	register_post_type( 'item', $args );

}
add_action( 'init', 'hummer_custom_post_types' );

/**
 * Declare custom taxonomies.
 */
function hummer_custom_taxonomies() {

	$labels = array(
		'name'                       	=> 'Taxonomies',
		'singular_name'              	=> 'Taxonomy',
		'menu_name'                  	=> 'Taxonomy',
		'all_items'                  	=> 'All Items',
		'parent_item'                	=> 'Parent Item',
		'parent_item_colon'          	=> 'Parent Item:',
		'new_item_name'              	=> 'New Item Name',
		'add_new_item'               	=> 'Add New Item',
		'edit_item'                  	=> 'Edit Item',
		'update_item'                	=> 'Update Item',
		'view_item'                  	=> 'View Item',
		'separate_items_with_commas' 	=> 'Separate items with commas',
		'add_or_remove_items'        	=> 'Add or remove items',
		'choose_from_most_used'      	=> 'Choose from the most used',
		'popular_items'              	=> 'Popular Items',
		'search_items'              	=> 'Search Items',
		'not_found'                 	=> 'Not Found',
		'no_terms'                  	=> 'No items',
		'items_list'                	=> 'Items list',
		'items_list_navigation'     	=> 'Items list navigation',
	);
	$args = array(
		'labels'                    	=> $labels,
		'hierarchical'              	=> false,
		'public'                    	=> true,
		'show_ui'                   	=> true,
		'show_admin_column'         	=> true,
		'show_in_nav_menus'         	=> true,
		'show_tagcloud'             	=> true,
		'rewrite' 						=> array( 'slug' => 'taxonomy' ),
	);
	register_taxonomy( 'taxonomy', array( 'post' ), $args );

}
add_action( 'init', 'hummer_custom_taxonomies', 0 );
