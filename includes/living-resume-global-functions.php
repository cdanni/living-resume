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
 * Globally-accessible functions
 *
 */

/**
 * Returns the result of the get_template global function
 */
function living_resume_get_template( $name ) {

	return Living_Resume_Globals::get_template( $name );

}

class Living_Resume_Globals {

	/**
	 * Returns the path to a template file
	 *
	 * Looks for the file in these directories, in this order:
	 *    Current theme
	 *    Parent theme
	 *    Current theme templates folder
	 *    Parent theme templates folder
	 *    This plugin
	 *
	 * @param    string    $name    The name of a template file
	 * @return   string    The path to the template
	 */
 	public static function get_template( $name ) {

 		$template = '';

		$locations[] = "{$name}.php";
		$locations[] = "/templates/{$name}.php";
		$locations[] = "/templates/template-parts/{$name}.php";
		

		/**
		 * Filter the locations to search for a template file
		 *
		 * @param    array    $locations    File names and/or paths to check
		 */
		apply_filters( 'living-resume-template-paths', $locations );

		$template = locate_template( $locations, TRUE );

		if ( empty( $template ) ) {

			if ( file_exists( LIVING_RESUME_PATH . 'public/templates/template-parts/' . $name . '.php' ) ) {
				$template = LIVING_RESUME_PATH . 'public/templates/template-parts/' . $name . '.php';
			} else {
				$template = LIVING_RESUME_PATH . 'public/templates/' . $name . '.php';
			}

		}

		return $template;

 	} // get_template()

} // class Living_Resume_Globals
