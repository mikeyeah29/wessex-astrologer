<?php
/**
 * Single Event Meta Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta.php
 *
 * @version 4.6.10
 *
 * @package TribeEventsCalendar
 */

do_action( 'tribe_events_single_meta_before' );

// Check for skeleton mode (no outer wrappers per section)
$not_skeleton = ! apply_filters( 'tribe_events_single_event_the_meta_skeleton', false, get_the_ID() );
$venue_details = tribe_get_venue_details();
// Do we want to group venue meta separately?
$set_venue_apart = apply_filters( 'tribe_events_single_event_the_meta_group_venue', false, get_the_ID() );
?>

<?php if ( $not_skeleton ) : ?>
    <div class="tribe-events-single-section tribe-events-event-meta primary tribe-clearfix">
<?php endif; ?>

<?php
do_action( 'tribe_events_single_event_meta_primary_section_start' );

// Include venue meta if appropriate.
if ( tribe_get_venue_id() ) {
    // If we have no map to embed and no need to keep the venue separate...
    if (tribe_embed_google_map() ) {
        echo '<div class="tribe-events-meta-group tribe-events-meta-group-gmap">';
        tribe_get_template_part( 'modules/meta/map' );
        echo '</div>';
    }
    if ( tribe_show_google_map_link() ) : ?>
        <?php
        $map_link = esc_url( tribe_get_map_link( get_the_ID() ) );

        $link = '';

        if ( ! empty( $map_link ) ) {
            $link = sprintf(
                '<a class="tribe-events-gmap gsf-link transition03" href="%s" title="%s" target="_blank">%s</a>',
                $map_link,
                esc_html__( 'Click to view a Google Map', 'g5plus-auteur' ),
                '<i class="fal fa-map-marker-alt"></i>' . $venue_details['address']
            );
        }
        echo wp_kses_post($link); ?>
    <?php endif;
}

do_action( 'tribe_events_single_event_meta_primary_section_end' );
?>

<?php if ( $not_skeleton ) : ?>
    </div>
<?php endif;
do_action( 'tribe_events_single_meta_after' );
