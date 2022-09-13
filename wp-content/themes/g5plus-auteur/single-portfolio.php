<?php
$single_layout = G5Plus_Auteur()->options()->get_single_portfolio_layout();
get_header();
while (have_posts()) : the_post();
    G5Plus_Auteur()->helper()->getTemplate("portfolio/single/layout/{$single_layout}");
endwhile;
get_footer();
