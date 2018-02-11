<?php
/**
 * The template for displaying all single endorsements.
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
	<header class="page-header">
		<h1 class="page-title">Endorsements</h1>
	</header><!-- .page-header -->

		<div id="primary" class="content-area living-resume">
		<main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) : the_post();
				include living_resume_get_template( 'endorsements/endorsement-details-archive' );
			endwhile;
			?>
			<div class="nav-next alignleft"><?php previous_posts_link( __( 'Previous', 'living-resume' ) ); ?></div>
			<div class="nav-previous alignright"><?php next_posts_link( __( 'Next', 'living-resume' ) ); ?></div>
		<?php
		} else {
			?>
			<div class="page-content">
				<p><?php echo __( "It looks like there are no endorsements published right now. Perhaps you'd like to add one!", 'living-resume' ); ?></p>
				<?php echo do_shortcode( "[livingresume-endorsement-form]" ); ?>
			</div>
			<?php
		}
		?>
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php
/**
 * Get a custom footer-livingresume.php file, if it exists.
 * Otherwise, get default footer.
 */
get_footer( 'livingresume' );
