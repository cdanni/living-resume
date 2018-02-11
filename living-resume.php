<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.cristinadanni.com
 * @since             1.0.0
 * @package           Living_Resume
 *
 * @wordpress-plugin
 * Plugin Name:       Living Resume
 * Plugin URI:        http://www.cristinadanni.com/living-resume/
 * Description:       Create a living resume with projects, skills, and companies neatly organized and easily linked together.
 * Version:           1.0.0
 * Author:            Cristina D'Anni
 * Author URI:        http://www.cristinadanni.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       living-resume
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

// Used for referring to the plugin file or basename
if ( ! defined( 'LIVING_RESUME_FILE' ) ) {
	define( 'LIVING_RESUME_FILE', plugin_basename( __FILE__ ) );
}

// Used for referring to the plugin url
if ( ! defined( 'LIVING_RESUME_PATH' ) ) {
	define( 'LIVING_RESUME_PATH', plugin_dir_path( __FILE__ ) );
}

// Used for referring to the plugin url
if ( ! defined( 'LIVING_RESUME_URL' ) ) {
	define( 'LIVING_RESUME_URL', plugin_dir_url( __FILE__ ) );
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-living-resume-activator.php
 */
function activate_living_resume() {
	require_once LIVING_RESUME_PATH . 'includes/class-living-resume-activator.php';
	Living_Resume_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-living-resume-deactivator.php
 */
function deactivate_living_resume() {
	require_once LIVING_RESUME_PATH . 'includes/class-living-resume-deactivator.php';
	Living_Resume_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_living_resume' );
register_deactivation_hook( __FILE__, 'deactivate_living_resume' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require LIVING_RESUME_PATH . 'includes/class-living-resume.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_living_resume() {

	$plugin = new Living_Resume();
	$plugin->run();

}
run_living_resume();
