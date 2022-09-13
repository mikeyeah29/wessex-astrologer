<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;
global $product;
/**
 * woocommerce_before_single_product hook.
 *
 * @hooked wc_print_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form();
    return;
}
$sidebar_layout = G5Plus_Auteur()->options()->get_sidebar_layout();
$sidebar = G5Plus_Auteur()->cache()->get_sidebar();
$sidebar_layout = ('none' === $sidebar_layout || !is_active_sidebar($sidebar)) ? '' : 'product-has-sidebar';
$product_single_layout = G5Plus_Auteur()->options()->get_product_single_layout();
$product_single_author_enable = G5Plus_Auteur()->options()->get_product_single_author_enable();


$wrapper_classes = array(
	'product-single-' . $product_single_layout,
	$sidebar_layout
);

if ($product_single_author_enable !== 'on') {
	$wrapper_classes[] = 'author-disable';
}

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class($wrapper_classes,$product); ?>>
    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     *
     * @hooked woocommerce_show_product_sale_flash - 10
     * @hooked woocommerce_show_product_images - 20
     */
    do_action( 'woocommerce_before_single_product_summary' );


    $product_add_to_cart_enable = G5Plus_Auteur()->options()->get_product_add_to_cart_enable();
    if ( ! $product_add_to_cart_enable ) {
	    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    }

    ?>

    <div class="summary entry-summary">
        <?php
        /**
         * Hook: woocommerce_single_product_summary.
         *
         * @hooked woocommerce_template_single_title - 5
         * @hooked woocommerce_template_single_rating - 10
         * @hooked woocommerce_template_single_price - 10
         * @hooked woocommerce_template_single_excerpt - 20
         * @hooked woocommerce_template_single_add_to_cart - 30
         * @hooked woocommerce_template_single_meta - 40
         * @hooked woocommerce_template_single_sharing - 50
         * @hooked WC_Structured_Data::generate_product_data() - 60
         */
        do_action( 'woocommerce_single_product_summary' );
        ?>
    </div>
    <div class="clearfix"></div>
    <?php
    if ($product_single_layout === 'layout-02') {
        echo '<div class="container">';
    }
    /**
     * woocommerce_after_single_product_summary hook.
     *
     * @hooked woocommerce_output_product_data_tabs - 10
     * @hooked woocommerce_upsell_display - 15
     * @hooked woocommerce_output_related_products - 20
     */
    do_action('woocommerce_after_single_product_summary');
    if ($product_single_layout === 'layout-02') {
        echo '</div>';
    }
    ?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>