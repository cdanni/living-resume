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
 * The core plugin class.
 *
 */
class Living_Resume {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Living_Resume_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'living-resume';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_shared_hooks();
		$this->define_template_functions();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Living_Resume_Loader. Orchestrates the hooks of the plugin.
	 * - Living_Resume_i18n. Defines internationalization functionality.
	 * - Living_Resume_Admin. Defines all hooks for the admin area.
	 * - Living_Resume_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once LIVING_RESUME_PATH . 'includes/class-living-resume-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once LIVING_RESUME_PATH . 'includes/class-living-resume-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once LIVING_RESUME_PATH . 'admin/class-living-resume-admin.php';

		/**
		 * The class responsible for defining and registering the Resume custom post type
		 */
		require_once LIVING_RESUME_PATH . 'includes/resumes/class-living-resume-resume.php';

		/**
		 * The class responsible for defining and registering the Company custom post type
		 */
		require_once LIVING_RESUME_PATH . 'includes/companies/class-living-resume-company.php';

		/**
		 * The class responsible for defining and registering the Project custom post type
		 */
		require_once LIVING_RESUME_PATH . 'includes/projects/class-living-resume-project.php';

		/**
		 * The class responsible for defining and registering the Endorsement custom post type,
		 * along with saving the form when submitted from the front end.
		 */
		require_once LIVING_RESUME_PATH . 'includes/endorsements/class-living-resume-endorsement.php';

		/**
		 * Include CMB2 for all custom metaboxes,
		 * clean require as the library handles potential multiple includes on its own
		 */
		require_once LIVING_RESUME_PATH . 'includes/cmb2/init.php';

		/**
		 * Include CMB2 Radio Image to use images as radio options,
		 * clean require as the library handles potential multiple includes on its own
		 */
		require_once LIVING_RESUME_PATH . 'includes/cmb2-radio-image/cmb2-radio-image.php';

		/**
		 * Include CMB2 Conditionals for custom metaboxes with conditional code, 
		 * wrapping in a conditional in case it's loaded by another plugin
		 */
		if ( ! class_exists( 'CMB2_Conditionals' ) ) {
			require_once LIVING_RESUME_PATH . 'includes/cmb2-conditionals/cmb2-conditionals.php';
		}

		/**
		 * Include CMB2 Field Type: Sorter to help organize layout, 
		 * wrapping in a conditional in case it's loaded by another plugin
		 */
		if ( ! function_exists( 'tb_sorter_enqueue' ) ) {
			require_once LIVING_RESUME_PATH . 'includes/cmb-field-type-sorter/cmb-field-sorter.php';
		}

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once LIVING_RESUME_PATH . 'public/class-living-resume-public.php';

		/**
		 * The class responsible for all global functions.
		 */
		require_once LIVING_RESUME_PATH . 'includes/living-resume-global-functions.php';

		/**
		 * The class responsible for defining all actions shared by the Dashboard and public-facing sides.
		 */
		require_once LIVING_RESUME_PATH . 'includes/class-living-resume-shared.php';

		/**
		 * The file responsible for defining all resume template tags.
		 */
		require_once LIVING_RESUME_PATH . 'public/living-resume-resume-template-functions.php';

		$this->loader = new Living_Resume_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Living_Resume_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Living_Resume_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Living_Resume_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_filter( 'admin_menu', $plugin_admin, 'reorder_menu' );
		$this->loader->add_filter( 'plugin_action_links_' . LIVING_RESUME_FILE, $plugin_admin, 'link_settings' );
		$this->loader->add_filter( 'post_row_actions', $plugin_admin, 'pdf_export_link', 10, 2 );
		$this->loader->add_action( 'wp', $plugin_admin, 'generate_pdf' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_sections' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_fields' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'admin_notices_init' );
		$this->loader->add_action( 'admin_notices', $plugin_admin, 'display_admin_notices' );
		$this->loader->add_filter( 'mce_buttons', $plugin_admin, 'register_tinymce_buttons' );
		$this->loader->add_filter( 'mce_external_plugins', $plugin_admin, 'register_tinymce_plugin' );
		$this->loader->add_action( 'wp_ajax_resume_list', $plugin_admin, 'resume_ajax' );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'resume_list' );

		$lr_resume = new Living_Resume_Resume();
		$this->loader->add_action( 'init', $lr_resume, 'load' );

		$lr_project = new Living_Resume_Project();
		$this->loader->add_action( 'init', $lr_project, 'load' );

		$lr_company = new Living_Resume_Company();
		$this->loader->add_action( 'init', $lr_company, 'load' );

		$lr_endorsement = new Living_Resume_Endorsement();
		$this->loader->add_action( 'init', $lr_endorsement, 'load' );

		//$template_functions = new Living_Resume_Template_Functions();
		//$this->loader->add_action( 'init', $template_functions, 'load' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Living_Resume_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'register_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'register_scripts' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'body_class', $plugin_public, 'set_body_classes', 20 );
		$this->loader->add_filter( 'single_template', $plugin_public, 'get_single_template' );
		$this->loader->add_filter( 'archive_template', $plugin_public, 'get_archive_template' );
		$this->loader->add_filter( 'taxonomy_template', $plugin_public, 'get_taxonomy_template' );
		$this->loader->add_filter( 'generate_rewrite_rules', $plugin_public, 'taxonomy_slug_rewrite' );
		$this->loader->add_action( 'init', $plugin_public, 'register_shortcodes' );

	}

	/**
	 * Register all of the hooks shared between public-facing and admin functionality
	 * of the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_shared_hooks() {

		$plugin_shared = new Living_Resume_Shared( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_shared, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_shared, 'admin_enqueue_styles' );

	} // define_shared_hooks()

	/**
	 * Register all of the hooks related to the templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_template_functions() {
		$template_functions = new Living_Resume_Template_Functions( $this->get_plugin_name(), $this->get_version() );
	} // define_template_functions()

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Living_Resume_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

} // class Living_Resume
