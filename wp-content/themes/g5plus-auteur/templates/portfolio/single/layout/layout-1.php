<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 9/20/2017
 * Time: 10:32 AM
 */
?>
<div class="gf-single-portfolio-wrap portfolio-single-layout-1 clearfix">
    <div id="post-<?php the_ID(); ?>" <?php post_class('portfolio-single clearfix layout-1'); ?>>
        <div class="portfolio-item-head d-flex flex-wrap justify-content-between align-items-end">
            <div class="portfolio-item-title">
                <div class="portfolio-cat">
                    <?php G5Plus_Auteur()->portfolio()->the_category(' / ') ?>
                </div>
                <?php G5Plus_Auteur()->helper()->getTemplate('portfolio/single/portfolio-title') ?>
            </div>
            <?php do_action('g5plus_portfolio_share') ?>
        </div>
        <?php G5Plus_Auteur()->helper()->getTemplate('portfolio/single/portfolio-gallery'); ?>
        <div class="gf-portfolio-content row">
            <div class="portfolio-content-inner col-md-6 col-sm-12 sm-mg-bottom-40">
                <div class="gf-entry-content clearfix ">
                    <?php
                    the_content();
                    G5Plus_Auteur()->blog()->link_pages();
                    ?>
                </div>
            </div>
            <div class="gf-portfolio-meta-wrap col-md-6 col-sm-12">
                <?php G5Plus_Auteur()->helper()->getTemplate('portfolio/single/portfolio-meta', array('layout' => 'horizontal')) ?>
            </div>
        </div>
    </div>
    <?php
    /**
     * @hooked - portfolio_related - 10
     *
     **/
    do_action('g5plus_after_single_portfolio')
    ?>
</div>