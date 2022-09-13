<?php
return array(
    'base' => 'gsf_pricing_tables',
    'name' => esc_html__('Pricing Tables', 'auteur-framework'),
    'icon' => 'fa fa-money',
    'category' => G5P()->shortcode()->get_category_name(),
    'params' => array(
        array(
            'param_name' => 'layout_style',
            'heading' => esc_html__('Layout Style', 'auteur-framework'),
            'description' => esc_html__('Specify your layout style', 'auteur-framework'),
            'type' => 'gsf_image_set',
            'value' => array(
                'style-1' => array(
                    'label' => esc_html__('Style 1', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/pricing-1.jpg'),
                ),
                'style-2' => array(
                    'label' => esc_html__('Style 2', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/pricing-2.jpg'),
                ),
                'style-3' => array(
                    'label' => esc_html__('Style 3', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/pricing-3.jpg'),
                ),
            ),
            'std' => 'style-1',
            'admin_label' => true
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Name', 'auteur-framework'),
            'param_name' => 'name',
            'admin_label' => true,
        ),
        array(
            'type' => 'gsf_number',
            'heading' => esc_html__('Min Height (px)', 'auteur-framework'),
            'param_name' => 'min_height',
            'std' => ''
        ),
        array(
            'type' => 'gsf_number',
            'heading' => esc_html__('Price', 'auteur-framework'),
            'param_name' => 'price',
            'admin_label' => true,
            'edit_field_class' => 'vc_col-sm-6 vc_column'
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Currency Code', 'auteur-framework'),
            'description' => esc_html__('Enter Currency Code. Ex: $, £, €, ₫ ...', 'auteur-framework'),
            'param_name' => 'currency_code',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Time text', 'auteur-framework'),
            'description' => esc_html__('Enter text for time. Ex: day, mo or year', 'auteur-framework'),
            'param_name' => 'text_time',
        ),
        array(
            'type' => 'checkbox',
            'heading' => esc_html__('Is Featured?', 'auteur-framework'),
            'param_name' => 'is_featured',
            'admin_label' => true,
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Featured Caption', 'auteur-framework'),
            'description' => esc_html__('Enter text for featured.', 'auteur-framework'),
            'param_name' => 'featured_text',
            'dependency' => array('element' => 'is_featured', 'value' => array('true', true)),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'param_group',
            'heading' => esc_html__('Features', 'auteur-framework'),
            'param_name' => 'values',
            'value' => urlencode(json_encode(array(
                array(
                    'label' => esc_html__('Features', 'auteur-framework'),
                    'value' => '',
                ),
            ))),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Feature', 'auteur-framework'),
                    'param_name' => 'features',
                    'value' => '',
                ),
            ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Button Text', 'auteur-framework'),
            'param_name' => 'button_text',
            'group' => esc_html__('Button Options', 'auteur-framework')
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__('URL (Link)', 'auteur-framework'),
            'param_name' => 'link',
            'description' => esc_html__('Add link to button.', 'auteur-framework'),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'group' => esc_html__('Button Options', 'auteur-framework')
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    ),
);