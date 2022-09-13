<div class="row single-product-info clearfix single-style-01">
    <div class="col-md-6 mg-bottom-100 sm-mg-bottom-50">
        <div class="single-product-image">
            <?php
            /**
             * woocommerce_before_single_product_summary hook.
             *
             * @hooked woocommerce_show_product_sale_flash - 10
             * @hooked woocommerce_show_product_images - 20
             */
            do_action('woocommerce_before_single_product_summary');
            ?>
        </div>
    </div>
    <div class="col-md-6 mg-bottom-100 sm-mg-bottom-50">
        <div class="summary-product entry-summary">
            <?php
            $product_add_to_cart_enable = G5Plus_Auteur()->options()->get_product_add_to_cart_enable();
            if (!$product_add_to_cart_enable) {
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            }
            ?>

            <?php
            /**
             * woocommerce_single_product_summary hook.
             * @hooked shop_loop_rating - 4
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked shop_single_function - 60
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             */
            do_action('woocommerce_single_product_summary');
            ?>
        </div><!-- .summary -->
    </div>
</div>
