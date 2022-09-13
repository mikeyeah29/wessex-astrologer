<?php
return array(
	'base' => 'gsf_counter',
	'name' => esc_html__( 'Counter', 'auteur-framework' ),
	'icon' => 'fa fa-tachometer',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Alignment', 'auteur-framework'),
            'param_name' => 'text_align',
            'description' => esc_html__('Select Alignment for counter', 'auteur-framework'),
            'value' => array(
                esc_html__('Left', 'auteur-framework') => 'text-left',
                esc_html__('Center', 'auteur-framework') => 'text-center',
                esc_html__('Right', 'auteur-framework') => 'text-right'
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => 'text-center'
        ),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Counter Size', 'auteur-framework'),
            'param_name' => 'counter_size',
            'description' => esc_html__('Select Size for counter', 'auteur-framework'),
            'value' => array(
                esc_html__('Medium', 'auteur-framework') => 'counter-size-md',
                esc_html__('Large', 'auteur-framework') => 'counter-size-lg',
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => 'counter-size-md'
        ),
		G5P()->shortcode()->vc_map_add_title(array('admin_label' => true)),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Custom Title Color', 'auteur-framework'),
            'param_name' => 'title_color',
            'std' => '',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'title', 'value_not_equal_to' => array('')),
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __('Use Theme Default Font family for Counter title?', 'auteur-framework'),
            'param_name' => 'title_use_theme_fonts',
            'std' => 'on'
        ),
        array(
            'type' => 'gsf_typography',
            'param_name' => 'title_typography',
            'dependency' => array('element' => 'title_use_theme_fonts', 'value_not_equal_to' => 'on')
        ),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Start Value', 'auteur-framework'),
			'param_name'       => 'start',
			'value'            => '',
			'std'              => '0',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'auteur-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('End Value', 'auteur-framework'),
			'param_name'       => 'end',
			'value'            => '',
			'std'              => '1000',
			'admin_label' => true,
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'auteur-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Decimals', 'auteur-framework'),
			'param_name'       => 'decimals',
			'value'            => '',
			'std'              => '0',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'auteur-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Duration (s)', 'auteur-framework'),
			'param_name'       => 'duration',
			'value'            => '',
			'std'              => '2,5',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'auteur-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Separator', 'auteur-framework'),
			'param_name'       => 'separator',
			'value'            => '',
			'std'              => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'auteur-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Decimal', 'auteur-framework'),
			'param_name'       => 'decimal',
			'value'            => '',
			'std'              => '.',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'auteur-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Prefix', 'auteur-framework'),
			'param_name'       => 'prefix',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'auteur-framework')
		),
		array(
			'type'             => 'textfield',
			'heading'          => esc_html__('Suffix', 'auteur-framework'),
			'param_name'       => 'suffix',
			'value'            => '',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Value Options', 'auteur-framework')
		),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Value Color', 'auteur-framework'),
            'param_name' => 'main_color',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'std' => G5P()->options()->get_accent_color(),
            'group' => esc_html__('Value Options', 'auteur-framework')
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => __('Use Theme Default Font family for Counter title?', 'auteur-framework'),
            'param_name' => 'value_use_theme_fonts',
            'std' => 'on',
            'group' => esc_html__('Value Options', 'auteur-framework')
        ),
        array(
            'type' => 'gsf_typography',
            'param_name' => 'value_typography',
            'dependency' => array('element' => 'value_use_theme_fonts', 'value_not_equal_to' => 'on'),
            'group' => esc_html__('Value Options', 'auteur-framework')
        ),
		G5P()->shortcode()->vc_map_add_icon_font(),
		array(
			'type' => 'colorpicker',
			'heading' => esc_html__('ICon Color', 'auteur-framework'),
			'param_name' => 'icon_color',
			'std' => '#333',
			'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array('element' => 'icon_font', 'value_not_equal_to' => ''),
		),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	),
);