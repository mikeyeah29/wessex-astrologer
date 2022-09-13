<?php
return array(
    'base' => 'gsf_heading',
    'name' => esc_html__('Heading', 'auteur-framework'),
    'icon' => 'fa fa-header',
    'category' => G5P()->shortcode()->get_category_name(),
    'params' => array(
        array(
            'type' => 'gsf_image_set',
            'heading' => esc_html__('Layout Style', 'auteur-framework'),
            'param_name' => 'layout_style',
            'value' => apply_filters('gsf_heading_layout_style', array(
                'style-1' => array(
                    'label' => esc_html__('Style 01', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-1.jpg'),
                ),
                'style-2' => array(
                    'label' => esc_html__('Style 02', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-2.jpg'),
                ),
                'style-3' => array(
                    'label' => esc_html__('Style 03', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-3.jpg'),
                ),
                'style-4' => array(
                    'label' => esc_html__('Style 04', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-6.jpg'),
                ),
                'style-5' => array(
                    'label' => esc_html__('Style 05', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-4.jpg'),
                ),
                'style-6' => array(
                    'label' => esc_html__('Style 06', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/heading-5.jpg'),
                )
            )),
            'std' => 'style-1',
            'admin_label' => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Text Alignment', 'auteur-framework'),
            'param_name' => 'text_align',
            'description' => esc_html__('Select text alignment.', 'auteur-framework'),
            'value' => array(
                esc_html__('Left', 'auteur-framework') => 'text-left justify-content-start',
                esc_html__('Center', 'auteur-framework') => 'text-center justify-content-center',
                esc_html__('Right', 'auteur-framework') => 'text-right justify-content-end'
            ),
            'std' => 'text-center justify-content-center',
            'admin_label' => true,
        ),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Distance between Title and Subtitle', 'auteur-framework'),
            'param_name' => 'space_between',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'layout_style', 'value' => array('style-3', 'style-4')),
            'value' => '30|px'
        ),
        array(
            'type' => 'textarea_raw_html',
            'heading' => esc_html__('Title', 'auteur-framework'),
            'param_name' => 'title',
            'value' => base64_encode( '' )
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Title Color', 'auteur-framework'),
            'param_name' => 'title_color',
            'std' => '#333',
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'group' => esc_html__('Title Options', 'auteur-framework')
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Title Text Shadow Color', 'auteur-framework'),
            'param_name' => 'title_text_shadow_color',
            'std' => '#fbf16f',
            'dependency' => array('element' => 'layout_style', 'value' => array('style-6')),
            'group' => esc_html__('Title Options', 'auteur-framework')
        ),
        array(
            'type' => 'gsf_number_responsive',
            'heading' => esc_html__('Font size', 'auteur-framework'),
            'param_name' => 'title_font_size',
            'group' => esc_html__('Title Options', 'auteur-framework'),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'value' => '56|48|40|34|30'
        ),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Title Line Height', 'auteur-framework'),
            'param_name' => 'title_line_height',
            'std' => '1.2|em',
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Title Options', 'auteur-framework')
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Sub Title', 'auteur-framework'),
            'param_name' => 'sub_title',
            'dependency' => array('element' => 'layout_style', 'value_not_equal_to' => array('style-5')),
        ),
        array(
            'type' => 'gsf_number_responsive',
            'heading' => esc_html__('Sub Title Font size', 'auteur-framework'),
            'param_name' => 'sub_title_font_size',
            'group' => esc_html__('Sub Title Options', 'auteur-framework'),
            'dependency' => array('element' => 'sub_title', 'value_not_equal_to' => array('')),
            'value' => '18||||'
        ),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Sub Title Letter Spacing', 'auteur-framework'),
            'param_name' => 'sub_title_letter_spacing',
            'std' => '5|px',
            'dependency' => array('element' => 'sub_title', 'value_not_equal_to' => array('')),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Sub Title Options', 'auteur-framework')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Sub Title color', 'auteur-framework'),
            'param_name' => 'sub_title_color',
            'value' => array(
                esc_html__('Accent Color', 'auteur-framework') => 'accent-color',
                esc_html__('Heading Color', 'auteur-framework') => 'heading-color',
                esc_html__('Text Color', 'auteur-framework') => 'text-color',
                esc_html__('Disable Color', 'auteur-framework') => 'disable-color',
                esc_html__('Primary Color', 'auteur-framework') => 'primary-color',
            ),
            'std' => 'accent-color',
            'group' => esc_html__('Sub Title Options', 'auteur-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'sub_title', 'value_not_equal_to' => array(''))
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __('Use Theme Default Font family for Heading title?', 'auteur-framework'),
            'param_name' => 'title_use_theme_fonts',
            'std' => 'on',
            'group' => esc_html__('Title Options', 'auteur-framework'),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array(''))
        ),
        array(
            'type' => 'gsf_typography',
            'param_name' => 'title_typography',
            'dependency' => array('element' => 'title_use_theme_fonts', 'value_not_equal_to' => 'on'),
            'group' => esc_html__('Title Options', 'auteur-framework')
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __('Use Theme Default Font family for Heading sub title?', 'auteur-framework'),
            'param_name' => 'sub_title_use_theme_fonts',
            'std' => 'on',
            'group' => esc_html__('Sub Title Options', 'auteur-framework'),
            'dependency' => array('element' => 'sub_title', 'value_not_equal_to' => array(''))
        ),
        array(
            'type' => 'gsf_typography',
            'param_name' => 'sub_title_typography',
            'dependency' => array('element' => 'sub_title_use_theme_fonts', 'value_not_equal_to' => 'on'),
            'group' => esc_html__('Sub Title Options', 'auteur-framework'),
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    ),
);