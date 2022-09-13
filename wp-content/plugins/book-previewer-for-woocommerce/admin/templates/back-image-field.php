<?php
/**
 * @var $post WP_Post
 */
$meta_key = 'bpfw_back_img';
$back_image = get_post_meta($post->ID, $meta_key, true);
$image_attributes = wp_get_attachment_image_src($back_image, 'full');
$back_image_classes = 'bpfw-back-image-wrap';
if ($image_attributes && count($image_attributes) > 0) {
	$back_image_classes .= ' has-back-image';
}
?>
<div class="<?php echo esc_attr($back_image_classes) ?>">
	<input type="hidden" name="<?php echo esc_attr($meta_key); ?>"
	       id="<?php echo esc_attr($meta_key); ?>"
	       value="<?php echo esc_attr($back_image); ?>" class="back-image-id"/>
	<?php wp_nonce_field('bpfw_back_image_save', 'bpfw_back_image_nonce'); ?>
	<a href="#" class="bpfw-back-image">
		<?php if ($image_attributes && (!empty($image_attributes[0]))): ?>
			<img src="<?php echo esc_url($image_attributes[0]) ?>"/>
		<?php endif; ?>
	</a>
	<p><?php esc_html_e('Click the image to edit or update','bpfw') ?></p>
	<a href="#" class="bpfw-set-image-button" data-title="<?php esc_attr_e('Product Back Image', 'bpfw'); ?>"
	   data-button="<?php esc_attr_e('Use this image', 'bpfw'); ?>"><?php esc_html_e('Set product back image', 'bpfw'); ?></a>
	<a href="#" class="bpfw-remove-image-button"><?php esc_html_e('Remove product back image', 'bpfw'); ?></a>
</div>