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

			//check for exclusion flag for pdf printing, if it's not here we can keep going
			if ( ! isset( $job_details['exclude_job_on_pdf'] ) || $job_details['exclude_job_on_pdf'] !== "on" ) {

			?>

			<div class="job-details" id="job-details-<?php echo $job_id; ?>">
				<table width="100%">
					<tr>
						<td width="50%" align="left" class="job-title lr-bolder"><?php echo $job_details['title']; ?></td>
						<td width="50%" align="right" class="employment-dates lr-bolder"><?php echo date( 'F Y', $job_details['start_date'] ); ?>
						<?php
						if (isset( $job_details['current_employer']) && $job_details['current_employer'] == "Yes" ) {
							echo ' - Present';
						} elseif (isset( $job_details['end_date'] ) && $job_details['end_date'] != false){
							echo ' - ' . date( 'F Y', $job_details['end_date'] );
						}
						?>
						</td>
					</tr>
					<tr>
						<td width="50%" align="left" class="company lr-bolder"><?php echo $job_details['company']; ?></td>
						<td width="50%" align="right" class="location lr-bolder"><?php echo $job_details['location']; ?></td>
					</tr>
				</table>
				<div class="job-description lr-description"><?php echo $job_details['job_description']; ?></div>
			</div>

			<?php
				$job_id++;
			}
		}
	}
	?>
</div>
