<?php
/**
 * The template for displaying config.php
 *
 */
return array(
    'base' => 'gsf_events',
    'name' => esc_html__('Events', 'auteur-framework'),
    'category' => G5P()->shortcode()->get_category_name(),
    'icon' => 'fa fa-clock-o',
    'params' => array_merge(
        array(
            array(
                'param_name' => 'event_layout',
                'heading' => esc_html__('Post Layout', 'auteur-framework'),
                'description' => esc_html__('Specify your event layout', 'auteur-framework'),
                'type' => 'gsf_image_set',
                'value' => array(
                    'style-01' => array(
                        'label' => esc_html__('Style 01', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/event-style-01.png'),
                    ),
                    'style-02' => array(
                        'label' => esc_html__('Style 02', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/shortcode/event-style-02.png'),
                    )
                ),
                'std' => 'style-01',
                'admin_label' => true
            ),
            array(
                'param_name' => 'image_size',
                'heading' => esc_html__('Image size', 'auteur-framework'),
                'description' => esc_html__('Enter your event image size', 'auteur-framework'),
                'type' => 'textfield',
                'std' => '330x200',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'event_layout', 'value_not_equal_to' => array('style-02'))
            ),
            array(
                'param_name' => 'image_ratio',
                'heading' => esc_html__('Image ratio', 'auteur-framework'),
                'description' => esc_html__('Specify your image event ratio', 'auteur-framework'),
                'type' => 'dropdown',
                'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_image_ratio()),
                'std' => '1x1',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_size', 'value' => 'full')
            ),
            array(
                'param_name' => 'image_ratio_custom_width',
                'heading' => esc_html__('Image ratio custom width', 'auteur-framework'),
                'description' => esc_html__('Enter custom width for image ratio', 'auteur-framework'),
                'type' => 'gsf_number',
                'std' => '500',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_ratio', 'value' => 'custom')
            ),
            array(
                'param_name' => 'image_ratio_custom_height',
                'heading' => esc_html__('Image ratio custom height', 'auteur-framework'),
                'description' => esc_html__('Enter custom height for image ratio', 'auteur-framework'),
                'type' => 'gsf_number',
                'std' => '500',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_ratio', 'value' => 'custom')
            ),
        ),

        array(
            array(
                'param_name' => 'source',
                'heading' => esc_html__('Source', 'auteur-framework'),
                'type' => 'dropdown',
                'std' => 'list',
                'value' => array(
                    esc_html__('All','auteur-framework') => 'all',
                    esc_html__('Upcoming','auteur-framework') => 'upcoming',
                    esc_html__('Ongoing','auteur-framework') => 'list',
                    esc_html__('Event passed','auteur-framework') => 'past',
                    esc_html__('Events','auteur-framework') => 'ids'
                )
            ),
            G5P()->shortCode()->vc_map_add_event_narrow_categories(array(
                'dependency' => array('element' => 'source', 'value' => array('list', 'all','past','upcoming'))
            )),
            array(
                'type' => 'autocomplete',
                'heading' => __( 'Choose event(s) to show', 'auteur-framework' ),
                'param_name' => 'event_ids',
                'settings' => array(
                    'multiple' => true,
                    'unique_values' => true,
                    'display_inline' => true
                ),
                'dependency' => array('element' => 'source', 'value' => array('ids')),
                'save_always' => true,
            ),
            array(
                'param_name' => 'items_per_page',
                'heading' => esc_html__('Posts Per Page', 'auteur-framework'),
                'description' => esc_html__('Enter number of items per page you want to display. Default 10', 'auteur-framework'),
                'type' => 'textfield',
                'std' => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'param_name' => 'event_columns_gutter',
                'heading' => esc_html__('Post Columns Gutter', 'auteur-framework'),
                'description' => esc_html__('Specify your horizontal space between event.', 'auteur-framework'),
                'type' => 'dropdown',
                'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_post_columns_gutter()),
                'std' => '30',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),

	        array(
		        'type' => 'dropdown',
		        'heading' => esc_html__('Order by', 'auteur-framework'),
		        'param_name' => 'orderby',
		        'value' => array(
		        	esc_html__('Create Date', 'auteur-framework') => 'post_date',
			        esc_html__('Title','auteur-framework') => 'title',
			        esc_html__('Random', 'auteur-framework') => 'rand',
			        esc_html__('Event Date', 'auteur-framework') => 'event_date',
		        ),
		        'std' => 'event_date',
		        'description' => esc_html__('Select how to sort retrieved events.', 'auteur-framework'),
		        'dependency' => array('element' => 'source', 'value' => array('list', 'all','past','upcoming')),
		        'edit_field_class' => 'vc_col-sm-6 vc_column'
	        ),

	        array(
		        'type' => 'dropdown',
		        'heading' => esc_html__('Sort order', 'auteur-framework'),
		        'param_name' => 'order',
		        'value' => array(
			        esc_html__('Descending', 'auteur-framework') => 'DESC',
			        esc_html__('Ascending', 'auteur-framework') => 'ASC'
		        ),
		        'std' => 'ASC',
		        'description' => esc_html__('Designates the ascending or descending order.', 'auteur-framework'),
		        'dependency' => array('element' => 'source', 'value' => array('list', 'all','past','upcoming')),
		        'edit_field_class' => 'vc_col-sm-6 vc_column'
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
                'param_name' => 'event_animation',
                'heading' => esc_html__('Animation', 'auteur-framework'),
                'description' => esc_html__('Specify your event animation', 'auteur-framework'),
                'type' => 'dropdown',
                'value' => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_animation(true)),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std' => '-1'
            ),
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
    )
);