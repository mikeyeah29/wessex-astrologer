<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 03/12/2018
 * Time: 8:47 SA
 */
global $product;
$product_quick_view = G5Plus_Auteur()->options()->get_product_quick_view_enable();
if ('on' !== $product_quick_view) return;
?>
<a title="<?php esc_attr_e('Quick view', 'g5plus-auteur') ?>" class="product-quick-view no-animation btn btn-accent btn-icon-left" data-product_id="<?php echo esc_attr($product->get_id()); ?>" href="<?php the_permalink(); ?>"><i class="fal fa-book"></i><?php esc_html_e('Quick view', 'g5plus-auteur') ?></a>