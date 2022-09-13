<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$venue_details = tribe_get_venue_details();
$event_id = get_the_ID();
//get_header();
?>

<?php tribe_the_notices() ?>
    <!-- #tribe-events-header -->
<?php while ( have_posts() ) :  the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <!-- Event content -->
        <h2 class="about-the-event"><?php esc_html_e('About The Event', 'g5plus-auteur'); ?></h2>
        <div class="tribe-events-event-meta-top">
            <?php if ( $venue_details ):?>
                <?php if(! empty( $venue_details['address'])):?>
                    <!-- Venue Display Info -->
                    <div class="tribe-events-venue-details tribe-events-address">
                        <i class="fal fa-map-marker-alt"></i> <?php echo sprintf('%s', $venue_details['address']); ?>
                    </div> <!-- .tribe-events-venue-details -->
                <?php endif;
                $date_with_year = tribe_get_date_option( 'dateWithYearFormat', Tribe__Date_Utils::DBDATEFORMAT );
                $date_with_year = empty($date_with_year) ? get_option('date_format') : $date_with_year;
                $event_start = tribe_get_start_date( $event_id, false, $date_with_year );

                $time_format = get_option( 'time_format' );
                $time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );
                $time_start = tribe_get_start_date( $event_id, false, $time_format );
                $time_end = tribe_get_end_date( $event_id, false, $time_format );
                ?>
                <div class="tribe-event-date">
                    <i class="fal fa-calendar"></i> <span class="tribe-date"><?php echo esc_html($event_start); ?></span>
                </div>
                <div class="tribe-event-time">
                    <i class="fal fa-clock"></i> <span class="tribe-time"><?php echo esc_html($time_start) . esc_html($time_range_separator) . esc_html($time_end) ?></span>
                </div>
            <?php endif; ?>
        </div>
        <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
        <div class="tribe-events-single-event-description tribe-events-content">
            <?php the_content(); ?>
        </div>
        <!-- .tribe-events-single-event-description -->
        <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
        <!-- Event meta -->
        <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
        <?php tribe_get_template_part( 'modules/meta' ); ?>
        <?php do_action('g5plus_single_post_share'); ?>
        <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
    </div> <!-- #post-x -->
<?php endwhile; ?>

    <!-- Event footer -->
    <div id="tribe-events-footer">
        <!-- Navigation -->
        <h3 class="tribe-events-visuallyhidden"><?php printf( esc_html__( '%s Navigation', 'g5plus-auteur' ), $events_label_singular ); ?></h3>
        <ul class="tribe-events-sub-nav">
            <li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
            <li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
        </ul>
        <!-- .tribe-events-sub-nav -->
    </div>
<?php if (get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) { comments_template(); } ?>
    <!-- #tribe-events-footer -->

<?php

//get_footer(); ?>