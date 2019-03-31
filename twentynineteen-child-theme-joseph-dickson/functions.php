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
	$style_path = '/blocks.css';
	wp_enqueue_style(
		'block-overrides',
		get_stylesheet_directory_uri() . $style_path,
		null,
		filemtime( get_stylesheet_directory() . $style_path )
	);
}
add_action( 'enqueue_block_assets', 'enqueue_block_assets' );

// Add Open Graph Support
// https://www.elegantthemes.com/blog/tips-tricks/how-to-add-open-graph-tags-to-wordpress

function doctype_opengraph($output) {
	return $output . '
	xmlns:og="http://opengraphprotocol.org/schema/"
	xmlns:fb="http://www.facebook.com/2008/fbml"';
}
add_filter('language_attributes', 'doctype_opengraph');

function facebook_opengraph() {
	global $post;
	
	// get the custom logo from the customizer and use it for Open Graph.
	$custom_logo_id = get_theme_mod( 'custom_logo' ); // grabs the id number of the custom logo

	if( is_single() || is_page() ) {
		if( has_post_thumbnail($post->ID)) {
			$img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'large');
		} else {
			// If no featured image is available for the post or page display the custom logo 
			$img_src = wp_get_attachment_image_src( $custom_logo_id , 'full' ); // converts custom logo id number into into a source url
		}

		if($excerpt = $post->post_excerpt) {
			$excerpt = strip_tags($post->post_excerpt);
			$excerpt = str_replace("", "'", $excerpt);
		} else {
			$excerpt = get_bloginfo('description');
		}
	?>

	<meta property="og:title" content="<?php echo the_title(); ?>"/>
	<meta property="og:description" content="<?php echo $excerpt; ?>"/>
	<meta property="og:type" content="article"/>
	<meta property="og:url" content="<?php echo the_permalink(); ?>"/>
	<meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
	<meta property="og:image" content="<?php echo $img_src[0]; ?>"/>

<?php
	} elseif( is_home() ) {
	// if the homepage

		// display the site description instead of an excerpt
		$excerpt = get_bloginfo('description');
		$img_src = wp_get_attachment_image_src( $custom_logo_id , 'full' ); // converts custom logo id number into source url
?>
			
		<meta property="og:title" content="<?php echo get_bloginfo( 'description' ); ?>"/>
		<meta property="og:description" content="<?php echo $excerpt; ?>"/>
		<meta property="og:type" content="article"/>
		<meta property="og:url" content="<?php echo the_permalink(); ?>"/>
		<meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
		<meta property="og:image" content="<?php echo $img_src[0]; ?>"/>


<?php
	} else {
		return;
	}
}
add_action('wp_head', 'facebook_opengraph', 5);
?>
