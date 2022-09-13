<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
/**
 * @var $product_id int
 */

$_product = wc_get_product($product_id);

$title = get_the_title($_product->get_id());

//Product gallery image
$attachment_ids = $_product->get_gallery_image_ids();
if (!$attachment_ids) {
    return;
}
?>
<div id="bpfw-popup" class="bpfw-preview-book">
    <div class="bpfw-popup-title">
        <h2><span><?php echo esc_html__('You are previewing: ', 'bpfw'); ?></span><?php echo esc_html($title); ?></h2>
    </div>
    <div class="bpfw-popup-content-wrapper">
        <div class="bpfw-popup-content">
            <?php
            if ($attachment_ids) {
                foreach ($attachment_ids as $attachment_id) {
                    $image = wp_get_attachment_image(
                        $attachment_id,
                        'full',
                        false,
                        apply_filters(
                            'woocommerce_gallery_image_html_attachment_image_params',
                            array(
                                'class' => 'loading',
                            ),
                            $attachment_id,
                            'full',
                            true
                        )
                    );
                    echo wp_kses_post($image);
                }
            }
            ?>
        </div>
        <div class="bpfw-preview-tools">
            <button class="bpfw-preview-zoom-in" title="<?php echo esc_attr__('Zoom in', 'bpfw') ?>">
	            <svg class="bpfw-svg-icon"><use href="#icon-plus-sign" xlink:href="#icon-plus-sign"></use></svg>
            </button>
            <button class="bpfw-preview-zoom-out" title="<?php echo esc_attr__('Zoom out', 'bpfw') ?>">
	            <svg class="bpfw-svg-icon"><use href="#icon-minus-sign" xlink:href="#icon-minus-sign"></use></svg>
            </button>
        </div>
    </div>
</div>

