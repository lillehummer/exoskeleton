<?php
/**
 * Sabi shortcodes.
 *
 * @category function library
 * @package lillehummernl
 * @author Lille Hummer
 */

add_action( 'init', 'hummer_register_shortcodes' );
function hummer_register_shortcodes() {
	add_shortcode( 'button', 'hummer_shortcode_button' );
}

function hummer_shortcode_button ( $attr, $content, $shortcode_tag ) {
	$a = shortcode_atts( array(
        'href' => 'http://',
    ), $atts );

	return '<a href="#" class="button"></a>';
}

add_action( 'register_shortcode_ui', 'hummer_shortcode_ui_button' );
function hummer_shortcode_ui_button() {
	$fields = array(
		array(
			'label'  => 'URL',
			'attr'   => 'href',
			'type'   => 'url',
			'meta'   => array(
				'placeholder' => 'http://',
			),
		),
	);

	$args = array(
		'label' => 'Button',
		'listItemImage' => 'dashicons-editor-quote',
		// 'post_type' => array( 'post' ),
		/* 'inner_content' => array(
			'label'        => 'Button text',
			'description'  => 'This text will appear between the shortcode.',
		), */
		'attrs' => $fields,
	);
	shortcode_ui_register_for_shortcode( 'button', $args );
}
