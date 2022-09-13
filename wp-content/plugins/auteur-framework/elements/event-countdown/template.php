<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

/**
 * @var $element UBE_Element_Auteur_Event_Countdown
 */

if (!is_singular(Tribe__Events__Main::POSTTYPE))
{
    esc_html_e('Widget only works on single event page.');
	return;
}

$atts = $element->get_settings_for_display();

$wrapper_classes = array(
	'ube-event-countdown',
	'gsf-event-countdown',
	'gsf-countdown',
	'clearfix',
);

if ('on' !== $atts['day_enable']) {
	$wrapper_classes[] = 'gsf-countdown-hide-day';
}

$time_format = get_option('time_format');
$time = tribe_get_start_date(get_the_ID(), false, tribe_get_date_format(true)) . ' ' . tribe_get_start_date(get_the_ID(), false, $time_format);

$element->set_render_attribute('wrapper', array(
	'class' => $wrapper_classes,
	'data-url-redirect' => '',
	'data-date-end' => mysql2date('Y/m/d H:i:s', $time),
));


$inner_classes = array(
	'gsf-countdown-inner',
	"countdown-{$atts['post_layout']}",
);

$element->set_render_attribute('inner-wrapper', array(
	'class' => $inner_classes
));
?>
<div <?php echo $element->get_render_attribute_string('wrapper') ?>>
    <div <?php echo $element->get_render_attribute_string('inner-wrapper') ?>>
        <div class="countdown-section countdown-day">
            <span class="countdown-value">00</span>
            <span class="countdown-text"><?php esc_html_e('Days', 'auteur-framework'); ?></span>
        </div>
        <div class="countdown-section countdown-hours">
            <span class="countdown-value">00</span>
            <span class="countdown-text"><?php esc_html_e('Hours', 'auteur-framework'); ?></span>
        </div>
        <div class="countdown-section countdown-minutes">
            <span class="countdown-value">00</span>
            <span class="countdown-text"><?php esc_html_e('Mins', 'auteur-framework'); ?></span>
        </div>
        <div class="countdown-section countdown-seconds">
            <span class="countdown-value">00</span>
            <span class="countdown-text"><?php esc_html_e('Secs', 'auteur-framework'); ?></span>
        </div>
    </div>
</div>
