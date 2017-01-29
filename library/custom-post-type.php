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
		'name'                  => 'Custom Post Types',
		'singular_name'         => 'Custom Post Type',
		'menu_name'             => 'Custom Post Types',
		'name_admin_bar'        => 'Custom Post Type',
		'archives'              => 'Item Archives',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Items',
		'add_new_item'          => 'Add New Item',
		'add_new'               => 'Add New',
		'new_item'              => 'New Item',
		'edit_item'             => 'Edit Item',
		'update_item'           => 'Update Item',
		'view_item'             => 'View Item',
		'search_items'          => 'Search Item',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into item',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$args = array(
		'label'                 => 'Custom Post Type',
		'description'           => 'Custom Post Type Description',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky' ),
		// 'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
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
		'capability_type'       => 'post',
		'show_in_rest' 			=> false,
		'rest_base' 			=> 'custom_post_type',
		'rewrite'				=> array( 'slug' => 'custom_post_type', 'with_front' => false ),
		'has_archive' 			=> 'custom_post_type',
		'menu_icon' 			=> '',
	);
	register_post_type( 'custom_post_type', $args );

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
