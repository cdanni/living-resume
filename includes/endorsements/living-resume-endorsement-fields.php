<?php

/**
 * Hook in and create metabox and custom fields for the Endorsement custom post type. 
 * Utlizes the CMB2 library and can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function living_resume_endorsement_register_metabox() {
	
	if ( ! is_admin() ) {
		$submitted_post_title_text = __( 'A short title for displaying on the <a href="/resumes/endorsements/">Endorsements page</a>.', 'living-resume' );
		$comment_box = 'textarea';
		$email_description = __( 'Please leave your email so I can contact you regarding this endorsement. Email addresses will not be made public.', 'living-resume' );
	} else {
		$submitted_post_title_text =  __( 'For front end purposes only! You must still add a title at the top!', 'living-resume' );
		$comment_box = 'wysiwyg';
		$email_description = '';
	}

	$prefix = '_living_resume_endorsement_';

	$cmb = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Endorsement', 'living-resume' ),
		'object_types' => array( 'lr_endorsement', ),
		'save_fields'  => is_admin(),
	) );

	/**
	 * Endorsement Fields
	 */
	$cmb->add_field( array(
		'name'       => __( 'Full Name', 'living-resume' ),
		'id'         => $prefix . 'full_name',
		'type'       => 'text_medium',
		'attributes' => array(
			'required' => true,
		),
		'default_cb' => 'living_resume_endorsement_maybe_set_default_from_posted_values',
	) );
	$cmb->add_field( array(
		'name'       => __( 'Email', 'living-resume' ),
		'id'         => $prefix . 'email',
		'type'       => 'text_email',
		'desc'       => $email_description,
		'attributes' => array(
			'required' => true,
		),
		'default_cb' => 'living_resume_endorsement_maybe_set_default_from_posted_values',
	) );
	$cmb->add_field( array(
		'name'    => __( 'Endorsement Title', 'living-resume' ),
		'id'      => 'submitted_post_title',
		'type'    => 'text_medium',
		'desc'    => $submitted_post_title_text,
	) );
	$cmb->add_field( array(
		'name'       => __( 'Comment', 'living-resume' ),
		'id'         => $prefix . 'content',
		'type'       => $comment_box,
		'attributes' => array(
			'required' => true,
		),
		'options'    => array( 
			'textarea_rows' => get_option( 'default_post_edit_rows', 8 ), 
			'media_buttons' => false,
		),
		'default_cb' => 'living_resume_endorsement_maybe_set_default_from_posted_values',
	) );
	$cmb->add_field( array(
		'name'       => __( 'Company', 'living-resume' ),
		'id'         => $prefix . 'company',
		'type'       => 'select',
		'desc'       => __( 'Select the Company this Endorsement is related to if applicable.', 'living-resume' ),
		'options_cb' => 'living_resume_endorsement_get_company_options',
		'default_cb' => 'living_resume_endorsement_maybe_set_default_from_posted_values',
	) );
	$cmb->add_field( array(
		'name'       => __( 'Project', 'living-resume' ),
		'id'         => $prefix . 'project',
		'type'       => 'select',
		'desc'       => __( 'Select the Project this Endorsement is related to if applicable.', 'living-resume' ),
		'options_cb' => 'living_resume_endorsement_get_project_options',
		'default_cb' => 'living_resume_endorsement_maybe_set_default_from_posted_values',
	) );
}
add_action( 'cmb2_admin_init', 'living_resume_endorsement_register_metabox' );
add_action( 'cmb2_init', 'living_resume_endorsement_register_metabox' );

/**
 * We need to pull the Companies as "options" for each endorsement
 * The company titles and IDs will be pulled into a single drop down menu
 */
function living_resume_endorsement_get_company_options( $field ) {

	$companies1 = array( '0' => 'Select Company' );

	$companies2 = Living_Resume_Shared::living_resume_get_company_options( $field ) ;

	$companies = $companies1 + $companies2;

	return $companies;
}

/**
 * We need to pull the Projects as "options" for each endorsement
 * The project titles and IDs will be pulled into a single drop down menu
 */
function living_resume_endorsement_get_project_options( $field ) {

	$projects1 = array( '0' => 'Select Project' );

	$projects2 = Living_Resume_Shared::living_resume_get_project_options( $field ) ;

	$projects = $projects1 + $projects2;

	return $projects;

}

/**
 * Sets the front-end-post-form field values if form has already been submitted.
 *
 * @return string
 */
function living_resume_endorsement_maybe_set_default_from_posted_values( $args, $field ) {
	if ( ! empty( $_POST[ $field->id() ] ) ) {
		return $_POST[ $field->id() ];
	}
	return '';
}

function get_endorsement_form() {
	// Use ID of metabox in yourprefix_frontend_form_register
	$metabox_id = '_living_resume_endorsement_metabox';

	// Post/object ID is not applicable since we're using this form for submission
	$object_id = 'fake-oject-id';

	// Get CMB2 metabox object
	return cmb2_get_metabox( $metabox_id, $object_id );
}

/**
 * Handles form submission on save. Redirects if save is successful, otherwise sets an error message as a cmb property
 *
 * @return void
 */
function living_resume_edorsement_form_submission() {
	// If no form submission, bail
	if ( empty( $_POST ) || ! isset( $_POST['submit-cmb'], $_POST['object_id'] ) ) {
		return false;
	}

	// Get CMB2 metabox object
	$cmb = get_endorsement_form();

	$post_data = array();

	// Get our shortcode attributes and set them as our initial post_data args
	if ( isset( $_POST['atts'] ) ) {
		foreach ( (array) $_POST['atts'] as $key => $value ) {
			$post_data[ $key ] = sanitize_text_field( $value );
		}
		unset( $_POST['atts'] );
	}

	// Check security nonce
	if ( ! isset( $_POST[ $cmb->nonce() ] ) || ! wp_verify_nonce( $_POST[ $cmb->nonce() ], $cmb->nonce() ) ) {
		return $cmb->prop( 'submission_error', new WP_Error( 'security_fail', __( 'Security check failed.' ) ) );
	}

	// Check title submitted
	if ( empty( $_POST['submitted_post_title'] ) ) {
		return $cmb->prop( 'submission_error', new WP_Error( 'post_data_missing', __( 'Endoresments require a title.' ) ) );
	}

	/**
	 * Fetch sanitized values
	 */
	$sanitized_values = $cmb->get_sanitized_values( $_POST );
	// Set our post data arguments
	$post_data['post_title'] = $sanitized_values['submitted_post_title'];
	unset( $sanitized_values['submitted_post_title'] );

	// Create the new post
	$new_submission_id = wp_insert_post( $post_data, true );

	// If we hit a snag, update the user
	if ( is_wp_error( $new_submission_id ) ) {
		return $cmb->prop( 'submission_error', $new_submission_id );
	}
	$cmb->save_fields( $new_submission_id, 'post', $sanitized_values );

	/**
	 * Other than post_type and post_status, we want
	 * our uploaded attachment post to have the same post-data
	 */
	unset( $post_data['post_type'] );
	unset( $post_data['post_status'] );

	/*
	 * Redirect back to the form page with a query variable with the new post ID.
	 * This will help double-submissions with browser refreshes
	 */
	wp_redirect( esc_url_raw( add_query_arg( 'post_submitted', $new_submission_id ) ) );
	exit;
}
add_action( 'cmb2_after_init', 'living_resume_edorsement_form_submission' );