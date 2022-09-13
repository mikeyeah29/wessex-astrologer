<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $event_layout
 * @var $image_size
 * @var $image_ratio
 * @var $image_ratio_custom_width
 * @var $image_ratio_custom_height
 * @var $source
 * @var $category
 * @var $event_ids
 * @var $items_per_page
 * @var $event_columns_gutter
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
 * @var $columns
 * @var $columns_md
 * @var $columns_sm
 * @var $columns_xs
 * @var $columns_mb
 * @var $event_animation
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Events
 */
$event_layout = $image_size = $image_ratio = $image_ratio_custom_width = $image_ratio_custom_height = $source = $category = $event_ids =
$items_per_page = $event_columns_gutter = $orderby = $order = $is_slider = $dots = $nav = $nav_position = $nav_size = $nav_style = $nav_hover_scheme =
$nav_hover_style = $autoplay = $autoplay_timeout = $columns = $columns_md = $columns_sm = $columns_xs = $columns_mb = $event_animation =
$css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$wrapper_classes = array(
	'gf-events',
    'clearfix',
	'gf-event-' . $event_layout,
	G5P()->core()->vc()->customize()->getExtraClass($el_class),
	$this->getCSSAnimation($css_animation),
	vc_shortcode_custom_css_class( $css ),
	$responsive
);

if ('' !== $css_animation && 'none' !== $css_animation) {
	$animation_class = G5P()->core()->vc()->customize()->get_animation_class($animation_duration, $animation_delay);
	$wrapper_classes[] = $animation_class;
}

$args = array(
	'post_type'=> Tribe__Events__Main::POSTTYPE,
	'no_found_rows' => 1,
	'post_status' => 'publish',
	'posts_per_page' => (is_numeric( $items_per_page ) && $items_per_page > 0) ? $items_per_page : 10,
);

if ($source === '') {
	$source = 'list';
}

if ($source !== 'ids') {
	$args['eventDisplay'] = $source;
}

if (!empty($category) > 0) {
    $args['tax_query'][] = array(
        'taxonomy' => Tribe__Events__Main::TAXONOMY,
        'terms' => explode(',', $category),
        'field' => 'slug',
        'operator' => 'IN'
    );
}
if ( 'ids' === $source && !empty( $event_ids ) ) {
	$post_id_array = explode( ',', $event_ids );

	// Split ids into post_in and post_not_in
    $post_in = array();
    foreach ( $post_id_array as $post_id ) {
		$post_id = trim( $post_id );
		if ( is_numeric( $post_id ) ) {
			$post_in[] = $post_id;
		}
	}
	if ( ! empty( $post_in ) ) {
		$args['post__in'] = $post_in;
		$args['orderby'] = 'post__in';
	}
}


if ($source !== 'ids') {
	$args['order'] = $order;
	$args['orderby'] = $orderby;
}

