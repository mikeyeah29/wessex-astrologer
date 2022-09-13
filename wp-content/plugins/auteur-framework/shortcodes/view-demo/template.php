<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $text_align
 * @var $columns_gutter
 * @var $scroll_on_hover
 * @var $columns
 * @var $columns_md
 * @var $columns_sm
 * @var $columns_xs
 * @var $columns_mb
 * @var $demo_items
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_View_Demo
 */

$layout_style = $text_align = $columns_gutter = $scroll_on_hover = $columns = $columns_md = $columns_sm = $columns_xs = $columns_mb = $demo_items = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gsf-view-demo',
	'clearfix',
    'gsf-view-demo-' . $layout_style,
    $text_align,
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class( $css ),
    $responsive
);
if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}

if('on' === $scroll_on_hover) {
    $wrapper_classes[] = 'demo-scroll-on-hover';
}
$item_class = array('demo-item-wrap grid-item');
$columns = array(
    'xl' => $columns,
    'lg' => $columns_md,
    'md' => $columns_sm,
    'sm' => $columns_xs,
    '' => $columns_mb
);
$item_class[] = G5P()->helper()->get_bootstrap_columns($columns);

$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts);
?>
<div class="<?php echo esc_attr($css_class); ?>">
	<div class="demo-items clearfix row gf-gutter-<?php echo esc_attr($columns_gutter) ?>">
		<?php
        $demo_items = (array)vc_param_group_parse_atts($demo_items);
        if($demo_items && count($demo_items) > 0) {
            foreach ($demo_items as $demo) {
                $img = isset($demo['image']) ? wp_get_attachment_url($demo['image']) : '';
                $title = isset($demo['title']) ? $demo['title'] : '';

                $link = isset($demo['link']) ? $demo['link'] : '';
                $a_href = $a_title = $a_target = $a_rel = '';
                $link = ('||' === $link) ? '' : $link;
                $link = vc_build_link($link);
                $use_link = false;
                if (strlen($link['url']) > 0) {
                    $use_link = true;
                    $a_href = $link['url'];
                    $a_title = $link['title'];
                    if (empty($title)) {
                        $title = $a_title;
                    }
                    $a_target = $link['target'];
                    $a_rel = $link['rel'];
                }
                $view_link_attr = array();
                $link_attr = array('class="gsf-link"');
                if ($use_link) {
                    $link_attr[] = 'href="' . esc_url(trim($a_href)) . '"';
                    $link_attr[] = 'title="' . esc_attr(trim($title)) . '"';
                    $view_link_attr[] = 'href="' . esc_url(trim($a_href)) . '"';
                    $view_link_attr[] = 'title="' . esc_attr(trim($title)) . '"';
                    if (!empty($a_target)) {
                        $link_attr[] = 'target="' . esc_attr(trim($a_target)) . '"';
                        $view_link_attr[] = 'target="' . esc_attr(trim($a_target)) . '"';
                    }

                    if (!empty($a_rel)) {
                        $link_attr[] = 'rel="' . esc_attr(trim($a_rel)) . '"';
                        $view_link_attr[] = 'rel="' . esc_attr(trim($a_rel)) . '"';
                    }
                }
                $link_attr = implode(' ', $link_attr);
                $view_link_attr = implode(' ', $view_link_attr);
                $demo_classes = array('demo-thumb');

                if('on' === $scroll_on_hover) {
                    $demo_class = 'gsf-demo-' . uniqid();
                    $demo_css = <<<CSS
                    .{$demo_class} {
                        background-image: url('{$img}');
                    }
CSS;
                    GSF()->customCss()->addCss($demo_css);
                    $demo_classes[] = $demo_class;
                }
                $is_new = isset($demo['is_new']) ? $demo['is_new'] : '';
                $is_coming_soon = isset($demo['is_coming_soon']) ? $demo['is_coming_soon'] : '';
                if('on' === $is_coming_soon) {
                    $use_link = false;
                    $is_new = '';
                }
                ?>
                <div class="<?php echo join(' ', $item_class); ?>">
                    <div class="demo-item<?php echo ('on' === $is_coming_soon) ? ' item-coming-soon' : ''; ?>">
                        <div class="demo-thumb-wrap">
                            <div class="<?php echo join(' ', $demo_classes); ?>">
                                <?php if ($use_link): ?>
                                    <a <?php echo wp_kses_post($link_attr); ?> ></a>
                                <?php endif; ?>
                                <?php if('on' === $is_new): ?>
                                    <span class="item-new"><?php esc_html_e('New', 'auteur-framework'); ?></span>
                                <?php endif; ?>
                                <?php if('on' !== $scroll_on_hover): ?>
                                    <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>">
                                    <a class="btn btn-accent btn-classic btn-md" <?php echo wp_kses_post($link_attr); ?>><?php esc_html_e('View Demo', 'auteur-framework'); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="demo-title">
                            <?php if ($use_link): ?>
                                <h4><a <?php echo wp_kses_post($link_attr); ?> ><?php echo esc_html($title); ?></a></h4>
                            <?php else: ?>
                                <h4><?php echo esc_html($title); ?></h4>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php }
        }?>
	</div>
</div>
