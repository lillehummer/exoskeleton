<?php

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}


function bones_custom_post_types() {

	register_post_type( 'custom_type',
		array( 'labels' => array(
			'name' => __( 'Custom Types', 'lillehummernl' ),
			'singular_name' => __( 'Custom Post', 'lillehummernl' ),
			'all_items' => __( 'All Custom Posts', 'lillehummernl' ),
			'add_new' => __( 'Add New', 'lillehummernl' ),
			'add_new_item' => __( 'Add New Custom Type', 'lillehummernl' ),
			'edit' => __( 'Edit', 'lillehummernl' ),
			'edit_item' => __( 'Edit Post Type', 'lillehummernl' ),
			'new_item' => __( 'New Post Type', 'lillehummernl' ),
			'view_item' => __( 'View Post Type', 'lillehummernl' ),
			'search_items' => __( 'Search Post Type', 'lillehummernl' ),
			'not_found' =>  __( 'Nothing found in the Database.', 'lillehummernl' ),
			'not_found_in_trash' => __( 'Nothing found in Trash', 'lillehummernl' ),
			'parent_item_colon' => ''
			),
			'description' => __( 'This is the example custom post type', 'lillehummernl' ),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8,
			'menu_icon' => '',
			'rewrite'	=> array( 'slug' => 'custom_type', 'with_front' => false ),
			'has_archive' => 'custom_type',
			'capability_type' => 'post',
			'hierarchical' => false,
			'show_in_rest' => false,
			'rest_base' => 'custom_type',
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
		)
	);

	register_taxonomy_for_object_type( 'category', 'custom_type' );
	register_taxonomy_for_object_type( 'post_tag', 'custom_type' );

}

	// adding the function to the Wordpress init
	add_action( 'init', 'bones_custom_post_types');

	register_taxonomy( 'custom_cat',
		array('custom_type'),
		array('hierarchical' => true,
			'labels' => array(
				'name' => __( 'Custom Categories', 'lillehummernl' ),
				'singular_name' => __( 'Custom Category', 'lillehummernl' ),
				'search_items' =>  __( 'Search Custom Categories', 'lillehummernl' ),
				'all_items' => __( 'All Custom Categories', 'lillehummernl' ),
				'parent_item' => __( 'Parent Custom Category', 'lillehummernl' ),
				'parent_item_colon' => __( 'Parent Custom Category:', 'lillehummernl' ),
				'edit_item' => __( 'Edit Custom Category', 'lillehummernl' ),
				'update_item' => __( 'Update Custom Category', 'lillehummernl' ),
				'add_new_item' => __( 'Add New Custom Category', 'lillehummernl' ),
				'new_item_name' => __( 'New Custom Category Name', 'lillehummernl' )
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'custom-slug' ),
		)
	);

	register_taxonomy( 'custom_tag',
		array('custom_type'),
		array('hierarchical' => false,
			'labels' => array(
				'name' => __( 'Custom Tags', 'lillehummernl' ),
				'singular_name' => __( 'Custom Tag', 'lillehummernl' ),
				'search_items' =>  __( 'Search Custom Tags', 'lillehummernl' ),
				'all_items' => __( 'All Custom Tags', 'lillehummernl' ),
				'parent_item' => __( 'Parent Custom Tag', 'lillehummernl' ),
				'parent_item_colon' => __( 'Parent Custom Tag:', 'lillehummernl' ),
				'edit_item' => __( 'Edit Custom Tag', 'lillehummernl' ),
				'update_item' => __( 'Update Custom Tag', 'lillehummernl' ),
				'add_new_item' => __( 'Add New Custom Tag', 'lillehummernl' ),
				'new_item_name' => __( 'New Custom Tag Name', 'lillehummernl' )
			),
			'show_admin_column' => true,
			'show_ui' => true,
			'query_var' => true,
		)
	);
?>
