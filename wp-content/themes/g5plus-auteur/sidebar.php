<?php
/**
 * The template for displaying sidebar
 *
 */
$sidebar_layout = G5Plus_Auteur()->options()->get_sidebar_layout();
$sidebar = G5Plus_Auteur()->cache()->get_sidebar();
$sidebar_condition = apply_filters('gsf_sidebar_condition', ($sidebar_layout !== 'none' && is_active_sidebar($sidebar)));
if (!$sidebar_condition) return;
$sidebar_width = G5Plus_Auteur()->options()->get_sidebar_width();
$sidebar_sticky_enable = G5Plus_Auteur()->options()->get_sidebar_sticky_enable();
$mobile_sidebar_enable = G5Plus_Auteur()->options()->get_mobile_sidebar_enable();

$wrapper_classes = array(
	'primary-sidebar',
	'sidebar'
);

$inner_classes = array(
	'primary-sidebar-inner'
);


$sidebar_col = ($sidebar_width == 'large') ? 4 : 3;
$wrapper_classes[] = "col-lg-{$sidebar_col}";
if ($sidebar_layout === 'left') {
	$wrapper_classes[] = 'order-lg-1';
}

if ($mobile_sidebar_enable !== 'on') {
	$wrapper_classes[] = 'hidden-sm';
	$wrapper_classes[] = 'hidden-xs';
}

if ($sidebar_sticky_enable === 'on') {
	$wrapper_classes[] = 'gf-sticky';
}


$wrapper_class = implode(' ', array_filter($wrapper_classes));
$inner_class = implode(' ', array_filter($inner_classes));
?>
<div class="<?php echo esc_attr($wrapper_class); ?>">
	<div class="<?php echo esc_attr($inner_class); ?>">
        <?php do_action('gsf_before_sidebar_content'); ?>
		<?php if (is_active_sidebar($sidebar)) {
            dynamic_sidebar($sidebar);
        } ?>
        <?php do_action('gsf_after_sidebar_content'); ?>
	</div>
</div>
