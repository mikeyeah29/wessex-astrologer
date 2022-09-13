<?php
return array(
    'base'        => 'gsf_view_demo',
    'name'        => esc_html__('View Demo', 'auteur-framework'),
    'icon'        => 'fa fa-eye',
    'category' => G5P()->shortcode()->get_category_name(),
    'params'      => array_merge(
        array(
            array(
                'type' => 'gsf_image_set',
                'heading' => esc_html__('Layout Style', 'auteur-framework'),
                'param_name' => 'layout_style',
                'value' => apply_filters('gsf_view_demo_layout_style', array(
                    'style-01' => array(
                        'label' => esc_html__('Style 01', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/view-demo-01.png')
                    ),
                    'style-02' => array(
                        'label' => esc_html__('Style 02', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/view-demo-02.png')
                    )
                )),
                'std' => 'style-01',
                'admin_label' => true
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Text Alignment', 'auteur-framework'),
                'param_name' => 'text_align',
                'description' => esc_html__('Select text alignment.', 'auteur-framework'),
                'value' => array(
                    esc_html__('Left', 'auteur-framework') => 'text-left',
                    esc_html__('Center', 'auteur-framework') => 'text-center',
                    esc_html__('Right', 'auteur-framework') => 'text-right'
                ),
                'std' => 'text-center',
                'admin_label' => true,
            ),
            array(
                'param_name' => 'columns_gutter',
                'heading' => esc_html__('Columns Gutter', 'auteur-framework'),
                'description' => esc_html__('Specify your horizontal space between items.', 'auteur-framework'),
                'type' => 'dropdown',
                'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_post_columns_gutter()),
                'std' => '30',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Scroll on Hover', 'auteur-framework' ),
                'param_name' => 'scroll_on_hover',
                'std' => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type'       => 'param_group',
                'heading'    => esc_html__('Demo Items', 'auteur-framework'),
                'param_name' => 'demo_items',
                'params'     => array(
                    array(
                        'type'        => 'textfield',
                        'heading'     => esc_html__('Title demo', 'auteur-framework'),
                        'param_name'  => 'title',
                        'value'       => '',
                        'admin_label' => true,
                    ),
                    array(
                        'type'        => 'attach_image',
                        'heading'     => esc_html__('Images', 'auteur-framework'),
                        'param_name'  => 'image',
                        'value'       => ''
                    ),
                    array(
                        'type' => 'gsf_switch',
                        'heading' => esc_html__('Mark as Coming Soon', 'auteur-framework'),
                        'param_name' => 'is_coming_soon',
                        'std' => ''
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => esc_html__('URL (Link)', 'auteur-framework'),
                        'param_name' => 'link',
                        'dependency' => array('element' => 'is_coming_soon', 'value_not_equal_to' => 'on')
                    ),
                    array(
                        'type' => 'gsf_switch',
                        'heading' => esc_html__('Mark as New Item', 'auteur-framework'),
                        'param_name' => 'is_new',
                        'std' => '',
                        'dependency' => array('element' => 'is_coming_soon', 'value_not_equal_to' => 'on')
                    )
                ),
            )
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
