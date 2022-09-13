<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $columns_gutter
 * @var $quote_image
 * @var $tes_style
 * @var $content_font_size
 * @var $content_line_height
 * @var $content_letter_spacing
 * @var $space_between
 * @var $testimonial_use_theme_font
 * @var $content_typography
 * @var $values
 * @var $dots
 * @var $nav
 * @var $nav_position
 * @var $nav_style
 * @var $autoplay
 * @var $autoplay_timeout
 * @var $columns
 * @var $columns_md
 * @var $columns_sm
 * @var $columns_xs
 * @var $columns_mb
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Testimonials
 */

$layout_style = $columns_gutter = $quote_image = $tes_style = $content_font_size = $content_line_height = $content_letter_spacing = $testimonial_use_theme_font =
    $space_between = $content_typography = $values = $dots = $nav = $nav_position = $nav_style = $autoplay = $autoplay_timeout =
$columns = $columns_md = $columns_sm = $columns_xs = $columns_mb = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
    'gsf-testimonials',
    'gsf-slider-container',
    $layout_style,
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
if('style-04' !== $layout_style) {
    $wrapper_classes[] = 'owl-carousel owl-theme';
} else {
    $wrapper_classes[] = 'd-flex align-items-center';
}
$columns = intval($columns);
$columns_md = intval($columns_md);
$columns_sm = intval($columns_sm);
$columns_xs = intval($columns_xs);
$columns_mb = intval($columns_mb);
$wrapper_classes[] = 'item-gutter-' . $columns_gutter;
$owl_attributes = '';
if('style-03' === $layout_style) {
    $owl_attributes = array(
        'items' => $columns,
        'margin' => 0,
        'dots' => ($dots === 'on') ? true : false,
        'nav' => ($nav === 'on') ? true : false,
        'autoHeight' => true,
        'autoplay' => ($autoplay === 'on') ? true : false,
        'autoplayTimeout' => $autoplay_timeout,
        'responsive' => array(
            '1200' => array(
                'items' => $columns,
                'slideBy' => $columns,
            ),
            '992' => array(
                'items' => $columns_md,
                'slideBy' => $columns_md,
            ),
            '768' => array(
                'items' => $columns_sm,
                'slideBy' => $columns_sm,
            ),
            '576' => array(
                'items' => $columns_xs,
                'slideBy' => $columns_xs,
            ),
            '0' => array(
                'items' => $columns_mb,
                'slideBy' => $columns_mb,
            )
        )
    );
} else {
    $owl_attributes = array(
        'items' => 1,
        'margin' => 0,
        'dots' => ($dots === 'on') ? true : false,
        'nav' => ($nav === 'on') ? true : false,
        'autoHeight' => true,
        'autoplay' => ($autoplay === 'on') ? true : false,
        'autoplayTimeout' => $autoplay_timeout,
    );
}
if ($nav === 'on' && 'style-04' !== $layout_style) {
    $wrapper_classes[] = ' ' . $nav_position. ' ' . $nav_style . ' ' .$nav_size. ' ' .$nav_hover_scheme .' '.$nav_hover_style;
}
$tes_content_class = 'gsf-testimonial-' . uniqid();
$tes_content_css = '';
$content_letter_spacing = str_replace('|', '', $content_letter_spacing);
$content_line_height = str_replace('|', '', $content_line_height);
$space_betweens = explode('|', $space_between);
$space_between = $space_betweens[0];
$space_between_lg = (! isset($space_betweens[1]) || empty($space_betweens[1]) || intval($space_betweens[1]) <=0) ? $space_between : $space_betweens[1];
$space_between_md = (! isset($space_betweens[2]) || empty($space_betweens[2]) || intval($space_betweens[2]) <=0) ? $space_between_lg : $space_betweens[2];
$space_between_sm = (! isset($space_betweens[3]) || empty($space_betweens[3]) || intval($space_betweens[3]) <=0) ? $space_between_md : $space_betweens[3];
$space_between_mb = (! isset($space_betweens[4]) || empty($space_betweens[4]) || intval($space_betweens[4]) <=0) ? $space_between_sm : $space_betweens[4];

