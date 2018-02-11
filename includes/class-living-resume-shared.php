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
  * The public & admin-facing shared functionality of the plugin.
 *
 */

 // Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) { exit; }

class Living_Resume_Shared {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

	}

	/**
	 * Register the stylesheets for the admin-side of the site.
	 * Adding here since the css is the same file for both.
	 *
	 * @since    1.0.0
	 */
	public function admin_enqueue_styles() {

		wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

	}

	public static function get_meta_values( $key = '', $type = 'post', $status = 'publish' ) {

		global $wpdb;

		if( empty( $key ) )
			return;

		$r = $wpdb->get_results( $wpdb->prepare( "
			SELECT pm.post_id, pm.meta_value FROM {$wpdb->postmeta} pm
			LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE pm.meta_key = '%s' 
			AND p.post_status = '%s' 
			AND p.post_type = '%s'
			", 
		$key, $status, $type ), ARRAY_A );

		return $r;
	} // get_meta_values()

	/**
	 * Let's grab some companies to populate selection options
	 */
	public static function living_resume_get_company_options( $field ) {
		$args = wp_parse_args( array(
			'post_type'   => 'lr_company',
			'numberposts' => -1,
			'orderby'     => 'title',
			'order'       => 'ASC',
		) );

		$posts = get_posts( $args );

		$post_options = array();

		if ( $posts ) {
			foreach ( $posts as $post ) {
				$post_options[ $post->ID ] = $post->post_title;
			}
		}

		return $post_options;

	} //living_resume_get_company_options()

	/** 
	 * Let's grab some projects to populate selection options
	 */
	public static function living_resume_get_project_options( $field ) {
		$args = wp_parse_args( array(
			'post_type'   => 'lr_project',
			'numberposts' => -1,
		) );

		$posts = get_posts( $args );

		$post_options = array();

		if ( $posts ) {
			foreach ( $posts as $post ) {
				$post_options[ $post->ID ] = $post->post_title;
			}
		}

		return $post_options;

	} //living_resume_get_project_options()

	/** 
	 * Let's grab some resumes to populate selection options
	 */
	public static function living_resume_get_resume_options( ) {
		$args = wp_parse_args( array(
			'post_type'   => 'lr_resume',
			'numberposts' => -1,
		) );

		$posts = get_posts( $args );

		$post_options = array();

		if ( $posts ) {
			foreach ( $posts as $post ) {
				$post_options[ $post->ID ] = $post->post_title;
			}
		}

		return $post_options;

	} //living_resume_get_project_options()

	/**
	 * We need to pull the Skills as "options" to populate the Skills block when using 'By Taxonomy'
	 */
	public static function living_resume_get_skill_options( $field ) {
		$args = $field->args( 'get_terms_args' );
		$args = is_array( $args ) ? $args : array();

		$args = wp_parse_args( $args, array( 'taxonomy' => 'lr_skills' ) );

		$taxonomy = $args['taxonomy'];

		$terms = (array) cmb2_utils()->wp_at_least( '4.5.0' )
			? get_terms( $args )
			: get_terms( $taxonomy, $args );

		// Initate an empty array
		$term_options = array();
		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$term_options[ $term->term_id ] = $term->name;
			}
		}

		return $term_options;
	}

	/**
	 * We need to pull the Tools as "options" to populate the Tools block when using 'By Taxonomy'
	 */
	public static function living_resume_get_tool_options( $field ) {
		$args = $field->args( 'get_terms_args' );
		$args = is_array( $args ) ? $args : array();

		$args = wp_parse_args( $args, array( 'taxonomy' => 'lr_tools' ) );

		$taxonomy = $args['taxonomy'];

		$terms = (array) cmb2_utils()->wp_at_least( '4.5.0' )
			? get_terms( $args )
			: get_terms( $taxonomy, $args );

		// Initate an empty array
		$term_options = array();
		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$term_options[ $term->term_id ] = $term->name;
			}
		}

		return $term_options;
	}

} // class Living_Resume_Shared