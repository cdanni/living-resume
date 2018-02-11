<?php
/**
 * The view for the resume tools used in the loop
 */

?>
<div id="living-resume-tools" class="lr-justify lr-section">
	<h2 class="entry-title"><?php echo Living_Resume_Template_Functions::resume_tools_title(); ?></h2>
	<?php 
	$tool_list = Living_Resume_Template_Functions::resume_tools_list(); 
		if ( is_array( $tool_list ) ) {
			$i = 0;
			$len = count( $tool_list );
			$tool_links = '<div class="tools lr-center"><p>';
			foreach ( $tool_list as $tool ) {
				if ( $i !== $len - 1 ) {
					$tool_links .= '<span>' . $tool . ', </span>';
				}
				else {
				$tool_links .= '<span>' . $tool . '</span>';
				}
				$i++;
			}
			$tool_links .= '</p></div>';
		} else {
			$tool_links = '<div class="tools lr-center">' . $tool_list . '</div>';
		}
		echo $tool_links;
	?>
</div>
