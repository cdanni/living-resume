<?php

/**
 *
 * @link       http://www.cristinadanni.com
 * @since      1.0.0
 *
 * @package    Living_Resume
 * @subpackage Living_Resume/admin
 * @author     Cristina D'Anni <cristina.danni@gmail.com>
 *
 * The admin-specific functionality of the plugin.
 */
class Living_Resume_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */

	private $option_name;
	
	/**
	 * The plugin options.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $options    The plugin options.
	 */
	private $options;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->set_options();
	}

	/**
	 * Sets the class variable $options
	 */
	private function set_options() {

		$this->options = get_option( $this->plugin_name . '-options' );

	} // set_options()

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

		wp_enqueue_style( $this->plugin_name, LIVING_RESUME_URL . 'admin/css/living-resume-admin.css', array(), $this->version, 'all' );

	} // enqueue_styles()

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, LIVING_RESUME_URL . 'admin/js/living-resume-admin.js', array( 'jquery' ), $this->version, false );
		

	} // enqueue_scripts()

	public function reorder_menu( $menu_order ) {
		/**
		 * This function is reorganizes the custom menu because WP puts them in a stupid order
		 * and doesn't allow for specifying menu position for taxonomy.
		 *
		 * This is dirty, hacky, and horrible, and I need to change it 
		 
		 */
		global $submenu;

		/**
		 * Removing the menu items, with the exception of the top three as their order is fine
		 *
		 */
		remove_submenu_page( 'edit.php?post_type=lr_resume', 'edit.php?post_type=lr_project' );
		remove_submenu_page( 'edit.php?post_type=lr_resume', 'edit.php?post_type=lr_endorsement' );

		/**
		 * Adding the menu items in the desired order, along with custom taxonomies for child post types
		 *
		 */
		add_submenu_page( 'edit.php?post_type=lr_resume', 'Projects', 'Projects', 'edit_posts', 'edit.php?post_type=lr_project');
		add_submenu_page( 'edit.php?post_type=lr_resume', 'Skills', '&nbsp;&nbsp;Skills', 'manage_categories', 'edit-tags.php?taxonomy=lr_skills&amp;post_type=lr_project');
		add_submenu_page( 'edit.php?post_type=lr_resume', 'Tools', '&nbsp;&nbsp;Tools', 'manage_categories', 'edit-tags.php?taxonomy=lr_tools&amp;post_type=lr_project');
		add_submenu_page( 'edit.php?post_type=lr_resume', 'Endorsements', 'Endorsements', 'edit_posts', 'edit.php?post_type=lr_endorsement');
		add_submenu_page(
			'edit.php?post_type=lr_resume',
			apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Living Resume Settings', 'living-resume' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Settings', 'living-resume' ) ),
			'manage_options',
			$this->plugin_name . '-settings',
			array( $this, 'page_settings' )
		);
		
		add_submenu_page(
			'edit.php?post_type=lr_resume',
			apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'Living Resume Help', 'living-resume' ) ),
			apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Help', 'living-resume' ) ),
			'manage_options',
			$this->plugin_name . '-help',
			array( $this, 'page_help' )
		);
	} // reorder_menu()

	/**
	 * Creates the settings page
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	public function page_settings() {

		include( LIVING_RESUME_PATH . 'admin/partials/living-resume-admin-settings.php' );

	} // page_settings()

	/**
	 * Creates the help page
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	public function page_help() {

		include( LIVING_RESUME_PATH . 'admin/partials/living-resume-admin-help.php' );

	} // page_help()

	/**
	 * Adds a link to the plugin settings page
	 *
	 * @since    1.0.0
	 * @param    array    $links    The current array of links
	 * @return   array    The modified array of links
	 */
	public function link_settings( $links ) {

		$lr_links[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'edit.php?post_type=lr_resume&page=' . $this->plugin_name . '-settings' ) ), esc_html__( 'Settings', 'living-resume' ) );

		return array_merge( $lr_links, $links );

	} // link_settings()

	/**
	 * Adds PDF export action to edit.php?post_type=lr_resume
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	public function pdf_export_link( $actions, $post ) {

		if ( get_post_type() === 'lr_resume' ) {
			$post_name = $post->post_title;
			$url = esc_url( 
				add_query_arg( 'format', 'lr_pdf', get_permalink ( $post->ID ) ) 
			);

			$actions['export-livingresume'] = '<a href="' . $url . '" title="" aria-label="' . esc_html__( "Export {$post_name}", 'living-resume' ) .'">Export Resume as PDF</a>';

		}

		return $actions;
	} // pdf_export_link()

	/**
	 * Generates a pdf file for downloading
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	public function generate_pdf( $post ) {

		if ( get_post_type( get_the_ID() ) != 'lr_resume' ) {
			return;
		}

		if( isset( $_GET['format'] ) && $_GET['format'] == 'lr_pdf' ) {

			$creation_date = date("Y-m-d");
			$creation_time = date("H:i:s");
			$filename = sanitize_file_name( get_the_title() );
			$filename .= '-' . $creation_date . '.pdf';

			// load the template for the resume and then grab the contents
			ob_start();

			include living_resume_get_template( 'single-lr_resume-pdf' );

			$html = ob_get_contents();

			ob_end_clean();

			// require dompdf autoload file for library
			require_once( LIVING_RESUME_PATH . 'includes/dompdf/autoload.inc.php');

			// instantiate and use the dompdf class
			$dompdf = new Dompdf\Dompdf();

			$dompdf->loadHtml($html);

			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper( 'A4', 'portrait' );

			// Render the HTML as PDF
			$dompdf->render();

			// Add creation information 
			$dompdf->add_info( 'Creator', 'Living Resume WordPress Plugin' );
			$dompdf->add_info( 'CreationDate', $creation_date . ' ' . $creation_time );

			// Output the generated PDF to Browser
			$dompdf->stream( $filename );
		}

	} // generate_pdf()

	/**
	 * Registers plugin settings
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	public function register_settings() {

		// register_setting( $option_group, $option_name, $sanitize_callback );

		register_setting(
			$this->plugin_name . '-options',
			$this->plugin_name . '-options',
			array( $this, 'sanitize' )
		);

	} // register_settings()

	/**
	 * Registers settings sections with WordPress
	 */
	public function register_sections() {

		// add_settings_section( $id, $title, $callback, $menu_slug );

		add_settings_section(
			$this->plugin_name . '-primary-resume-settings',
			apply_filters( $this->plugin_name . 'section-title-primary-resume-settings', esc_html__( 'Primary Resume Settings', 'living-resume' ) ),
			array( $this, 'section_primary_resume_settings' ),
			$this->plugin_name
		);

		add_settings_section(
			$this->plugin_name . '-personal-header',
			apply_filters( $this->plugin_name . 'section-title-personal-header', esc_html__( 'Personal Header Information', 'living-resume' ) ),
			array( $this, 'section_personal_header_information' ),
			$this->plugin_name
		);

		add_settings_section(
			$this->plugin_name . '-personal-footer',
			apply_filters( $this->plugin_name . 'section-title-personal-footer', esc_html__( 'Personal Footer Information', 'living-resume' ) ),
			array( $this, 'section_personal_footer_information' ),
			$this->plugin_name
		);

		add_settings_section(
			$this->plugin_name . '-pdf-settings',
			apply_filters( $this->plugin_name . 'section-title-pdf-settings', esc_html__( 'PDF Settings', 'living-resume' ) ),
			array( $this, 'section_pdf_settings' ),
			$this->plugin_name
		);

	} // register_sections()

	/**
	 * Creates a settings section
	 *
	 * @since    1.0.0
	 * @param    array    $params    Array of parameters for the section
	 * @return   mixed    The settings section
	 */

	public function section_primary_resume_settings( $params ) {

		include( LIVING_RESUME_PATH . 'admin/partials/living-resume-admin-section-primary-resume-settings.php' );

	} // section_primary_resume_settings()

	public function section_personal_header_information( $params ) {

		include( LIVING_RESUME_PATH . 'admin/partials/living-resume-admin-section-personal-header-information.php' );

	} // section_personal_header_information()

	public function section_personal_footer_information( $params ) {

		include( LIVING_RESUME_PATH . 'admin/partials/living-resume-admin-section-personal-footer-information.php' );

	} // section_personal_footer_information()

	public function section_pdf_settings( $params ) {

		include( LIVING_RESUME_PATH . 'admin/partials/living-resume-admin-section-pdf-settings.php' );

	} // section_pdf_settings()

	/**
	 * Registers settings fields with WordPress
	 */
	public function register_fields() {

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );

		$available_resumes = Living_Resume_Shared::living_resume_get_resume_options( );

		$fields = array(
			array( 'primary_resume', 'Primary Resume', 'select_posts', '-primary-resume-settings', $available_resumes ),
			array( 'full_name', 'Full Name', 'text', '-personal-header', '' ),
			array( 'email', 'Email Address', 'text', '-personal-header', '' ),
			array( 'telephone', 'Telephone Number', 'text', '-personal-header', '' ),
			array( 'linkedin', 'LinkedIn URL', 'text', '-personal-footer', '' ),
			array( 'github', 'GitHub Profile', 'text', '-personal-footer', '' ),
			array( 'codepen', 'CodePen Profile', 'text', '-personal-footer', '' ),
			array( 'behance', 'Behance Profile', 'text', '-personal-footer', '' ),
			array( 'alt_coderepo', 'Alternative Code Repository', 'text', '-personal-footer', '' ),
			array( 'alt_designrepo', 'Alternative Design Repository', 'text', '-personal-footer', '' ),
			array( 'twitter', 'Twitter Profile', 'text', '-personal-footer', '' ),
			array( 'facebook', 'Facebook Profile', 'text', '-personal-footer', '' ),
			array( 'google-plus', 'Google+ Profile', 'text', '-personal-footer', '' ),
			array( 'pdf_font_family', 'PDF Font Family', 'select', '-pdf-settings', array( 'Courier, monospace', 'DejaVu Sans, sans-serif', 'DejaVu Serif, serif', 'Helvetica, sans-serif', 'Times, serif' ) ),
		);

		foreach ( $fields as $field_settings ) {
			if ( is_array( $field_settings ) ) {
				add_settings_field(
					$field_settings[0],
					apply_filters( $this->plugin_name . 'label-'. $field_settings[0] .'', esc_html__( $field_settings[1], 'living-resume' ) ),
					array( $this, $field_settings[2] .'_field_render' ),
					$this->plugin_name,
					$this->plugin_name . $field_settings[3],
					array(
						'label_for' => $field_settings[1],
						'id'        => $field_settings[0],
						'values'    => $field_settings[4],
					)
				);
			}
			
		}

	} // register_fields()

	/**
	* Sanitize each setting field as needed
	*
	* @param    array    $input        The original input
 	* @return   array    $new_input    The sanitized input
	*/
	public function sanitize( $input ) {

		if ( $input['primary_resume'] == 'default' ) {
			add_settings_error(
				'LivingResumeSettingErrors',
				esc_attr( 'settings_updated' ),
				'Endorsements will not properly link with the Primary Resume selected.',
				'error'
			);
		}

		if ( $input['pdf_font_family'] == 'default' ) {
			add_settings_error(
				'LivingResumeSettingErrors',
				esc_attr( 'settings_updated' ),
				'PDFs might not print properly without a Font Family selected.',
				'error'
			);
		}

		// Initialize the new array that will hold the sanitize values
		$new_input = array();

		// Loop through the input and sanitize each of the values
		foreach ( $input as $key => $val ) {

			$new_input[ $key ] = sanitize_text_field( $val );

		}

		add_settings_error(
			'LivingResumeSettingErrors',
			esc_attr( 'settings_updated' ),
			'Living Resume Settings Updated.',
			'updated'
		);

		return $new_input;
	}

	/** 
	 * Get the settings option array and print the text input field
	 */
	public function text_field_render( $args ) { 
		if ( isset( $args['id'] ) ) {
			$this_id = $args['id'];
		}
		if ( isset( $this->options[$this_id] ) ) {
			$this_value = $this->options[$this_id];
		} else {
			$this_value = '';
		}
	?>

	<input type="text" id="<?php echo $this_id;?>" name="<?php echo $this->plugin_name . '-options'; ?>[<?php echo $this_id;?>]" size="40" value="<?php echo $this_value; ?>">

	<?php
	}

	/** 
	 * Get the settings option array and print the select field
	 */
	public function select_field_render( $args ) { 
		if ( isset( $args['id'] ) ) {
			$this_id = $args['id'];
			$option_values = $args['values'];
		}
	?>

	<select id="<?php echo $this_id;?>" name="<?php echo $this->plugin_name . '-options'; ?>[<?php echo $this_id;?>]">
		<option value="default">Select</option>
		<?php
		if ( is_array( $option_values ) ) {
			foreach ( $option_values as $option_value ) { 
			?>
				<option value="<?php echo $option_value;?>" 
				<?php 
					if ( isset ( $this->options[$this_id] ) && $this->options[$this_id] == $option_value ) {
						echo 'selected';
					}
				?>
				><?php echo $option_value;?></option>
			<?php
			}
		}
		?>
	</select>
	<?php
	}

	/** 
	 * Get the posts option array and print the select field
	 */
	public function select_posts_field_render( $args ) { 
		if ( isset( $args['id'] ) ) {
			$this_id = $args['id'];
			$option_values = $args['values'];
		}
	?>

	<select id="<?php echo $this_id;?>" name="<?php echo $this->plugin_name . '-options'; ?>[<?php echo $this_id;?>]">
		<option value="default">Select</option>
		<?php
		if ( is_array( $option_values ) ) {
			foreach ( $option_values as $option_key => $option_value ) { 
			?>
				<option value="<?php echo $option_key;?>" 
				<?php 
					if ( isset ( $this->options[$this_id] ) && $this->options[$this_id] == $option_key ) {
						echo 'selected';
					}
				?>
				><?php echo $option_value;?></option>
			<?php
			}
		}
		?>
	</select>
	<?php
	}

	/**
	* Adds notices for the admin to display.
	* Saves them in a temporary plugin option.
	* This method is called on plugin activation, so its needs to be static.
	*/
	public static function add_admin_notices() {

		$notices = get_option( 'living_resume_deferred_admin_notices', array() );

		$notices[] = array( 'class' => 'notice notice-info', 'notice' => __( 'Living Resume <strong>activated</strong>: To get started building your resume, review the <a href="' . admin_url( 'edit.php?post_type=lr_resume&page=living-resume-settings' ) . '">settings</a>.', 'living-resume' ) );

		apply_filters( 'living_resume_admin_notices', $notices );
		update_option( 'living_resume_deferred_admin_notices', $notices );

	} // add_admin_notices

	/**
	 * Manages any updates or upgrades needed before displaying notices.
	 * Checks plugin version against version required for displaying
	 * notices.
	*/
	public function admin_notices_init() {

		$current_version = '1.0.0';

		if ( $this->version !== $current_version ) {

			// Do whatever upgrades needed here.

			update_option( 'living_resume_version', $current_version );

			$this->add_notice();

		}

	} // admin_notices_init()

	/**
	 * Displays admin notices
	 *
	 * @return    string    Admin notices
	 */
	public function display_admin_notices() {

		$notices = get_option( 'living_resume_deferred_admin_notices' );

		if ( empty( $notices ) ) { return; }

		foreach ( $notices as $notice ) {

			echo '<div class="' . esc_attr( $notice['class'] ) . '"><p>' . $notice['notice'] . '</p></div>';

		}

		delete_option( 'living_resume_deferred_admin_notices' );

	} // display_admin_notices()

	/**
	 * Register TinyMCE buttons for shortcode insertion
	 */
	public function register_tinymce_buttons( $buttons ) {
		array_push( $buttons, 'lr-display-resume', 'lr-display-endorsement-form' );
		return $buttons;
	}

	/**
	 * Register TinyMCE plugin for shortcode insertion
	 */
	public function register_tinymce_plugin( $plugin_array ) {
		$plugin_array['living-resume-buttons'] = plugins_url( '/js/living-resume-tinymce-plugin.js',__FILE__ );
		return $plugin_array;
	}

	/**
	 * Retrieve list of resumes for shortcode insertion
	 */
	public function get_resumes( $post_type ) {
		global $wpdb;
		$cpt_type = $post_type;
		$cpt_post_status = 'publish';
		$cpt = $wpdb->get_results( $wpdb->prepare(
			"SELECT ID, post_title
				FROM $wpdb->posts 
				WHERE $wpdb->posts.post_type = %s
				AND $wpdb->posts.post_status = %s
				ORDER BY ID DESC",
			$cpt_type,
			$cpt_post_status
		) );
		$list = array();
		foreach ( $cpt as $post ) {
			$selected = '';
			$post_id = $post->ID;
			$post_name = $post->post_title;
			$list[] = array(
				'text'  => $post_name,
				'value' => $post_id
			);
		}
		wp_send_json( $list );
	}

	public function resume_ajax() {
		// check for nonce
		check_ajax_referer( 'lr-nonce', 'security' );
		$posts = $this->get_resumes( 'lr_resume' );
		return $posts;
	}
	
	public function resume_list() {

		global $pagenow;

		if( $pagenow != 'admin.php' ){
			$nonce = wp_create_nonce( 'lr-nonce' );
			?>
			<script type="text/javascript">
				jQuery( document ).ready( function( $ ) {
					var data = {
						'action'   : 'resume_list', // wp ajax action
						'security' : '<?php echo $nonce; ?>' // nonce value created earlier
					};
					// fire ajax
					jQuery.post( ajaxurl, data, function( response ) {
						// if nonce fails then not authorized else settings saved
						if( response === '-1' ){
							// do nothing
							console.log('error');
						} else {
							//console.log(response);
							if ( typeof(tinyMCE) != 'undefined' ) {
								if ( tinyMCE.activeEditor != null ) {
									tinyMCE.activeEditor.settings.ResumeList = response;
								}
							}
						}
					});
				});
			</script>
			<?php
		}
	}
} // class Living_Resume_Admin