<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $image
 * @var $category
 * @var $height_mode
 * @var $height
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Portfolio_Category
 */
$image = $category = $height_mode = $height =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
    'gf-portfolio-category',
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class($css),
    $responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}
$_class = 'gf-portfolio-cat-' . random_int(1000, 9999);
$_bg_css = '';
if (!empty($image)) {
    $image_src = '';
    $image_arr = wp_get_attachment_image_src($image, 'full');
    $img_width = $img_height = '';
    if (sizeof($image_arr) > 0 && !empty($image_arr[0])) {
        $image_src = $image_arr[0];
        $img_width = isset($image_arr[1]) ? intval($image_arr[1]) : 0;
        $img_height = isset($image_arr[2]) ? intval($image_arr[2]) : 0;
    }
    if ($height_mode != 'custom') {
        if ($height_mode === 'original' && intval($img_width) !== 0) {
            $height_mode = ($img_height / $img_width) * 100;
        }
        $_bg_css = <<<CSS
			.{$_class} {
				background-image: url('{$image_src}');
				padding-bottom: {$height_mode}%;
			}
CSS;
    } else {
        $height = str_replace('|', '', $height);
        $_bg_css = <<<CSS
			.{$_class} {
				background-image: url('{$image_src}');
				height: {$height};
			}
CSS;
    }
}
GSF()->customCss()->addCss($_bg_css);
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<?php if (!empty($category)): ?>
    <div class="<?php echo esc_attr($css_class) ?>">
        <?php $cate_link = get_term_link($category, 'portfolio_cat'); ?>
        <?php $category = get_term_by('slug', $category, 'portfolio_cat', 'OBJECT'); ?>
        <?php if($category && !is_object($cate_link)): ?>
            <div class="gf-portfolio-cat-bg effect-bg-image <?php echo esc_attr($_class); ?>"></div>
            <div class="gf-portfolio-cat-inner">
                <a href="<?php echo esc_url($cate_link); ?>" title="<?php echo esc_attr($category->name); ?>"
                   class="btn btn-classic btn-white btn-rounded"><?php esc_html_e('See all work', 'auteur-framework') ?></a>
                <h5><?php echo esc_html($category->name); ?></h5>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>