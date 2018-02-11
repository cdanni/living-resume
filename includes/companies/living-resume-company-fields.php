<?php

/**
 * Hook in and create metabox and custom fields for the Company custom post type. 
 * Utlizes the CMB2 library and can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function living_resume_company_register_metabox() {

	$prefix = '_living_resume_company_';

	$cmb = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Company', 'living-resume' ),
		'object_types' => array( 'lr_company', ), // Post type
	) );
	$cmb->add_field( array(
		'name' => __( 'Company Website', 'living-resume' ),
		'id'   => $prefix . 'url',
		'type' => 'text',
		'desc' => __( 'URL for company website, will open in a new page on Resumes. <br>Include full address, including http:// or https://.', 'living-resume' ),
	) );
}
add_action( 'cmb2_admin_init', 'living_resume_company_register_metabox' );
