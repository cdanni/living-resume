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
 * Defines the template tags for creating the templates.
 *
 */

class Living_Resume_Template_Functions {

	/**
	 * Private static reference to this class
	 * Useful for removing actions declared here.
	 *
	 * @var 	object 		$_this
 	 */
	private static $_this;

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

		self::$_this = $this;

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	} // __construct()

	/**
	 * Returns a reference to this class. Used for removing
	 * actions and/or filters declared using an object of this class.
	 *
	 * @see  	http://hardcorewp.com/2012/enabling-action-and-filter-hook-removal-from-class-based-wordpress-plugins/
	 * @return 	object 		This class
	 */
	static function this() {

		return self::$_this;

	} // this()

	/**
	 * Returns the introduction title
	 */
	public static function resume_introduction_title() {

		$introduction = get_post_meta( get_the_ID(), '_living_resume_introduction', true );

		if ( is_array( $introduction ) ) {
			if ( isset( $introduction[0]['title'] ) ) {
				$introduction_title = $introduction[0]['title'];
			} else {
				$introduction_title = '';
			}
		} else {
			$introduction_title = '';
		}

		return $introduction_title;

	} // resume_introduction_title()

	/**
	 * Returns the introduction text
	 */
	public static function resume_introduction_text() {

		$introduction = get_post_meta( get_the_ID(), '_living_resume_introduction', true );

		if ( is_array( $introduction ) ) {
			if ( isset( $introduction[0]['text'] ) ) {
				$introduction_text = wpautop( $introduction[0]['text'] );
			} else {
				$introduction_text = '';
			}
		} else {
			$introduction_text = '';
		}

		return $introduction_text;

	} // resume_introduction_text()

	/**
	 * Returns the employment section title
	 */
	public static function resume_employment_title() {

		$employment_title = get_post_meta( get_the_ID(), '_living_resume_employment_title', true );

		if ( is_array( $employment_title ) ) {
			if ( isset( $employment_title[0]['section_title'] ) ) {
				$employment_title = $employment_title[0]['section_title'];
			} else {
				$employment_title = '';
			}
		} else {
			$employment_title = '';
		}

		return $employment_title;

	} // resume_employment_title()

	/**
	 * Returns the employment history section
	 */
	public static function resume_employment_history() {

		$employment_history = get_post_meta( get_the_ID(), '_living_resume_employment_history', true );

		$endorsed_company = ''; // setting this to empty for now;

		if ( is_array( $employment_history ) ) {
			foreach ($employment_history as $key => $job ){

				if( isset( $job['title'] ) ) {
					$job_title = $job['title'];
				} else {
					$job_title = '';
				}
				$employment_history[ $key ]['title'] = $job_title;

				if( isset( $job['start_date'] ) ) {
					$start_date = $job['start_date'];
				} else {
					$start_date = 0;
				}
				$employment_history[ $key ]['start_date'] = $start_date;

				if( isset( $job['end_date'] ) ) {
					$end_date = $job['end_date'];
				} else {
					$end_date = 0;
				}
				$employment_history[ $key ]['end_date'] = $end_date;

				if ( isset( $job['company'] ) ) {
					$company_name = get_the_title( $job['company'] );
					$company_url = get_post_meta( $job['company'], '_living_resume_company_url', true );

					if ( isset( $company_url ) && $company_url != '' ) {
						$company = '<a href="' . $company_url . '" name="' . str_replace(' ', '', strtolower( $company_name ) ) . '" target="_blank">' . $company_name . '</a>';
					} else {
						$company = $company_name;
					}
				} else {
					$company = '';
				}
				$employment_history[ $key ]['company'] = $company;

				if( isset( $job['job_description'] ) ) {
					$job_description = wpautop( $job['job_description'] );
				} else {
					$job_description = '';
				}
				$employment_history[ $key ]['job_description'] = $job_description;

				if ( isset( $job['projects'] ) && $job['projects'] != false ) {
					foreach ( $job['projects'] as $projectkey => $project_id ){

						$project_name = get_the_title( $project_id );
						if ( isset( $project_name ) ) {
							$project_name = $project_name;
						}
						else {
							$project_name = '';
						}

						$project_url = get_permalink( $project_id );
						if ( isset( $project_url ) ) {
							$project_url = $project_url;
						}
						else {
							$project_url = "#";
						}

						$project_details = array( $project_url, $project_name );
						$employment_history[ $key ]['projects'][ $projectkey ] = $project_details;
					}
				}

				$job_endorsements = Living_Resume_Shared::get_meta_values( '_living_resume_endorsement_company', 'lr_endorsement' );

				if ( is_array( $job_endorsements ) ) {

					$endorsements = array();

					foreach ( $job_endorsements as $endorsement_key => $endorsement_data ) {

						if ( $endorsement_data['meta_value'] == $job['company'] ) { 

							if ( ! isset( $endorsed_company ) || $endorsed_company == '' ) {

								$endorsement_url = get_the_permalink( $endorsement_data['post_id'] );
								$endorsement_name = get_the_title( $endorsement_data['post_id'] );
								$endorsement_details = array( $endorsement_url, $endorsement_name );

								$employment_history[ $key ]['endorsements'][ $endorsement_key ] = $endorsement_details;

								$endorsed_company = $endorsement_data['meta_value'];

							}

						}

					}
				}
			}
		} else {
			$employment_history = '';
		}

		return $employment_history;
	
	} // resume_employment_history()

	/**
	 * Returns the employment section title
	 */
	public static function resume_education_title() {

		$education_title = get_post_meta( get_the_ID(), '_living_resume_education_title', true );

		if ( is_array( $education_title ) ) {
			if ( isset( $education_title[0]['section_title'] ) ) {
				$education_title = $education_title[0]['section_title'];
			} else {
				$education_title = '';
			}
		} else {
			$education_title = '';
		}

		return $education_title;

	} // resume_education_title()

		/**
	 * Returns the education history section
	 */
	public static function resume_education_history() {

		$education_history = get_post_meta( get_the_ID(), '_living_resume_education_history', true );

		if ( is_array( $education_history ) ) {
			foreach ($education_history as $key => $degree ){

				if( isset( $degree['title'] ) ) {
					$degree_title = $degree['title'];
				} else {
					$degree_title = '';
				}
				$education_history[ $key ]['degree_title'] = $degree_title;

				if( isset( $degree['school'] ) ) {
					$degree_school = $degree['school'];
				} else {
					$degree_school = '';
				}
				$education_history[ $key ]['degree_school'] = $degree_school;

				if( isset( $degree['location'] ) ) {
					$degree_location = $degree['location'];
				} else {
					$degree_location = '';
				}
				$education_history[ $key ]['degree_location'] = $degree_location;

				if( isset( $degree['description'] ) ) {
					$degree_description = wpautop( $degree['description'] );
				} else {
					$degree_description = '';
				}
				$education_history[ $key ]['degree_description'] = $degree_description;

				if ( isset( $degree['projects'] ) && $degree['projects'] != false ) {
					foreach ( $degree['projects'] as $thiskey => $project_id ){

						$project_name = get_the_title( $project_id );
						if ( isset( $project_name ) ) {
							$project_name = $project_name;
						}
						else {
							$project_name = '';
						}

						$project_url = get_permalink( $project_id );
						if ( isset( $project_url ) ) {
							$project_url = $project_url;
						}
						else {
							$project_url = "#";
						}

						$project_details = array( $project_name, $project_url );
						$education_history[ $key ]['projects'][ $thiskey ] = $project_details;
					}
				}
			}
		} else {
			$education_history = '';
		}

		return $education_history;
	
	} // resume_education_history()

	/**
	 * Returns the skills title
	 */
	public static function resume_skills_title() {

		$skills = get_post_meta( get_the_ID(), '_living_resume_skills_block', true );

		if ( is_array( $skills ) ) {
			if ( isset( $skills[0]['title'] ) ) {
				$skills_title = $skills[0]['title'];
			} else {
				$skills_title = '';
			}
		} else {
			$skills_title = '';
		}

		return $skills_title;

	} // resume_skills_title()

	/**
	 * Returns the skills title
	 */
	public static function resume_skills_list() {

		$skills = get_post_meta( get_the_ID(), '_living_resume_skills_block', true );

		if ( is_array( $skills ) ) {
			if ( isset( $skills[0]['add_type'] ) ) {
				$skills_type = $skills[0]['add_type'];
			} else {
				$skills_type = "form";
			}

			if ( $skills_type == "tax" ) {
				if ( isset( $skills[0]['skills_tax'] ) ) {
					$skills_tax = $skills[0]['skills_tax'];
					$terms = get_terms( 'lr_skills', array( 
						'include' => $skills_tax,
						'orderby' => 'count',
					) );

					$termlinks = array();
					foreach ( $terms as $term ) {
						$termlinks[] = '<a href="/resumes/projects/skills/' . $term->slug . '">' . $term->name . '</a>';
					}
					
					$skills_list = $termlinks;
				} else {
					$skills_list = '';
				}
			} elseif ( $skills_type == "form" ) {
				if ( isset( $skills[0]['skills_form'] ) ) {
					$skills_list = wpautop( $skills[0]['skills_form'] );
				} else {
					$skills_list = '';
				}
			}
		} else {
			$skills_list = '';
		}

		return $skills_list;

	} // resume_skills_list()

	/**
	 * Returns the tools title
	 */
	public static function resume_tools_title() {

		$tools = get_post_meta( get_the_ID(), '_living_resume_tools_block', true );

		if ( is_array( $tools ) ) {
			if ( isset( $tools[0]['title'] ) ) {
				$tools_title = $tools[0]['title'];
			} else {
				$tools_title = '';
			}
		} else {
			$tools_title = '';
		}

		return $tools_title;

	} // resume_tools_title()

	/**
	 * Returns the tools title
	 */
	public static function resume_tools_list() {

		$tools = get_post_meta( get_the_ID(), '_living_resume_tools_block', true );

		if ( is_array( $tools ) ) {
			if ( isset( $tools[0]['add_type'] ) ) {
				$tools_type = $tools[0]['add_type'];
			} else {
				$tools_type = "form";
			}

			if ( $tools_type == "tax" ) {
				if ( isset( $tools[0]['tools_tax'] ) ) {
					$tools_tax = $tools[0]['tools_tax'];
					$terms = get_terms( 'lr_tools', array( 
						'include' => $tools_tax,
						'orderby' => 'count',
					) );

					$termlinks = array();
					foreach ( $terms as $term ) {
						$termlinks[] = '<a href="/resumes/projects/tools/' . $term->slug . '">' . $term->name . '</a>';
					}
					
					$tools_list = $termlinks;
				} else {
					$tools_list = '';
				}
			} elseif ( $tools_type == "form" ) {
				if ( isset( $tools[0]['tools_form'] ) ) {
					$tools_list = wpautop( $tools[0]['tools_form'] );
				} else {
					$tools_list = '';
				}
			}
		} else {
			$tools_list = '';
		}

		return $tools_list;


	} // resume_tools_list()

	/**
	 * Returns the additional information title for First Additional Information Block
	 */
	public static function resume_info_one_title() {

		$additional_information = get_post_meta( get_the_ID(), '_living_resume_additional_one', true );

		if ( is_array( $additional_information ) ) {
			if ( isset( $additional_information[0]['title'] ) ) {
				$additional_information_title = $additional_information[0]['title'];
			} else {
				$additional_information_title = '';
			}
		} else {
			$additional_information_title = '';
		}

		return $additional_information_title;


	} // resume_info_one_title()

	/**
	 * Returns the additional information text for First Additional Information Block
	 */
	public static function resume_info_one_text() {

		$additional_information = get_post_meta( get_the_ID(), '_living_resume_additional_one', true );

		if ( is_array( $additional_information ) ) {
			if ( isset( $additional_information[0]['text'] ) ) {
				$additional_information_text = wpautop( $additional_information[0]['text'] );
			} else {
				$additional_information_text = '';
			}
		} else {
			$additional_information_text = '';
		}

		return $additional_information_text;

	} // resume_info_one_text()

	/**
	 * Returns the additional information title for Second Additional Information Block
	 */
	public static function resume_info_two_title() {

		$additional_information = get_post_meta( get_the_ID(), '_living_resume_additional_two', true );

		if ( is_array( $additional_information ) ) {
			if ( isset( $additional_information[0]['title'] ) ) {
				$additional_information_title = $additional_information[0]['title'];
			} else {
				$additional_information_title = '';
			}
		} else {
			$additional_information_title = '';
		}

		return $additional_information_title;

	} // resume_info_two_title()

	/**
	 * Returns the additional information text for Second Additional Information Block
	 */
	public static function resume_info_two_text() {

		$additional_information = get_post_meta( get_the_ID(), '_living_resume_additional_two', true );

		if ( is_array( $additional_information ) ) {
			if ( isset( $additional_information[0]['text'] ) ) {
				$additional_information_text = wpautop( $additional_information[0]['text'] );
			} else {
				$additional_information_text = '';
			}
		} else {
			$additional_information_text = '';
		}

		return $additional_information_text;


	} // resume_info_two_text()

	/**
	 * Returns the header layout option
	 */
	public static function resume_header_layout( ) {

		$header_layout = get_post_meta( get_the_ID(), '_living_resume_header_layout', true );

		if ( ! empty( $header_layout ) ) {
			$header_layout = $header_layout;
		} else {
			$header_layout = "none";
		}

		return $header_layout;

	} // resume_header_layout()

	/**
	 * Returns the header options - Full Name 
	 */
	public static function resume_full_name( ) {

		$resume_options = get_option( 'living-resume-options' );

		if ( is_array( $resume_options ) ) {
			if ( isset( $resume_options['full_name'] ) ) {
				$full_name = $resume_options['full_name'];
			} else {
				$full_name = '';
			}
		} else {
			$full_name = '';
		}

		return $full_name;

	} // resume_full_name()

	/**
	 * Returns the header options - Email 
	 */
	public static function resume_email( ) {

		$resume_options = get_option( 'living-resume-options' );

		if ( is_array( $resume_options ) ) {
			if ( isset( $resume_options['email'] ) ) {
				$email = $resume_options['email'];
			} else {
				$email = '';
			}
		} else {
			$email = '';
		}

		return $email;

	} // resume_email()

	/**
	 * Returns the header options - Telephone 
	 */
	public static function resume_telephone( ) {

		$resume_options = get_option( 'living-resume-options' );

		if ( is_array( $resume_options ) ) {
			if ( isset( $resume_options['telephone'] ) ) {
				$telephone = $resume_options['telephone'];
			} else {
				$telephone = '';
			}
		} else {
			$telephone = '';
		}

		return $telephone;

	} // resume_telephone()

	/**
	 * Returns the footer layout option
	 */
	public static function resume_footer_layout( ) {

		$footer_layout = get_post_meta( get_the_ID(), '_living_resume_footer_layout', true );

		if ( ! empty( $footer_layout ) ) {
			$footer_layout = $footer_layout;
		} else {
			$footer_layout = "none";
		}

		return $footer_layout;

	} // resume_footer_layout()

	/**
	 * Returns the footer options - Links 
	 */
	public static function resume_footer_links( ) {

		$resume_options = get_option( 'living-resume-options' );

		$available_links = array( 'linkedin', 'github', 'codepen', 'behance','alt_coderepo', 'alt_designrepo', 'twitter', 'facebook', 'google-plus' );
		
		$footer_links = array();

		if ( is_array( $resume_options ) ) {
			foreach ( $available_links as $link ) {
				if ( array_key_exists( $link, $resume_options )) {

					if ( $resume_options[$link] !== '' ) {
						$footer_links[$link] = $resume_options[$link];
					}

				}
			}
		}

		return $footer_links;

	} // resume_footer_links()

	/**
	 * Returns the resume sort order for display and print
	 */
	public static function resume_sort_order( ) {

		$default_layout = array(
			'placebo'=>'placebo',
			'_living_resume_sort_introduction'=>'Introduction',
			'_living_resume_sort_employment_history'=>'Employment History',
			'_living_resume_sort_education_history'=>'Education History',
			'_living_resume_sort_skills_block'=>'Skills',
		);

		$layout = get_post_meta( get_the_ID(), '_living_resume_sort_layout', true );

		if ( is_array( $layout ) ) {
			if ( isset( $layout['Enabled'] ) ) {
				$layout = $layout['Enabled'];
			} else {
				$layout = $default_layout;
			}
		} else {
			$layout = $default_layout;
		}

		return $layout;

	} // resume_sort_order()

	/**
	 * Returns the pdf font selection
	 */
	public static function pdf_font_family( ) {

		$resume_options = get_option( 'living-resume-options' );

		if ( is_array( $resume_options ) ) {
			if ( isset( $resume_options['pdf_font_family'] ) ) {
				$pdf_font_family = $resume_options['pdf_font_family'];
			} else {
				$pdf_font_family = "Helvetica, sans-serif";
			}
		} else {
			$pdf_font_family = "Helvetica, sans-serif";
		}

		return $pdf_font_family;

	} // pdf_font_family()

	/**
	 * Returns the project url
	 */
	public static function project_url( ) {

		$project_details = get_post_meta( get_the_ID(), '_living_resume_project_details', true );

		if ( is_array( $project_details ) ) {
			if ( isset( $project_details[0]['url'] ) ) {
				$project_url = '<a href="' . $project_details[0]['url'] .'">' . $project_details[0]['url'] .'</a>';
			} else {
				$project_url = '';
			}
		} else {
			$project_url = '';
		}

		return $project_url;

	} // project_url()

	/**
	 * Returns the project description
	 */
	public static function project_description() {
		
		$project_details = get_post_meta( get_the_ID(), '_living_resume_project_details', true );

		if ( is_array( $project_details ) ) {
			if ( isset( $project_details[0]['description'] ) ) {
				$project_description = wpautop( $project_details[0]['description'] );
			} else {
				$project_description = '';
			}
		} else {
			$project_description = '';
		}

		return $project_description;

	} // project_description()

	/**
	 * Returns the project description
	 */
	public static function project_description_excerpt( ) {
		
		$project_details = get_post_meta( get_the_ID(), '_living_resume_project_details', true );

		if ( is_array( $project_details ) ) {
			if ( isset( $project_details[0]['description'] ) ) {
				$project_description = wp_trim_words( $project_details[0]['description'], 20 );
			} else {
				$project_description = '';
			}
		} else {
			$project_description = '';
		}

		return $project_description;

	} // project_description()

	/**
	 * Returns the project images
	 */
	public static function project_images() {
		
		$project_details = get_post_meta( get_the_ID(), '_living_resume_project_details', true );

		if ( is_array( $project_details ) ) {
			if ( isset( $project_details[0]['images'] ) ) {

				$images = array();
				
				foreach( $project_details[0]['images'] as $image_id => $image_url ) {
					$images[]= $image_id . '|' .$image_url;
				}

				$project_images = array();

				$i=0;
				$prev = $next = '';
				foreach ( $images as $key => $value ) {
					$count = count( $images );

					$prev = array_key_exists($key - 1, $images) ? $images[$key - 1] : '';
					if ( isset( $prev ) && $prev != '' ) {
						$prev = explode( '|', $prev );
						$prev_link = '<a href="#img_' . $prev[0] . '"><i class="fas fa-chevron-left fa-2x previous"></i></a>';
					} else {
						$prev_link = '';
					}

					$next = array_key_exists($key + 1, $images) ? $images[$key + 1] : null;
					if ( ! is_null( $next ) ) {
						$next = explode( '|', $next );
						$next_link = '<a href="#img_' . $next[0] . '"><i class="fas fa-chevron-right fa-2x next"></i></a>';
					} else {
						$next_link = '';
					}

					$image_data = explode( '|', $images[$i] );

					//$the_image = wp_get_attachment_image( $image_data[0], 'thumbnail' );

					$image_metadata = wp_prepare_attachment_for_js( $image_data[0] );
					$thumb_url = $image_metadata['sizes']['thumbnail']['url'];
					$thumb_height = $image_metadata['sizes']['thumbnail']['height'];
					$thumb_width = $image_metadata['sizes']['thumbnail']['width'];

					if ( ! empty( $image_metadata['alt'] ) ) {
						$image_alt = $image_metadata['alt'];
					} else {
						$image_alt = '';
					}
					if ( ! empty( $image_metadata['title'] ) ) {
						$image_title = $image_metadata['title'];
					} else {
						$image_title = '';
					}
					if ( ! empty( $image_metadata['caption'] ) ) {
						$image_caption = '<div class="description">' . $image_metadata['caption'] . '</div>';
					} else {
						$image_caption = '';
					}
					

					$project_images[] = '<a href="#img_' . $image_data[0] .'" class="lr-thumb"><img src="' . $thumb_url . '" height="' . $thumb_height . '" width="' . $thumb_width . '" alt="' . $image_alt . '" title="' . $image_title . '" /></a><div id="img_' . $image_data[0] .'" class="lightbox"><a href="#_"><i class="far fa-times fa-2x exit"></i></a>' . $prev_link . '<div class="lightbox-image"><a href="#_">' . $image_caption . '<img src="' . $image_data[1] .'" /></a></div>' . $next_link . '</div>';
					$i++;
				}

			} else {
				$project_images = '';
			}
		} else {
			$project_images = '';
		}

		return $project_images;

	} // project_image()

	/**
	 * Returns the project endorsements
	 */
	public static function project_endorsements() {
		$project_endorsements = Living_Resume_Shared::get_meta_values( '_living_resume_endorsement_project', 'lr_endorsement' );

		if ( is_array( $project_endorsements ) ) {

			$endorsements = array();

			foreach ( $project_endorsements as $project_endorsement ) {
				if ( $project_endorsement['meta_value'] == get_the_ID() ) {

					$endorsed_post_id = $project_endorsement['post_id'];

					$endorsement_link = get_the_permalink( $endorsed_post_id );
					$endorsement_title = get_the_title( $endorsed_post_id );

					$endorsement_url = get_the_permalink( $endorsed_post_id );
					$endorsement_name = get_the_title( $endorsed_post_id );
					$endorsement_details = array( $endorsement_url, $endorsement_name );

					$endorsements[] = $endorsement_details;

				}
				
			}
		}

		return $endorsements;
	}

	/**
	 * Returns the endorsement content
	 */
	public static function endorsement_content() {
		
		$endorsement_content = get_post_meta( get_the_ID(), '_living_resume_endorsement_content', true );

		if ( ! empty( $endorsement_content ) ) {
			$endorsement_content = wpautop( $endorsement_content );
		} else {
			$endorsement_content = '';
		}

		return $endorsement_content;


	} // endorsement_content()

	/**
	 * Returns the endorsement company name
	 */
	public static function endorsement_company() {

		$endorsement_company = get_post_meta( get_the_ID(), '_living_resume_endorsement_company', true );

		if ( ! empty( $endorsement_company ) && $endorsement_company !== '0' ) {
			$resume_options = get_option( 'living-resume-options' );
			if ( is_array( $resume_options ) ) {
				if ( isset( $resume_options['primary_resume'] ) ) {
					$primary_resume = $resume_options['primary_resume'];
				} else {
					$primary_resume = '';
				}
			} else {
				$primary_resume = ''; // update this to find most recent memory if primary is not set
			}

			$endorsement_company = '<a href="' . get_the_permalink( $primary_resume ) . '#' . str_replace(' ', '', strtolower( get_the_title( $endorsement_company ) ) ) . '">' . get_the_title( $endorsement_company ) . '</a>';
		} else {
			$endorsement_company = '';
		}

		return $endorsement_company;

	} // endorsement_company()

	/**
	 * Returns the endorsement project link
	 */
	public static function endorsement_project() {
		
		$endorsement_project = get_post_meta( get_the_ID(), '_living_resume_endorsement_project', true );

		if ( ! empty( $endorsement_project ) && $endorsement_project !== '0' ) {
			$endorsement_project = '<a href="' . get_the_permalink( $endorsement_project ) . '">' . get_the_title( $endorsement_project ) . '</a>';
		} else {
			$endorsement_project = '';
		}

		return $endorsement_project;

	} // endorsement_project()

	/**
	 * Returns the endorsement person
	 */
	public static function endorsement_person( ) {

		$endorsement_person = get_post_meta( get_the_ID(), '_living_resume_endorsement_full_name', true );

		if ( ! empty( $endorsement_person ) ) {
			$endorsement_person = $endorsement_person;
		} else {
			$endorsement_person = '';
		}

		return $endorsement_person;

	} // endorsement_person()

}