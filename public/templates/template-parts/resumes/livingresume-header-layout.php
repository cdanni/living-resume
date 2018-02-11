<?php
/**
 * The view for the resume header used in the loop
 */

?>

<?php 
$header_layout = Living_Resume_Template_Functions::resume_header_layout();

if ( $header_layout !== "none" ) {

?>
	<div id="living-resume-header" style="text-align:<?php echo $header_layout; ?>">
		<header class="entry-header">
			<h1 class="entry-title"><?php echo Living_Resume_Template_Functions::resume_full_name(); ?></h1>
		</header><!-- .entry-header -->
		<p><?php echo Living_Resume_Template_Functions::resume_email(); ?>
		<br /><?php echo Living_Resume_Template_Functions::resume_telephone(); ?></p>
	</div>
<?php
}