<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $authors
 * @var $image_size
 * @var $items_per_page
 * @var $is_slider
 * @var $dots
 * @var $nav
 * @var $nav_position
 * @var $nav_size
 * @var $nav_style
 * @var $nav_hover_scheme
 * @var $nav_hover_style
 * @var $autoplay
 * @var $autoplay_timeout
 * @var $columns_gutter
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * @var $post_paging
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Product_Authors
 */

$authors = $image_size = $items_per_page = $is_slider = $dots = $nav = $nav_position = $nav_size =
$nav_style = $nav_hover_scheme = $nav_hover_style = $autoplay = $autoplay_timeout = $columns_gutter =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = $post_paging = '';
$atts    = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
if ( ! function_exists( 'G5Plus_Auteur' ) ) {
	return;
}
$wrapper_classes = array(
	'gf-product-authors',
	G5P()->core()->vc()->customize()->getExtraClass( $el_class ),
	$this->getCSSAnimation( $css_animation ),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

if ( '' !== $css_animation && 'none' !== $css_animation ) {
	$animation_class   = G5P()->core()->vc()->customize()->get_animation_class( $animation_duration, $animation_delay );
	$wrapper_classes[] = $animation_class;
}

$query_args = array(
	'taxonomy'   => 'product_author',
	'hide_empty' => true,
	'number'     => $items_per_page,
);

$settings = array(
	'columns'        => $columns_mb,
	'columns_xl'     => $columns,
	'columns_lg'     => $columns_md,
	'columns_md'     => $columns_sm,
	'columns_sm'     => $columns_xs,
	'columns_gutter' => $columns_gutter,
	'post_paging'    => $post_paging,
	'taxonomy'       => 'product_author',

	'authors'          => $authors,
	'image_size'       => $image_size,
	'is_slider'        => $is_slider,
	'dots'             => $dots,
	'nav'              => $nav,
	'autoplay'         => $autoplay,
	'nav_style'        => $nav_style,
	'autoplay_timeout' => $autoplay_timeout,
	'nav_position'     => $nav_position,
	'nav_size'         => $nav_size,
	'nav_hover_scheme' => $nav_hover_scheme,
	'nav_hover_style'  => $nav_hover_style,

);

$class_to_filter = implode( ' ', array_filter( $wrapper_classes ) );
$css_class       = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts );
?>
<div class="<?php echo esc_attr( $css_class ) ?>">
	<?php if ( function_exists( 'G5Plus_Auteur' ) ) {
		G5Plus_Auteur()->authors()->archive_markup( $query_args, $settings );
	} ?>
</div>