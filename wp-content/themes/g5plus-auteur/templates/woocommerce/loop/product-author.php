<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 11/12/2018
 * Time: 10:45 SA
 */
global $product;
// show product author
$author_enable = G5Plus_Auteur()->options()->get_product_author_enable();
if('on' === $author_enable) {
    echo get_the_term_list( $product->get_id(), 'product_author', '<div class="product-author"><span>' . esc_html__( 'By', 'g5plus-auteur' ) . '</span>', ', ', '</div>' );
}