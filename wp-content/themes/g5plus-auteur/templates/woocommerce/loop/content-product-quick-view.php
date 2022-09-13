<?php
/**
 * The template for displaying product quick-views
 *
 */
global $product;
?>
<div id="popup-product-quick-view-wrapper" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="product-quickview-navigation">
        <?php $prev_product = get_adjacent_post(false, '', true, 'product_cat');
        if($prev_product):?>
            <a href="<?php echo esc_url(get_permalink($prev_product->ID)); ?>" data-product_id="<?php echo esc_attr($prev_product->ID); ?>" class="prev-product product-quick-view" title="<?php echo esc_attr($prev_product->post_title); ?>">
                <i class="fal fa-angle-left"></i>
            </a>
        <?php else: ?>
            <span class="prev-product disable fal fa-angle-left"></span>
        <?php endif; ?>
        <?php $next_product = get_adjacent_post(false, '', false, 'product_cat');
        if($next_product):?>
            <a href="<?php echo esc_url(get_permalink($next_product->ID)); ?>" data-product_id="<?php echo esc_attr($next_product->ID); ?>" class="next-product product-quick-view" title="<?php echo esc_attr($next_product->post_title); ?>">
                <i class="fal fa-angle-right"></i>
            </a>
        <?php else: ?>
            <i class="fal fa-angle-right"></i>
            <span class="next-product disable fal fa-angle-right"></span>
        <?php endif; ?>
    </div>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<a class="popup-close fas fa-times" data-dismiss="modal" href="javascript:;"></a>
			<div class="modal-body">
				<div class="woocommerce">
					<div itemscope id="product-<?php the_ID(); ?>" <?php wc_product_class('product product-single-layout-01'); ?>>
						<div class="single-product-info quick-view-product-image clearfix">
                            <?php
                            /**
                             * Hook: woocommerce_before_single_product_summary.
                             *
                             * @hooked woocommerce_show_product_sale_flash - 10
                             * @hooked woocommerce_show_product_images - 20
                             */
                            do_action( 'woocommerce_before_single_product_summary' );
                            ?>
                            <div class="summary entry-summary">
                                <?php
                                $product_add_to_cart_enable = G5Plus_Auteur()->options()->get_product_add_to_cart_enable();
                                if ('on' !== $product_add_to_cart_enable) {
                                    remove_action('woocommerce_quick_view_product_summary','woocommerce_template_single_add_to_cart',30);
                                }
                                ?>
                                <?php
                                /**
                                 * woocommerce_quick_view_product_summary hook.
                                 *
                                 * @hooked shop_loop_quick_view_product_title - 5
                                 * @hooked shop_loop_rating - 10
                                 * @hooked woocommerce_template_single_price - 10
                                 * @hooked woocommerce_template_single_excerpt - 20
                                 * @hooked woocommerce_template_single_add_to_cart - 30
                                 * @hooked woocommerce_template_single_meta - 40
                                 * @hooked woocommerce_template_single_sharing - 50
                                 * @hooked shop_single_function - 60
                                 */
                                do_action( 'woocommerce_quick_view_product_summary' );
                                ?>

                            </div><!-- .summary -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>