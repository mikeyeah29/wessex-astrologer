<?php
/**
 * The template for displaying layout-1.php
 *
 */
add_action('g5plus_main_content_top',array(G5Plus_Auteur()->templates(),'post_single_image'));
get_header();
while (have_posts()) : the_post();
	G5Plus_Auteur()->helper()->getTemplate('single/layout-6/content');
endwhile;
get_footer();