<?php
/**
 * Created by PhpStorm.
 * User: MyPC
 * Date: 21/12/2018
 * Time: 2:01 CH
 */

$organizer_ids = tribe_get_organizer_ids();
$multiple = count( $organizer_ids ) > 1;

$phone = tribe_get_organizer_phone();
$email = tribe_get_organizer_email();
$website = tribe_get_organizer_website_link();
?>
<?php if(tribe_has_organizer()): ?>
    <div class="widget tribe-events-organizer">
        <h2 class="tribe-events-single-section-title widget-title"><span><?php esc_html_e('Speaker', 'g5plus-auteur'); ?></span></h2>
        <?php
        $wrapper_class = array('organizers-wrap');
        $owl_args = array();
        if($multiple) {
            $wrapper_class[] = 'owl-carousel owl-theme nav-top-right nav-normal nav-style-01 hover-accent';
            $owl_args = array(
                'items'      => 1,
                'margin'     => 0,
                'loop'       => false,
                'autoHeight' => true,
                'nav'        => true
            );
        }?>
        <div class="<?php echo esc_attr(join(' ', $wrapper_class)); ?>"<?php if(!empty($owl_args)): ?> data-owl-options='<?php echo esc_attr(json_encode($owl_args)); ?>'<?php endif; ?>>
            <?php foreach ( $organizer_ids as $organizer ) {
                if ( ! $organizer ) {
                    continue;
                }
                ?>
                <div class="event-organizer-item">
                    <?php
                    $name = get_the_title($organizer);
                    $position = G5Plus_Auteur()->metaBoxEvent()->get_organizer_position($organizer);
                    $avatar = G5Plus_Auteur()->metaBoxEvent()->get_organizer_avatar($organizer);
                    if(is_array($avatar) && isset($avatar['id'])) {
                        $avatar = $avatar['id'];
                    };
                    G5Plus_Auteur()->blog()->render_post_image_markup(array(
                        'image_id' => $avatar,
                        'image_size' => '370x450',
                        'display_permalink' => false,
                        'image_mode' => 'background'
                    ));
                    ?>
                    <div class="organizer-info">
                        <h5 class="organizer-name fw-bold mg-top-25 mg-bottom-10 uppercase"><?php echo esc_html($name); ?></h5>
                        <p class="organizer-position fs-15 mg-bottom-0">/ <?php echo esc_html($position); ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php endif;
tribe_get_template_part( 'modules/meta/details' );

$schedule = G5Plus_Auteur()->metaBoxEvent()->get_section_event_schedule(get_the_ID());
if(!empty($schedule)):?>
    <div class="single-event-schedule widget">
        <h2 class="widget-title"><span><?php esc_html_e('Schedule', 'g5plus-auteur'); ?></span></h2>
        <?php $time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' ); ?>
        <?php foreach ($schedule as $phase):
            $time_start = date_i18n(get_option('time_format'),$phase['time_start']);
            $time_end = date_i18n(get_option('time_format'),$phase['time_end']);
            $title = $phase['title'];
            $organizer = $phase['organizer'];
            ?>
            <div class="event-phase-item">
                <div class="tribe-event-time">
                    <i class="fal fa-clock"></i> <span class="tribe-time"><?php echo esc_html($time_start) . esc_html($time_range_separator) . esc_html($time_end) ?></span>
                </div>
                <?php if(!empty($title)): ?>
                    <h6 class="phase-title mg-top-10 mg-bottom-10"><?php echo esc_html($title); ?></h6>
                <?php endif; ?>
                <?php if(!empty($organizer)):
                    $position = G5Plus_Auteur()->metaBoxEvent()->get_organizer_position($organizer);?>
                    <p class="phase-organizer"><?php esc_html_e('By ', 'g5plus-auteur') ?><span class="organizer-name"><?php echo esc_html(get_the_title($organizer)); ?></span> <?php echo esc_html($position); ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif;
