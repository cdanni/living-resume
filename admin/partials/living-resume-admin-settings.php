<?php

/**
 *
 * @link       http://www.cristinadanni.com
 * @since      1.0.0
 *
 * @package    Living_Resume
 * @subpackage Living_Resume/admin/partials
 */
?>

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php settings_errors(); ?>

	<form method="post" action="options.php"><?php

	settings_fields( $this->plugin_name . '-options' );

	do_settings_sections( $this->plugin_name );

	submit_button( 'Save Living Resume Settings' );

	?></form>
</div>