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
 * Define the internationalization functionality.
 *
 */
class Living_Resume_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'living-resume',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

} // class Living_Resume_i18n
