<?php
return array(
	'base' => 'gsf_info_box',
	'name' => esc_html__('Info Box','auteur-framework'),
	'icon' => 'fa fa-diamond',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
		array(
			'type' => 'gsf_image_set',
			'heading' => esc_html__('Layout Style', 'auteur-framework'),
			'param_name' => 'layout_style',
			'value' => apply_filters('gsf_info_box_layout_style',array(
				'text-left' => array(
					'label' => esc_html__('Style 01', 'auteur-framework'),
					'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-01.png'),
				),
				'text-center' => array(
					'label' => esc_html__('Style 02', 'auteur-framework'),
					'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-02.png'),
				),
				'text-right' => array(
					'label' => esc_html__('Style 03', 'auteur-framework'),
					'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-03.png'),
				),
				'ib-left' => array(
					'label' => esc_html__('Style 04', 'auteur-framework'),
					'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-04.png'),
				),
                'ib-right' => array(
                    'label' => esc_html__('Style 05', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-05.png'),
                ),
                'ib-left-inline' => array(
                    'label' => esc_html__('Style 06', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-06.png'),
                ),
                'ib-right-inline' => array(
                    'label' => esc_html__('Style 07', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/info-box-07.png'),
                )
			)),
			'std' => 'text-left',
			'admin_label' => true
		),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Title', 'auteur-framework' ),
            'param_name' => 'title',
            'value' => '',
            'admin_label' => true,
        ),
		array(
			'type' => 'gsf_switch',
			'heading' => __( 'Use theme default font family?', 'auteur-framework' ),
			'param_name' => 'use_theme_fonts',
            'group' => esc_html__('Title Options', 'auteur-framework'),
			'std' => 'on',
			'description' => __( 'Use font family from the theme.', 'auteur-framework' ),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array(''))
		),
		array(
			'type' => 'gsf_typography',
			'param_name' => 'typography',
            'group' => esc_html__('Title Options', 'auteur-framework'),
			'dependency' => array('element' => 'use_theme_fonts', 'value_not_equal_to' => 'on')
		),
        array(
            'type' => 'gsf_number_responsive',
            'heading' => esc_html__('Title Font Size', 'auteur-framework'),
            'param_name' => 'title_font_size',
            'group' => esc_html__('Title Options', 'auteur-framework'),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'std' => '20||||'
        ),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Title Letter Spacing', 'auteur-framework'),
            'param_name' => 'title_letter_spacing',
            'group' => esc_html__('Title Options', 'auteur-framework'),
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
            'std' => '0|px',
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Sub Title', 'auteur-framework' ),
            'param_name' => 'sub_title',
            'value' => '',
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'gsf_number',
            'heading' => esc_html__('Sub Title Font Size', 'auteur-framework'),
            'param_name' => 'sub_title_font_size',
            'std' => 15,
            'dependency' => array('element' => 'sub_title', 'value_not_equal_to' => array('')),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
		array(
			'type' => 'textarea_html',
			'heading' => esc_html__('Description', 'auteur-framework'),
			'param_name' => 'content',
			'description' => esc_html__('Provide the description for this element.', 'auteur-framework')
		),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__('Link (url)', 'auteur-framework'),
            'param_name' => 'link',
            'value' => '',
        ),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('Title Color', 'auteur-framework'),
			'param_name' => 'title_color',
			'std' => '#363636',
			'edit_field_class' => 'vc_col-sm-6 vc_column'
		),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Background Color', 'auteur-framework'),
            'param_name' => 'ib_bg_color',
            'std' => G5P()->options()->get_foreground_accent_color(),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Box Shadow', 'auteur-framework' ),
            'param_name' => 'ib_box_shadow',
            'std' => '',
            'description' => __( 'Set empty for hidden', 'auteur-framework' ),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),


        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Icon Type', 'auteur-framework'),
            'param_name' => 'icon_type',
            'group' => esc_html__('Icon Options', 'auteur-framework'),
            'value' => array(
                esc_html__('Icon', 'auteur-framework') => 'icon',
                esc_html__('Image', 'auteur-framework') => 'image',
            ),
            'std' => 'icon'
        ),
        array(
			'type'        => 'attach_image',
			'heading'     => esc_html__('Images', 'auteur-framework'),
			'param_name'  => 'image',
			'group' => esc_html__('Icon Options', 'auteur-framework'),
			'value'       => '',
			'description' => esc_html__('Select images from media library.', 'auteur-framework'),
			'dependency' => array('element' => 'icon_type', 'value' => 'image')
		),
        G5P()->shortcode()->vc_map_add_icon_font(array(
            'group' => esc_html__('Icon Options', 'auteur-framework'),
            'dependency' => array('element' => 'icon_type', 'value' => 'icon')
        )),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Icon Background Style', 'auteur-framework'),
            'param_name' => 'icon_bg_style',
            'value' => array(
                esc_html__('Classic', 'auteur-framework') => 'icon-classic',
                esc_html__('Circle - Fill Color', 'auteur-framework') => 'icon-bg-circle-fill',
                esc_html__('Circle - Outline', 'auteur-framework') => 'icon-bg-circle-outline',
                esc_html__('Square - Fill Color', 'auteur-framework') => 'icon-bg-square-fill',
                esc_html__('Square - Outline', 'auteur-framework') => 'icon-bg-square-outline',
                esc_html__('Icon float on Circle Background', 'auteur-framework') => 'icon-float-on-circle'
            ),
            'std' => 'icon-classic',
            'group' => esc_html__('Icon Options', 'auteur-framework'),
            'description' => esc_html__('Select Icon Background Style.', 'auteur-framework'),
			'dependency' => array('element' => 'icon_type', 'value' => 'icon')
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Icon Color', 'auteur-framework'),
            'param_name' => 'icon_color',
            'std' => G5P()->options()->get_accent_color(),
            'group' => esc_html__('Icon Options', 'auteur-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
			'dependency' => array('element' => 'icon_type', 'value' => 'icon'),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Background Color', 'auteur-framework'),
            'param_name' => 'icon_bg_color',
            'std' => '#333',
            'group' => esc_html__('Icon Options', 'auteur-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element'=>'icon_bg_style', 'value_not_equal_to'=>'icon-classic')
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Icon Box Shadow', 'auteur-framework' ),
            'param_name' => 'ib_icon_box_shadow',
            'std' => '',
            'group' => esc_html__('Icon Options', 'auteur-framework'),
            'description' => __( 'Set empty for hidden', 'auteur-framework' ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element'=>'icon_bg_style', 'value_not_equal_to'=>'icon-classic')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Icon Size', 'auteur-framework'),
            'param_name' => 'icon_size',
            'value' => array(
                esc_html__('Large', 'auteur-framework') => 'ib-large',
                esc_html__('Medium', 'auteur-framework') => 'ib-medium',
                esc_html__('Small', 'auteur-framework') => 'ib-small'
            ),
            'std' => 'ib-large',
            'group' => esc_html__('Icon Options', 'auteur-framework'),
            'description' => esc_html__('Select Color Scheme.', 'auteur-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'icon_type', 'value' => 'icon'),
        ),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Icon Vertical Alignment', 'auteur-framework'),
            'param_name' => 'icon_align',
            'value' => array(
                esc_html__('Top', 'auteur-framework') => 'icon-align-top',
                esc_html__('Middle', 'auteur-framework') => 'icon-align-middle'
            ),
            'std' => 'icon-align-top',
            'group' => esc_html__('Icon Options', 'auteur-framework'),
            'description' => esc_html__('Select Icon Vertical Alignment.', 'auteur-framework'),
            'dependency' => array('element'=>'layout_style', 'value'=>array('ib-left','ib-right')),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Distance between Icon and Content', 'auteur-framework'),
            'param_name' => 'distance_between',
            'value' => array(
                esc_html__('Low', 'auteur-framework') => 'distance-low',
                esc_html__('Medium', 'auteur-framework') => 'distance-medium',
                esc_html__('Tall', 'auteur-framework') => 'distance-tall'
            ),
            'std' => 'distance-low',
            'group' => esc_html__('Icon Options', 'auteur-framework'),
            'dependency' => array('element'=>'layout_style', 'value'=>array('text-left', 'text-center','text-right')),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),

        array(
            'type' => 'gsf_switch',
            'heading' => esc_html__('Flip on Hover', 'auteur-framework'),
            'param_name' => 'flip_on_hover',
            'group' => esc_html__('Hover Options', 'auteur-framework'),
            'std' => ''
        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__('Background Images on Flip', 'auteur-framework'),
            'param_name' => 'flip_bg_image',
            'value' => '',
            'description' => esc_html__('Select images from media library.', 'auteur-framework'),
            'group' => esc_html__('Hover Options', 'auteur-framework'),
            'dependency' => array('element' => 'flip_on_hover', 'value' => array('on'))
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Background Color', 'auteur-framework'),
            'param_name' => 'hover_bg_color',
            'std' => '#fff',
            'description' => __( 'Choose background color when hover', 'auteur-framework' ),
            'group' => esc_html__('Hover Options', 'auteur-framework'),
            'dependency' => array('element' => 'flip_on_hover', 'value_not_equal_to' => array('on')),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Box Shadow', 'auteur-framework' ),
            'param_name' => 'ib_hover_box_shadow',
            'std' => '',
            'group' => esc_html__('Hover Options', 'auteur-framework'),
            'description' => __( 'Set empty for hidden', 'auteur-framework' ),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Title', 'auteur-framework'),
            'param_name' => 'hover_text_color',
            'std' => '#333',
            'description' => __( 'Choose color when hover', 'auteur-framework' ),
            'group' => esc_html__('Hover Options', 'auteur-framework'),
            'dependency' => array('element' => 'flip_on_hover', 'value_not_equal_to' => array('on')),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Icon Color', 'auteur-framework'),
            'param_name' => 'icon_hover_color',
            'std' => G5P()->options()->get_accent_color(),
            'description' => __( 'Choose icon color when hover', 'auteur-framework' ),
            'group' => esc_html__('Hover Options', 'auteur-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'flip_on_hover', 'value_not_equal_to' => array('on'))
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
	)
);