$inner_class = array(
    'gf-blog-inner clearfix layout-grid'
);
$item_class = array(
    'event_item'
);
$owl_args = array();
$columns = intval($columns);
$event_columns_gutter = intval($event_columns_gutter);
$columns_md = intval($columns_md);
$columns_sm = intval($columns_sm);
$columns_xs = intval($columns_xs);
$columns_mb = intval($columns_mb);
$carousel_class = 'gsf-slider-container item-gutter-' . $event_columns_gutter;
if('on' === $is_slider) {
    $settings['post_paging'] = 'none';
    $inner_class[] = 'owl-carousel owl-theme';
    $owl_args = array(
        'items' => $columns,
        'margin' => 0,
        'slideBy' => $columns,
        'dots' => ($dots === 'on') ? true : false,
        'nav' => ($nav === 'on') ? true : false,
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
        ),
        'autoHeight' => true,
        'autoplay' => ($autoplay === 'on') ? true : false,
        'autoplayTimeout' => intval($autoplay_timeout),
    );
    if($nav_style == 'nav-square-text' || $nav_style == 'nav-circle-text') {
        $owl_args['navText'] = array('<i class="far fa-angle-left"></i> <span>'.esc_html__( 'Prev', 'auteur-framework' ).'</span>', '<span>'.esc_html__( 'Next', 'auteur-framework' ).'</span> <i class="far fa-angle-right"></i>');
    }
    if($nav === 'on') {
        $carousel_class .= ' ' . $nav_position. ' ' . $nav_style . ' ' .$nav_size. ' ' .$nav_hover_scheme .' '.$nav_hover_style;
    }
    $inner_class[] = $carousel_class;
} else {
    $item_class[] = G5P()->helper()->get_bootstrap_columns(array(
        'xl' => $columns,
        'lg' => $columns_md,
        'md' => $columns_sm,
        'sm' => $columns_xs,
        '' => $columns_mb,
    ));
    $inner_class[] = 'row gf-gutter-' . $event_columns_gutter;
}
$wrapper_class = implode(' ', array_filter($wrapper_classes));
if('' === $event_animation) {
    $event_animation = G5P()->options()->get_event_animation();
}
$item_inner_class = array(
    'event-item-inner',
    $this->getCSSAnimation($event_animation)
);
$image_ratio = '';
if (in_array($image_size,array('full','large','medium','thumbnail'))) {
    $image_ratio = G5Plus_Auteur()->options()->get_event_image_ratio();
    if ($image_ratio === 'custom') {
        $image_ratio_custom = G5Plus_Auteur()->options()->get_event_image_ratio_custom();
        if (is_array($image_ratio_custom) && isset($image_ratio_custom['width']) && isset($image_ratio_custom['height'])) {
            $image_ratio_custom_width = intval($image_ratio_custom['width']);
            $image_ratio_custom_height = intval($image_ratio_custom['height']);
            if (($image_ratio_custom_width > 0) && ($image_ratio_custom_height > 0)) {
                $image_ratio = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";
            }
        } elseif (preg_match('/x/', $image_ratio_custom)) {
            $image_ratio = $image_ratio_custom;
        }
    }

    if ($image_ratio === 'custom') {
        $image_ratio = '1x1';
    }
}
$data = tribe_get_events( $args, true );
?>
<div class="<?php echo esc_attr($wrapper_class) ?>">
    <?php if ($data->have_posts()) :?>
        <div class="<?php echo join(' ', $inner_class); ?>" <?php if(!empty($owl_args)): ?> data-owl-options='<?php echo json_encode( $owl_args );?>' <?php endif; ?>>
        <?php while ($data->have_posts()): $data->the_post();
            $post_id = get_the_ID();
            $attach_id = get_post_thumbnail_id();
            ?>
            <article class="<?php echo join(' ', $item_class) ?>">
                <div class="<?php echo join(' ', $item_inner_class); ?>">
                    <div class="event-image">
                        <?php
                        G5Plus_Auteur()->blog()->render_post_image_markup(array(
                            'post_id' => $post_id,
                            'image_id' => $attach_id,
                            'image_size' => $image_size,
                            'image_ratio' => $image_ratio,
                            'display_permalink' => true,
                            'image_mode' => 'background'
                        ));?>
                        <a href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="btn btn-classic btn-white btn-md btn-square btn-icon-right"><?php esc_html_e('View More', 'auteur-framework') ?><i class="fal fa-chevron-double-right"></i></a>
                    </div>
                    <?php
                    $date_no_year = tribe_get_date_option( 'dateWithoutYearFormat', Tribe__Date_Utils::DBDATEFORMAT );
                    $date_no_year = empty($date_no_year) ? get_option('date_format') : $date_no_year;
                    $event_start = tribe_get_start_date( $post_id, false, $date_no_year ); ?>
                    <div class="event-content">
                        <p class="event-start-time fw-extra-bold accent-color fs-15 uppercase"><a class="tribe-event-url gsf-link transition03" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark"><?php echo esc_html($event_start); ?></a></p>
                        <h3 class="tribe-events-list-event-title">
                            <a class="transition03 gsf-link" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
                                <?php the_title() ?>
                            </a>
                        </h3>
                        <?php
                        $time_format = get_option( 'time_format' );
                        $time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );
                        $time_start = tribe_get_start_date( $post_id, false, $time_format );
                        $time_end = tribe_get_end_date( $post_id, false, $time_format );
                        ?>
                        <div class="event-meta">
                            <?php
                            $venue_details = tribe_get_venue_details();
                            if(! empty( $venue_details['address'])):?>
                            <!-- Venue Display Info -->
                            <div class="tribe-events-venue-details tribe-events-address">
                                <i class="fal fa-map-marker-alt"></i> <?php echo sprintf('%s', $venue_details['address']); ?>
                            </div> <!-- .tribe-events-venue-details -->
                            <?php endif;?>
                            <div class="tribe-event-time">
                                <i class="fal fa-clock"></i> <span class="tribe-time"><?php echo esc_html($time_start) . esc_html($time_range_separator) . esc_html($time_end) ?></span>
                            </div>
                        </div>
                        <p class="event-excerpt"><?php echo get_the_excerpt(); ?></p>
                    </div>
                </div>
            </article>
            <?php wp_reset_postdata(); ?>
        <?php endwhile; ?>
        </div>
    <?php endif;?>
</div>
