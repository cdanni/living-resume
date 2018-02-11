<?php
/**
 *
 * @link       http://www.cristinadanni.com
 * @since      1.0.0
 *
 * @package    Living_Resume
 * @subpackage Living_Resume/includes/project
 * @author     Cristina D'Anni <cristina.danni@gmail.com>
 *
 * This class defines all code necessary to create the Project CPT during plugin's activation.
 *
 */
class Living_Resume_Project {
	
	/**
	 * Let's load this thing!
	 */
	public function load() {
		$lr_project = new Living_Resume_Project;
		$lr_project->new_cpt_lr_project();

		$skills = new Living_Resume_Project;
		$skills->new_taxonomy_lr_skills();

		$tools = new Living_Resume_Project;
		$tools->new_taxonomy_lr_tools();

		/**
		 * Let's pull in some custom fields, shall we?
		 * Custom fields are via CMB2, because who wants to reinvent the wheel?
		 */
		require_once LIVING_RESUME_PATH . 'includes/projects/living-resume-project-fields.php';
	}

	/**
	 * Create the new custom post type Project
	 * We'll later pull these projects into each job on our resume
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_post_type()
	 */
	public static function new_cpt_lr_project() {

		$cap_type = 'post';
		$plural   = 'Projects';
		$single   = 'Project';
		$cpt_name = 'lr_project';
		$parent_slug = 'resumes';

		$opts['can_export']           = TRUE;
		$opts['capability_type']      = $cap_type;
		$opts['description']          = 'Projects';
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
		$opts['taxonomies']           = array( 'lr_skills, lr_tools' );

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

		$opts = apply_filters( 'living-resume-cpt-project-options', $opts );

		register_post_type( strtolower( $cpt_name ), $opts );

	} // new_cpt_lr_project()

