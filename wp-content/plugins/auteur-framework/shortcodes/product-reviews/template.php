<?php
/**
 * Shortcode attributes
 * @var $atts
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
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Product_Reviews
 */

$items_per_page = $is_slider = $dots = $nav = $nav_position = $nav_size =
$nav_style = $nav_hover_scheme = $nav_hover_style = $autoplay = $autoplay_timeout = $columns_gutter =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
if(!function_exists('G5Plus_Auteur')) return;
$wrapper_classes = array(
    'gf-product-reviews',
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class($css),
    $responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}
$columns = intval($columns);
$columns_gutter = intval($columns_gutter);
$columns_md = intval($columns_md);
$columns_sm = intval($columns_sm);
$columns_xs = intval($columns_xs);
$columns_mb = intval($columns_mb);
$item_class = array('gsf-product-review-item');
$inner_class = $owl_args = array();
if('on' === $is_slider) {
    $inner_class[] = 'owl-carousel owl-theme';
    $owl_args = array(
        'items' => $columns,
        'margin' => $columns == 1 ? 0 : $columns_gutter,
        'slideBy' => $columns,
        'dots' => ($dots === 'on') ? true : false,
        'nav' => ($nav === 'on') ? true : false,
        'responsive' => array(
            '1200' => array(
                'items' => $columns,
                'margin' => $columns == 1 ? 0 : $columns_gutter,
                'slideBy' => $columns,
            ),
            '992' => array(
                'items' => $columns_md,
                'margin' => $columns_md == 1 ? 0 : $columns_gutter,
                'slideBy' => $columns_md,
            ),
            '768' => array(
                'items' => $columns_sm,
                'margin' => $columns_sm == 1 ? 0 : $columns_gutter,
                'slideBy' => $columns_sm,
            ),
            '576' => array(
                'items' => $columns_xs,
                'margin' => $columns_xs == 1 ? 0 : $columns_gutter,
                'slideBy' => $columns_xs,
            ),
            '0' => array(
                'items' => $columns_mb,
                'margin' => $columns_mb == 1 ? 0 : $columns_gutter,
                'slideBy' => $columns_mb,
            )
        ),
        'autoHeight' => true,
        'autoplay' => ($autoplay === 'on') ? true : false,
        'autoplayTimeout' => intval($autoplay_timeout),
    );
    if($nav_style == 'nav-square-text' || $nav_style == 'nav-circle-text') {
        $owl_args['navText'] = array('<i class="fal fa-angle-left"></i> <span>'.esc_html__( 'Prev', 'auteur-framework' ).'</span>', '<span>'.esc_html__( 'Next', 'auteur-framework' ).'</span> <i class="fal fa-angle-right"></i>');
    }

    if($nav === 'on') {
        $inner_class = array_merge($inner_class, array($nav_position, $nav_style, $nav_size, $nav_hover_scheme, $nav_hover_style));
    }
} else {
    $inner_class[] = 'gf-gutter-' . $columns_gutter;
    $inner_class[] = 'gf-blog-inner';
    $item_class[] = 'grid-item';
    $columns = array(
        'xl' => $columns,
        'lg' => $columns_md,
        'md' => $columns_sm,
        'sm' => $columns_xs,
        '' => $columns_mb
    );
    $item_class[] = G5Plus_Auteur()->helper()->get_bootstrap_columns($columns);
}
$comments = get_comments(
    array(
        'number'      => $items_per_page,
        'status'      => 'approve',
        'post_status' => 'publish',
        'post_type'   => 'product',
        'parent'      => 0,
    )
);
$totalRecord = sizeof($comments);
$class_to_filter = implode(' ', array_filter($wrapper_classes));
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->getShortcode(), $atts);
?>
<div class="<?php echo esc_attr($css_class) ?>">
    <?php if($totalRecord > 0): ?>
        <div class="gsf-product-reviews-inner <?php echo join(' ', $inner_class); ?>" data-owl-options='<?php echo json_encode($owl_args); ?>'>
            <?php foreach ($comments as $comment):
                $product = wc_get_product( $comment->comment_post_ID );
                ?>
                <article <?php post_class( $item_class); ?>>
                    <div class="product-review-item-inner">
                        <div class="entry-thumbnail-wrap">
                            <div class="entry-thum-inner bubba-effect">
                                <div class="effect-content">
                                    <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="transition03 gsf-link"><?php esc_html_e('View Book', 'auteur-framework'); ?></a>
                                    <?php echo wp_kses_post($product->get_image()); ?>
                                </div>
                            </div>
                        </div>
                        <div class="review-info">
                            <h4 class="product-title"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"
                                                 class="transition03 gsf-link"><?php echo esc_html($product->get_name()); ?></a></h4>
                            <span class="reviewer"><?php echo sprintf( esc_html__( 'By %s', 'auteur-framework' ), strtoupper(get_comment_author( $comment->comment_ID )) ); ?></span>
                            <?php if(isset($comment->comment_content) && !empty($comment->comment_content)): ?>
                                <p class="review-content"><?php echo esc_html($comment->comment_content); ?></p>
                            <?php endif; ?>
                            <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="product-categories heading-color">', '</div>' ); ?>
                            <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"
                               class="btn btn-link btn-md btn-accent btn-icon-right"><?php esc_html_e('Read the review', 'auteur-framework') ?><i class="fal fa-chevron-double-right"></i></a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="item-not-found"><?php esc_html_e('No item found','auteur-framework'); ?></div>
    <?php endif; ?>
</div>