<?php
return array(
	'base' => 'gsf_social_networks',
	'name' => esc_html__( 'Social Networks', 'auteur-framework' ),
	'icon' => 'fa fa-share-alt',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
		array(
			'param_name' => 'social_networks',
			'heading' => esc_html__('Social Networks', 'auteur-framework'),
			'type' => 'gsf_selectize',
			'multiple' => true,
			'drag' => true,
			'description' => esc_html__('Select Social Networks', 'auteur-framework'),
			'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_social_networks())
		),
		array(
			'param_name' => 'social_shape',
			'heading' => esc_html__('Social Shape', 'auteur-framework'),
			'type' => 'dropdown',
			'value' => array(
				esc_html__( 'Classic', 'auteur-framework' ) => 'classic',
				esc_html__( 'Circle Fill', 'auteur-framework' ) => 'circle',
                esc_html__( 'Circle Outline', 'auteur-framework' ) => 'circle-outline',
                esc_html__( 'Square', 'auteur-framework' ) => 'square',
			),
			'std' => 'classic'
		),
        array(
            'param_name' => 'social_size',
            'heading' => esc_html__('Social Size', 'auteur-framework'),
            'type' => 'dropdown',
            'value' => array(
                esc_html__( 'Small', 'auteur-framework' ) => 'small',
                esc_html__( 'Normal', 'auteur-framework' ) => 'normal',
                esc_html__( 'Large', 'auteur-framework' ) => 'large'
            ),
            'std' => 'normal'
        ),
        array(
            'type' => 'gsf_number_responsive',
            'heading' => esc_html__('Distance between items', 'auteur-framework'),
            'param_name' => 'space_between',
            'std' => '10||||'
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	),
);