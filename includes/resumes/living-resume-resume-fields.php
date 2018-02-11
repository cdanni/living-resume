<?php

/**
 * Hook in and create metabox and custom fields for the Resume custom post type. 
 * Utlizes the CMB2 library and can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function living_resume_resume_register_metabox() {

	$prefix = '_living_resume_';

	$cmb = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Resume', 'living-resume' ),
		'object_types' => array( 'lr_resume', ),
		'classes'      => 'resume-post-type',
	) );


	/** 
	 * Introduction Group 
	 */

	$group_introduction = $cmb->add_field( array(
		'id'         => $prefix . 'introduction',
		'type'       => 'group',
		'desc'       => __( 'Introduction Block', 'living-resume' ),
		'repeatable' => false,
		'options'    => array(
			'closed'      => true,
			'group_title' => __( 'Introduction', 'living-resume' ),
		),
	) );
	$cmb->add_group_field( $group_introduction, array(
		'name' => __( 'Introduction Title', 'living-resume' ),
		'id'   => 'title',
		'type' => 'text',
		'desc' => __( 'Add a brief title to introduce yourself.', 'living-resume' ),
	) );
	$cmb->add_group_field( $group_introduction, array(
		'name'    => __( 'Introduction Text', 'living-resume' ),
		'id'      => 'text',
		'type'    => 'wysiwyg',
		'desc'    => __( 'Add a short introductory paragraph.', 'living-resume' ),
		'options' => array( 
			'textarea_rows' => get_option( 'default_post_edit_rows', 5 ), 
		),
	) );

	/**
	 * Employment Title  Display Name
	 */
	
	$group_employment_display_name = $cmb->add_field( array(
		'id'         => $prefix . 'employment_title',
		'type'       => 'group',
		'desc'       => __( 'Employment Section Title to Show with Employment History Block', 'living-resume' ),
		'repeatable' => false,
		'options'    => array(
			'closed'      => true,
			'group_title' => __( 'Employment Section Title', 'living-resume' ),
		),
	) );
	$cmb->add_group_field( $group_employment_display_name, array(
		'name'    => __( 'Section Title', 'living-resume' ),
		'id'      => 'section_title',
		'type'    => 'text',
		'desc'    => __( 'Add a title to display for the Employment section.', 'living-resume' ),
		'default' => __( 'Employment History', 'living-resume' ),
	) );

	/** 
	 * Repeatable Employment Group 
	 */

	$group_employment = $cmb->add_field( array(
		'id'      => $prefix . 'employment_history',
		'type'    => 'group',
		'desc'    => __( 'Employment History Block', 'living-resume' ),
		'options' => array(
			'group_title'   => __( 'Job {#}', 'living-resume' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Job', 'living-resume' ),
			'remove_button' => __( 'Remove Job', 'living-resume' ),
			'sortable'      => true,
			'closed'        => true, // true to have the groups closed by default
		),
	) );
	$cmb->add_group_field( $group_employment, array(
		'name'        => __( 'Job Title', 'living-resume' ),
		'id'          => 'title',
		'type'        => 'text',
		'attributes'  => array(
			//'required' => true,
		),
	) );
	$cmb->add_group_field( $group_employment, array(
		'name'        => __( 'Company', 'living-resume' ),
		'id'          => 'company',
		//'type'        => 'text',
		'type'        => 'select',
		'options_cb'        => 'living_resume_resume_get_company_options',
	) );
	$cmb->add_group_field( $group_employment, array(
		'name' => __( 'Company Location', 'living-resume' ),
		'id'   => 'location',
		'type' => 'text',
		'desc' => __( 'For display purposes, only enter the city and state.', 'living-resume' ),
	) );
	$cmb->add_group_field( $group_employment, array(
		'name'        => __( 'Start Date', 'living-resume' ),
		'id'          => 'start_date',
		'type'        => 'text_date_timestamp',
		'desc'        => __( 'Only the month and year will be shown.', 'living-resume' ),
		'attributes'  => array(
			//'required' => true,
		),
	) );
	$cmb->add_group_field( $group_employment, array(
		'name'        => __( 'Current Employer', 'living-resume' ),
		'id'          => 'current_employer',
		'type'        => 'radio_inline',
		'desc'        => __( 'Selecting "No" will open a required end date box.', 'living-resume' ),
		'options'     => array(
			'Yes' => 'Yes',
			'No'  => 'No',
		),
		'attributes' => array(
			//'required' => true,
		),
	) );
	$cmb->add_group_field( $group_employment, array(
		'name'        => __( 'End Date', 'living-resume' ),
		'id'          => 'end_date',
		'type'        => 'text_date_timestamp',
		'desc'        => __( 'Only the month and year will be shown.', 'living-resume' ),
		'attributes'  => array(
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $group_employment, 'current_employer' ) ),
			'data-conditional-value' => 'No',
		),
	) );
	$cmb->add_group_field( $group_employment, array(
		'name'    => __( 'Description', 'living-resume' ),
		'id'      => 'job_description' ,
		'type'    => 'wysiwyg',
		'options' => array( 
			'textarea_rows' => get_option( 'default_post_edit_rows', 5 ), 
		),
	) );
	$cmb->add_group_field( $group_employment, array(
		'name'              => __( 'Projects', 'living-resume' ),
		'id'                => 'projects',
		'type'              => 'multicheck_inline',
		'desc'              => __( 'Choose applicable Projects from the Projects options. These will be highlighted and linked to on the front end.', 'living-resume' ),
		'select_all_button' => false,
		'options_cb'        => 'living_resume_resume_get_project_options',
	) );
	$cmb->add_group_field( $group_employment, array(
		'name' => __( 'Exclude from PDF', 'living-resume' ),
		'id'   => 'exclude_job_on_pdf',
		'type' => 'checkbox',
		'desc' => __( 'Exclude this job on PDF version of the resume.', 'living-resume' ),
	) );

	/**
	 * Education Title  Display Name
	 */

	$group_education_display_name = $cmb->add_field( array(
		'id'          => $prefix . 'education_title',
		'type'        => 'group',
		'desc'        => __( 'Education Section Title to Show with Education History Block', 'living-resume' ),
		'repeatable'  => false,
		'options'     => array(
			'closed'      => true,
			'group_title' => __( 'Education Section Title', 'living-resume' ),
		),
	) );
	$cmb->add_group_field( $group_education_display_name, array(
		'name'    => __( 'Section Title', 'living-resume' ),
		'id'      => 'section_title',
		'type'    => 'text',
		'desc'    => __( 'Add a title to display for the Education section.', 'living-resume' ),
		'default' => __( 'Education History', 'living-resume' ),
	) );


	/** 
	 * Repeatable Education Group 
	 */

	$group_education = $cmb->add_field( array(
		'id'      => $prefix . 'education_history',
		'type'    => 'group',
		'desc'    => __( 'Education History Block', 'living-resume' ),
		'options' => array(
			'group_title'   => __( 'Degree {#}', 'living-resume' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Degree', 'living-resume' ),
			'remove_button' => __( 'Remove Degree', 'living-resume' ),
			'sortable'      => true,
			'closed'        => true, // true to have the groups closed by default
		),
	) );
	$cmb->add_group_field( $group_education, array(
		'name'        => __( 'Degree Title', 'living-resume' ),
		'id'          => 'title',
		'type'        => 'text',
		'attributes'  => array(
			//'required' => true,
		),
	) );
	$cmb->add_group_field( $group_education, array(
		'name'       => __( 'School', 'living-resume' ),
		'id'         => 'school',
		'type'       => 'text',
		'desc'       => __( 'Institution the degree is from', 'living-resume' ),
	) );
	$cmb->add_group_field( $group_education, array(
		'name' => __( 'Institution Location', 'living-resume' ),
		'id'   => 'location',
		'type' => 'text',
		'desc' => __( 'For display purposes, only enter the city and state.', 'living-resume' ),
	) );
	$cmb->add_group_field( $group_education, array(
		'name'        => __( 'Graduation Date', 'living-resume' ),
		'id'          => 'degree_date',
		'type'        => 'text_date_timestamp',
		'desc'        => __( 'Only the month and year will be shown. If not already awarded, please use the expected date.', 'living-resume' ),
		'attributes'  => array(
			//'required' => true,
		),
	) );
	$cmb->add_group_field( $group_education, array(
		'name' => __( 'Current Program', 'living-resume' ),
		'id'   => 'current_program',
		'type' => 'checkbox',
		'desc' => __( 'Selecting this will add "Expected" in front of the above date.', 'living-resume' ),
	) );
	$cmb->add_group_field( $group_education, array(
		'name'    => __( 'Description', 'living-resume' ),
		'id'      => 'description' ,
		'type'    => 'wysiwyg',
		'options' => array( 
			'textarea_rows' => get_option( 'default_post_edit_rows', 5 ), 
		),
	) );
	$cmb->add_group_field( $group_education, array(
		'name'              => __( 'Projects', 'living-resume' ),
		'id'                => 'projects',
		'type'              => 'multicheck_inline',
		'desc'              => __( 'Choose applicable Projects from the Projects options. These will be highlighted and linked to on the front end.', 'living-resume' ),
		'select_all_button' => false,
		'options_cb'        => 'living_resume_get_project_options',
	) );
	$cmb->add_group_field( $group_education, array(
		'name' => __( 'Exclude from PDF', 'living-resume' ),
		'id'   => 'exclude_degree_on_pdf',
		'type' => 'checkbox',
		'desc' => __( 'Exclude this degree on PDF version of the resume.', 'living-resume' ),
	) );


	/**
	 * Skills Group
	 */

	$group_skills = $cmb->add_field( array(
		'id'         => $prefix . 'skills_block',
		'type'       => 'group',
		'desc'       => __( 'Skills Block', 'living-resume' ),
		'repeatable' => false,
		'options'    => array(
			'closed'      => true,
			'group_title' => __( 'Skills', 'living-resume' ),
		),
	) );
	$cmb->add_group_field( $group_skills, array(
		'name' => __( 'Skills Title', 'living-resume' ),
		'id'   => 'title',
		'type' => 'text',
		'desc'    => __( 'Add a title to display for the Skills section.', 'living-resume' ),
		'default' => __( 'Skills', 'living-resume' ),
	) );
	$cmb->add_group_field( $group_skills, array(
		'name'    => __( 'Add Skills', 'living-resume' ),
		'id'      => 'add_type',
		'type'    => 'radio_inline',
		'desc'    => __( 'Selecting "By Taxonomy" will open a method to select from the Skills added to Projects. Selecting "Free Form" will open a text editor.', 'living-resume' ),
		'options' => array(
			'tax'   => 'By Taxonomy',
			'form'  => 'Free Form',
		),
	) );
	$cmb->add_group_field( $group_skills, array(
		'name'       => __( 'Skills', 'living-resume' ),
		'id'         => 'skills_tax',
		'type'       => 'multicheck_inline',
		'options_cb' => 'living_resume_resume_get_skill_options',
		'attributes' => array(
			//'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $group_skills, 'add_type' ) ),
			'data-conditional-value' => 'tax',
		),
	) );
	$cmb->add_group_field( $group_skills, array(
		'name'       => __( 'Description', 'living-resume' ),
		'id'         => 'skills_form' ,
		'type'       => 'wysiwyg',
		'options'    => array( 
			'textarea_rows' => get_option( 'default_post_edit_rows', 5 ), 
		),
		'attributes' => array(
			//'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $group_skills, 'add_type' ) ),
			'data-conditional-value' => 'form',
		),
		'after_field' => "<input name='skills_form_hidden' type='hidden' data-conditional-id='" . wp_json_encode( array( $group_skills, 'add_type' ) ) . "' data-conditional-value='form'>", // this exists for the primary purpose of being able to hide the wysiwyg unless chosen above
	) );


	/**
	 * Tools Group
	 */

	$group_tools = $cmb->add_field( array(
		'id'         => $prefix . 'tools_block',
		'type'       => 'group',
		'desc'       => __( 'Tools Block', 'living-resume' ),
		'repeatable' => false,
		'options'    => array(
			'closed'      => true,
			'group_title' => __( 'Tools', 'living-resume' ),
		),
	) );
	$cmb->add_group_field( $group_tools, array(
		'name' => __( 'Tools Title', 'living-resume' ),
		'id'   => 'title',
		'type' => 'text',
		'desc'    => __( 'Add a title to display for the Tools section.', 'living-resume' ),
		'default' => __( 'Tools', 'living-resume' ),
	) );
	$cmb->add_group_field( $group_tools, array(
		'name'    => __( 'Add Tools', 'living-resume' ),
		'id'      => 'add_type',
		'type'    => 'radio_inline',
		'desc'    => __( 'Selecting "By Taxonomy" will open a method to select from the Tools added to Projects. Selecting "Free Form" will open a text editor.', 'living-resume' ),
		'options' => array(
			'tax'   => 'By Taxonomy',
			'form'  => 'Free Form',
		),
	) );
	$cmb->add_group_field( $group_tools, array(
		'name'       => __( 'Tools', 'living-resume' ),
		'id'         => 'tools_tax',
		'type'       => 'multicheck_inline',
		'options_cb' => 'living_resume_resume_get_tool_options',
		'attributes' => array(
			//'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $group_tools, 'add_type' ) ),
			'data-conditional-value' => 'tax',
		),
	) );
	$cmb->add_group_field( $group_tools, array(
		'name'       => __( 'Description', 'living-resume' ),
		'id'         => 'tools_form' ,
		'type'       => 'wysiwyg',
		'options'    => array( 
			'textarea_rows' => get_option( 'default_post_edit_rows', 5 ), 
		),
		'attributes' => array(
			//'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => wp_json_encode( array( $group_tools, 'add_type' ) ),
			'data-conditional-value' => 'form',
		),
		'after_field' => "<input name='tools_form_hidden' type='hidden' data-conditional-id='" . wp_json_encode( array( $group_tools, 'add_type' ) ) . "' data-conditional-value='form'>", // this exists for the primary purpose of being able to hide the wysiwyg unless chosen above
	) );


	/** 
	 * Additional Information Group 1
	 */

	$group_additional_one = $cmb->add_field( array(
		'id'         => $prefix . 'additional_one',
		'type'       => 'group',
		'desc'       => __( 'First Additional Information Block', 'living-resume' ),
		'repeatable' => false,
		'options'    => array(
			'closed'      => true,
			'group_title' => __( 'Additional Information', 'living-resume' ),
		),
	) );
	$cmb->add_group_field( $group_additional_one, array(
		'name' => __( 'Additional Title', 'living-resume' ),
		'id'   => 'title',
		'type' => 'text',
		'desc' => __( 'Add a brief title to this section.', 'living-resume' ),
	) );
	$cmb->add_group_field( $group_additional_one, array(
		'name'    => __( 'Additional Text', 'living-resume' ),
		'id'      => 'text',
		'type'    => 'wysiwyg',
		'desc'    => __( 'You can use this area to list anything from career highlights to references.', 'living-resume' ),
		'options' => array( 
			'textarea_rows' => get_option( 'default_post_edit_rows', 5 ), 
		),
	) );


	/** 
	 * Additional Information Group 2
	 */

	$group_additional_two = $cmb->add_field( array(
		'id'         => $prefix . 'additional_two',
		'type'       => 'group',
		'desc'       => __( 'Second Additional Information Block', 'living-resume' ),
		'repeatable' => false,
		'options'    => array(
			'closed'      => true,
			'group_title' => __( 'Additional Information', 'living-resume' ),
		),
	) );
	$cmb->add_group_field( $group_additional_two, array(
		'name' => __( 'Additional Title', 'living-resume' ),
		'id'   => 'title',
		'type' => 'text',
		'desc' => __( 'Add a brief title to this section.', 'living-resume' ),
	) );
	$cmb->add_group_field( $group_additional_two, array(
		'name'    => __( 'Additional Text', 'living-resume' ),
		'id'      => 'text',
		'type'    => 'wysiwyg',
		'desc'    => __( 'You can use this area to list anything from career highlights to references.', 'living-resume' ),
		'options' => array( 
			'textarea_rows' => get_option( 'default_post_edit_rows', 5 ), 
		),
	) );

}
add_action( 'cmb2_admin_init', 'living_resume_resume_register_metabox' );

