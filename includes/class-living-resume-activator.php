<?php

/**
 *
 * @link       http://www.cristinadanni.com
 * @since      1.0.0
 *
 * @package    Living_Resume
 * @subpackage Living_Resume/includes
 * @author     Cristina D'Anni <cristina.danni@gmail.com>
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 */
class Living_Resume_Activator {

	/**
	 * Activate Living Resume.
	 *
	 * We've got a lot going on elsewhere, but this is pretty basic.
	 * We're just going to force a flusing of the rewrite rules to generate permalinks.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		require_once LIVING_RESUME_PATH . 'admin/class-living-resume-admin.php';

		/**
		 * Grabbing the custom post types and taxonomy so our rules write cleanly
		 */
		
		Living_Resume_Project::new_taxonomy_lr_skills();
		Living_Resume_Project::new_taxonomy_lr_tools();
		Living_Resume_Project::new_cpt_lr_project();

		Living_Resume_Company::new_cpt_lr_company();

		Living_Resume_Endorsement::new_cpt_lr_endorsement();
		
		Living_Resume_Resume::new_cpt_lr_resume();

		flush_rewrite_rules( );

		Living_Resume_Admin::add_admin_notices();
	}
} // class Living_Resume_Activator
