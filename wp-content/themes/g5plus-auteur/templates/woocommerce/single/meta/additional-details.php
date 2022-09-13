<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
/**
 * @var $additional_details
 */

?>
<?php foreach ($additional_details as $additional_detail): ?>
    <?php if (isset($additional_detail['title']) && !empty($additional_detail['title']) && isset($additional_detail['value']) && !empty($additional_detail['value'])): ?>
		<span class="<?php echo esc_attr(sanitize_title($additional_detail['title']))?>"><label><?php echo wp_kses_post($additional_detail['title'])?>:</label> <span><?php echo wp_kses_post($additional_detail['value']) ?></span></span>
    <?php endif; ?>
<?php endforeach; ?>