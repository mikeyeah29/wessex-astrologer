<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$product_cross_sells_enable = G5Plus_Auteur()->options()->get_product_cross_sells_enable();
if('on' !== $product_cross_sells_enable) return;

$product_cross_sells_gutter = intval(G5Plus_Auteur()->options()->get_product_cross_sells_columns_gutter());
$product_columns = intval(G5Plus_Auteur()->options()->get_product_cross_sells_columns());
$product_columns_md = intval(G5Plus_Auteur()->options()->get_product_cross_sells_columns_md());
$product_columns_sm = intval(G5Plus_Auteur()->options()->get_product_cross_sells_columns_sm());
$product_columns_xs = intval(G5Plus_Auteur()->options()->get_product_cross_sells_columns_xs());
$product_columns_mb = intval(G5Plus_Auteur()->options()->get_product_cross_sells_columns_mb());
$product_animation = G5Plus_Auteur()->options()->get_product_cross_sells_animation();

$settings = array(
    'post_layout'            => 'grid',
    'post_columns'           => array(
        'xl' => $product_columns,
        'lg' => $product_columns_md,
        'md' => $product_columns_sm,
        'sm' => $product_columns_xs,
    ),
    'post_columns_gutter'    => $product_cross_sells_gutter,
    'post_paging'            => 'none',
    'post_animation'         => $product_animation,
    'itemSelector'           => 'article',
    'category_filter_enable' => false,
    'post_type' => 'product'
);
$settings['carousel_class'] = 'gsf-slider-container item-gutter-' . $product_cross_sells_gutter;
$settings['carousel'] = array(
    'items' => $product_columns,
    'margin' => 0,
    'slideBy' => $product_columns,
    'dots' => true,
    'responsive' => array(
        '1200' => array(
            'items' => $product_columns,
            'slideBy' => $product_columns,
        ),
        '992' => array(
            'items' => $product_columns_md,
            'slideBy' => $product_columns_md,
        ),
        '768' => array(
            'items' => $product_columns_sm,
            'slideBy' => $product_columns_sm,
        ),
        '576' => array(
            'items' => $product_columns_xs,
            'slideBy' => $product_columns_xs,
        ),
        '0' => array(
            'items' => $product_columns_mb,
            'slideBy' => $product_columns_mb,
        )
    ),
    'autoHeight' => true,
);


G5Plus_Auteur()->blog()->set_layout_settings($settings);

if ( $cross_sells ) : ?>

	<div class="cross-sells">

		<h2 class="gf-heading-title"><?php esc_html_e( 'You may be interested in&hellip;', 'g5plus-auteur' ) ?></h2>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
				 	$post_object = get_post( $cross_sell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
G5Plus_Auteur()->blog()->unset_layout_settings();