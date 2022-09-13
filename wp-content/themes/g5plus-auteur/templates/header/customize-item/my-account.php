<?php
/**
 * @var $customize_location
 */
if (!class_exists('WooCommerce')) {
    return;
}
?>
<div class="header-customize-item item-my-account fold-out hover">
    <a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="gsf-link transition03"
       title="<?php esc_attr_e('My Account', 'g5plus-auteur'); ?>"><i class="fal fa-user"></i></a>
</div>