<?php
return array(
    'name'     => esc_html__('Google Map', 'auteur-framework'),
    'base'     => 'gsf_google_map',
    'icon'     => 'fa fa-map-marker',
    'category' => G5P()->shortcode()->get_category_name(),
    'params'   => array(
        array(
            'type'       => 'param_group',
            'heading'    => esc_html__('Markers', 'auteur-framework'),
            'param_name' => 'markers',
            'value'      => urlencode(json_encode(array(
                array(
                    'label' => esc_html__('Title', 'auteur-framework'),
                    'value' => '',
                ),
            ))),
            'params'     => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Address ', 'auteur-framework'),
                    'param_name'  => 'address',
                    'admin_label' => true,
                    'value'       => '',
                    'description' => esc_html__( 'Enter address or coordinate. Example: 40.735601,-74.165918 or Central Business District', 'auteur-framework' )
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Title', 'auteur-framework'),
                    'param_name'  => 'title',
                    'admin_label' => true,
                    'value'       => '',
                ),
                array(
                    'type'       => 'textarea',
                    'heading'    => esc_html__('Description', 'auteur-framework'),
                    'param_name' => 'description',
                    'value'      => ''
                ),
                array(
                    'type'        => 'attach_image',
                    'heading'     => esc_html__('Marker Icon', 'auteur-framework'),
                    'param_name'  => 'icon',
                    'value'       => '',
                    'description' => esc_html__('Select an image from media library.', 'auteur-framework'),
                ),
            ),
        ),
        array(
            'type'             => 'gsf_number_and_unit',
            'heading'          => esc_html__('Map height', 'auteur-framework'),
            'param_name'       => 'map_height',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std'              => '500|px',
        ),
        array(
            'type'             => 'gsf_number_and_unit',
            'heading' => esc_html__('Map height in Large Devices', 'auteur-framework'),
            'description' => esc_html__('Browser Width < 1200px', 'auteur-framework'),
            'param_name'       => 'map_height_lg',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std'              => '450|px',
        ),
        array(
            'type'             => 'gsf_number_and_unit',
            'heading' => esc_html__('Map height in Medium Devices', 'auteur-framework'),
            'description' => esc_html__('Browser Width < 992px', 'auteur-framework'),
            'param_name'       => 'map_height_md',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std'              => '400|px',
        ),
        array(
            'type'             => 'gsf_number_and_unit',
            'heading' => esc_html__('Map height in Small Devices', 'auteur-framework'),
            'description' => esc_html__('Browser Width < 768px', 'auteur-framework'),
            'param_name'       => 'map_height_sm',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std'              => '350|px',
        ),
        array(
            'type'             => 'gsf_number_and_unit',
            'heading' => esc_html__('Map height in Extra Small Devices', 'auteur-framework'),
            'description' => esc_html__('Browser Width < 576px', 'auteur-framework'),
            'param_name'       => 'map_height_mb',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std'              => '300|px',
        ),
        array(
            'type'             => 'gsf_number',
            'heading'          => esc_html__('Map zoom level default', 'auteur-framework'),
            'param_name'       => 'map_zoom',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'args' => array(
                'min' => 0,
                'max' => 22,
                'step' => 1
            ),
            'std' => 13
        ),
        array(
            'type'             => 'gsf_switch',
            'heading'          => esc_html__('Zoom on scroll', 'auteur-framework'),
            'param_name'       => 'scroll_wheel',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std'              => ''
        ),
        array(
            'type'             => 'gsf_switch',
            'heading'          => esc_html__('Enable Overlay', 'auteur-framework'),
            'param_name'       => 'overlay',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std'              => 'on'
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Map Style', 'auteur-framework'),
            'param_name' => 'map_style',
            'std' => 'theme',
            'value' => array(
                esc_html__('Standar', 'auteur-framework') => 'standar',
                esc_html__('Themes Style (Default)', 'auteur-framework') => 'theme',
                esc_html__('Light', 'auteur-framework') => 'light',
                esc_html__('Dark', 'auteur-framework') => 'dark',
                esc_html__('Sliver', 'auteur-framework') => 'sliver',
                esc_html__('Retro', 'auteur-framework') => 'retro',
                esc_html__('Night', 'auteur-framework') => 'night',
                esc_html__('Aubergine', 'auteur-framework') => 'aubergine',
                esc_html__('Custom', 'auteur-framework') => 'custom'
            ),
            'admin_label'      => true,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type'             => 'textarea_raw_html',
            'heading'          => esc_html__('Custom map style', 'auteur-framework'),
            'param_name'       => 'map_style_content',
            'dependency' => array('element' => 'map_style', 'value' => 'custom'),
            'description' => wp_kses_post(__('Come <a target="_blank" href="https://snazzymaps.com/">here</a> to search map style code!', 'auteur-framework'))
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    ),
);