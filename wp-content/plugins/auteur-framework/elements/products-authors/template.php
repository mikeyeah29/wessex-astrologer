<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @var $element UBE_Element_Auteur_Products_Authors
 */

$atts            = $element->get_settings();
$wrapper_classes = array(
	'gf-product-authors',
	'ube-product-authors',
);
$element->set_render_attribute( 'wrapper', array(
	'class' => $wrapper_classes
) );


$query_args = array(
	'taxonomy'   => 'product_author',
	'hide_empty' => true,
	'number'     => $atts['items_per_page'],
);

$atts['columns_xl'] = absint( $atts['columns']['xl'] );
$atts['columns_lg'] = $atts['columns']['lg'] == '' ? $atts['columns_xl'] : absint( $atts['columns']['lg'] );
$atts['columns_md'] = $atts['columns']['md'] == '' ? $atts['columns_lg'] : absint( $atts['columns']['md'] );
$atts['columns_sm'] = $atts['columns']['sm'] == '' ? $atts['columns_md'] : absint( $atts['columns']['sm'] );
$atts['columns']    = $atts['columns']['xs'] == '' ? $atts['columns_sm'] : absint( $atts['columns']['xs'] );
if ( $atts['is_slider'] == 'on' ) {
	$atts['post_paging'] = 'none';
}
$settings = array(
	'columns'        => $atts['columns'],
	'columns_xl'     => $atts['columns_xl'],
	'columns_lg'     => $atts['columns_lg'],
	'columns_md'     => $atts['columns_md'],
	'columns_sm'     => $atts['columns_sm'],
	'columns_gutter' => $atts['post_columns_gutter'],
	'post_paging'    => $atts['post_paging'],
	'taxonomy'       => 'product_author',

	'authors'          => $atts['authors'],
	'image_size'       => $atts['image_size'],
	'is_slider'        => $atts['is_slider'],
	'dots'             => $atts['dots'],
	'nav'              => $atts['nav'],
	'autoplay'         => $atts['autoplay'],
	'nav_style'        => $atts['nav_style'],
	'autoplay_timeout' => $atts['autoplay_timeout'],
	'nav_position'     => $atts['nav_position'],
	'nav_size'         => $atts['nav_size'],
	'nav_hover_scheme' => $atts['nav_hover_scheme'],
	'nav_hover_style'  => $atts['nav_hover_style'],

);

?>
<div <?php $element->print_render_attribute_string( 'wrapper' ) ?>>
	<?php if ( function_exists( 'G5Plus_Auteur' ) ) {
		G5Plus_Auteur()->authors()->archive_markup( $query_args, $settings );
	} ?>
</div>

