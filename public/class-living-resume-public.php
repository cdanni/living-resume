<?php

/**
 *
 * @link       http://www.cristinadanni.com
 * @since      1.0.0
 *
 * @package    Living_Resume
 * @subpackage Living_Resume/public
 * @author     Cristina D'Anni <cristina.danni@gmail.com>
 *
 * The public-facing functionality of the plugin.
 *
 */
class Living_Resume_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site for later enqueing
	 *
	 * @since    1.0.0
	 */
	public function register_styles() {
		wp_register_style( $this->plugin_name . '-cmb2-form-styles', LIVING_RESUME_URL . 'includes/cmb2/css/cmb2.min.css', array(), $this->version, true );

	}

	/**
	 * Enqueue the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, LIVING_RESUME_URL . 'public/css/living-resume-public.css', array(), $this->version, 'all' );
		
		if( isset( $_GET['format'] ) && $_GET['format'] == 'lr_pdf' ) {
			//wp_enqueue_style( $this->plugin_name, LIVING_RESUME_URL . 'css/living-resume-pdf.css', array(), $this->version, 'all' );
		}

	}

/**
	 * Register the JavaScript for the public-facing side of the site for later enqueing
	 *
	 * @since    1.0.0
	 */
	public function register_scripts() {
		wp_register_script( 'cmb2-conditionals', LIVING_RESUME_URL . 'includes/cmb2-conditionals/cmb2-conditionals.js' , array( 'jquery', 'cmb2-scripts' ), '1.0.4', false );

	}

	/**
	 * Enqueue the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, LIVING_RESUME_URL . 'js/living-resume-public.js', array( 'jquery' ), $this->version, false );
		

	}
	/**
	 * Modifies the body classes of the resume, project, and endorsement to be treated as pages
	 *
	 */
	public function set_body_classes( $classes ) {

		// these are the classes we want to ditch
		$unwanted_classes = array( 'single', 'postid-' . get_the_ID(), 'has-sidebar' );

		// these are the post types we're targeting
		$post_types = array( 'lr_resume', 'lr_project', 'lr_endorsement' );
		$post_type = get_post_type( );

		// but we're only targeting single posts, not archives
		if ( is_single() ) {
			foreach ( $unwanted_classes as $unwanted_class ) {
				if (in_array( $unwanted_class, $classes ) ) {
					// remove what we don't want
					unset( $classes[array_search( $unwanted_class, $classes )] );
				}
			}

			// add the ones we do want
			if ( in_array( $post_type, $post_types ) ) {
				$classes[] = 'page';
				$classes[] = 'page-id-' . get_the_ID();
			}
		}
		return $classes;
	}

	/**
	 * Adds a default single view templates for resumes, projects, and endorsements
	 *
	 * @param    string    $template    The name of the template
	 * @return    mixed    The single template
	 */
	public function get_single_template( $template ) {

		global $post;

		$return = $template;

		if ( $post->post_type == 'lr_resume' ) {

			$return = living_resume_get_template( 'single-lr_resume' );

		} elseif ( $post->post_type == 'lr_project' ) {

			$return = living_resume_get_template( 'single-lr_project' );

		} elseif ( $post->post_type == 'lr_endorsement' ) {

			$return = living_resume_get_template( 'single-lr_endorsement' );

		} 

		return $return;

	} // get_single_template()
	
		/**
	 * Adds a default archive view templates for endorsements
	 *
	 * @param    string    $template    The name of the template
	 * @return    mixed    The archive template
	 */
	public function get_archive_template( $template ) {

		global $post;

		$return = $template;

		 if ( is_post_type_archive ( 'lr_endorsement' ) ) {

			$return = living_resume_get_template( 'archive-lr_endorsement' );

		}

		if ( is_post_type_archive ( 'lr_project' ) ) {

			$return = living_resume_get_template( 'archive-lr_project' );

		}
	
		return $return;

	} // get_archive_template()

	public function get_taxonomy_template( $template ) {

		$taxonomy = get_query_var('taxonomy');

		if ( $taxonomy == 'lr_skills' ) {

			$return = living_resume_get_template( 'taxonomy-lr_skills' );

		} elseif ( $taxonomy == 'lr_tools' ) {

			$return = living_resume_get_template( 'taxonomy-lr_tools' );

		}

		return $return;

	} // get_taxonomy_template()
	
	/**
	 * Rewrites taxonomy to act as a child under each CPT
	 */
	public function taxonomy_slug_rewrite( $wp_rewrite ) {
		$rules = array();
		$terms = get_terms( array(
			'taxonomy' => array(
				'lr_skills',
				'lr_tools',
			),
			'hide_empty' => false,
		) );

		foreach ( $terms as $term ) {
			if ( $term->taxonomy == 'lr_skills' ) {
				$termparent = 'resumes/projects/skills/';
			} elseif ( $term->taxonomy == 'lr_tools' ) {
				$termparent = 'resumes/projects/tools/';
			}

			$rules[$termparent . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
			$rules[$termparent . $term->slug . '/page/?([0-9]{1,})/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug . '&paged=' . $wp_rewrite->preg_index( 1 );

		}

		// merge with global rules
		$wp_rewrite->rules = $rules + $wp_rewrite->rules;
		return $wp_rewrite->rules;
	}

	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 */
	public function register_shortcodes() {

		add_shortcode( 'livingresume-resume', array( $this, 'display_living_resume' ) );
		add_shortcode( 'livingresume-endorsement-form', array( $this, 'display_endorsement_form' ) );

	} // register_shortcodes()

	/**
	 * Processes shortcode display_living_resume
	 *
	 * @param    array    $atts    The attributes from the shortcode
	 *
	 * @uses    get_option
	 * @uses    get_layout
	 *
	 * @return    mixed    $output    Output of the buffer
	 */
	public function display_living_resume( $atts, $content = '' ) {
		extract( shortcode_atts( array(
			'resume_id' => '',
		), $atts ) );

		if ( empty( $atts['resume_id'] ) ) :
			return;
		endif;

		$query = new WP_Query( array(
			'post_type'   => 'lr_resume',
			'post_status' => 'publish',
			'p'           => $atts['resume_id']
		) );
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post();
			?>
				<div id="living-resume">
					<?php include living_resume_get_template( 'resumes/livingresume-layout' ); ?>
		
				</div>
			<?php
			endwhile;
		endif;
		wp_reset_postdata();
	} // display_living_resume()

	public function display_endorsement_form( $atts = array() ) {

		// Get CMB2 metabox object
		$cmb = get_endorsement_form();

		$object_id = 'fake-oject-id';

		// Current user
		$user_id = get_current_user_id();

		// Get $cmb object_types
		$post_types = $cmb->prop( 'object_types' );

		// Parse attributes. These shortcode attributes can be optionally overridden.
		$atts = shortcode_atts( array(
			'post_author' => $user_id ? $user_id : 1, // Current user, or admin
			'post_status' => 'pending',
			'post_type'   => reset( $post_types ), // Only use first object_type in array
		), $atts, 'livingresume-endorsement-form' );

		/*
		 * Let's add these attributes as hidden fields to our cmb form
		 * so that they will be passed through to our form submission
		 */
		foreach ( $atts as $key => $value ) {
			$cmb->add_hidden_field( array(
				'field_args'  => array(
					'id'    => 'atts[$key]',
					'type'  => 'hidden',
					'default' => $value,
				),
			) );
		}

		// Initiate our output variable
		$output = '';

		// Get any submission errors
		if ( ( $error = $cmb->prop( 'submission_error' ) ) && is_wp_error( $error ) ) {
			// If there was an error with the submission, add it to our ouput.
			$output .= '<h3>' . sprintf( __( 'There was an error in the submission: %s', 'living-resume' ), '<strong>'. $error->get_error_message() .'</strong>' ) . '</h3>';
		}

		// If the post was submitted successfully, notify the user.
		if ( isset( $_GET['post_submitted'] ) && ( $post = get_post( absint( $_GET['post_submitted'] ) ) ) ) {

			// Add notice of submission to our output
			$output .= '<h3>' . esc_html__( 'Thank you! Your endorsement has been submitted and is pending review.', 'living-resume' ) . '</h3>';

		}

		// Our CMB2 form stuff goes here
		$output .= cmb2_get_metabox_form( $cmb, $object_id, array( 'save_button' => __( 'Submit Endorsement', 'living-resume' ) ) );

		return $output;
	}

	
}
