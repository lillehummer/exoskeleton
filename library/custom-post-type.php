<?php

/**
 * Flush rewrite rules.
 */
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

/**
 * Declare custom post types
 */
function bones_custom_post_types() {

	$labels = array(
		'name'                  => _x( 'Post Types', 'Post Type General Name', 'lillehummernl' ),
		'singular_name'         => _x( 'Post Type', 'Post Type Singular Name', 'lillehummernl' ),
		'menu_name'             => __( 'Post Types', 'lillehummernl' ),
		'name_admin_bar'        => __( 'Post Type', 'lillehummernl' ),
		'archives'              => __( 'Item Archives', 'lillehummernl' ),
		'parent_item_colon'     => __( 'Parent Item:', 'lillehummernl' ),
		'all_items'             => __( 'All Items', 'lillehummernl' ),
		'add_new_item'          => __( 'Add New Item', 'lillehummernl' ),
		'add_new'               => __( 'Add New', 'lillehummernl' ),
		'new_item'              => __( 'New Item', 'lillehummernl' ),
		'edit_item'             => __( 'Edit Item', 'lillehummernl' ),
		'update_item'           => __( 'Update Item', 'lillehummernl' ),
		'view_item'             => __( 'View Item', 'lillehummernl' ),
		'search_items'          => __( 'Search Item', 'lillehummernl' ),
		'not_found'             => __( 'Not found', 'lillehummernl' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'lillehummernl' ),
		'featured_image'        => __( 'Featured Image', 'lillehummernl' ),
		'set_featured_image'    => __( 'Set featured image', 'lillehummernl' ),
		'remove_featured_image' => __( 'Remove featured image', 'lillehummernl' ),
		'use_featured_image'    => __( 'Use as featured image', 'lillehummernl' ),
		'insert_into_item'      => __( 'Insert into item', 'lillehummernl' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'lillehummernl' ),
		'items_list'            => __( 'Items list', 'lillehummernl' ),
		'items_list_navigation' => __( 'Items list navigation', 'lillehummernl' ),
		'filter_items_list'     => __( 'Filter items list', 'lillehummernl' ),
	);
	$args = array(
		'label'                 => __( 'Post Type', 'lillehummernl' ),
		'description'           => __( 'Post Type Description', 'lillehummernl' ),
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
		'show_in_rest' 					=> false,
		'rest_base' 						=> 'post_type',
		'rewrite'								=> array( 'slug' => 'custom_type', 'with_front' => false ),
		'has_archive' 					=> 'custom_type',
		'menu_icon' 						=> '',
	);
	register_post_type( 'post_type', $args );

}
add_action( 'init', 'bones_custom_post_types' );

/**
 * Declare custom taxonomies.
 */
function bones_custom_taxonomies() {

	$labels = array(
		'name'                       	=> _x( 'Taxonomies', 'Taxonomy General Name', 'lillehummernl' ),
		'singular_name'              	=> _x( 'Taxonomy', 'Taxonomy Singular Name', 'lillehummernl' ),
		'menu_name'                  	=> __( 'Taxonomy', 'lillehummernl' ),
		'all_items'                  	=> __( 'All Items', 'lillehummernl' ),
		'parent_item'                	=> __( 'Parent Item', 'lillehummernl' ),
		'parent_item_colon'          	=> __( 'Parent Item:', 'lillehummernl' ),
		'new_item_name'              	=> __( 'New Item Name', 'lillehummernl' ),
		'add_new_item'               	=> __( 'Add New Item', 'lillehummernl' ),
		'edit_item'                  	=> __( 'Edit Item', 'lillehummernl' ),
		'update_item'                	=> __( 'Update Item', 'lillehummernl' ),
		'view_item'                  	=> __( 'View Item', 'lillehummernl' ),
		'separate_items_with_commas' 	=> __( 'Separate items with commas', 'lillehummernl' ),
		'add_or_remove_items'        	=> __( 'Add or remove items', 'lillehummernl' ),
		'choose_from_most_used'      	=> __( 'Choose from the most used', 'lillehummernl' ),
		'popular_items'              	=> __( 'Popular Items', 'lillehummernl' ),
		'search_items'              	=> __( 'Search Items', 'lillehummernl' ),
		'not_found'                 	=> __( 'Not Found', 'lillehummernl' ),
		'no_terms'                  	=> __( 'No items', 'lillehummernl' ),
		'items_list'                	=> __( 'Items list', 'lillehummernl' ),
		'items_list_navigation'     	=> __( 'Items list navigation', 'lillehummernl' ),
	);
	$args = array(
		'labels'                    	=> $labels,
		'hierarchical'              	=> false,
		'public'                    	=> true,
		'show_ui'                   	=> true,
		'show_admin_column'         	=> true,
		'show_in_nav_menus'         	=> true,
		'show_tagcloud'             	=> true,
		'rewrite' 										=> array( 'slug' => 'custom-slug' ),
	);
	register_taxonomy( 'taxonomy', array( 'post' ), $args );

}
add_action( 'init', 'bones_custom_taxonomies', 0 );

?>
