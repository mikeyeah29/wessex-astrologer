<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage auteur
 * @since auteur 1.0
 */
return array(
    'base' => 'gsf_button',
    'name' => esc_html__('Button', 'auteur-framework'),
    'category' => G5P()->shortcode()->get_category_name(),
    'description' => esc_html__('Eye catching button', 'auteur-framework'),
    'icon'        => 'fa fa-bold',
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Text', 'auteur-framework'),
            'param_name' => 'title',
            'value' => esc_html__('Text on the button', 'auteur-framework'),
            'admin_label' => true,
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__('URL (Link)', 'auteur-framework'),
            'param_name' => 'link',
            'description' => esc_html__('Add link to button.', 'auteur-framework'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Style', 'auteur-framework'),
            'description' => esc_html__('Select button display style.', 'auteur-framework'),
            'param_name' => 'style',
            'value' => array(
                esc_html__('Classic', 'auteur-framework') => 'classic',
                esc_html__('Outline', 'auteur-framework') => 'outline',
                esc_html__('Link', 'auteur-framework') => 'link'
            ),
            'std' => 'classic',
            'admin_label' => true,
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Border Color', 'auteur-framework'),
            'param_name' => 'border_color',
            'std' => '#fe3d7d',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
            'dependency' => array(
                'element' => 'style',
                'value' => 'skew',
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Shape', 'auteur-framework'),
            'description' => esc_html__('Select button shape.', 'auteur-framework'),
            'param_name' => 'shape',
            'value' => array(
                esc_html__('Rounded', 'auteur-framework') => 'rounded',
                esc_html__('Square', 'auteur-framework') => 'square',
                esc_html__('Round', 'auteur-framework') => 'round',
            ),
            'dependency' => array(
                'element' => 'style',
                'value_not_equal_to' => array('link'),
            ),
            'std' => 'square',
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Color', 'auteur-framework'),
            'param_name' => 'color',
            'description' => esc_html__('Select button color.', 'auteur-framework'),
            'value' => array(
                esc_html__('Accent', 'auteur-framework') => 'accent',
                esc_html__('Primary', 'auteur-framework') => 'primary',
                esc_html__('Gray', 'auteur-framework') => 'gray',
                esc_html__('Black', 'auteur-framework') => 'black',
                esc_html__('White', 'auteur-framework') => 'white',
                esc_html__('Red', 'auteur-framework') => 'red',
            ),
            'std' => 'primary',
            'admin_label' => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Size', 'auteur-framework'),
            'param_name' => 'size',
            'description' => esc_html__('Select button display size.', 'auteur-framework'),
            'std' => 'md',
            'value' => array(
                esc_html__('Mini', 'auteur-framework') => 'xs',
                esc_html__('Small', 'auteur-framework') => 'sm',
                esc_html__('Normal', 'auteur-framework') => 'md',
                esc_html__('Large', 'auteur-framework') => 'lg',
            ),
            'admin_label' => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Alignment', 'auteur-framework'),
            'param_name' => 'align',
            'description' => esc_html__('Select button alignment.', 'auteur-framework'),
            'value' => array(
                esc_html__('Inline', 'auteur-framework') => 'inline',
                esc_html__('Left', 'auteur-framework') => 'left',
                esc_html__('Right', 'auteur-framework') => 'right',
                esc_html__('Center', 'auteur-framework') => 'center',
            ),
            'std' => 'inline',
            'admin_label' => true,
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => esc_html__('Set full width button?', 'auteur-framework'),
            'param_name' => 'button_block',
            'std' => '',
            'dependency' => array(
                'element' => 'align',
                'value_not_equal_to' => 'inline',
            ),
            'admin_label' => true,
        ),

        G5P()->shortcode()->vc_map_add_icon_font(),
        array(
            'type' => 'gsf_button_set',
            'heading' => esc_html__('Icon Alignment', 'auteur-framework'),
            'description' => esc_html__('Select icon alignment.', 'auteur-framework'),
            'param_name' => 'icon_align',
            'value' => array(
                esc_html__('Left', 'auteur-framework') => 'left',
                esc_html__('Right', 'auteur-framework') => 'right',
            ),
            'dependency' => array(
                'element' => 'icon_font',
                'value_not_equal_to' => array(''),
            ),
        ),
        array(
            'type' => 'gsf_switch',
            'heading' => esc_html__('Advanced on click action', 'auteur-framework'),
            'param_name' => 'custom_onclick',
            'std' => '',
            'description' => esc_html__('Insert inline onclick javascript action.', 'auteur-framework'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('On click code', 'auteur-framework'),
            'param_name' => 'custom_onclick_code',
            'description' => esc_html__('Enter onclick action code.', 'auteur-framework'),
            'dependency' => array(
                'element' => 'custom_onclick',
                'value' => 'on',
            ),
        ),
        G5P()->shortcode()->vc_map_add_css_animation(),
        G5P()->shortcode()->vc_map_add_animation_duration(),
        G5P()->shortcode()->vc_map_add_animation_delay(),
        G5P()->shortcode()->vc_map_add_extra_class(),
        G5P()->shortcode()->vc_map_add_css_editor(),
        G5P()->shortcode()->vc_map_add_responsive()
    )
);