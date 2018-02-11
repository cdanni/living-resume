<?php
/**
 * The template for displaying all single resumes.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Living_Resume
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * Get a custom header-livingresume.php file, if it exists.
 * Otherwise, get default header.
 */
get_header( 'livingresume' );

?>
<div class="wrap">
	<div id="primary" class="content-area living-resume">
		<main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) : the_post();
				include living_resume_get_template( 'resumes/livingresume-layout' );
			endwhile;
			?>
		<?php
		}
		?>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
/**
 * Get a custom footer-livingresume.php file, if it exists.
 * Otherwise, get default footer.
 */
get_footer( 'livingresume' );
