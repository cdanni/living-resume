<?php
/**
 * The view for the endorsement details used in the loop
 */

?>
<article id="<?php echo the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php echo the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php echo Living_Resume_Template_Functions::endorsement_content(); ?>

		<p class="endorsement-person"> -- <?php echo Living_Resume_Template_Functions::endorsement_person(); ?></p>

		<?php $endorsement_company = Living_Resume_Template_Functions::endorsement_company();
			if ( isset( $endorsement_company ) && $endorsement_company !== "" ) {
				echo '<p class="endorsement-company">Find out more about this company: ' . $endorsement_company .'</p>';
			}
		?>

		<?php $endorsement_project = Living_Resume_Template_Functions::endorsement_project();
			if ( isset( $endorsement_project ) && $endorsement_project !== "" ) {
				echo '<p class="endorsement-project">Find out more about this project: ' . $endorsement_project .'</p>';
			}
		?>

	</div>
</article>
