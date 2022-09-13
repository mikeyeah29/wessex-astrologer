<?php
return array(
	'base' => 'gsf_products',
	'name' => esc_html__('Products','auteur-framework'),
	'icon' => 'fab fa-product-hunt',
    'category' => G5P()->shortcode()->get_category_name(),
	'params' =>  array_merge(
	    array(
            array(
                'type' => 'gsf_image_set',
                'heading' => esc_html__('Layout Style', 'auteur-framework'),
                'param_name' => 'layout_style',
                'admin_label' => true,
                'std' => 'grid',
                'value' => G5P()->settings()->get_product_catalog_layout()
            ),
            array(
                'param_name'       => 'image_size',
                'heading'    => esc_html__('Image size', 'auteur-framework'),
                'description' => esc_html__('Enter your product image size', 'auteur-framework'),
                'type'     => 'textfield',
                'std'  => 'medium',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'layout_style','value' => array('metro-01', 'metro-02', 'metro-03', 'metro-04', 'metro-05'))
            ),
            array(
                'param_name'       => 'image_ratio',
                'heading'    => esc_html__('Image ratio', 'auteur-framework'),
                'description' => esc_html__('Specify your image product ratio', 'auteur-framework'),
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
                'type' => 'dropdown',
                'heading' => esc_html__('Show', 'auteur-framework'),
                'param_name' => 'show',
                'value' => array(
                    esc_html__('All', 'auteur-framework') => 'all',
                    esc_html__('Sale Off', 'auteur-framework') => 'sale',
                    esc_html__('New In', 'auteur-framework') => 'new-in',
                    esc_html__('Featured', 'auteur-framework') => 'featured',
                    esc_html__('Top rated', 'auteur-framework') => 'top-rated',
                    esc_html__('Recent review', 'auteur-framework') => 'recent-review',
                    esc_html__('Best Selling', 'auteur-framework') => 'best-selling',
                    esc_html__('Narrow Products', 'auteur-framework') => 'products'
                )
            ),
            array(
                'type' => 'autocomplete',
                'heading' => esc_html__( 'Narrow Products', 'auteur-framework' ),
                'param_name' => 'product_ids',
                'settings' => array(
                    'multiple' => true,
                    'sortable' => true,
                    'unique_values' => true,
                ),
                'save_always' => true,
                'description' => esc_html__( 'Enter List of Products', 'auteur-framework' ),
                'dependency' => array('element' => 'show','value' => 'products'),
            ),
            G5P()->shortCode()->vc_map_add_product_narrow_categories(array(
                'dependency' => array('element' => 'show','value_not_equal_to' => array('products'))
            )),
            G5P()->shortCode()->vc_map_add_product_narrow_authors(array(
                'dependency' => array('element' => 'show','value_not_equal_to' => array('products'))
            )),
            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Category Filter', 'auteur-framework' ),
                'param_name' => 'show_category_filter',
                'std' => '',
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'show','value_not_equal_to' => array('products'))
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
                'dependency' => array('element'=>'show_category_filter', 'value'=> 'on'),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Products Per Page', 'auteur-framework' ),
                'param_name' => 'products_per_page',
                'value' => 6,
                'admin_label' => true,
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'show','value_not_equal_to' => array('products'))
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
                'dependency' => array('element' => 'layout_style','value_not_equal_to' => array('list')),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),

            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Order by', 'auteur-framework'),
                'param_name' => 'orderby',
                'value' => array(
                    esc_html__('Date', 'auteur-framework') => 'date',
                    esc_html__('Price', 'auteur-framework') => 'price',
                    esc_html__('Random', 'auteur-framework') => 'rand',
                    esc_html__('Sales', 'auteur-framework') => 'sales'
                ),
                'description' => esc_html__('Select how to sort retrieved products.', 'auteur-framework'),
                'dependency' => array('element' => 'show','value' => array('all', 'sale', 'featured')),
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
                'description' => esc_html__('Designates the ascending or descending order.', 'auteur-framework'),
                'dependency' => array('element' => 'show','value' => array('all', 'sale', 'featured')),
                'edit_field_class' => 'vc_col-sm-6 vc_column'
            ),
            array(
                'type' => 'gsf_switch',
                'heading' => esc_html__('Is Slider?', 'auteur-framework' ),
                'param_name' => 'is_slider',
                'std' => '',
                'admin_label' => true,
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'dependency' => array('element' => 'layout_style', 'value' => array('grid', 'list'))
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
                'param_name' => 'product_paging',
                'heading' => esc_html__( 'Product Paging', 'auteur-framework' ),
                'description' => esc_html__( 'Specify your post paging mode', 'auteur-framework' ),
                'type' => 'dropdown',
                'value' => array(
                    esc_html__('No Pagination', 'auteur-framework')=> 'none',
                    esc_html__('Ajax - Pagination', 'auteur-framework') => 'pagination-ajax',
                    esc_html__('Ajax - Next Prev', 'auteur-framework') => 'next-prev',
                    esc_html__('Ajax - Load More', 'auteur-framework') => 'load-more',
                    esc_html__('Ajax - Infinite Scroll', 'auteur-framework') => 'infinite-scroll'
                ),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std' => 'none'
            ),
            array(
                'param_name' => 'product_animation',
                'heading' => esc_html__( 'Product Animation', 'auteur-framework' ),
                'description' => esc_html__( 'Specify your product animation', 'auteur-framework' ),
                'type' => 'dropdown',
                'value' => G5P()->shortcode()->switch_array_key_value( G5P()->settings()->get_animation(true) ),
                'edit_field_class' => 'vc_col-sm-6 vc_column',
                'std' => ''
            ),
        ),
        G5P()->shortCode()->get_column_responsive(array(
            'element'=>'layout_style',
            'value'=>array('grid')
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