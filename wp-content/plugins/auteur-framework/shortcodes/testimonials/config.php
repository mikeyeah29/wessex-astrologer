<?php
return array(
    'base' => 'gsf_testimonials',
    'name' => esc_html__('Testimonials', 'auteur-framework'),
    'icon' => 'fa fa-quote-right',
    'category' => G5P()->shortcode()->get_category_name(),
    'params' => array_merge(
        array(
            array(
                'type' => 'gsf_image_set',
                'heading' => esc_html__('Testimonials Layout', 'auteur-framework'),
                'description' => esc_html__('Select our testimonial layout.', 'auteur-framework'),
                'param_name' => 'layout_style',
                'value' => apply_filters('gsf_testimonials_layout_style', array(
                    'style-01' => array(
                        'label' => esc_html__('Style 01', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/testimonials-1.jpg'),
                    ),
                    'style-02' => array(
                        'label' => esc_html__('Style 02', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/testimonials-2.jpg'),
                    ),
                    'style-03' => array(
                        'label' => esc_html__('Style 03', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/testimonials-3.jpg'),
                    ),
                    'style-04' => array(
                        'label' => esc_html__('Style 04', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/testimonials-4.jpg'),
                    ),
                    'style-05' => array(
                        'label' => esc_html__('Style 05', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/testimonials-5.jpg'),
                    )
                )),
                'std' => 'style-01',
                'admin_label' => true,
            ),
            array(
                'type'        => 'attach_image',
                'heading'     => esc_html__('Upload Blockquote Image:', 'auteur-framework'),
                'param_name'  => 'quote_image',
                'value'       => '',
                'dependency'       => array(
                    'element' => 'layout_style',
                    'value'   => array('style-01','style-02','style-04','style-05')
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Columns Gutter', 'auteur-framework'),
                'param_name' => 'columns_gutter',
                'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_post_columns_gutter()),
                'std' => '30',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'layout_style', 'value' => array('style-03'))
            ),
            array(
                'type' => 'gsf_number_responsive',
                'heading' => esc_html__('Testimonial content Font size', 'auteur-framework'),
                'param_name' => 'content_font_size',
                'value' => '24||20||18'
            ),
            array(
                'type' => 'gsf_number_and_unit',
                'heading' => esc_html__('Testimonial content Line Height', 'auteur-framework'),
                'param_name' => 'content_line_height',
                'std' => '1.5|em',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type' => 'gsf_number_and_unit',
                'heading' => esc_html__('Testimonial content Letter Spacing', 'auteur-framework'),
                'param_name' => 'content_letter_spacing',
                'std' => '0|px',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type' => 'gsf_number_responsive',
                'heading' => esc_html__('Distance between Content and Info', 'auteur-framework'),
                'param_name' => 'space_between',
                'std' => '30||||'
            ),
            array(
                'type' => 'gsf_switch',
                'heading' => __('Use Theme Default Font family for Testimonial content?', 'auteur-framework'),
                'param_name' => 'testimonial_use_theme_font',
                'std' => 'on'
            ),
            array(
                'type' => 'gsf_typography',
                'param_name' => 'content_typography',
                'dependency' => array('element' => 'testimonial_use_theme_font', 'value_not_equal_to' => 'on')
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__('Values', 'auteur-framework'),
                'param_name' => 'values',
                'description' => esc_html__('Enter values for author', 'auteur-framework'),
                'value' => '',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Author Name', 'auteur-framework'),
                        'param_name' => 'author_name',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Author Job', 'auteur-framework'),
                        'param_name' => 'author_job',
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__('Content testimonials of the author', 'auteur-framework'),
                        'param_name' => 'author_bio'
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Upload Avatar', 'auteur-framework'),
                        'param_name' => 'author_avatar',
                        'value' => '',
                        'description' => esc_html__('Upload avatar for author.', 'auteur-framework'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Rating stars', 'auteur-framework'),
                        'param_name' => 'user_rating',
                        'std' => '',
                        'value' => array(
                            esc_html__('None', 'auteur-framework') => '',
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5'
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Author Link', 'auteur-framework'),
                        'param_name' => 'author_link'
                    ),
                )
            ),
            G5P()->shortcode()->vc_map_add_pagination(array(
                'group' => esc_html__('Slider Options', 'auteur-framework'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )),
            G5P()->shortcode()->vc_map_add_navigation(array(
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
        ),
        G5P()->shortCode()->get_column_responsive(array(
                'element' => 'layout_style', 'value' => array('style-03')
            )
        ),
        array(
            G5P()->shortcode()->vc_map_add_css_animation(),
            G5P()->shortcode()->vc_map_add_animation_duration(),
            G5P()->shortcode()->vc_map_add_animation_delay(),
            G5P()->shortcode()->vc_map_add_extra_class(),
            G5P()->shortcode()->vc_map_add_css_editor(),
            G5P()->shortcode()->vc_map_add_responsive()
        )
    )
);