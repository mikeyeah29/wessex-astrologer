<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage auteur
 * @since auteur 1.0
 */
return array(
	'base' => 'gsf_portfolios',
	'name' => esc_html__( 'Portfolios', 'auteur-framework' ),
	'category' => G5P()->shortcode()->get_category_name(),
	'icon' => 'fa fa-windows',
	'params' => array_merge(
		array(
			array(
				'param_name' => 'portfolio_layout',
				'heading' => esc_html__( 'Portfolio Layout', 'auteur-framework' ),
				'description' => esc_html__( 'Specify your portfolio layout', 'auteur-framework' ),
				'type' => 'gsf_image_set',
				'value' => apply_filters('gsf_options_portfolio_layout', array(
                    'grid' => array(
                        'label' => esc_html__('Grid', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/portfolio-grid.png'),
                    ),
                    'masonry' => array(
                        'label' => esc_html__('Masonry', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/portfolio-masonry.png'),
                    ),
                    'scattered' => array(
                        'label' => esc_html__('Scattered', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/portfolio-masonry-sd.png'),
                    ),
                    'justified' => array(
                        'label' => esc_html__('Justified', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/portfolio-justified.jpg'),
                    ),
                    'metro-1' => array(
                        'label' => esc_html__('Metro 01', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/layout-metro-01.png')
                    ),
                    'propeller' => array(
                        'label' => esc_html__('Propeller', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/portfolio-propeller.png')
                    ),
                    'metro-2' => array(
                        'label' => esc_html__('Metro 02', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/layout-metro-02.png')
                    ),
                    'metro-3' => array(
                        'label' => esc_html__('Metro 03', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/layout-metro-03.png')
                    ),
                    'metro-4' => array(
                        'label' => esc_html__('Metro 04', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/layout-metro-04.png')
                    ),
                    'metro-5' => array(
                        'label' => esc_html__('Metro 05', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/layout-metro-05.png')
                    ),
                    'metro-6' => array(
                        'label' => esc_html__('Metro 06', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/portfolio-metro-06.jpg')
                    ),
                    'metro-7' => array(
                        'label' => esc_html__('Metro 07', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/portfolio-metro-07.jpg')
                    ),

                    'carousel-3d' => array(
                        'label' => esc_html__('Carousel 3D', 'auteur-framework'),
                        'img' => G5P()->pluginUrl('assets/images/theme-options/portfolio-3d-carousel.png')
                    ),
                )),
				'std' => 'grid',
				'admin_label' => true
			),
            array(
                'param_name' => "portfolio_item_skin",
                'heading' => esc_html__('Portfolio Item Skin','auteur-framework'),
                'type'     => 'gsf_image_set',
                'value'  => G5P()->settings()->get_portfolio_item_skin(),
                'std'  => 'portfolio-item-skin-01',
                'description'     => esc_html__('Note: Skin 01, Skin 02 only apply for Grid Layout and Masonry Layout', 'auteur-framework'),
            ),
            array(
                'param_name'       => 'image_size',
                'heading'    => esc_html__('Image size', 'auteur-framework'),
                'description' => esc_html__('Enter your portfolio image size', 'auteur-framework'),
                'type'     => 'textfield',
                'std'  => 'medium',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'portfolio_layout', 'value_not_equal_to' => array('masonry', 'scattered','justified', 'propeller'))
            ),
            array(
                'param_name'       => 'portfolio_row_height',
                'heading'    => esc_html__('Row Height', 'auteur-framework'),
                'description' => esc_html__('Enter your portfolio row height', 'auteur-framework'),
                'type'     => 'gsf_number',
                'std' => 375,
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'portfolio_layout', 'value' => 'justified')
            ),

            array(
                'param_name'       => 'portfolio_row_max_height',
                'heading'    => esc_html__('Row Max Height', 'auteur-framework'),
                'description' => esc_html__('Enter your portfolio row max height', 'auteur-framework'),
                'type'     => 'gsf_number',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'portfolio_layout', 'value' => 'justified')
            ),

            array(
                'param_name'       => 'image_ratio',
                'heading'    => esc_html__('Image ratio', 'auteur-framework'),
                'description' => esc_html__('Specify your image portfolio ratio', 'auteur-framework'),
                'type'     => 'dropdown',
                'value'  => G5P()->shortcode()->switch_array_key_value(G5P()->settings()->get_image_ratio()),
                'std'  => '1x1',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_size', 'value' => 'full')
            ),
            array(
                'param_name'       => 'image_ratio_custom_width',
                'heading'    => esc_html__('Image ratio custom width', 'auteur-framework'),
                'description' => esc_html__('Enter custom width for image ratio', 'auteur-framework'),
                'type'     => 'gsf_number',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_ratio', 'value' => 'custom')
            ),
            array(
                'param_name'       => 'image_ratio_custom_height',
                'heading'    => esc_html__('Image ratio custom height', 'auteur-framework'),
                'description' => esc_html__('Enter custom height for image ratio', 'auteur-framework'),
                'type'     => 'gsf_number',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'image_ratio', 'value' => 'custom')
            ),
            array(
                'param_name'       => 'image_masonry_width',
                'heading'    => esc_html__('Image masonry width', 'auteur-framework'),
                'type'     => 'gsf_number',
                'std'      => '400',
                'dependency' => array('element' => 'portfolio_layout', 'value' => 'masonry')
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Show', 'auteur-framework'),
                'param_name' => 'show',
                'value' => array(
                    esc_html__('All', 'auteur-framework') => 'all',
                    esc_html__('Featured', 'auteur-framework') => 'featured',
                    esc_html__('Narrow Portfolios', 'auteur-framework') => 'portfolios'
                )
            ),
            array(
                'type' => 'autocomplete',
                'heading' => esc_html__( 'Narrow Portfolios', 'auteur-framework' ),
                'param_name' => 'portfolio_ids',
                'settings' => array(
                    'multiple' => true,
                    'sortable' => true,
                    'unique_values' => true,
                ),
                'save_always' => true,
                'description' => esc_html__( 'Enter List of Portfolios', 'auteur-framework' ),
                'dependency' => array('element' => 'show', 'value' => 'portfolios')
            ),
            G5P()->shortCode()->vc_map_add_portfolio_narrow_categories(array(
                'dependency' => array('element' => 'show', 'value_not_equal_to' => array('portfolios'))
            )),
			array(
				'param_name' => 'portfolios_per_page',
				'heading' => esc_html__( 'Portfolios Per Page', 'auteur-framework' ),
				'description' => esc_html__( 'Enter number of portfolio per page you want to display. Default 10', 'auteur-framework' ),
				'type' => 'gsf_number',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std' => 10
			),
            array(
                'param_name' => 'portfolio_columns_gutter',
                'heading' => esc_html__( 'Portfolio Columns Gutter', 'auteur-framework' ),
                'description' => esc_html__( 'Specify your horizontal space between portfolio item.', 'auteur-framework' ),
                'type' => 'dropdown',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'value' => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_post_columns_gutter(true) ),
                'std' => '30',
                'dependency' => array( 'element' => 'portfolio_layout', 'value_not_equal_to' => array( 'carousel-3d', 'scattered') )
            ),
			array(
				'param_name' => 'show_cate_filter',
				'heading' => esc_html__( 'Category Filter', 'auteur-framework' ),
				'type' => 'gsf_switch',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std' => ''
			),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Category Filter Alignment', 'auteur-framework'),
                'param_name' => 'cate_filter_align',
                'value' => array(
                    esc_html__('Left', 'auteur-framework') => 'cate-filter-left',
                    esc_html__('Center', 'auteur-framework') => 'cate-filter-center',
                    esc_html__('Right', 'auteur-framework') => 'cate-filter-right'
                ),
                'std' => 'cate-filter-left',
                'dependency' => array('element'=>'show_cate_filter', 'value'=> 'on'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Is Slider?', 'auteur-framework' ),
                'param_name' => 'is_slider',
                'std' => '',
                'admin_label' => true,
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'portfolio_layout', 'value' => array('grid', 'masonry'))
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Carousel Rows', 'auteur-framework'),
                'param_name' => 'rows',
                'value' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4'
                ),
                'dependency' => array('element' => 'is_slider','value' => 'on'),
                'group' => esc_html__('Slider Options','auteur-framework'),
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
				'param_name' => 'portfolio_paging',
				'heading' => esc_html__( 'Portfolio Paging', 'auteur-framework' ),
				'description' => esc_html__( 'Specify your portfolio paging mode', 'auteur-framework' ),
				'type' => 'dropdown',
				'value' => array(
					esc_html__('No Pagination', 'auteur-framework')=>'none',
					esc_html__('Ajax - Pagination', 'auteur-framework') => 'pagination-ajax',
					esc_html__('Ajax - Next Prev', 'auteur-framework') => 'next-prev',
					esc_html__('Ajax - Load More', 'auteur-framework') => 'load-more',
					esc_html__('Ajax - Infinite Scroll', 'auteur-framework') => 'infinite-scroll'
				),
                'dependency' => array('element' => 'portfolio_layout','value_not_equal_to' => array('carousel', 'carousel-3d')),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std' => ''
			),
			array(
				'param_name' => 'portfolio_animation',
				'heading' => esc_html__( 'Animation', 'auteur-framework' ),
				'description' => esc_html__( 'Specify your portfolio animation', 'auteur-framework' ),
				'type' => 'dropdown',
				'value' => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_animation(true) ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std' => '-1'
			),
            array(
                'param_name'       => 'portfolio_light_box',
                'type'     => 'dropdown',
                'heading'    => esc_html__('Light Box', 'auteur-framework'),
                'value'  => array(
                    esc_html__('Inherit', 'auteur-framework') => '',
                    esc_html__('Feature Image', 'auteur-framework') => 'feature',
                    esc_html__('Media Gallery', 'auteur-framework') => 'media'
                ),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std'  => ''
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Order By', 'auteur-framework'),
                'param_name' => 'order_by',
                'value'      => array(
                    esc_html__('Date', 'auteur-framework') => 'date',
                    esc_html__('Portfolio Id', 'auteur-framework') => 'ID',
                    esc_html__('Portfolio Title', 'auteur-framework') => 'title'
                ),
                'default' => 'date',
                'dependency' => array('element' => 'show','value' => array('all')),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Order', 'auteur-framework'),
                'param_name' => 'order',
                'value'      => array(
                    esc_html__('Ascending', 'auteur-framework') => 'ASC',
                    esc_html__('Descending', 'auteur-framework') => 'DESC'),
                'dependency' => array('element' => 'show','value' => array('all')),
                'default' => 'ASC',
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            )
        ),
        G5P()->shortCode()->get_column_responsive(array(
            'element'=>'portfolio_layout',
            'value'=>array('grid', 'masonry', 'carousel')
        )),
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