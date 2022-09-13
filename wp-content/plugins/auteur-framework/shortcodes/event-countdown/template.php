<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $layout_style
 * @var $number_font_size
 * @var $main_color
 * @var $day_enable
 * @var $title_use_theme_fonts
 * @var $title_typography
 * @var $css_animation
 * @var $animation_duration
 * @var $animation_delay
 * @var $el_class
 * @var $css
 * @var $responsive
 * Shortcode class
 * @var $this WPBakeryShortCode_GSF_Event_Countdown
 */
$layout_style = $number_font_size = $main_color = $day_enable = $title_use_theme_fonts = $title_typography = $css_animation = $animation_duration = $animation_delay = $el_class = $css = $responsive = '';
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);
if (!is_singular(Tribe__Events__Main::POSTTYPE)) return;
$date_with_year_format    = tribe_get_date_format( true );
$time_format              = get_option( 'time_format' );
$time = tribe_get_start_date( get_the_ID(), false, $date_with_year_format ) . ' ' . tribe_get_start_date( get_the_ID(), false, $time_format );
$shortcode = '[gsf_countdown layout_style="' . $layout_style . '" time="' . $time . '" number_font_size="' . $number_font_size . '" main_color="' . $main_color . '" day_enable="' . $day_enable . '" 
        css_animation="' . $css_animation .'" animation_duration="' . $animation_duration . '" animation_delay="' . $animation_delay . '" 
        el_class="' . $el_class . '" css="' . $css . '" responsive="' . $responsive . '" title_use_theme_fonts="' . $title_use_theme_fonts . '" title_typography="' . $title_typography . '"]';
echo do_shortcode($shortcode);