function living_resume_resume_register_page_sort() {

	$prefix = '_living_resume_sort_';

	$cmb_sort = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Resume Sorting Options', 'living-resume' ),
		'object_types' => array( 'lr_resume', ),
		'classes'      => 'resume-post-type',
	) );


	/** 
	 * Page Sorting Group
	 */

	$cmb_sort->add_field( array(
		'name'    => __( 'Resume Layout', 'living-resume' ),
		'id'      => $prefix . 'layout',
		'desc'    => __( 'Drag and drop to change the layout of your resume. Items in the Disabled box will not be displayed on screen or on the PDF.', 'living-resume' ),
		'type'    => 'tb_sorter',
		'options' => array(
			'Enabled'  => array(
				$prefix . 'introduction' => __( 'Introduction', 'living-resume' ),
				$prefix . 'employment_history' => __( 'Employment History', 'living-resume' ),
				$prefix . 'education_history' => __( 'Education History', 'living-resume' ),
				$prefix . 'skills_block' => __( 'Skills', 'living-resume' ),
				$prefix . 'tools_block' => __( 'Tools', 'living-resume' ),
			),
			'Disabled' => array(
				$prefix . 'additional_one'   => __( 'First Additional Block', 'living-resume' ),
				$prefix . 'additional_two'   => __( 'Second Additional Block', 'living-resume' ),
			),

		),
	));

}
add_action( 'cmb2_admin_init', 'living_resume_resume_register_page_sort' );

