<?php
return array(
    'base'        => 'gsf_time_line',
    'name'        => esc_html__('Time Line', 'auteur-framework'),
    'icon'        => 'fa fa-line-chart',
    'description' => esc_html__('Show time line by insert', 'auteur-framework'),
    'category' => G5P()->shortcode()->get_category_name(),
    'params'      => array(
        array(
            'type'        => 'param_group',
            'heading'     => esc_html__('Values', 'auteur-framework'),
            'param_name'  => 'values',
            'description' => esc_html__('Enter values for time line', 'auteur-framework'),
            'value'       => '',
            'params'      => array(
                array(
                    'type'        => 'gsf_number',
                    'heading'     => esc_html__('Year', 'auteur-framework'),
                    'param_name'  => 'year',
                    'admin_label' => true,
                ),
                array(
                    'type'       => 'attach_image',
                    'heading'    => esc_html__('Feature Image:', 'auteur-framework'),
                    'param_name' => 'image',
                    'value'      => '',
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Title', 'auteur-framework'),
                    'param_name'  => 'title',
                    'admin_label' => true,
                ),
                array(
                    'type'       => 'textarea',
                    'heading'    => esc_html__('Description', 'auteur-framework'),
                    'param_name' => 'description'
                )
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