<?php
/**
 * @var $post_layout
 * @var $image_ratio
 * @var $image_size
 * @var $post_class
 * @var $post_inner_class
 * @var $placeholder_enable
 * @var $post_attributes
 * @var $post_inner_attributes
 * @var $portfolio_light_box
 * @var $portfolio_item_skin
 */
/*
if (!in_array($portfolio_item_skin, array('portfolio-item-skin-01', 'portfolio-item-skin-02'))) {
    $placeholder_enable = true;
}*/
?>
<?php
$image_mode = 'background';
if ('justified' === $post_layout) {
    $image_mode = 'image';
}
?>
<article <?php echo implode(' ', $post_attributes); ?> <?php post_class($post_class) ?>>
    <div <?php echo implode(' ', $post_inner_attributes); ?> class="<?php echo esc_attr($post_inner_class); ?>">
        <div class="entry-thumbnail-wrap">
            <?php
            G5Plus_Auteur()->portfolio()->render_thumbnail_markup(array(
                'image_size' => $image_size,
                'image_ratio' => $image_ratio,
                'placeholder_enable' => $placeholder_enable,
                'portfolio_layout' => $post_layout,
                'image_mode' => $image_mode
            ));
            ?>
            <?php if (in_array($portfolio_item_skin, array('portfolio-item-skin-01', 'portfolio-item-skin-02', 'portfolio-item-skin-05'))): ?>
                <div class="portfolio-content block-center">
                    <div class="block-center-inner">
                        <div class="portfolio-action">
                            <?php G5Plus_Auteur()->helper()->getTemplate('portfolio/loop/post-zoom', array(
                                'portfolio_light_box' => $portfolio_light_box
                            )) ?>
                        </div>
                    </div>
                    <?php if (in_array($portfolio_item_skin, array('portfolio-item-skin-05'))): ?>
                        <?php G5Plus_Auteur()->helper()->getTemplate('portfolio/loop/post-title') ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="portfolio-content">
                    <div class="portfolio-content-inner">
                        <?php if ('portfolio-item-skin-03' === $portfolio_item_skin): ?>
                            <div class="portfolio-info">
                                <?php G5Plus_Auteur()->helper()->getTemplate('portfolio/loop/post-title') ?>
                                <?php G5Plus_Auteur()->helper()->getTemplate('portfolio/loop/post-category'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="portfolio-action">
                            <?php G5Plus_Auteur()->helper()->getTemplate('portfolio/loop/post-zoom', array(
                                'portfolio_light_box' => $portfolio_light_box
                            )) ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php if (!in_array($portfolio_item_skin, array('portfolio-item-skin-03', 'portfolio-item-skin-05'))): ?>
            <div class="portfolio-info">
                <?php G5Plus_Auteur()->helper()->getTemplate('portfolio/loop/post-title') ?>
                <?php G5Plus_Auteur()->helper()->getTemplate('portfolio/loop/post-category'); ?>
            </div>
        <?php endif; ?>
    </div>
</article>

