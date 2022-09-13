<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $portfolio_layout
 * @var $portfolio_item_skin
 * @var $image_size
 * @var $portfolio_row_height
 * @var $portfolio_row_max_height
 * @var $image_ratio
 * @var $image_ratio_custom_width
 * @var $image_ratio_custom_height
 * @var $image_masonry_width
 * @var $show
 * @var $portfolio_ids
 * @var $category
 * @var $portfolios_per_page
 * @var $portfolio_columns_gutter
 * @var $show_cate_filter
 * @var $cate_filter_align
 * @var $order_by
 * @var $order
 * @var $rows
 * @var $dots
 * @var $nav
 * @var $nav_position
 * @var $nav_size
 * @var $nav_style
 * @var $nav_hover_scheme
 * @var $nav_hover_style
 * @var $autoplay
 * @var $autoplay_timeout
 * @var $columns
 * @var $columns_md
 * @var $columns_sm
 * @var $columns_xs
 * @var $columns_mb
 * @var $portfolio_paging
 * @var $portfolio_animation
 * @var $portfolio_light_box
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Portfolios
 */
$portfolio_layout = $portfolio_item_skin = $image_size = $portfolio_row_height = $portfolio_row_max_height = $image_ratio = $image_ratio_custom_width = $image_ratio_custom_height = $image_masonry_width = $show = $portfolio_ids = $category
    = $portfolios_per_page = $portfolio_columns_gutter = $show_cate_filter = $cate_filter_align = $order_by = $order = $portfolio_columns_gutter = $is_slider = $rows
    = $nav = $nav_position = $nav_size = $nav_hover_scheme = $nav_hover_style = $nav_style = $autoplay = $autoplay_timeout = $columns = $columns_md = $columns_sm = $columns_xs = $columns_mb = $portfolio_paging
    = $portfolio_animation = $portfolio_light_box = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
    'gf-portfolios',
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

$args = array(
    'post_type' => 'portfolio',
    'posts_per_page' => (is_numeric($portfolios_per_page) && $portfolios_per_page > 0) ? $portfolios_per_page : '-1'
);
switch ($show) {
    case 'all':
        $args['orderby'] = $order_by;
        $args['order'] = $order;
        break;
    case 'featured':
        $query_args = array(
            'post_type' => 'portfolio',
            'tax_query' => array(
                array(
                    'taxonomy' => 'portfolio_visibility',
                    'field' => 'slug',
                    'terms' => 'featured',
                ),
            ),
        );
        $query = new WP_Query($query_args);
        $portfolio_ids = wp_list_pluck($query->posts, 'ID');
        wp_reset_postdata();
        if (!empty($portfolio_ids)) {
            $args['post__in'] = $portfolio_ids;
            $args['orderby'] = 'post__in';
        }
        break;
    case 'portfolios':
        $category = '';
        if (!empty($portfolio_ids)) {
            $portfolio_ids_array = explode(',', $portfolio_ids);
            // Split ids into post_in and post_not_in
            $post_in = array();
            foreach ($portfolio_ids_array as $post_id) {
                $post_id = trim($post_id);
                if (is_numeric($post_id) || intval($post_id) > 0) {
                    $post_in[] = intval($post_id);
                }
            }
            if (!empty($post_in)) {
                $args['post__in'] = $post_in;
                $args['orderby'] = 'post__in';
            }
        }
        break;
    default:
        break;
}
if (!empty($category)) {
    $args['tax_query'][] = array(
        'taxonomy' => 'portfolio_cat',
        'terms' => explode(',', $category),
        'field' => 'slug',
        'operator' => 'IN'
    );
}
$category = G5P()->helper()->get_term_ids_from_slugs(explode(',', $category), 'portfolio_cat');

$settings = array(
    'posts_per_page' => (is_numeric($portfolios_per_page) && $portfolios_per_page > 0) ? $portfolios_per_page : '-1',
    'post_columns_gutter' => $portfolio_columns_gutter,
    'post_layout' => $portfolio_layout,
    'portfolio_item_skin' => $portfolio_item_skin,
    'post_paging' => $portfolio_paging,
    'cat' => $category,
    'post_columns' => array(
        'xl' => $columns,
        'lg' => $columns_md,
        'md' => $columns_sm,
        'sm' => $columns_xs,
        '' => $columns_mb
    ),
    'image_size' => $image_size,
    'image_ratio' => $image_ratio,
    'image_ratio_custom' => array(
        'width' => intval($image_ratio_custom_width),
        'height' => intval($image_ratio_custom_height)
    ),
    'image_width' => array(
        'width' => intval($image_masonry_width)
    )
);

if('none' === $portfolio_paging) {
    $args['no_found_rows']  = 1;
}

if ('on' === $show_cate_filter) {
    $settings['category_filter_enable'] = true;
    $settings['category_filter_vertical'] = false;
    $settings['portfolio_cate_filter'] = $cate_filter_align;
}
if ('justified' === $portfolio_layout) {
    $settings['portfolio_row_height'] = $portfolio_row_height;
    $settings['portfolio_row_max_height'] = $portfolio_row_max_height;
}
if ($portfolio_animation !== '') {
    $settings['post_animation'] = $portfolio_animation;
}
if ($portfolio_light_box !== '') {
    $settings['portfolio_light_box'] = $portfolio_light_box;
}
$columns = intval($columns);
$portfolio_columns_gutter = intval($portfolio_columns_gutter);
$columns_md = intval($columns_md);
$columns_sm = intval($columns_sm);
$columns_xs = intval($columns_xs);
$columns_mb = intval($columns_mb);

