<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $values
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Time_Line
 */

$responsive = $css = $el_class = $css_animation = $animation_delay = $animation_duration = $values = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
    'gsf-time-line',
    'clearfix',
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class($css),
    $responsive
);
if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}

$class_to_filter = implode(' ', $wrapper_classes);
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>

<div class="<?php echo esc_attr($css_class) ?>">
    <?php $values = (array)vc_param_group_parse_atts($values);
    if (count($values) > 0):?>
        <div class="time-line-items">
            <ul>
                <?php
                $index = 0;
                foreach ($values as $value):
                    if(empty($value)) continue;
                    $index ++;
                    // get image src
                    if (!empty($value['image'])) {
                        $image_id = preg_replace('/[^\d]/', '', $value['image']);
                        $image_full = wpb_resize($image_id, null, 500, 350, true);
                        $image_src = '';
                        if (sizeof($image_full) > 0) {
                            $image_src = $image_full['url'];
                        }
                    }
                    $year = isset($value['year']) ? $value['year'] : '';
                    $title = isset($value['title']) ? $value['title'] : '';
                    $description = isset($value['description']) ? $value['description'] : '';
                    ?>
                    <li class="time-line-item clearfix <?php echo esc_attr($index%2 === 0 ? 'time-line-even' : 'time-line-odd'); ?>">
                        <div class="time-line-year"><span class="tl-year-inner"><?php echo esc_html($year); ?></span></div>
                        <?php if (!empty($image_src)): ?>
                            <div class="time-line-thumb">
                                <div class="thumb-inner">
                                    <img src="<?php echo esc_url($image_src) ?>" alt="<?php echo esc_attr($title) ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="time-line-content">
                            <div class="content-inner">
                                <?php if (!empty($title)): ?>
                                    <h5 class="time-line-title">
                                        <?php echo esc_html($title) ?>
                                    </h5>
                                <?php endif; ?>
                                <?php if (!empty($description)): ?>
                                    <p class="time-line-des">
                                        <?php echo esc_html($description) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>