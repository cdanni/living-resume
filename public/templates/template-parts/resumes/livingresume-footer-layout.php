<?php
/**
 * The view for the resume footer used in the loop
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
	<div id="living-resume-footer" class="lr-section" style="text-align:<?php echo $footer_layout; ?>;">
		<h2 class="entry-title">Connect with me</h2>
		<ul>
		<?php 
		$have_icons = array( 'linkedin', 'github', 'codepen', 'behance','twitter', 'facebook', 'google-plus' );

		foreach ( $footer_links as $network => $link ){
			if ( in_array( $network, $have_icons ) ) {
			?>
				<li class="list-inline"><a href="<?php echo $link; ?>"><i class="fa fa-<?php echo $network; ?> fa-2x" aria-hidden="true"></i>&nbsp;<?php echo $network; ?></a></li>
			<?php
			} else {
				if ( $network == "alt_coderepo" ) {
				?>
					<li class="list-inline"><a href="<?php echo $link; ?>"><i class="fa fa-code fa-2x" aria-hidden="true"></i>&nbsp;Code Repository</a></li>
				<?php
				} elseif ( $network == "alt_designrepo" ) {
				?>
					<li class="list-inline"><a href="<?php echo $link; ?>"><i class="fa fa-picture-o fa-2x" aria-hidden="true"></i>&nbsp;Design Repository</a></li>
				<?php
				}
			}
		}

		?>
		</ul>
	</div>
<?php
}