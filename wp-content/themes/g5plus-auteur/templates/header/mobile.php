<?php
/**
 * The template for displaying mobile
 *
 */
$mobile_header_layout = G5Plus_Auteur()->options()->get_mobile_header_layout();
$mobile_header_float_enable = G5Plus_Auteur()->options()->get_mobile_header_float_enable();
$mobile_header_sticky = G5Plus_Auteur()->options()->get_mobile_header_sticky();
$mobile_header_border = G5Plus_Auteur()->options()->get_mobile_header_border();

$mobile_header_classes = array(
	'mobile-header',
	$mobile_header_layout
);
$header_attributes = array();
if ($mobile_header_float_enable === 'on') {
    $mobile_header_classes[] = 'header-float';
}
$mobile_header_classes = array_merge($mobile_header_classes);

if('' !== $mobile_header_sticky) {
    $header_attributes[] = 'data-sticky-type="'. $mobile_header_sticky .'"';
}
$mobile_header_class = implode(' ',array_filter($mobile_header_classes));
?>
<header <?php echo implode(' ',$header_attributes)?> class="<?php echo esc_attr($mobile_header_class) ?>">
	<?php G5Plus_Auteur()->helper()->getTemplate('header/mobile/top-bar'); ?>
	<?php G5Plus_Auteur()->helper()->getTemplate("header/mobile/{$mobile_header_layout}",array(
		'header_layout' => $mobile_header_layout,
		'header_border' => $mobile_header_border,
        'header_sticky' => $mobile_header_sticky
	)); ?>
	<?php G5Plus_Auteur()->helper()->getTemplate('header/mobile/search', array('header_border' => $mobile_header_border)); ?>
</header>
