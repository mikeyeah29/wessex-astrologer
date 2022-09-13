<?php
return array(
	'base' => 'gsf_lists',
	'name' => esc_html__('Lists','auteur-framework'),
	'icon' => 'fa fa-list-ol',
    'category' => G5P()->shortcode()->get_category_name(),
	'params' =>	array(
	    array(
			'type' => 'dropdown',
			'heading' => esc_html__('Bullet Type', 'auteur-framework'),
			'param_name' => 'bullet_type',
			'value' => array(
				esc_html__('Number','auteur-framework') => 'list-number',
				esc_html__('Icon','auteur-framework') => 'list-icon',
				esc_html__('Dot','auteur-framework') => 'list-dot',
				esc_html__('Square','auteur-framework') => 'list-square',
			),
            'std' => 'list-number',
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Bullet Style', 'auteur-framework'),
			'param_name' => 'bullet_style',
			'value' => array(
                esc_html__('Simple','auteur-framework') => 'list-simple',
                esc_html__('Square','auteur-framework') => 'list-square-outline',
                esc_html__('Circle','auteur-framework') => 'list-circle-outline',
            ),
			'std' => 'list-simple',
			'description' => esc_html__( 'Select lists design style.', 'auteur-framework' ),
			'admin_label' => true,
			'dependency'  => array('element' => 'bullet_type', 'value' => 'list-icon'),
		),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__( 'Bullet Color', 'auteur-framework' ),
            'param_name' => 'bullet_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => '#333',
            'description' => esc_html__( 'Select bullet color.', 'auteur-framework' )
        ),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__( 'Label Color', 'auteur-framework' ),
			'param_name' => 'label_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
			'description' => esc_html__( 'Select Label color.', 'auteur-framework' ),
            'std' => '#696969'
		),
        array(
            'type' => 'gsf_number_and_unit',
            'heading' => esc_html__('Distance between items', 'auteur-framework'),
            'param_name' => 'space_between',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'value' => '10|px'
        ),
        G5P()->shortcode()->vc_map_add_icon_font(array(
            'dependency'  => array('element' => 'bullet_type', 'value' => 'list-icon')
        )),
		array(
			'type' => 'param_group',
			'heading' => esc_html__('Values','auteur-framework'),
			'param_name' => 'values',
			'description' => esc_html__('Enter values for list - icon and text','auteur-framework'),
			'value' => '',
			'params' => array(
				array(
					'type' => 'textarea',
					'heading' => esc_html__( 'Label', 'auteur-framework' ),
					'param_name' => 'label',
					'admin_label' => true,
				),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Custom Bullet', 'auteur-framework' ),
                    'param_name' => 'custom_bullet',
                    'description' => esc_html__('Set empty for default', 'auteur-framework')
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Bullet Color', 'auteur-framework' ),
                    'param_name' => 'bullet_color',
                    'std' => '',
                    'description' => esc_html__( 'Set empty for default.', 'auteur-framework' )
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__( 'Label Color', 'auteur-framework' ),
                    'param_name' => 'label_color',
                    'description' => esc_html__( 'Set empty for default.', 'auteur-framework' ),
                    'std' => ''
                ),
                G5P()->shortcode()->vc_map_add_icon_font(),
			)
		),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
	)
);
