<?php
add_filter('wc_get_template', 'bpfw_change_template_product_image', 10, 2);
function bpfw_change_template_product_image($template, $template_name)
{
    if ($template_name === 'single-product/product-image.php') {
        return BPFW()->locate_template('product-image.php');
    }
    return $template;
}

add_action('save_post', 'bpfw_save');
function bpfw_save($post_id)
{
    if (!isset($_POST['bpfw_back_image_nonce']) || !wp_verify_nonce($_POST['bpfw_back_image_nonce'], 'bpfw_back_image_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;

    update_post_meta($post_id, 'bpfw_back_img', sanitize_text_field($_POST['bpfw_back_img']));
    return $post_id;
}

add_action('wp_footer', 'bpfw_add_svg_icons', 9999);
function bpfw_add_svg_icons() {
	BPFW()->load_file(BPFW()->plugin_dir('templates/svg-icons.php'));
}