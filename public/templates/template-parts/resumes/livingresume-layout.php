<?php
/**
 * The view for the resume layout order used in the loop
 */

/**
 * Layout Order
 * arrays: $living_resume_sort_order
 * The array only pulls the "enabled" blocks
 */
?>

<article id="<?php echo the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
	<?php
	/* Include resume header */
	include living_resume_get_template( 'resumes/livingresume-header-layout' );

	/* Grab resume sort order */
	$living_resume_sort_order = Living_Resume_Template_Functions::resume_sort_order();

	/**
	 * Going to run through the layout order and see which blocks should be displayed
	 * and display them in the order they show up in the array
	 */
	foreach ( $living_resume_sort_order as $key => $value ) {
		if ( $key == '_living_resume_sort_introduction' ) {
			include living_resume_get_template( 'resumes/livingresume-introduction' );
		}
		elseif ( $key == '_living_resume_sort_employment_history' ) {
			include living_resume_get_template( 'resumes/livingresume-employment' );
		}
		elseif ( $key == '_living_resume_sort_education_history' ) {
			include living_resume_get_template( 'resumes/livingresume-education' );
		}
		elseif ( $key == '_living_resume_sort_skills_block' ) {
			include living_resume_get_template( 'resumes/livingresume-skills' );
		}
		elseif ( $key == '_living_resume_sort_tools_block' ) {
			include living_resume_get_template( 'resumes/livingresume-tools' );
		}
		elseif ( $key == '_living_resume_sort_additional_one' ) {
			include living_resume_get_template( 'resumes/livingresume-additional-one' );
		}
		elseif ( $key == '_living_resume_sort_additional_two' ) {
			include living_resume_get_template( 'resumes/livingresume-additional-two' );
		}
	}

	/* Include resume footer */
	include living_resume_get_template( 'resumes/livingresume-footer-layout' );
	?>
	</div>
</article>