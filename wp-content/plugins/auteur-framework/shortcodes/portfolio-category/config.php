<?php
return array(
	'base' => 'gsf_portfolio_category',
	'name' => esc_html__( 'Portfolio Category', 'auteur-framework' ),
	'icon' => 'fa fa-image',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
        G5P()->shortcode()->vc_map_add_portfolio_category(),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__('Background Image', 'auteur-framework'),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'image'
		),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Height Mode', 'auteur-framework' ),
			'param_name' => 'height_mode',
			'value' => array(
				'1:1' => '100',
				esc_html__( 'Original', 'auteur-framework' )=> 'original',
				'4:3' => '133.333333333',
				'3:4' => '75',
				'16:9' => '177.777777778',
				'9:16' => '56.25',
				esc_html__( 'Custom', 'auteur-framework' )=> 'custom'
			),
			'std' => 'original',
			'description' => esc_html__( 'Sizing proportions for height and width. Select "Original" to scale image without cropping.', 'auteur-framework' )
		),
		array(
			'type' => 'gsf_number_and_unit',
			'heading' => esc_html__( 'Height', 'auteur-framework' ),
			'param_name' => 'height',
			'std' => '420|px',
			'dependency' => array('element' => 'height_mode', 'value' => 'custom'),
			'description' => esc_html__( 'Enter custom height', 'auteur-framework' )
		),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	),
);