<?php
// Adapted from - https://developer.wordpress.org/themes/advanced-topics/child-themes/#3-enqueue-stylesheet

add_action( 'wp_enqueue_scripts', 'twenty_nineteen_child_theme_enqueue_styles' );
function twenty_nineteen_child_theme_enqueue_styles() {
 
    $parent_style = 'twenty-nineteen-parent-theme-styles'; // This is 'twentynineteen-parent-theme-styles' for the Twenty Nineteen theme.
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'twenty-nineteen-child-styles',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

// Enqueue additional CSS for the block editor and front end of the website 
function enqueue_block_assets() {
	wp_enqueue_style(
		'block-overrides',
		get_stylesheet_directory_uri() . '/blocks.css',
		null,
		time() // Change for production
	);
}
add_action( 'enqueue_block_assets', 'enqueue_block_assets' );
?>
