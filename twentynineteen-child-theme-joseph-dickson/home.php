<?php
/**
 * The home template file
 *
 * This is based on Twenty Nineteen's index.php file and overrides index.php
 * to add a WP_Query to check for a page slugged 'who-am-i' if it exists that
 * post will load after the header and before the site content such as posts
 * or a static page. -- Joseph Dickson
 *
 * About index.php
 *
 * index.php is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php
/* WP_Query Documentation
 * https://codex.wordpress.org/Class_Reference/WP_Query
 */

// The Query
$the_query = new WP_Query( 
	array(
		'post_type'	=> 'page',
		'name'		=> 'who-am-i'
	)
);

// The Loop
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
			get_template_part( 'template-parts/content/content-no-thumbnail' );
	}
	/* Restore original Post Data */
	wp_reset_postdata();
} else {
	// no posts found
}

		 ?>

		<?php
		if ( have_posts() ) {

			// Load posts loop.
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content/content' );
			}

			// Previous/next page navigation.
			twentynineteen_the_posts_navigation();

		} else {

			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/content/content', 'none' );

		}
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php
get_footer();
