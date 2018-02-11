<?php
/**
 * The template for exporting single resumes to pdf files.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Living_Resume
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

?>
<!DOCTYPE html>

<html>
<head>
	<title><?php wp_title('', true, ''); ?></title>
	<meta name="author" content="<?php echo Living_Resume_Template_Functions::resume_full_name();?>" />
	<?php wp_head(); ?>

	<style>
		html { 
			font-family: <?php echo Living_Resume_Template_Functions::pdf_font_family(); ?> !important; 
			font-size: 62.5% !important;
		}
		/*#living-resume-pdf { font-size: 1.0rem !important; color: #333;}
		#living-resume-pdf h1 { font-size: 1.4rem !important; color: #000; }
		#living-resume-pdf h2 { font-size: 1.3rem !important; color: #222; }
		#primary.living-resume .lr-left { clear: both; width: 50%; display: inline; text-align: left; }
		#primary.living-resume .lr-right { width: 50%; display: inline; text-align: right; }
		#primary.living-resume .lr-clear { clear: both !important; display: block; }
		*/
		
		#primary.living-resume .lr-section { border-top: solid .5px #efefef; }
		#primary.living-resume .lr-description { clear: both !important; margin-top: 0.5rem; display: block !important; }
		#primary.living-resume table,
		#primary.living-resume table tr,
		#primary.living-resume table td { padding: 0; margin: 0; }
		#primary.living-resume living-resume-footer ul.network-links { list-style: none; }
	</style>

</head>

<body id="living-resume-pdf">
	<div class="wrap">
		<div id="primary" class="content-area living-resume">
			<main id="main" class="site-main" role="main">
			<?php
			if ( have_posts() ) {
				while ( have_posts() ) : the_post();
					include living_resume_get_template( 'pdfs/livingresume-layout' );
				endwhile;
				?>
			<?php
			}
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .wrap -->
	<?php wp_footer(); ?>
</body>
</html>
