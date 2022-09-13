<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 */


$time_format = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );

$start_datetime = tribe_get_start_date();
$start_date = tribe_get_start_date( null, false );
$start_time = tribe_get_start_date( null, false, $time_format );
$start_ts = tribe_get_start_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$end_datetime = tribe_get_end_date();
$end_date = tribe_get_display_end_date( null, false );
$end_time = tribe_get_end_date( null, false, $time_format );
$end_ts = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$time_formatted = null;
if ( $start_time == $end_time ) {
	$time_formatted = esc_html( $start_time );
} else {
	$time_formatted = esc_html( $start_time . $time_range_separator . $end_time );
}

$event_id = Tribe__Main::post_id_helper();

/**
 * Returns a formatted time for a single event
 *
 * @var string Formatted time string
 * @var int Event post id
 */
$time_formatted = apply_filters( 'tribe_events_single_event_time_formatted', $time_formatted, $event_id );

/**
 * Returns the title of the "Time" section of event details
 *
 * @var string Time title
 * @var int Event post id
 */
$time_title = apply_filters( 'tribe_events_single_event_time_title', esc_html__( 'Time:', 'g5plus-auteur' ), $event_id );

$cost    = tribe_get_formatted_cost();
$website = tribe_get_event_website_link();
?>

<div class="widget tribe-events-meta-group tribe-events-meta-group-details">
	<h2 class="widget-title"><span><?php esc_html_e( 'Details', 'g5plus-auteur' ) ?></span></h2>
	<div class="details-wrap">

		<?php
		do_action( 'tribe_events_single_meta_details_section_start' );

		// All day (multiday) events
		if ( tribe_event_is_all_day() && tribe_event_is_multiday() ) :
			?>
            <div class="detail-item">
                <span class="detail-label tribe-events-start-date-label"><?php esc_html_e( 'Start:', 'g5plus-auteur' ) ?></span><?php echo esc_html( $start_date ) ?>
            </div>
            <div class="detail-item">
                <span class="detail-label tribe-events-end-date-label"> <?php esc_html_e( 'End:', 'g5plus-auteur' ) ?></span> <?php echo esc_html( $end_date ) ?>
            </div>
		<?php
		// All day (single day) events
		elseif ( tribe_event_is_all_day() ):
			?>

            <div class="detail-item">
                <span class="detail-label tribe-events-start-date-label"> <?php esc_html_e( 'Date:', 'g5plus-auteur' ) ?></span> <?php echo esc_html( $start_date ) ?>
            </div>

		<?php
		// Multiday events
		elseif ( tribe_event_is_multiday() ) :
			?>

            <div class="detail-item">
                <span class="detail-label tribe-events-start-datetime-label"> <?php esc_html_e( 'Start:', 'g5plus-auteur' ) ?></span> <?php echo esc_html( $start_datetime ) ?>
            </div>
            <div class="detail-item">
                <span class="detail-label tribe-events-end-datetime-label"> <?php esc_html_e( 'End:', 'g5plus-auteur' ) ?></span> <?php echo esc_html( $end_datetime ) ?>
            </div>

		<?php
		// Single day events
		else :
			?>

            <div class="detail-item">
                <span class="detail-label tribe-events-start-date-label"> <?php esc_html_e( 'Date:', 'g5plus-auteur' ) ?> </span>
                <span class="detail-value tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr( $start_ts ) ?>"> <?php echo esc_html( $start_date ) ?> </span>
            </div>

            <div class="detail-item">
                <span class="detail-label tribe-events-start-time-label"> <?php echo esc_html( $time_title ); ?> </span>
                <span class="detail-value tribe-events-abbr tribe-events-start-time published dtstart" title="<?php echo esc_attr( $end_ts ) ?>"><?php echo esc_html($time_formatted); ?> </span>
            </div>
		<?php endif ?>

		<?php
		// Event Cost
		if ( ! empty( $cost ) ) : ?>

            <div class="detail-item">
                <span class="detail-label tribe-events-event-cost-label"> <?php esc_html_e( 'Cost:', 'g5plus-auteur' ) ?></span> <?php echo esc_html( $cost ); ?>
            </div>
		<?php endif ?>
            <?php
            echo tribe_get_event_categories(
                get_the_id(), array(
                    'before'       => '',
                    'sep'          => ', ',
                    'after'        => '',
                    'label'        => null, // An appropriate plural/singular label will be provided
                    'label_before' => '<div class="detail-item"><span class="detail-label tribe-events-event-categories-label">',
                    'label_after'  => '</span>',
                    'wrap_before'  => '',
                    'wrap_after'   => '</div>',
                )
            );
            ?>
        <?php
        $list      = get_the_term_list( get_the_ID(), 'post_tag', '<div class="detail-item"><span class="detail-label">' . esc_html__('Event Tags:', 'g5plus-auteur') . '</span> ', ', ', '</div>' );
        $list      = apply_filters( 'tribe_meta_event_tags', $list, esc_html__('Event Tags:', 'g5plus-auteur'), ', ' );
        echo wp_kses_post($list);
        ?>
		<?php
		// Event Website
		if ( ! empty( $website ) ) : ?>

            <div class="detail-item">
                <span class="detail-label tribe-events-event-url-label"> <?php esc_html_e( 'Website:', 'g5plus-auteur' ) ?></span> <?php echo wp_kses_post($website); ?>
            </div>
		<?php endif ?>

		<?php do_action( 'tribe_events_single_meta_details_section_end' ) ?>
	</div>
</div>
