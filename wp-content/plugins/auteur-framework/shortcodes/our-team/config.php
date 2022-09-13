<?php
return array(
    'base'     => 'gsf_our_team',
    'name'     => esc_html__('Our Team', 'auteur-framework'),
    'icon'     => 'fa fa-users',
    'category' => G5P()->shortcode()->get_category_name(),
    'params'   => array(
        array(
            'type'       => 'gsf_image_set',
            'heading'    => esc_html__('Layout Style', 'auteur-framework'),
            'param_name' => 'layout_style',
            'value'      => array(
                'style-1' => array(
                    'label' => esc_html__('Style 01', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/ourteam-1.jpg'),
                ),
                'style-2' => array(
                    'label' => esc_html__('Style 02', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/ourteam-2.jpg'),
                ),
                'style-3' => array(
                    'label' => esc_html__('Style 03', 'auteur-framework'),
                    'img' => G5P()->pluginUrl('assets/images/shortcode/ourteam-3.jpg'),
                ),
            ),
            'std' => 'style-1'
        ),
        array(
            'type'       => 'attach_image',
            'heading'    => esc_html__('Image:', 'auteur-framework'),
            'param_name' => 'image',
            'value'      => '',
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Name', 'auteur-framework'),
            'param_name'  => 'ourteam_name',
            'admin_label' => true,
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Position', 'auteur-framework'),
            'param_name' => 'ourteam_position',
            'value'      => ''
        ),
        array(
            'type'       => 'vc_link',
            'heading'    => esc_html__('Link (url)', 'auteur-framework'),
            'param_name' => 'link',
            'value'      => '',
        ),
        array(
            'type'       => 'param_group',
            'heading'    => esc_html__('Social', 'auteur-framework'),
            'param_name' => 'socials',
            'params'     => array(
                G5P()->shortcode()->vc_map_add_icon_font(array(
                    'admin_label' => true
                )),
                array(
                    'type'       => 'vc_link',
                    'heading'    => esc_html__('Link (url)', 'auteur-framework'),
                    'param_name' => 'social_link',
                    'value'      => '',
                )
            ),
            'dependency' => array('element' => 'layout_style', 'value_not_equal_to' => array('style-2')),
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    )
);
