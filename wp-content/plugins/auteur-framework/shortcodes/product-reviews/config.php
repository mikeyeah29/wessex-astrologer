<?php
return array(
	'base' => 'gsf_product_reviews',
	'name' => esc_html__( 'Product Reviews', 'auteur-framework' ),
	'icon' => 'fa fa-star',
	'category' => G5P()->shortcode()->get_category_name(),
	'params' =>  array_merge(
        array(
            array(
                'type' => 'gsf_number',
                'heading' => esc_html__('Items to show', 'auteur-framework' ),
                'param_name' => 'items_per_page',
                'std' => 6,
                'args' => array(
                    'min' => -1,
                    'max' => 500,
                    'step' => 1
                ),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Columns Gutter', 'auteur-framework'),
                'param_name' => 'columns_gutter',
                'value' => array(
                    esc_html__('None', 'auteur-framework') => 'none',
                    esc_html__('10px', 'auteur-framework') => '10',
                    esc_html__('20px', 'auteur-framework') => '20',
                    esc_html__('30px', 'auteur-framework') => '30'
                ),
                'std' => '30',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Is Slider?', 'auteur-framework' ),
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
            ))
        ),
        G5P()->shortCode()->get_column_responsive(),
		array(
            G5P()->shortcode()->vc_map_add_css_animation(),
            G5P()->shortcode()->vc_map_add_animation_duration(),
            G5P()->shortcode()->vc_map_add_animation_delay(),
            G5P()->shortcode()->vc_map_add_extra_class(),
            G5P()->shortcode()->vc_map_add_css_editor(),
            G5P()->shortcode()->vc_map_add_responsive()
        )
	),
);