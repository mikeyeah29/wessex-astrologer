<?php
return array(
	'base' => 'gsf_product_category',
	'name' => esc_html__( 'Product Category', 'auteur-framework' ),
	'icon' => 'fa fa-image',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' => array(
        array(
            'type' => 'gsf_image_set',
            'heading' => esc_html__('Layout Style', 'auteur-framework'),
            'param_name' => 'layout_style',
            'value' => array(
                'style-01' => array(
                    'label' => esc_html__('Style 01', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/shop-category-01.png')
                ),
                'style-02' => array(
                    'label' => esc_html__('Style 02', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/shop-category-02.jpg')
                ),
				'style-03' => array(
					'label' => esc_html__('Style 03', 'auteur-framework'),
					'img' => G5P()->pluginUrl('assets/images/shortcode/shop-category-03.jpg')
				),
				'style-04' => array(
					'label' => esc_html__('Style 04', 'auteur-framework'),
					'img' => G5P()->pluginUrl('assets/images/shortcode/shop-category-04.png')
				)
            ),
            'std' => 'style-01',
            'admin_label' => true
        ),
        G5P()->shortcode()->vc_map_add_product_category(),
		array(
			'type' => 'attach_image',
			'heading' => esc_html__('Background Image', 'auteur-framework'),
			'edit_field_class' => 'vc_col-sm-6 vc_column',
			'param_name' => 'image'
		),
        array(
            'param_name'        => 'hover_effect',
            'heading'     => esc_html__('Hover Effect', 'auteur-framework'),
            'type'      => 'dropdown',
            'std'      => '',
            'value' => array(
                esc_html__('None', 'auteur-framework') => '',
                esc_html__('Suprema', 'auteur-framework') => 'suprema-effect',
                esc_html__('Layla', 'auteur-framework') => 'layla-effect',
                esc_html__('Bubba', 'auteur-framework') => 'bubba-effect',
                esc_html__('Jazz', 'auteur-framework') => 'jazz-effect',
                esc_html__('Flash', 'auteur-framework') => 'flash-effect'
            ),
            'dependency' => array('element' => 'layout_style', 'value' => array('style-01', 'style-04'))
        ),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Category Heading Size', 'auteur-framework'),
            'param_name' => 'title_size',
            'std' => 'title-size-small',
            'value' => array(
                esc_html__('Small', 'auteur-framework') => 'title-size-small',
                esc_html__('Large', 'auteur-framework') => 'title-size-large',
            ),
			'dependency' => array('element' => 'layout_style', 'value' => array('style-01'))
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
			'dependency' => array('element' => 'banner_bg_image', 'value_not_equal_to' => array('')),
			'description' => esc_html__( 'Sizing proportions for height and width. Select "Original" to scale image without cropping.', 'auteur-framework' )
		),
		array(
			'type' => 'gsf_number_and_unit',
			'heading' => esc_html__( 'Height', 'auteur-framework' ),
			'param_name' => 'height',
			'std' => '340|px',
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