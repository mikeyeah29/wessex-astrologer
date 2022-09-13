<?php
G5Plus_Auteur()->helper()->get_header();
$portfolio_cate_filter = G5Plus_Auteur()->options()->get_portfolio_cate_filter();
$query_args = $settings = null;
if('' !== $portfolio_cate_filter) {
    $settings['category_filter_enable'] = true;
    if (is_tax('portfolio_cat')) {
        global $wp_query;
        if (isset($wp_query->queried_object)) {
            $settings['current_cat'] = $wp_query->queried_object->term_id;
        }
    }
}
G5Plus_Auteur()->portfolio()->archive_markup($query_args,$settings);
G5Plus_Auteur()->helper()->get_footer();