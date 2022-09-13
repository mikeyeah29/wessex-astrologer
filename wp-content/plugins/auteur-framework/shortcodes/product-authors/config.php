<?php
return array(
	'base'     => 'gsf_product_authors',
	'name'     => esc_html__( 'Product Authors', 'auteur-framework' ),
	'icon'     => 'fa fa-users',
	'category' => G5P()->shortcode()->get_category_name(),
	'params'   => array_merge(
		array(
			G5P()->shortcode()->vc_map_add_product_narrow_authors( array(
				'heading'     => esc_html__( 'Including the authors', 'auteur-framework' ),
				'description' => esc_html__( 'Empty to select all authors', 'auteur-framework' )
			) ),
			array(
				'param_name'       => 'image_size',
				'heading'          => esc_html__( 'Image size', 'auteur-framework' ),
				'description'      => esc_html__( 'Enter your product author image size', 'auteur-framework' ),
				'type'             => 'textfield',
				'std'              => '300x400',
				'edit_field_class' => 'vc_col-sm-6 vc_column'
			),
			array(
				'type'             => 'gsf_number',
				'heading'          => esc_html__( 'Items to show', 'auteur-framework' ),
				'param_name'       => 'items_per_page',
				'std'              => 6,
				'args'             => array(
					'min'  => 1,
					'max'  => 500,
					'step' => 1
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column'
			),
			array(
				'type'             => 'dropdown',
				'heading'          => esc_html__( 'Columns Gutter', 'auteur-framework' ),
				'param_name'       => 'columns_gutter',
				'value'            => array(
					esc_html__( 'None', 'auteur-framework' ) => 'none',
					esc_html__( '10px', 'auteur-framework' ) => '10',
					esc_html__( '20px', 'auteur-framework' ) => '20',
					esc_html__( '30px', 'auteur-framework' ) => '30'
				),
				'std'              => '30',
				'edit_field_class' => 'vc_col-sm-6 vc_column'
			),
			array(
				'param_name'       => 'post_paging',
				'heading'          => esc_html__( 'Paging', 'auteur-framework' ),
				'description'      => esc_html__( 'Specify your post paging mode', 'auteur-framework' ),
				'type'             => 'dropdown',
				'value'            => array(
					esc_html__( 'No Pagination', 'auteur-framework' )          => 'none',
					esc_html__( 'Ajax - Pagination', 'auteur-framework' )      => 'pagination-ajax',
					esc_html__( 'Ajax - Next Prev', 'auteur-framework' )       => 'next-prev',
					esc_html__( 'Ajax - Load More', 'auteur-framework' )       => 'load-more',
					esc_html__( 'Ajax - Infinite Scroll', 'auteur-framework' ) => 'infinite-scroll'
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'std'              => 'none',
				'dependency'       => array(
					'element'            => 'is_slider',
					'value_not_equal_to' => 'on',
				),
			),
			array(
				'type'             => 'gsf_switch',
				'heading'          => esc_html__( 'Is Slider?', 'auteur-framework' ),
				'param_name'       => 'is_slider',
				'std'              => '',
				'admin_label'      => true,
				'edit_field_class' => 'vc_col-sm-6 vc_column'
			),
			G5P()->shortcode()->vc_map_add_pagination( array(
				'dependency'       => array( 'element' => 'is_slider', 'value' => 'on' ),
				'group'            => esc_html__( 'Slider Options', 'auteur-framework' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column'
			) ),
			G5P()->shortcode()->vc_map_add_navigation( array(
				'dependency' => array( 'element' => 'is_slider', 'value' => 'on' ),
				'group'      => esc_html__( 'Slider Options', 'auteur-framework' ),
			) ),
			G5P()->shortcode()->vc_map_add_navigation_position( array(
				'group' => esc_html__( 'Slider Options', 'auteur-framework' )
			) ),
			G5P()->shortcode()->vc_map_add_navigation_style( array(
				'group' => esc_html__( 'Slider Options', 'auteur-framework' )
			) ),
			G5P()->shortcode()->vc_map_add_navigation_size( array(
				'group' => esc_html__( 'Slider Options', 'auteur-framework' )
			) ),
			G5P()->shortcode()->vc_map_add_navigation_hover_style( array(
				'group' => esc_html__( 'Slider Options', 'auteur-framework' )
			) ),
			G5P()->shortcode()->vc_map_add_navigation_hover_scheme( array(
				'group' => esc_html__( 'Slider Options', 'auteur-framework' )
			) ),
			G5P()->shortCode()->vc_map_add_autoplay_enable( array(
				'dependency' => array( 'element' => 'is_slider', 'value' => 'on' ),
				'group'      => esc_html__( 'Slider Options', 'auteur-framework' ),
			) ),
			G5P()->shortCode()->vc_map_add_autoplay_timeout( array(
				'group' => esc_html__( 'Slider Options', 'auteur-framework' ),
			) )
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