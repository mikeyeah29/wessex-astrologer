<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $portfolio_ids
 * @var $image_size
 * @var $portfolio_animation
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Portfolio_Singular
 */
$portfolio_ids = $image_size = $portfolio_animation = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
    'gsf-portfolio-singular',
    G5P()->core()->vc()->customize()->getExtraClass($el_class),
    $this->getCSSAnimation($css_animation),
    vc_shortcode_custom_css_class($css),
    $responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
    $animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
    $wrapper_classes[] = $animation_class;
}
if (empty($portfolio_ids)) return;
$portfolio_ids = explode(',', $portfolio_ids);
$query_args = array(
    'post_status' => 'publish',
    'post_type' => 'portfolio',
    'no_found_rows' => 1,
    'post__in' => $portfolio_ids,
    'orderby' => 'post__in'
);
$query_args = G5Plus_Auteur()->query()->get_main_query_vars($query_args);
G5Plus_Auteur()->query()->query_posts($query_args);
$owl_attributes = array(
    'items' => 1,
    'margin' => 0,
    'slideBy' => 1,
    'dots' => false,
    'nav' => false
);
$wrapper_class = implode(' ', array_filter($wrapper_classes));
?>
    <div class="<?php echo esc_attr($wrapper_class) ?>">
        <div class="portfolio-index-wrap d-flex flex-wrap align-items-center justify-content-xl-end">
            <?php foreach ($portfolio_ids as $index=>$value): ?>
                <?php
                $index_text = $index;
                $index_text++;
                if($index < 10) $index_text = '0' . $index_text;?>
                <div class="index-item mg-bottom-10 <?php echo esc_attr($index == 0 ? 'active' : ''); ?>" data-item-index="<?php echo esc_attr($index); ?>"><?php echo esc_html($index_text); ?></div>
            <?php endforeach; ?>
            <a href="<?php echo get_post_type_archive_link('portfolio') ?>" class="view-all gsf-link mg-bottom-10"><?php esc_html_e('View all projects', 'auteur-framework') ?> <i class="fal fa-angle-right"></i></a>
        </div>
        <div class="portfolio-singular-wrap owl-carousel"
             data-owl-options='<?php echo json_encode($owl_attributes); ?>'>
            <?php
            $index = 0;
            $index_text = '';
            if (G5Plus_Auteur()->query()->have_posts()) {
                while (G5Plus_Auteur()->query()->have_posts()) : G5Plus_Auteur()->query()->the_post();
                    $index++; ?>
                    <div class="portfolio-singular-inner row"
                         data-index="<?php echo esc_attr($index) ?>">
                        <div class="portfolio-singular-content col-xl-6 col-lg-5 d-flex md-mg-bottom-30 md-pd-top-0">
                            <?php if ($index < 10) $index_text = '0' . $index; ?>
                            <p class="portfolio-index mg-top-10 mg-bottom-10"><?php echo wp_kses_post($index_text . '.') ?></p>
                            <div class="portfolio-singular-info">
                                <?php
                                G5Plus_Auteur()->helper()->getTemplate('portfolio/loop/post-category');
                                G5Plus_Auteur()->helper()->getTemplate('portfolio/loop/post-title');
                                ?>
                                <a title="<?php the_title() ?>" href="<?php G5Plus_Auteur()->portfolio()->the_permalink() ?>" class="btn btn-accent btn-square uppercase"><?php echo esc_html__('View project','auteur-framework')?></a>
                                <?php
                                    G5Plus_Auteur()->helper()->getTemplate('portfolio/single/portfolio-meta', array('layout' => 'vertical'));
                               ?>
                            </div>
                        </div>
                        <div class="portfolio-singular-thumb col-xl-6 col-lg-7">
                            <?php
                            G5Plus_Auteur()->portfolio()->render_thumbnail_markup(array(
                                'image_size' => $image_size,
                                'display_permalink' => false,
                                'image_mode' => 'image'
                            )); ?>
                        </div>
                    </div>
                    <?php
                endwhile;
            }
            ?>
        </div>
    </div>
<?php G5Plus_Auteur()->query()->reset_query(); ?>