<?php
/**
 * The view for the project details used in the archive
 */

?>
<article id="<?php echo the_ID(); ?>" <?php post_class(); ?>>
	<h2 class="entry-title"><a href="<?php echo get_permalink( ); ?>"><?php echo the_title(); ?></a></h2>
	<div class="entry-content"><?php echo wp_trim_words( Living_Resume_Template_Functions::project_description(), 40, '...' ); ?></div>
</article>