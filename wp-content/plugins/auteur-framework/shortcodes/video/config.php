<?php
return array(
	'name' => esc_html__( 'Video', 'auteur-framework' ),
	'base' => 'gsf_video',
	'icon' => 'fa fa-play-circle',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Video Icon Style', 'auteur-framework'),
            'param_name' => 'video_style',
            'value' => array(
                esc_html__('Outline', 'auteur-framework') => 'outline',
                esc_html__('Fill', 'auteur-framework') => 'fill'
            ),
            'std' =>'outline'
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Video Icon Size', 'auteur-framework'),
            'param_name' => 'video_size',
            'value' => array(
                esc_html__('Large', 'auteur-framework') => 'large',
                esc_html__('Medium', 'auteur-framework') => 'medium',
                esc_html__('Small', 'auteur-framework') => 'small'),
            'std' =>'large',
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Link', 'auteur-framework' ),
            'param_name' => 'link',
            'value' => '',
            'description' => esc_html__( 'Enter link video', 'auteur-framework' ),
        ),

        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Background/Border Color', 'auteur-framework' ),
            'param_name' => 'icon_bg_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => G5P()->options()->get_accent_color()
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Color', 'auteur-framework' ),
            'param_name' => 'icon_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => G5P()->options()->get_foreground_accent_color()
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Background Hover Color', 'auteur-framework' ),
            'param_name' => 'icon_bg_hover_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => '#333'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Icon Hover Color', 'auteur-framework' ),
            'param_name' => 'icon_hover_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => '#fff'
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
	)
);