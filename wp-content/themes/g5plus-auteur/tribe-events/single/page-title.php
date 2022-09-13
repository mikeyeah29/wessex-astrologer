<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 19/12/2018
 * Time: 2:10 CH
 */
$event_id = get_the_ID();
echo '<div class="singe-event-page-title">';
echo tribe_event_featured_image( $event_id, 'full', false );
$date_no_year = tribe_get_date_option( 'dateWithoutYearFormat', Tribe__Date_Utils::DBDATEFORMAT );
$date_no_year = empty($date_no_year) ? get_option('date_format') : $date_no_year;
$event_start = tribe_get_start_date( $event_id, false, $date_no_year );
?>
<div class="event-main-info">
    <div class="event-main-info-inner">
        <p class="event-start-time fw-extra-bold gsf-white-text fs-15 uppercase"><?php echo esc_html($event_start); ?></p>
        <?php the_title( '<h1 class="tribe-events-single-event-title"><span class="gsf-white-text">', '</span></h1>' ); ?>
    </div>
</div>
<?php
echo '</div>';