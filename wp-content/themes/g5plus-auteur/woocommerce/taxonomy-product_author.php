<?php
/**
 * The Template for displaying products in a product author. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product_author.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$query_args = $settings = null;
G5Plus_Auteur()->helper()->get_header('shop');

$settings['shop_catalog_filter'] = false;
global $wp_query;
if (!isset($wp_query->queried_object)) {
    G5Plus_Auteur()->helper()->get_footer('shop');
    return;
}
$term = $wp_query->queried_object;
$id = $term->term_id;
$slug = $term->slug;
$term_description = $term->description;
$img = G5Plus_Auteur()->termMeta()->get_product_author_thumb($id);
$img_id = isset($img['id']) && !empty($img['id']) ? $img['id'] : '';

$author_quote = G5Plus_Auteur()->termMeta()->get_product_author_quote($id);
$addition_details = G5Plus_Auteur()->termMeta()->get_author_additional_details($id);
$social_networks = G5Plus_Auteur()->termMeta()->get_author_social_networks($id);

$author_name = $term->name;
?>
<div class="single-author-info row mg-bottom-100 pd-bottom-25 md-mg-bottom-60 sm-mg-bottom-40">
    <div class="single-author-thumbnail col-md-5 sm-mg-bottom-50">
        <div class="author-thumbnail-inner">
            <?php
            G5Plus_Auteur()->blog()->render_post_image_markup(array(
                'image_id'          => $img_id,
                'image_size'        => '300x400',
                'display_permalink' => false,
                'image_mode'        => 'background'
            ));
            ?>
        </div>
    </div>
    <div class="author-details col-lg-6 col-md-7">
        <div class="author-info hover-light">
            <h3 class="author-name mg-top-10"><?php echo esc_html($author_name) ?></h3>
	        <?php if (!empty($author_quote)): ?>
            <p class="author-quote">"<?php echo wp_kses_post($author_quote); ?>"</p>
			<?php endif; ?>
	        <?php if (!empty($term_description)): ?>
            <p class="author-description fs-15 mg-bottom-25"><?php echo wp_kses_post(wpautop($term_description)); ?></p>
			<?php endif; ?>
            <?php if(!empty( $addition_details )): ?>
                <div class="author-addition-details">
                    <?php foreach ($addition_details as $detail): ?>
                        <div class="author-detail-item">
                            <span class="detail-title"><?php echo esc_html(isset($detail['title']) ? $detail['title'] : ''); ?></span>
                            <span class="detail-value"><?php echo esc_html(isset($detail['value']) ? $detail['value'] : ''); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php G5Plus_Auteur()->helper()->getTemplate('woocommerce/loop/product-author-socials', array('social_networks' => $social_networks))?>
        </div>
    </div>
</div>
<div class="author-books">
    <h2 class="gf-heading-title fs-48 mg-bottom-70 md-mg-bottom-50"><?php esc_html_e("Author's books", 'g5plus-auteur'); ?></h2>
    <?php
    /**
     * woocommerce_before_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
     * @hooked woocommerce_breadcrumb - 20
     * @hooked WC_Structured_Data::generate_website_data() - 30
     */
    do_action( 'woocommerce_before_main_content' );

    G5Plus_Auteur()->woocommerce()->archive_markup($query_args, $settings);

    /**
     * woocommerce_after_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
     */
    do_action( 'woocommerce_after_main_content' );
    ?>
</div>
<?php
G5Plus_Auteur()->helper()->get_footer('shop');