	/**
	 * Create the new custom taxonomy Skill
	 * Assigns skills to the Project child custom post types for tagging purposes
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function new_taxonomy_lr_skills() {
		$plural   = 'Skills';
		$single   = 'Skill';
		$tax_name = 'lr_skills';
		$parent_slug = 'resumes/projects';

		$opts['hierarchical']      = FALSE;
		$opts['public']            = TRUE;
		$opts['query_var']         = $tax_name;
		$opts['show_admin_column'] = TRUE;
		$opts['show_in_menu']      = TRUE;
		$opts['show_in_nav_menus'] = TRUE;
		$opts['show_tag_cloud']    = TRUE;
		$opts['show_ui']           = TRUE;
		$opts['sort']              = '';

		$opts['capabilities']['assign_terms'] = 'edit_posts';
		$opts['capabilities']['delete_terms'] = 'manage_categories';
		$opts['capabilities']['edit_terms']   = 'manage_categories';
		$opts['capabilities']['manage_terms'] = 'manage_categories';

		$opts['labels']['add_new_item']               = esc_html__( "Add New {$single}", 'living-resume' );
		$opts['labels']['add_or_remove_items']        = esc_html__( "Add or remove {$plural}", 'living-resume' );
		$opts['labels']['all_items']                  = esc_html__( $plural, 'living-resume' );
		$opts['labels']['choose_from_most_used']      = esc_html__( "Choose from most used {$plural}", 'living-resume' );
		$opts['labels']['edit_item']                  = esc_html__( "Edit {$single}" , 'living-resume');
		$opts['labels']['menu_name']                  = esc_html__( "&nbsp;&nbsp;{$plural}", 'living-resume' );
		$opts['labels']['name']                       = esc_html__( $plural, 'living-resume' );
		$opts['labels']['new_item_name']              = esc_html__( "New {$single} Name", 'living-resume' );
		$opts['labels']['not_found']                  = esc_html__( "No {$plural} Found", 'living-resume' );
		$opts['labels']['parent_item']                = esc_html__( "Parent {$single}", 'living-resume' );
		$opts['labels']['parent_item_colon']          = esc_html__( "Parent {$single}:", 'living-resume' );
		$opts['labels']['popular_items']              = esc_html__( "Popular {$plural}", 'living-resume' );
		$opts['labels']['search_items']               = esc_html__( "Search {$plural}", 'living-resume' );
		$opts['labels']['separate_items_with_commas'] = esc_html__( "Separate {$plural} with commas", 'living-resume' );
		$opts['labels']['singular_name']              = esc_html__( $single, 'living-resume' );
		$opts['labels']['update_item']                = esc_html__( "Update {$single}", 'living-resume' );
		$opts['labels']['view_item']                  = esc_html__( "View {$single}", 'living-resume' );

		$opts['rewrite']['ep_mask']      = EP_NONE;
		$opts['rewrite']['hierarchical'] = FALSE;
		$opts['rewrite']['slug']         = esc_html__( strtolower( $parent_slug . '/' . $plural ), 'living-resume' );
		$opts['rewrite']['with_front']   = FALSE;

		$opts = apply_filters( 'living-resume-taxonomy-skill-options', $opts );

		register_taxonomy( $tax_name, array( 'lr_project' ), $opts );

	} // new_taxonomy_lr_skills()

		/**
	 * Create the new custom taxonomy Tool
	 * Assigns tools to the Project child custom post types for tagging purposes
	 *
	 * @since 	1.0.0
	 * @access 	public
	 * @uses 	register_taxonomy()
	 */
	public static function new_taxonomy_lr_tools() {
		$plural   = 'Tools';
		$single   = 'Tool';
		$tax_name = 'lr_tools';
		$parent_slug = 'resumes/projects';

		$opts['hierarchical']      = FALSE;
		$opts['public']            = TRUE;
		$opts['query_var']         = $tax_name;
		$opts['show_admin_column'] = TRUE;
		$opts['show_in_menu']      = TRUE;
		$opts['show_in_nav_menus'] = TRUE;
		$opts['show_tag_cloud']    = TRUE;
		$opts['show_ui']           = TRUE;
		$opts['sort']              = '';

		$opts['capabilities']['assign_terms'] = 'edit_posts';
		$opts['capabilities']['delete_terms'] = 'manage_categories';
		$opts['capabilities']['edit_terms']   = 'manage_categories';
		$opts['capabilities']['manage_terms'] = 'manage_categories';

		$opts['labels']['add_new_item']               = esc_html__( "Add New {$single}", 'living-resume' );
		$opts['labels']['add_or_remove_items']        = esc_html__( "Add or remove {$plural}", 'living-resume' );
		$opts['labels']['all_items']                  = esc_html__( $plural, 'living-resume' );
		$opts['labels']['choose_from_most_used']      = esc_html__( "Choose from most used {$plural}", 'living-resume' );
		$opts['labels']['edit_item']                  = esc_html__( "Edit {$single}" , 'living-resume');
		$opts['labels']['menu_name']                  = esc_html__( "&nbsp;&nbsp;{$plural}", 'living-resume' );
		$opts['labels']['name']                       = esc_html__( $plural, 'living-resume' );
		$opts['labels']['new_item_name']              = esc_html__( "New {$single} Name", 'living-resume' );
		$opts['labels']['not_found']                  = esc_html__( "No {$plural} Found", 'living-resume' );
		$opts['labels']['parent_item']                = esc_html__( "Parent {$single}", 'living-resume' );
		$opts['labels']['parent_item_colon']          = esc_html__( "Parent {$single}:", 'living-resume' );
		$opts['labels']['popular_items']              = esc_html__( "Popular {$plural}", 'living-resume' );
		$opts['labels']['search_items']               = esc_html__( "Search {$plural}", 'living-resume' );
		$opts['labels']['separate_items_with_commas'] = esc_html__( "Separate {$plural} with commas", 'living-resume' );
		$opts['labels']['singular_name']              = esc_html__( $single, 'living-resume' );
		$opts['labels']['update_item']                = esc_html__( "Update {$single}", 'living-resume' );
		$opts['labels']['view_item']                  = esc_html__( "View {$single}", 'living-resume' );

		$opts['rewrite']['ep_mask']      = EP_NONE;
		$opts['rewrite']['hierarchical'] = FALSE;
		$opts['rewrite']['slug']         = esc_html__( strtolower( $parent_slug . '/' . $plural ), 'living-resume' );
		$opts['rewrite']['with_front']   = FALSE;

		$opts = apply_filters( 'living-resume-taxonomy-tool-options', $opts );

		register_taxonomy( $tax_name, array( 'lr_project' ), $opts );

	} // new_taxonomy_lr_tools()

}