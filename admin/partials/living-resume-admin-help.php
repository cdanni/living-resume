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

	<h3>Getting Started</h3>

	<p>The settings contain information about you, your social networks, and options for PDF printing and selecting your primary resume. The purpose of the primary resume is to have a single resume to link an Endorsement back to if a company Endorsement is given.</p>
	<p><?php echo __( 'To get started building your resume, review the <a href="' . admin_url( 'edit.php?post_type=lr_resume&page=living-resume-settings' ) . '">resume settings</a>.', 'living-resume' ); ?>
	</p>

	<h3>Companies</h3>
	<p>Companies are created as single posts for ease of reuse, but only the company name and link to the company website is used at this time. Dates and locations are not included as you may have worked for the same company twice, or in two seperate locations. Creating them as post types also allows for easier functionality of the Endorsement public facing form.</p>
	<p><?php echo __( 'To get started entering companies, go to the <a href="' . admin_url( 'edit.php?post_type=lr_company' ) . '">company post type</a>.', 'living-resume' ); ?>
	</p>

	<h3>Projects</h3>
	<p>Projects are created as single posts for ease of reuse, and can include as many details as you like, as well as a small gallery of accompanying images that will display in a simple lightbox. Projects also have their own custom taxonomy so you can assign the skills and/or tools used to complete the project. These skills and tools will be made available to you to select to add to your resume.</p>
	<p><?php echo __( 'To get started entering projects, go to the <a href="' . admin_url( 'edit.php?post_type=lr_project' ) . '">project post type</a>.', 'living-resume' ); ?>
	</p>

	<h3>Resumes</h3>
	<p>You can create as many resumes as you wish. You can either link directly to a resume post type, or use a shortcode to show your resume in any page or post on your site. A shortcode generator button is available for you in the content area of any page or post. You can override the resume templates by adding template files in your theme.</p>
	<p>To use a custom list template in a theme, copy the file from public/templates into a templates folder in your theme using the same folder structure as the file you are duplicating. Customize as needed, but keep the template functions and file name as-is. The plugin will automatically use your custom template file instead of the ones included in the plugin.</p>
	<p><?php echo __( 'To get started entering projects, go to the <a href="' . admin_url( 'edit.php?post_type=lr_resume' ) . '">resume post type</a>.', 'living-resume' ); ?>
	</p>

	<h3>Endorsements</h3>
	<p>You can allow people to add endorsements on the front end by using a shortcode. A shortcode generator button is available for you in the content area of any page or post.</p>
	<p>When an endorsement is added from the front end, it is added in as a pending post so you can review it. It will not appear on the site until you publish it. Additionally, you can add endorsements yourself if they have been emailed to you. In the endorsement, there is an opportunity to select if the endorsement is related to a particular company or project, or both.</p>
	<p>Endorsements related to a particular company will flow into the online version of your resume automatically. Additionally, when viewing the endorsement, there will be a link to your primary resume that jumps to that particular company. If you have worked at the same company multiple times, the endorsement will only link to the first instance it comes across in your resume, and will only display in the first instance.</p>
	<p><?php echo __( 'To get started with endorsements, go to the <a href="' . admin_url( 'edit.php?post_type=lr_endorsement' ) . '">endorsement post type</a>.', 'living-resume' ); ?>
	</p>

	<h3>PDF Printing</h3>
	<p>You can save and print a very basic PDF version of your resume from the resume post type page. From that page, click Export Resume as PDF.</p>
	<p>This option is not available on the front end as it is resource intensive.</p>
	<p><?php echo __( 'To get started with PDFs, go to the <a href="' . admin_url( 'edit.php?post_type=lr_resume' ) . '">resume post type</a>.', 'living-resume' ); ?>
	</p>
</div>