if (in_array($portfolio_layout, array('carousel-3d'))) {
    $columns = $columns_md = $columns_sm = $columns_xs = 2;
    $settings['post_paging'] = 'none';
    $carousel_class = '';
    $owl_args = array(
        'items' => $columns,
        'margin' => $columns == 1 ? 0 : $portfolio_columns_gutter,
        'slideBy' => $columns,
        'dots' => true,
        'nav' => false,
        'responsive' => array(
            '1200' => array(
                'items' => $columns,
                'margin' => $columns == 1 ? 0 : $portfolio_columns_gutter,
                'slideBy' => $columns,
            ),
            '992' => array(
                'items' => $columns_md,
                'margin' => $columns_md == 1 ? 0 : ($portfolio_columns_gutter > 30 ? 30 : $portfolio_columns_gutter),
                'slideBy' => $columns_md,
            ),
            '768' => array(
                'items' => $columns_sm,
                'margin' => $columns_sm == 1 ? 0 : ($portfolio_columns_gutter > 30 ? 30 : $portfolio_columns_gutter),
                'slideBy' => $columns_sm,
            ),
            '575' => array(
                'items' => $columns_xs,
                'margin' => $columns_xs == 1 ? 0 : ($portfolio_columns_gutter > 30 ? 30 : $portfolio_columns_gutter),
                'slideBy' => $columns_xs,
            ),
            '0' => array(
                'items' => $columns_mb,
                'margin' => $columns_mb == 1 ? 0 : ($portfolio_columns_gutter > 30 ? 30 : $portfolio_columns_gutter),
                'slideBy' => $columns_mb,
            )
        ),
        'autoHeight' => true,
        'autoplay' => false,
        'center' => true,
        'loop' => true,
    );
    $carousel_class = 'carousel-3d';
    if (!empty($carousel_class)) {
        $settings['carousel_class'] = $carousel_class;
    }
    $settings['carousel'] = $owl_args;
}

if ('on' === $is_slider) {
    $settings['post_paging'] = 'none';
    $carousel_class = '';
    if ($rows == 1) {
        $owl_args = array(
            'items' => $columns,
            'margin' => $columns == 1 ? 0 : $portfolio_columns_gutter,
            'slideBy' => $columns,
            'dots' => ($dots === 'on') ? true : false,
            'nav' => ($nav === 'on') ? true : false,
            'responsive' => array(
                '1200' => array(
                    'items' => $columns,
                    'margin' => $columns == 1 ? 0 : $portfolio_columns_gutter,
                    'slideBy' => $columns,
                ),
                '992' => array(
                    'items' => $columns_md,
                    'margin' => $columns_md == 1 ? 0 : ($portfolio_columns_gutter > 30 ? 30 : $portfolio_columns_gutter),
                    'slideBy' => $columns_md,
                ),
                '768' => array(
                    'items' => $columns_sm,
                    'margin' => $columns_sm == 1 ? 0 : ($portfolio_columns_gutter > 30 ? 30 : $portfolio_columns_gutter),
                    'slideBy' => $columns_sm,
                ),
                '576' => array(
                    'items' => $columns_xs,
                    'margin' => $columns_xs == 1 ? 0 : ($portfolio_columns_gutter > 30 ? 30 : $portfolio_columns_gutter),
                    'slideBy' => $columns_xs,
                ),
                '0' => array(
                    'items' => $columns_mb,
                    'margin' => $columns_mb == 1 ? 0 : ($portfolio_columns_gutter > 30 ? 30 : $portfolio_columns_gutter),
                    'slideBy' => $columns_mb,
                )
            ),
            'autoHeight' => true,
            'autoplay' => ($autoplay === 'on') ? true : false,
            'autoplayTimeout' => intval($autoplay_timeout),
        );
    } else {
        $settings['itemSelector'] = '.owl-item-inner';
        $owl_args = array(
            'items' => 1,
            'margin' => 0,
            'slideBy' => 1,
            'dots' => ($dots === 'on') ? true : false,
            'nav' => ($nav === 'on') ? true : false,
            'autoHeight' => true,
            'autoplay' => ($autoplay === 'on') ? true : false,
            'autoplayTimeout' => intval($autoplay_timeout),
        );
        $settings['carousel_rows'] = array(
            'rows' => intval($rows),
            'items_show' => $rows * $columns
        );
        $carousel_class = 'carousel-gutter-' . $portfolio_columns_gutter;
    }
    if ($nav_style == 'nav-square-text' || $nav_style == 'nav-circle-text') {
        $owl_args['navText'] = array('<i class="fal fa-angle-left"></i> <span>' . esc_html__('Prev', 'auteur-framework') . '</span>', '<span>' . esc_html__('Next', 'auteur-framework') . '</span> <i class="fal fa-angle-right"></i>');
    }

    if ($nav === 'on') {
        $carousel_class .= ' ' . $nav_position. ' ' . $nav_style . ' ' .$nav_size. ' ' .$nav_hover_scheme .' '.$nav_hover_style;
    }
    if (!empty($carousel_class)) {
        $settings['carousel_class'] = $carousel_class;
    }
    $settings['carousel'] = $owl_args;
}
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
    <?php if (function_exists('G5Plus_Auteur')) {
        G5Plus_Auteur()->portfolio()->archive_markup($args, $settings);
    } ?>
</div>