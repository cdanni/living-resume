<?php

/**
 * Hook in and create metabox and custom fields for the Project custom post type. 
 * Utlizes the CMB2 library and can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function living_resume_project_register_metabox() {

	$prefix = '_living_resume_project_';

	$cmb = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Project', 'living-resume' ),
		'object_types' => array( 'lr_project', ), // Post type
	) );
	$group_project = $cmb->add_field( array(
		'id'         => $prefix . 'details',
		'type'       => 'group',
		'desc'       => __( 'Projects will generate their own posts, and be usable within Resumes as links. Adding Skills and Tools to this Project via the associated taxonomy will provide searchable options that link back to this Project. ', 'living-resume' ),
		'repeatable' => false,
		'options'    => array(
			'group_title'   => __( 'Information', 'living-resume' ),
		),
	) );
	$cmb->add_group_field( $group_project, array(
		'name' => __( 'Project Website', 'living-resume' ),
		'id'   => 'url',
		'type' => 'text',
		'desc' => __( 'URL for project website if applicable. Include full address, including http:// or https://.', 'living-resume' ),
	) );
	$cmb->add_group_field( $group_project, array(
		'name'    => __( 'Project Description', 'living-resume' ),
		'id'      => 'description',
		'type'    => 'wysiwyg',
		'desc'    => __( 'Provide a detailed description of the project.', 'living-resume' ),
		'options' => array( 
			'textarea_rows' => get_option( 'default_post_edit_rows', 5 ), 
		),
	) );
	$cmb->add_group_field( $group_project, array(
		'name' => __( 'Project Images', 'living-resume' ),
		'desc' => 'Upload images or choose images from the Media Library related to the project.',
		'id'   => 'images',
		'type' => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		'query_args' => array( 'type' => 'image' ), // Only images attachment
		// Optional, override default text strings
		'text' => array(
			'add_upload_files_text' => 'Add or Upload Images', // default: "Add or Upload Files"
		),
	) );
}
add_action( 'cmb2_admin_init', 'living_resume_project_register_metabox' );