function living_resume_resume_display_shortcode() {

	$prefix = '_living_resume_shortcode_';

	$cmb_shortcode = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Resume Shortcode', 'living-resume' ),
		'object_types' => array( 'lr_resume', ),
		'classes'      => 'resume-post-type',
		'context'      => 'side',
	) );


	/** 
	 * Shortcode Field
	 */
	$cmb_shortcode->add_field( array(
		//'name'    => __( 'Resume Shortcode', 'living-resume' ),
		'id'      => $prefix . 'shortcode_readonly',
		'desc'    => __( 'Use this shortcode to display your resume on a regular page or post.', 'living-resume' ),
		'type'    => 'text',
		'save_field'  => false,
		'default_cb'  => 'living_resume_get_current_post_id',
		'attributes'  => array(
			'readonly' => 'readonly',
			//disabled' => 'disabled',
		),
	));
}
add_action( 'cmb2_admin_init', 'living_resume_resume_display_shortcode' );

function living_resume_resume_header_options() {

	$prefix = '_living_resume_header_';

	$cmb_header_options = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Resume Header', 'living-resume' ),
		'object_types' => array( 'lr_resume', ),
		'classes'      => 'resume-post-type',
		'context'      => 'side',
	) );


	/** 
	 * Header Group
	 */
	$cmb_header_options->add_field( array(
		'name'             => __( 'Header Layout', 'cmb2' ),
		'desc'             => __( 'Select the appropriate header layout', 'living-resume' ),
		'id'               => $prefix . 'layout',
		'type'             => 'radio_image',
		'options'          => array(
			'left'   => __('Left Align', 'living-resume'),
			'center' => __('Centered', 'living-resume'),
			'right'  => __('Right Align', 'living-resume'),
			'none'   => __('No Header', 'living-resume'),
		),
		'images_path'      => LIVING_RESUME_URL . '/admin/images',
		'images'           => array(
			'left'   => 'left-align.png',
			'center' => 'center-align.png',
			'right'  => 'right-align.png',
			'none'   => 'no-header.png',
		)
	) );

}
add_action( 'cmb2_admin_init', 'living_resume_resume_header_options' );

