<?php
/**
 * The view for the resume skills used in the loop
 */

?>
<div id="living-resume-skills" class="lr-justify lr-section">
	<h2 class="entry-title"><?php echo Living_Resume_Template_Functions::resume_skills_title(); ?></h2>
	<?php 
	$skill_list = Living_Resume_Template_Functions::resume_skills_list(); 
		if ( is_array( $skill_list ) ) {
			$i = 0;
			$len = count( $skill_list );
			$skill_links = '<div class="skills lr-center"><p>';
			foreach ( $skill_list as $skill ) {
				if ( $i !== $len - 1 ) {
					$skill_links .= '<span>' . $skill . ', </span>';
				}
				else {
				$skill_links .= '<span>' . $skill . '</span>';
				}
				$i++;
			}
			$skill_links .= '</p></div>';
		} else {
			$skill_links = '<div class="skills lr-center">' . $skill_list . '</div>';
		}
		echo $skill_links;
	?>
</div>
