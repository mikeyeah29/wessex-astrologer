<?php
return array(
	'base'        => 'gsf_partners',
	'name'        => esc_html__('Partners', 'auteur-framework'),
	'icon'        => 'fa fa-user-plus',
	'category'    => G5P()->shortcode()->get_category_name(),
	'params'      =>array(
		array(
            'type'       => 'param_group',
            'heading'    => esc_html__('Partner Info', 'auteur-framework'),
            'param_name' => 'partners',
            'params'     => array(
                array(
                    'type'        => 'attach_image',
                    'heading'     => esc_html__('Images', 'auteur-framework'),
                    'param_name'  => 'image',
                    'value'       => '',
                    'description' => esc_html__('Select images from media library.', 'auteur-framework')
                ),
                array(
                    'type'       => 'vc_link',
                    'heading'    => esc_html__('Link (url)', 'auteur-framework'),
                    'param_name' => 'link',
                    'value'      => '',
                ),
            ),
        ),
		array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Items', 'auteur-framework'),
            'param_name'       => 'items',
            'value'            => array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6),
            'std'              => 3,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'admin_label' => true,
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => esc_html__('Is Slider?', 'auteur-framework'),
            'param_name' => 'is_slider',
            'std' => '',
            'admin_label' => true,
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        G5P()->shortcode()->vc_map_add_pagination(array(
            'dependency' => array('element' => 'is_slider', 'value' => 'on'),
            'group' => esc_html__('Slider Options', 'auteur-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        )),
        G5P()->shortcode()->vc_map_add_navigation(array(
            'dependency' => array('element' => 'is_slider', 'value' => 'on'),
            'group' => esc_html__('Slider Options', 'auteur-framework'),
        )),
        G5P()->shortcode()->vc_map_add_navigation_position(array(
            'group' => esc_html__('Slider Options', 'auteur-framework')
        )),
        G5P()->shortcode()->vc_map_add_navigation_style(array(
            'group' => esc_html__('Slider Options', 'auteur-framework')
        )),
        G5P()->shortcode()->vc_map_add_navigation_size(array(
            'group' => esc_html__('Slider Options', 'auteur-framework')
        )),
        G5P()->shortcode()->vc_map_add_navigation_hover_style(array(
            'group' => esc_html__('Slider Options', 'auteur-framework')
        )),
        G5P()->shortcode()->vc_map_add_navigation_hover_scheme(array(
            'group' => esc_html__('Slider Options', 'auteur-framework')
        )),
        G5P()->shortCode()->vc_map_add_autoplay_enable(array(
            'dependency' => array('element' => 'is_slider', 'value' => 'on'),
            'group' => esc_html__('Slider Options', 'auteur-framework'),
        )),
        G5P()->shortCode()->vc_map_add_autoplay_timeout(array(
            'group' => esc_html__('Slider Options', 'auteur-framework'),
        )),
        array(
            'type'             => 'dropdown',
            'heading'          => esc_html__('Columns Gutter', 'auteur-framework'),
            'param_name'       => 'columns_gutter',
            'value'            => array(
                '30px' => '30',
                '20px' => '20',
                '10px' => '10',
                esc_html__('None', 'auteur-framework') => '0',
            ),
            'std'              => '30',
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type'             => 'gsf_button_set',
            'heading'          => esc_html__('Effect at first', 'auteur-framework'),
            'param_name'       => 'effect_at_first',
            'value'            => array(
                esc_html__('Opacity', 'auteur-framework') => 'opacity',
                esc_html__('GrayScale', 'auteur-framework') => 'grayscale',
                esc_html__('Both Opacity and GrayScale', 'auteur-framework') => 'all'
            ),
            'std'              => 'opacity'
        ),
        array(
            'type'             => 'gsf_slider',
            'heading'          => esc_html__('Opacity value', 'auteur-framework'),
            'param_name'       => 'opacity',
            'args' => array(
                'min'   => 1,
                'max'   => 100,
                'step'  => 1
            ),
            'std' => 100,
            'description' => esc_html__('Select opacity for images at first.', 'auteur-framework'),
            'dependency' => array('element' => 'effect_at_first', 'value'=>array('opacity', 'all'))
        ),
        array(
            'type'             => 'gsf_slider',
            'heading'          => esc_html__('GrayScale value', 'auteur-framework'),
            'param_name'       => 'grayscale',
            'args' => array(
                'min'   => 1,
                'max'   => 100,
                'step'  => 1
            ),
            'std' => 100,
            'description' => esc_html__('Select grayscale for images at first.', 'auteur-framework'),
            'dependency' => array('element' => 'effect_at_first', 'value'=>array('grayscale', 'all'))
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => esc_html__('Set Partner with border', 'auteur-framework' ),
            'param_name' => 'border',
            'admin_label' => true,
            'edit_field_class' => 'vc_col-sm-4 vc_column'
        ),
		array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Tablet landscape', 'auteur-framework'),
            'param_name'  => 'items_md',
            'description' => esc_html__('Browser Width >= 992px and < 1200px', 'auteur-framework'),
            'value'       => array(esc_html__('Default', 'auteur-framework') => -1, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6),
            'std'         => -1,
            'group'       => esc_html__('Responsive', 'auteur-framework')
        ),
		array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Tablet portrait', 'auteur-framework'),
            'param_name'  => 'items_sm',
            'description' => esc_html__('Browser Width >= 768px and < 991px', 'auteur-framework'),
            'value'       => array(esc_html__('Default', 'auteur-framework') => -1, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6),
            'std'         => -1,
            'group'       => esc_html__('Responsive', 'auteur-framework')
        ),
		array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Mobile landscape', 'auteur-framework'),
            'param_name'  => 'items_xs',
            'description' => esc_html__('Browser Width >= 576px and < 768px', 'auteur-framework'),
            'value'       => array(esc_html__('Default', 'auteur-framework') => -1, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6),
            'std'         => -1,
            'group'       => esc_html__('Responsive', 'auteur-framework')
        ),
		array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Mobile portrait', 'auteur-framework'),
            'param_name'  => 'items_mb',
            'description' => esc_html__('Browser Width < 576px', 'auteur-framework'),
            'value'       => array(esc_html__('Default', 'auteur-framework') => -1, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6),
            'std'         => -1,
            'group'       => esc_html__('Responsive', 'auteur-framework')
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    )
);

