<?php
defined('ABSPATH') || exit;

if (!function_exists('wc_get_gallery_image_html')) {
    return;
}

remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);

global $product;

//product back image
$bpfw_back_id = get_post_meta(get_the_ID(), 'bpfw_back_img', true);
if ($bpfw_back_id !== '') {
    $image_attributes = wp_get_attachment_image_src($bpfw_back_id, 'full');
}
//Product gallery image
$attachment_ids = $product->get_gallery_image_ids();

$columns = apply_filters('woocommerce_product_thumbnails_columns', 4);
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes = apply_filters('woocommerce_single_product_image_gallery_classes', array(
    'woocommerce-product-gallery',
    'woocommerce-product-gallery--' . ($post_thumbnail_id ? 'with-images' : 'without-images'),
    'woocommerce-product-gallery--columns-' . absint($columns),
    'images'
));

//img
$image = wp_get_attachment_image(
    $post_thumbnail_id,
    'woocommerce_single',
    false,
    apply_filters(
        'woocommerce_gallery_image_html_attachment_image_params',
        array(
            'class' => esc_attr('wp-post-image'),
        ),
        $post_thumbnail_id,
        'woocommerce_single',
        true
    )
);

?>
<div class="<?php echo esc_attr(implode(' ', array_map('sanitize_html_class', $wrapper_classes))); ?>"
     data-columns="<?php echo esc_attr($columns); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
    <div class="bpfw-images">
        <figure class="woocommerce-product-gallery__wrapper bpfw-flip-wrapper">
            <?php
            if ($post_thumbnail_id) {
                echo wp_kses_post($image);
            } else {
                echo sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_attr__('Awaiting product image', 'bpfw'));
            }
            if ($post_thumbnail_id) {
                $html = '<div class="bpfw-flip bpfw-flip-front">' . $image . '</div>';
            } else {
                $html = '<div class="bpfw-flip bpfw-flip-front">';
                $html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_attr__('Awaiting product image', 'bpfw'));
                $html .= '</div>';
            }
            echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);
            ?>
            <?php if (($bpfw_back_id !== '') && (($image_attributes[0]) !== '')): ?>
                <div class="bpfw-flip bpfw-flip-back">
                    <img src="<?php echo esc_url($image_attributes[0]); ?>" alt="Back Cover">
                </div>
            <?php endif; ?>
            <div class="bpfw-flip bpfw-flip-first-page"></div>
            <div class="bpfw-flip bpfw-flip-second-page"></div>
            <div class="bpfw-flip bpfw-flip-side"></div>
            <div class="bpfw-flip bpfw-flip-side-paper"></div>
        </figure>
        <div class="bpfw-btn-action">
            <?php if ($bpfw_back_id !== ''): ?>
                <a href="#" class="bpfw-btn bpfw-action-flip">
	                <svg class="bpfw-svg-icon"><use href="#icon-back-arrow" xlink:href="#icon-back-arrow"></use></svg>
	                <span><?php echo esc_html__('Flip to Back', 'bpfw'); ?></span>
                </a>
            <?php endif; ?>
            <?php if ($attachment_ids): ?>
                <a href="<?php echo esc_url(wp_nonce_url(admin_url("admin-ajax.php?action=bpfw_read_book&product_id={$product->get_id()}"), 'acds_read_book_action', 'acds_read_book_nonce')) ?>" class="bpfw-btn bpfw-action-read-book">
	                <svg class="bpfw-svg-icon"><use href="#icon-eye" xlink:href="#icon-eye"></use></svg>
                    <span><?php echo esc_html__('Look inside', 'bpfw'); ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
