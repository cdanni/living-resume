<?php
/**
 * The view for the project details used in the loop
 */

?>
<article id="<?php echo the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php echo the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<div class="project-description">
			<?php echo Living_Resume_Template_Functions::project_description(); ?>

			<div class="project-images">
				<?php $project_images = Living_Resume_Template_Functions::project_images(); 
					if ( is_array( $project_images ) && ! empty ( $project_images )  ) {
						foreach ( $project_images as $image ) {
							echo '<div class="project-image">' . $image . '</div>';
						}
					}
				?>

			</div>

			<div class="project-url">
				<?php echo Living_Resume_Template_Functions::project_url(); ?>
			</div>

			<div class="project-endorsements">
			<?php $endorsements = Living_Resume_Template_Functions::project_endorsements(); 
				if ( is_array( $endorsements ) && ! empty ( $endorsements ) ) {
					echo 'Project Endorsements:';
					echo '<ul class="endorsement-links">';
						foreach(  $endorsements as $endorsement ) {
							echo '<li class="endorsement-link"><a href="' . $endorsement[0] . '">'. $endorsement[1] .'</a></li>';
						}
					echo '</ul>';
				}
			?>
			</div>
		</div>

	</div>

</article>
