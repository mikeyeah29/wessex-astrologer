<?php
/**
 * List View Template
 * The wrapper template for a list of events. This includes the Past Events and Upcoming Events views
 * as well as those same views filtered to a specific category.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$main_class = array('site-content-archive-event');
do_action('g5plus_before_archive_event');
?>
	<main  class="<?php echo esc_attr(join(' ',$main_class) ) ?>">
        <?php
        do_action( 'tribe_events_before_template' );
        ?>

        <!-- Tribe Bar -->
        <?php tribe_get_template_part( 'modules/bar' ); ?>

        <!-- Main Events Content -->
        <?php tribe_get_template_part( 'list/content' ); ?>

        <div class="tribe-clear"></div>

        <?php
        do_action( 'tribe_events_after_template' );
        ?>
	</main>