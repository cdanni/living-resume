<?php
/**
 * The view for the pdf resume footer used in the loop
 */

?>

<?php 
$footer_layout = Living_Resume_Template_Functions::resume_footer_layout();

if ( $footer_layout !== "none" ) {

	// grabbing the footer links
	$footer_links = Living_Resume_Template_Functions::resume_footer_links(); 

	// if array is emtpy, just quit now, no point in going any further
	if ( empty( $footer_links ) ) {
		return;
	}

?>
	<div id="living-resume-footer"  class="lr-justify lr-section" style="text-align:<?php echo $footer_layout; ?>">
		<h2 class="entry-title">Connect with me</h2>
		<?php 

		foreach ( $footer_links as $link ){
			?>
			<a href="<?php echo $link; ?>"><?php echo $link; ?></a><br />
			<?php
		}

		?>
	</div>
<?php
}