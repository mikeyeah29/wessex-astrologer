<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $text_align
 * @var $counter_size
 * @var $title
 * @var $title_color
 * @var $title_use_theme_fonts
 * @var $title_typography
 * @var $end
 * @var $start
 * @var $decimals
 * @var $duration
 * @var $separator
 * @var $decimal
 * @var $prefix
 * @var $suffix
 * @var $main_color
 * @var $value_use_theme_fonts
 * @var $value_typography
 * @var $icon_font
 * @var $icon_color
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Counter
 */
$text_align = $counter_size = $title = $title_color = $end = $start = $decimals = $decimal = $prefix = $duration = $separator = $suffix = $main_color =
$icon_font = $icon_color = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gsf-counter',
    $text_align,
    $counter_size,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class($css),
	$responsive
);
//animation
if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}

$ct_class = 'ct-' . uniqid();
$ct_css = $icon_html = '';
if(!empty($icon_font)) {
    $icon_html = '<i class="' . esc_attr($icon_font) . '"></i>';
    if (empty($icon_color)) $icon_color = '#333';
    $ct_css = <<<CSS
	 .{$ct_class} .ct-icon{
	 	color:  {$icon_color};
	 }
CSS;
}
if ('on' !== $title_use_theme_fonts) {
    $title_typography = $this->get_font_attrs($title_typography);
    $ct_css .= <<<CSS
        .{$ct_class} .counter-title {
            font-family: {$title_typography[0]} !important;
            font-weight: {$title_typography[2]} !important;
            font-style: {$title_typography[3]} !important;
}
CSS;
}
if ('on' !== $value_use_theme_fonts) {
    $value_typography = $this->get_font_attrs($value_typography);
    $ct_css .= <<<CSS
        .{$ct_class} .counter-value {
            font-family: {$value_typography[0]} !important;
            font-weight: {$value_typography[2]} !important;
            font-style: {$value_typography[3]} !important;
}
CSS;
}
$ct_css .= <<<CSS
    .{$ct_class} .counter-value {
        color: {$main_color}
}
CSS;
if(!empty($title_color)) {
    $ct_css .= <<<CSS
        .{$ct_class} .counter-title {
            color: {$title_color};
}
CSS;
}
GSF()->customCss()->addCss($ct_css);
$wrapper_classes[] = $ct_class;

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);

?>

<div class="<?php echo esc_attr($css_class)?>">
	<?php if (!empty($icon_font)): ?>
		<div class="ct-icon-shape">
			<div class="fs-48 ct-icon"><?php echo wp_kses_post($icon_html); ?></div>
		</div>
	<?php endif; ?>
	<div class="ct-content">
		<?php if (!empty($end)): ?>
			<h4 class="counterup counter-value" data-start="<?php echo esc_attr($start) ?>"
				  data-end="<?php echo esc_attr($end) ?>" data-decimals="<?php echo esc_attr($decimals) ?>"
				  data-duration="<?php echo esc_attr($duration) ?>" data-separator="<?php echo esc_attr($separator) ?>"
				  data-decimal="<?php echo esc_attr($decimal) ?>" data-prefix="<?php echo wp_kses_post($prefix) ?>"
				  data-suffix="<?php echo wp_kses_post($suffix) ?>"><?php echo wp_kses_post($end) ?><span><?php echo wp_kses_post($suffix) ?></span></h4>
		<?php endif; ?>
        <?php if (!empty($title)): ?>
            <div class="counter-title">
                <span><?php echo wp_kses_post($title) ?></span>
            </div>
        <?php endif;?>
	</div>
</div>