function living_resume_resume_footer_options() {

	$prefix = '_living_resume_footer_';

	$cmb_footer_options = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Resume Footer', 'living-resume' ),
		'object_types' => array( 'lr_resume', ),
		'classes'      => 'resume-post-type',
		'context'      => 'side',
	) );


	/** 
	 * Header Group
	 */
	$cmb_footer_options->add_field( array(
		'name'             => __( 'Footer Layout', 'cmb2' ),
		'desc'             => __( 'Select the appropriate footer layout', 'living-resume' ),
		'id'               => $prefix . 'layout',
		'type'             => 'radio_image',
		'options'          => array(
			'left'   => __('Left Align', 'living-resume'),
			'center' => __('Centered', 'living-resume'),
			'right'  => __('Right Align', 'living-resume'),
			'none'   => __('No Header', 'living-resume'),
		),
		'images_path'      => LIVING_RESUME_URL . '/admin/images',
		'images'           => array(
			'left'   => 'left-align.png',
			'center' => 'center-align.png',
			'right'  => 'right-align.png',
			'none'   => 'no-header.png',
		)
	) );

}
add_action( 'cmb2_admin_init', 'living_resume_resume_footer_options' );

/**
 * We need to pull the current post id to populate the shortcode box
 */
function living_resume_get_current_post_id( $field_args, $field ) {

	return '[livingresume-resume resume_id="'. $field->object_id .'"]';
}

/**
 * We need to pull the Companies as "options" for each endorsement
 * The company titles and IDs will be pulled into a single drop down menu
 */
function living_resume_resume_get_company_options( $field ) {

	$companies1 = array( '0' => 'Select Company');

	$companies2 = Living_Resume_Shared::living_resume_get_company_options( $field ) ;

	$companies = $companies1 + $companies2;

	return $companies;
}

/**
 * We need to pull the Projects as "options" for each job listed
 * The project titles and IDs will be pulled into an inline multi-select
 */
function living_resume_resume_get_project_options( $field ) {

	$projects = Living_Resume_Shared::living_resume_get_project_options( $field ) ;

	return $projects;

}

/**
 * We need to pull the Skills as "options" to populate the Skills block when using 'By Taxonomy'
 */
function living_resume_resume_get_skill_options( $field ) {

	$skills = Living_Resume_Shared::living_resume_get_skill_options( $field ) ;

	return $skills;
}

/**
 * We need to pull the Tools as "options" to populate the Tools block when using 'By Taxonomy'
 */
function living_resume_resume_get_tool_options( $field ) {

	$tools = Living_Resume_Shared::living_resume_get_tool_options( $field ) ;

	return $tools;
}