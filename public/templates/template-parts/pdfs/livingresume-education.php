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

			//check for exclusion flag for pdf printing, if it's not here we can keep going
			if ( ! isset( $degree_details['exclude_degree_on_pdf'] ) || $degree_details['exclude_degree_on_pdf'] !== "on" ) {

			?>

			<div class="degree-details" id="degree-details-<?php echo $degree_id; ?>">
				<table width="100%">
					<tr>
						<td width="50%" align="left" class="degree-title lr-bolder"><?php echo $degree_details['title']; ?></td>
						<td width="50%" align="right" class="graduation-date lr-bolder"><?php echo date( 'F Y', $degree_details['degree_date'] ); ?>
						<?php
						if (isset( $degree_details['current_program']) && $degree_details['current_program'] == "on" ) {
							echo ' (Expected)';
						}
						?>
						</td>
					</tr>
					<tr>
						<td width="50%" align="left" class="school lr-bolder"><?php echo $degree_details['school']; ?></td>
						<td width="50%" align="right" class="location lr-bolder"><?php echo $degree_details['location']; ?></td>
					</tr>
				</table>
				<div class="degree-description lr-description"><?php echo $degree_details['degree_description']; ?></div>
			</div>

			<?php
				$degree_id++;
			}
		}
	}
	?>
</div>
