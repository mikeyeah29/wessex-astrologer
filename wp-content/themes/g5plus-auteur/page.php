<?php
/**
 * The template for displaying page
 *
 */
get_header();
	while (have_posts()) : the_post();
		G5Plus_Auteur()->helper()->getTemplate('content-page');
	endwhile;
get_footer();