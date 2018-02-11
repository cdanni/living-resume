<?php
/**
 * The template for displaying all projects tagged with a specific tool.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#custom-taxonomies
 *
 * @package Living_Resume
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$term = get_queried_object();
$term_name = $term->name;
$default_posts_per_page = get_option( 'posts_per_page' );

$args = array(
	'posts_per_page' => $default_posts_per_page,
	'post_type' => 'lr_project',
	'orderby' => 'title',
	'tax_query' => array(
		array(
			'taxonomy' => $term->taxonomy,
			'field'    => 'slug',
			'terms'    => $term->name,
		)
	),
	'paged' => $paged
);
$query = query_posts( $args );

/**
 * Get a custom header-livingresume.php file, if it exists.
 * Otherwise, get default header.
 */
get_header( 'livingresume' );

?>
<div class="wrap">
	<header class="page-header">
		<h1 class="page-title">Skills: <?php echo $term_name; ?></h1>
	</header><!-- .page-header -->

	<div id="primary" class="content-area living-resume">
		<main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) : the_post();
				include living_resume_get_template( 'projects/project-details-archive' );
			endwhile;
			?>
			<div class="nav-next alignleft"><?php previous_posts_link( __( 'Previous', 'living-resume' ) ); ?></div>
			<div class="nav-previous alignright"><?php next_posts_link( __( 'Next', 'living-resume' ) ); ?></div>
		<?php
		} else {
			?>
			<div class="page-content">
				<p><?php echo __( "It looks like no projects have been tagged with {$term_name} at this time.", 'living-resume' ); ?></p>
			</div>
			<?php
		}
		wp_reset_postdata();
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
