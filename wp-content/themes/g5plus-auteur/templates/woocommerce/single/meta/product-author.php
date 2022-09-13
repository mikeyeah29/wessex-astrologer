<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
global $product;
$terms = wc_get_product_terms( $product->get_id(), 'product_author', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
echo get_the_term_list($product->get_id(),'product_author','<span class="posted_in"><label>' . _n( 'Author:', 'Authors:', count( $terms ), 'g5plus-auteur' ) . '</label> ', ', ', '</span>');