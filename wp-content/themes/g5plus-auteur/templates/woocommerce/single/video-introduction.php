<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 19/07/2018
 * Time: 9:32 SA
 */
$video = G5Plus_Auteur()->metaBoxProduct()->get_product_single_video();
if(empty($video) || !has_post_thumbnail()) return;
$thumb_url = G5Plus_Auteur()->themeUrl('assets/images/play-video.jpg');
?>
<div class="single-product-video woocommerce-product-gallery__image hidden" data-thumb="<?php echo esc_url($thumb_url); ?>">
    <?php if (wp_oembed_get($video) !== false): ?>
        <div class="embed-responsive embed-responsive-16by9">
            <?php echo wp_oembed_get($video, array('wmode' => 'transparent')); ?>
        </div>
    <?php else: ?>
        <div class="embed-responsive embed-responsive-16by9">
            <?php echo wp_kses_post($video); ?>
        </div>
    <?php endif;?>
</div>
