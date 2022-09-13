<?php
/**
 * Template display product title
 *
 */
$product_rating_enable = G5Plus_Auteur()->options()->get_product_rating_enable();
$title = get_the_title();
?>
<?php if (!empty($title)): ?>
<h4 class="product-name product_title<?php echo esc_attr($product_rating_enable === 'on' ? ' product-title-rating' : ''); ?>">
    <a class="gsf-link" href="<?php the_permalink(); ?>"><?php echo esc_html($title); ?></a>
</h4>
<?php endif; ?>
