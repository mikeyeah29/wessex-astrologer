<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */
G5Plus_Auteur()->helper()->get_header();
$blog_cate_filter = G5Plus_Auteur()->options()->get_blog_cate_filter();
$query_args = $settings = null;
if('' !== $blog_cate_filter) {
    $settings['category_filter_enable'] = true;
}
G5Plus_Auteur()->blog()->archive_markup($query_args,$settings);
G5Plus_Auteur()->helper()->get_footer();