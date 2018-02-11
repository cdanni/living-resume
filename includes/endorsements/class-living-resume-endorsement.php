<?php
/**
 *
 * @link       http://www.cristinadanni.com
 * @since      1.0.0
 *
 * @package    Living_Resume
 * @subpackage Living_Resume/includes/endorsement
 * @author     Cristina D'Anni <cristina.danni@gmail.com>
 *
 * This class defines all code necessary to create the Endorsement CPT during plugin's activation.
 *
 */
class Living_Resume_Endorsement {

	/**
	 * Let's load this thing!
	 */
	public function load() {
		$lr_endorsement = new Living_Resume_Endorsement;
		$lr_endorsement->new_cpt_lr_endorsement();

		/**
		 * Let's pull in some custom fields, shall we?
		 * Custom fields are via CMB2, because who wants to reinvent the wheel?
		 */
		require_once LIVING_RESUME_PATH . 'includes/endorsements/living-resume-endorsement-fields.php';
	}

	/**
	 * Create the new custom post type Endorsement
	 * We'll later pull these endorsements into each job on our resume
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public static function new_cpt_lr_endorsement() {

		$cap_type = 'post';
		$plural   = 'Endorsements';
		$single   = 'Endorsement';
		$cpt_name = 'lr_endorsement'; // had to shorten name due to WP limitations in CPT names
		$parent_slug = 'resumes';

		$opts['can_export']           = TRUE;
		$opts['capability_type']      = $cap_type;
		$opts['description']          = 'Endorsements';
		$opts['exclude_from_search']  = FALSE;
		$opts['has_archive']          = TRUE;
		$opts['hierarchical']         = FALSE;
		$opts['map_meta_cap']         = TRUE;
		//$opts['menu_icon']            = 'dashicons-portfolio';
		//$opts['menu_position']        = 21;
		$opts['public']               = TRUE;
		$opts['publicly_querable']    = FALSE;
		$opts['query_var']            = TRUE;
		$opts['register_meta_box_cb'] = '';
		$opts['rewrite']              = FALSE;
		$opts['show_in_admin_bar']    = TRUE;
		$opts['show_in_menu']         = 'edit.php?post_type=lr_resume';
		$opts['show_in_nav_menu']     = TRUE;
		$opts['show_ui']              = TRUE;
		$opts['supports']             = array( 'title', 'slug' );
		//$opts['taxonomies']           = array( );

		$opts['capabilities']['delete_others_posts']    = "delete_others_{$cap_type}s";
		$opts['capabilities']['delete_post']            = "delete_{$cap_type}";
		$opts['capabilities']['delete_posts']           = "delete_{$cap_type}s";
		$opts['capabilities']['delete_private_posts']   = "delete_private_{$cap_type}s";
		$opts['capabilities']['delete_published_posts'] = "delete_published_{$cap_type}s";
		$opts['capabilities']['edit_others_posts']      = "edit_others_{$cap_type}s";
		$opts['capabilities']['edit_post']              = "edit_{$cap_type}";
		$opts['capabilities']['edit_posts']             = "edit_{$cap_type}s";
		$opts['capabilities']['edit_private_posts']     = "edit_private_{$cap_type}s";
		$opts['capabilities']['edit_published_posts']   = "edit_published_{$cap_type}s";
		$opts['capabilities']['publish_posts']          = "publish_{$cap_type}s";
		$opts['capabilities']['read_post']              = "read_{$cap_type}";
		$opts['capabilities']['read_private_posts']     = "read_private_{$cap_type}s";

		$opts['labels']['add_new']            = esc_html__( "Add New {$single}", 'living-resume' );
		$opts['labels']['add_new_item']       = esc_html__( "Add New {$single}", 'living-resume' );
		$opts['labels']['all_items']          = esc_html__( $plural, 'living-resume' );
		$opts['labels']['edit_item']          = esc_html__( "Edit {$single}" , 'living-resume' );
		$opts['labels']['menu_name']          = esc_html__( $plural, 'living-resume' );
		$opts['labels']['name']               = esc_html__( $plural, 'living-resume' );
		$opts['labels']['name_admin_bar']     = esc_html__( $single, 'living-resume' );
		$opts['labels']['new_item']           = esc_html__( "New {$single}", 'living-resume' );
		$opts['labels']['not_found']          = esc_html__( "No {$plural} Found", 'living-resume' );
		$opts['labels']['not_found_in_trash'] = esc_html__( "No {$plural} Found in Trash", 'living-resume' );
		$opts['labels']['parent_item_colon']  = esc_html__( "Parent {$plural} :", 'living-resume' );
		$opts['labels']['search_items']       = esc_html__( "Search {$plural}", 'living-resume' );
		$opts['labels']['singular_name']      = esc_html__( $single, 'living-resume' );
		$opts['labels']['view_item']          = esc_html__( "View {$single}", 'living-resume' );

		$opts['rewrite']['ep_mask']           = EP_PERMALINK;
		$opts['rewrite']['feeds']             = FALSE;
		$opts['rewrite']['pages']             = TRUE;
		$opts['rewrite']['slug']              = esc_html__( strtolower( $parent_slug . '/' . $plural ), 'living-resume' );
		$opts['rewrite']['with_front']        = FALSE;

		$opts = apply_filters( 'living-resume-cpt-endorsement-options', $opts );

		register_post_type( strtolower( $cpt_name ), $opts );

	} // new_cpt_lr_endorsement()
}