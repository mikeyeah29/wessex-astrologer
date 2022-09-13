<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();

// Venue
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';
$image_size = G5Plus_Auteur()->options()->get_event_image_size();
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

$post_id = get_the_ID();

?>
<!-- Event Image -->
<div class="event-image">
	<?php
	if(function_exists('G5Plus_Auteur')) {
        $img_id = get_post_thumbnail_id($post_id);
        if($img_id) {
            G5Plus_Auteur()->blog()->render_post_image_markup(array(
                'post_id' => $post_id,
                'image_id' => $img_id,
                'image_size' => $image_size,
                'image_ratio' => $image_ratio,
                'display_permalink' => true,
                'image_mode' => 'background'
            ));
        }
    }
	?>
    <a href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="btn btn-classic btn-white btn-md btn-square btn-icon-right"><?php esc_html_e('View More', 'g5plus-auteur') ?><i class="fal fa-chevron-double-right"></i></a>
</div>
<?php
$date_no_year = tribe_get_date_option( 'dateWithoutYearFormat', Tribe__Date_Utils::DBDATEFORMAT );
$date_no_year = empty($date_no_year) ? get_option('date_format') : $date_no_year;
$event_start = tribe_get_start_date( $post_id, false, $date_no_year ); ?>
<div class="event-content">
    <p class="event-start-time fw-extra-bold accent-color fs-15 uppercase"><a class="tribe-event-url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark"><?php echo esc_html($event_start); ?></a></p>
	<!-- Event Title -->
    <?php do_action( 'tribe_events_before_the_event_title' ) ?>
        <h2 class="tribe-events-list-event-title">
            <a class="gsf-link transition03 tribe-event-url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
                <?php the_title() ?>
            </a>
        </h2>
    <?php do_action( 'tribe_events_after_the_event_title' ) ?>
        <!-- Event Meta -->
    <?php do_action( 'tribe_events_before_the_meta' ) ?>
        <div class="tribe-events-event-meta">
            <div class="author <?php echo esc_attr( $has_venue_address ); ?>">
                <?php if ( $venue_details ):?>
                    <?php if(! empty( $venue_details['address'])):?>
                        <!-- Venue Display Info -->
                        <div class="tribe-events-venue-details tribe-events-address">
                            <i class="fal fa-map-marker-alt"></i> <?php echo sprintf('%s', $venue_details['address']); ?>
                        </div> <!-- .tribe-events-venue-details -->
                    <?php endif;
                    $time_format = get_option( 'time_format' );
                    $time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );
                    $time_start = tribe_get_start_date( $post_id, false, $time_format );
                    $time_end = tribe_get_end_date( $post_id, false, $time_format );
                    ?>
                    <div class="tribe-event-time">
                        <i class="fal fa-clock"></i> <span class="tribe-time"><?php echo esc_html($time_start) . esc_html($time_range_separator) . esc_html($time_end) ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div><!-- .tribe-events-event-meta -->
    <?php do_action( 'tribe_events_after_the_meta' ) ?>
</div>
<?php
do_action( 'tribe_events_after_the_content' );