<?php
/**
 * The view for the resume employment history used in the loop
 */

?>

<div id="living-resume-employment" class="lr-justify lr-section">
	<h2 class="entry-title"><?php echo Living_Resume_Template_Functions::resume_employment_title(); ?></h2>

	<?php
	$employment_history = Living_Resume_Template_Functions::resume_employment_history();

	if ( ! empty( $employment_history ) ) {
		$job_id = 1;
		foreach ( $employment_history as $job_details ) {
		?>

		<div class="job-details" id="job-details-<?php echo $job_id; ?>">
			<div class="job-title lr-left lr-bolder"><?php echo $job_details['title']; ?></div>
			<div class="employment-dates lr-right lr-bolder"><?php echo date( 'F Y', $job_details['start_date'] ); ?>
			<?php
			if (isset( $job_details['current_employer']) && $job_details['current_employer'] == "Yes" ) {
				echo ' - Present';
			} elseif (isset( $job_details['end_date'] ) && $job_details['end_date'] != false){
				echo ' - ' . date( 'F Y', $job_details['end_date'] );
			}
			?>
			</div>
			<div class="company lr-left lr-bolder"><?php echo $job_details['company']; ?></div>
			<div class="location lr-right lr-bolder"><?php echo $job_details['location']; ?></div>
			<div class="job-description lr-description"><?php echo $job_details['job_description']; ?></div>
			<?php
				if (isset( $job_details['projects'] ) && ! empty( $job_details['projects'] ) ){
					echo '<div class="projects">';
					echo 'Notable Projects:';
					echo '<ul class="project-links">';
					foreach( $job_details['projects'] as $job_project ) {
						echo '<li class="project-link"><a href="' . $job_project[0] . '">'. $job_project[1] .'</a></li>';
					}
					echo '</ul>';
					echo '</div>';
				}
			?>
			
			<?php
			if (isset( $job_details['endorsements'] ) && ! empty ( $job_details['endorsements'] ) ){
				echo '<div class="endorsements">';
				echo 'Job Endorsements:';
				echo '<ul class="endorsement-links">';
					foreach( $job_details['endorsements'] as $endorsement ) {
						echo '<li class="endorsement-link"><a href="' . $endorsement[0] . '">'. $endorsement[1] .'</a></li>';
					}
				echo '</ul>';
				echo '</div>';
			}
			?>
		</div>
		<?php
			$job_id++;
		}
	}
	?>
</div>
