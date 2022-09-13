<div class="row single-product-info clearfix single-style-02">
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
            <div class="single-product-controls">
                <ul class="gf-inline">
                    <li>
                        <?php $prev_product = get_adjacent_post(false, '', true, 'product_cat');
                        if ($prev_product):?>
                            <?php $product = wc_get_product($prev_product->ID); ?>
                            <a href="<?php echo esc_url($product->get_permalink()); ?>" class="prev-product"
                               title="<?php esc_attr_e('Previous', 'g5plus-auteur') ?>">
                                <i class="fal fa-long-arrow-left"></i>
                            </a>
                            <div class="product-near">
                                <div class="product-near-thumb">
                                    <a href="<?php echo esc_url($product->get_permalink()); ?>"
                                       title="<?php echo esc_attr($product->get_name()); ?>">
                                        <?php echo wp_kses_post($product->get_image()); ?>
                                    </a>
                                </div>
                                <div class="product-near-info">
                                    <a href="<?php echo esc_url($product->get_permalink()); ?>"
                                       title="<?php echo esc_attr($product->get_name()); ?>"
                                       class="product-near-title">
                                        <span class="product-title"><?php echo esc_html($product->get_name()); ?></span>
                                    </a>
                                    <p class="price">
                                        <?php echo wp_kses_post($product->get_price_html()); ?>
                                    </p>
                                </div>
                            </div>
                        <?php else: ?>
                            <span class="prev-product disable fal fa-angle-left"></span>
                        <?php endif; ?>
                    </li>
                    <li>
                        <?php $next_product = get_adjacent_post(false, '', false, 'product_cat');
                        if ($next_product):?>
                            <?php $product = wc_get_product($next_product->ID); ?>
                            <a href="<?php echo esc_url(get_permalink($next_product->ID)); ?>" class="next-product"
                               title="<?php esc_attr_e('Next', 'g5plus-auteur') ?>">
                                <i class="fal fa-long-arrow-right"></i>
                            </a>
                            <div class="product-near">
                                <div class="product-near-thumb">
                                    <a href="<?php echo esc_url($product->get_permalink()); ?>"
                                       title="<?php echo esc_attr($product->get_name()); ?>">
                                        <?php echo wp_kses_post($product->get_image()); ?>
                                    </a>
                                </div>
                                <div class="product-near-info">
                                    <a href="<?php echo esc_url($product->get_permalink()); ?>"
                                       title="<?php echo esc_attr($product->get_name()); ?>"
                                       class="product-near-title">
                                        <span class="product-title"><?php echo esc_html($product->get_name()); ?></span>
                                    </a>
                                    <p class="price">
                                        <?php echo wp_kses_post($product->get_price_html()); ?>
                                    </p>
                                </div>
                            </div>
                        <?php else: ?>
                            <span class="next-product disable fal fa-angle-right"></span>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
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
