<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @var $element UBE_Element_Auteur_Portfolios_Slider
 */

$atts = $element->get_settings();
$wrapper_classes = array(
	'gf-portfolios',
	'clearfix',
	'ube-portfolio',
);
$element->set_render_attribute('wrapper', array(
	'class' => $wrapper_classes
));

$show = isset($atts['show']) ? $atts['show'] : '';
$post_image_size = isset($atts['image_size']) ? $atts['image_size'] : 'medium';
$post_image_width = isset($atts['post_image_width']) ? $atts['post_image_width'] : '400';
$post_layout = isset($atts['post_layout']) ? $atts['post_layout'] : 'grid';
$item_skin = isset($atts['item_skin']) ? $atts['item_skin'] : 'portfolio-item-skin-01';
$post_image_ratio_width = isset($atts['post_image_ratio_width']) ? $atts['post_image_ratio_width'] : '';
$post_image_ratio_height = isset($atts['post_image_ratio_height']) ? $atts['post_image_ratio_height'] : '';


$settings = array(
	'post_layout' => $post_layout,
	'portfolio_item_skin' => $item_skin,
	'image_size' => $post_image_size,
	'image_width' => array(
		'width' => $post_image_width
	),
	'image_ratio_custom' => array(
		'width' => $post_image_ratio_width,
		'height' => $post_image_ratio_height
	)
);

if ('on' === $atts['show_cate_filter']) {
	$settings['category_filter_enable'] = true;
	$settings['category_filter_vertical'] = false;
	$settings['portfolio_cate_filter'] = $atts['cate_filter_align'];
}

if ($atts['light_box'] !== '') {
	$settings['portfolio_light_box'] = $atts['light_box'];
}

if ('justified' === $post_layout) {
	$settings['portfolio_row_height'] = $atts['image_justified_width'];
	$settings['portfolio_row_max_height'] = $atts['image_justified_height'];
}

$query_args = array(
	'post_type' => 'portfolio',
);
$atts['is_slider'] = true;
$element->prepare_display($atts,$query_args,$settings);
?>
<div <?php $element->print_render_attribute_string('wrapper') ?>>
	<?php if (function_exists('G5Plus_Auteur')) {G5Plus_Auteur()->portfolio()->archive_markup($element->_query_args, $element->_settings);}  ?>
</div>