$content_font_sizes = explode('|', $content_font_size);
$content_font_size = $content_font_sizes[0];
$content_font_size_lg = (! isset($content_font_sizes[1]) || empty($content_font_sizes[1]) || intval($content_font_sizes[1]) <=0) ? $content_font_size : $content_font_sizes[1];
$content_font_size_md = (! isset($content_font_sizes[2]) || empty($content_font_sizes[2]) || intval($content_font_sizes[2]) <=0) ? $content_font_size_lg : $content_font_sizes[2];
$content_font_size_sm = (! isset($content_font_sizes[3]) || empty($content_font_sizes[3]) || intval($content_font_sizes[3]) <=0) ? $content_font_size_md : $content_font_sizes[3];
$content_font_size_mb = (! isset($content_font_sizes[4]) || empty($content_font_sizes[4]) || intval($content_font_sizes[4]) <=0) ? $content_font_size_sm : $content_font_sizes[4];
$tes_content_css .= <<<CSS
    .{$tes_content_class} .testimonials-content {
        margin-bottom: {$space_between}px !important;
    }
    .{$tes_content_class} .testimonials-content p {
        font-size: {$content_font_size}px !important;
        line-height: {$content_line_height} !important;
        letter-spacing: {$content_letter_spacing} !important;
    }
    @media (min-width: 992px) and (max-width: 1199px) {
        .{$tes_content_class} .testimonials-content {
            margin-bottom: {$space_between_lg}px !important;
        }
        .{$tes_content_class} .testimonials-content p {
            font-size: {$content_font_size_lg}px !important;
        }
    }
    @media (min-width: 768px) and (max-width: 991px) {
        .{$tes_content_class} .testimonials-content {
            margin-bottom: {$space_between_md}px !important;
        }
        .{$tes_content_class} .testimonials-content p {
            font-size: {$content_font_size_md}px !important;
        }
    }
    @media (min-width: 576px) and (max-width: 767px) {
        .{$tes_content_class} .testimonials-content {
            margin-bottom: {$space_between_sm}px !important;
        }
        .{$tes_content_class} .testimonials-content p {
            font-size: {$content_font_size_sm}px !important;
        }
    }
    @media (max-width: 575px) {
        .{$tes_content_class} .testimonials-content {
            margin-bottom: {$space_between_mb}px !important;
        }
        .{$tes_content_class} .testimonials-content p {
            font-size: {$content_font_size_mb}px !important;
        }
    }
CSS;

if ('on' !== $testimonial_use_theme_font) {
    $content_typography = $this->get_font_attrs($content_typography);
    $tes_content_css .= <<<CSS
    .{$tes_content_class} .testimonials-content p {
        font-family: {$content_typography[0]} !important;
        font-weight: {$content_typography[2]} !important;
        font-style: {$content_typography[3]} !important;
}
CSS;
}
$wrapper_classes[] = $tes_content_class;
GSF()->customCss()->addCss($tes_content_css);
$class_to_filter = implode(' ', $wrapper_classes);
$class_to_filter .= vc_shortcode_custom_css_class($css, ' ');
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>" <?php if('style-04' !== $layout_style): ?> data-owl-options='<?php echo json_encode($owl_attributes); ?>'<?php endif; ?>>
    <?php
    $values = (array)vc_param_group_parse_atts($values);
    if('style-04' === $layout_style) :?>
        <div class="testimonial-avatar-wrap owl-carousel owl-theme manual col-lg-5 col-md-6 col-sm-12 md-mg-top-40 order-2 order-md-first">
            <?php foreach ($values as $value):
                $name = isset($value['author_name']) ? $value['author_name'] : '';
                $avatar = isset($value['author_avatar']) ? $value['author_avatar'] : '';
                $image_src = '';
                if (!empty($avatar)) {
                    $image_full = wpb_resize($avatar, null, 420, 485, true);
                    if (is_array($image_full) && isset($image_full['url'])) {
                        $image_src = $image_full['url'];
                    }
                }
                if(!empty($image_src)):?>
                    <div class="testimonial-avatar-item">
                        <img src="<?php echo esc_url($image_src) ?>" alt="<?php echo esc_attr($name); ?>">
                    </div>
                <?php endif;
            endforeach;?>
        </div>
        <div class="testimonial-content-wrap owl-carousel owl-theme manual offset-lg-1 offset-md-0 col-md-6 col-sm-12 <?php echo esc_attr($nav_position. ' ' . $nav_style . ' ' .$nav_size. ' ' .$nav_hover_scheme .' '.$nav_hover_style); ?>" data-owl-options='<?php echo json_encode($owl_attributes); ?>'>
    <?php endif;
    ?>
    <?php foreach ($values as $value):
        $name = isset($value['author_name']) ? $value['author_name'] : '';
        $job = isset($value['author_job']) ? $value['author_job'] : '';
        $bio = isset($value['author_bio']) ? $value['author_bio'] : '';
        $url = isset($value['author_link']) ? $value['author_link'] : '';
        $avatar = isset($value['author_avatar']) ? $value['author_avatar'] : '';
        $user_rating = isset($value['user_rating']) ? $value['user_rating'] : '';
        $image_src = '';
        if (!empty($avatar)) {
            if('style-01' === $layout_style) {
                $image_full = wpb_resize($avatar, null, 670, 430, true);
            } elseif('style-04' === $layout_style) {
                $image_src = wpb_resize($avatar, null, 420, 485, true);
            } else {
                $image_full = wpb_resize($avatar, null, 140, 140, true);
            }

            if (is_array($image_full) && isset($image_full['url'])) {
                $image_src = $image_full['url'];
            }
        }
        ?>
        <?php G5P()->helper()->getTemplate('shortcodes/testimonials/templates/' . $layout_style, array('name'=>$name, 'job' => $job, 'bio' => $bio, 'image_src' => $image_src, 'url' => $url, 'quote_image' => $quote_image, 'user_rating' => $user_rating)); ?>
    <?php endforeach; ?>
    <?php if('style-04' === $layout_style) : ?>
        </div>
    <?php endif; ?>
</div>
