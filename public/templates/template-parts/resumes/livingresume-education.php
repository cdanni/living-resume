<?php
/**
 * The view for the resume education history used in the loop
 */

?>
<div id="living-resume-education" class="lr-justify lr-section">
	<h2 class="entry-title"><?php echo Living_Resume_Template_Functions::resume_education_title(); ?></h2>

	<?php 
	$education_history = Living_Resume_Template_Functions::resume_education_history();

	if ( ! empty( $education_history ) ) {
		$degree_id = 1;
		foreach ( $education_history as $degree_details ) {
		?>

		<div class="degree-details" id="degree-details-<?php echo $degree_id; ?>">
			<div class="degree-title lr-left lr-bolder"><?php echo $degree_details['title']; ?></div>
			<div class="graduation-date lr-right lr-bolder"><?php echo date( 'F Y', $degree_details['degree_date'] ); ?>
			<?php
			if (isset( $degree_details['current_program']) && $degree_details['current_program'] == "on" ) {
				echo ' (Expected)';
			}
			?>
			</div>
			<div class="school lr-left lr-bolder"><?php echo $degree_details['school']; ?></div>
			<div class="location lr-right lr-bolder"><?php echo $degree_details['location']; ?></div>
			<div class="degree-description lr-description"><?php echo $degree_details['degree_description']; ?></div>
			<div class="projects">
				<?php
				if (isset( $degree_details['projects'] ) ){
					$degree_project_details = $degree_details['projects'];
					if ( !empty( $degree_project_details )) { 
						echo 'Notable Projects:';
						echo '<ul class="project-links">';
						foreach( $degree_project_details as $degree_project ) {
							echo '<li class="project-link"><a href="' . $degree_project[1] . '">'. $degree_project[0] .'</a></li>';
						}
						echo '</ul>';
					}

				}
				?>
			</div>
		</div>
		<?php
			$degree_id++;
		}
	}
	?>
</div>
