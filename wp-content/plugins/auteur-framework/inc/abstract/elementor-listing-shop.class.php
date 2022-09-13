<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if (!class_exists('G5P_Elements_Listing_Abstract', false)) {
	G5P()->loadFile(G5P()->pluginDir('inc/abstract/elementor-listing.class.php'));
}

abstract class G5Shop_Abstracts_Elements_Listing extends G5P_Elements_Listing_Abstract {

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'auteur-framework' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_layout_controls();

		$this->register_columns_controls();
		$this->register_columns_gutter_controls(array(
			'post_layout!' => ['list']
		));
		$this->register_post_count_control();
		$this->register_post_paging_controls();
		$this->register_post_animation_controls();
		$this->register_cate_filter_controls();
		$this->end_controls_section();
	}

	protected function register_layout_controls() {
		$this->add_control(
			'post_layout',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Product Layout','auteur-framework'),
				'description' => esc_html__('Specify your product layout','auteur-framework'),
				'options' => $this->get_config_product_layout(),
				'default' => 'grid',
			]
		);
	}

	protected function register_columns_controls()
	{
		$this->add_control(
			'columns',
			[
				'type' => UBE_Controls_Manager::BOOTSTRAP_RESPONSIVE,
				'label' => esc_html__('Columns', 'auteur-framework'),
				'data_type' => 'select',
				'options' => $this->get_post_columns(),
				'default' => '4',
				'condition' => [
					'post_layout' => 'grid',
				],
			]
		);
	}

	protected function register_is_slider_controls(){
		$this->add_control(
			'is_slider',
			[
				'label' => esc_html__('Is Slider', 'auteur-framework'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Enable', 'auteur-framework'),
				'label_off' => esc_html__('Disable', 'auteur-framework'),
				'return_value' => 'on',
				'default' => '',
			]
		);
	}



	public function get_config_product_layout()
	{
		$config = apply_filters('g5shop_elementor_product_layout', array(
			'grid' => array(
				'label' => esc_html__('Grid', 'auteur-framework'),
				'priority' => 10,
			),
			'list' => array(
				'label' => esc_html__('List', 'auteur-framework'),
				'priority' => 20,
			),
			'metro-01' => array(
				'label' => esc_html__('Metro 01', 'auteur-framework'),
				'priority' => 30,
			),
			'metro-02' => array(
				'label' => esc_html__('Metro 02', 'auteur-framework'),
				'priority' => 40,
			),
			'metro-03' => array(
				'label' => esc_html__('Metro 03', 'auteur-framework'),
				'priority' => 50,
			),
			'metro-04' => array(
				'label' => esc_html__('Metro 04', 'auteur-framework'),
				'priority' => 60,
			),
			'metro-05' => array(
				'label' => esc_html__('Metro 05', 'auteur-framework'),
				'priority' => 70,
			),
		));
		//uasort( $config, 'g5core_sort_by_order_callback' );
		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;

	}

	protected function register_narrow_product_controls() {
		$this->add_control(
			'ids',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => false,
				'data_args' => array(
					'post_type' => 'product'
				),
				'label' => esc_html__('Narrow Product', 'auteur-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter List of Product', 'auteur-framework'),
				'default' => '',
			]
		);
	}

	protected function register_tabs_section_controls() {
		$this->start_controls_section(
			'section_tabs',
			[
				'label' => esc_html__( 'Tabs', 'auteur-framework' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->register_tabs_cate_filter_controls();

		$this->register_tabs_controls();

		$this->end_controls_section();
	}

	protected function register_tabs_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'auteur-framework' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_layout_controls();
		$this->register_columns_controls();
		$this->register_columns_gutter_controls();
		$this->register_post_count_control();

		$this->register_post_paging_controls();
		$this->register_post_animation_controls();

		$this->end_controls_section();
	}

	protected function register_tabs_controls() {

		$product_tabs = new \Elementor\Repeater();

		$product_tabs->add_control(
			'tab_title',
			[
				'label' => esc_html__('Title', 'auteur-framework' ),
				'type' => Controls_Manager::TEXT
			]
		);

		$product_tabs->add_control(
			'show',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Show', 'auteur-framework'),
				'options' => [
					'' => esc_html__('All', 'auteur-framework'),
					'sale' => esc_html__('Sale Off', 'auteur-framework'),
					'new-in' => esc_html__('New In', 'auteur-framework'),
					'featured' => esc_html__('Featured', 'auteur-framework'),
					'top-rated' => esc_html__('Top rated', 'auteur-framework'),
					'recent-review' => esc_html__('Recent review', 'auteur-framework'),
					'best-selling' => esc_html__('Best Selling', 'auteur-framework'),
				],
				'default' => '',
				'separator'  => 'before',
			]

		);


		$product_tabs->add_control(
			'cat',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'product_cat'
				),
				'label' => esc_html__('Narrow Category','auteur-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter categories by names to narrow output.', 'auteur-framework'),
				'default' => '',
			]
		);

		$product_tabs->add_control(
			'authors',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'product_author'
				),
				'label' => esc_html__('Narrow Author','auteur-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter Author by names to narrow output.', 'auteur-framework'),
				'default' => '',
			]
		);

		$product_tabs->add_control(
			'orderby',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Order by', 'auteur-framework'),
				'description' => esc_html__('Select how to sort retrieved products.', 'auteur-framework'),
				'options'     => array(
					'date' =>  esc_html__('Date', 'auteur-framework'),
					'price' => esc_html__('Price', 'auteur-framework'),
					'rand' => esc_html__('Random', 'auteur-framework'),
					'sales' => esc_html__('Sales', 'auteur-framework'),
				),
				'default' => 'date',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);

		$product_tabs->add_control(
			'order',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Sorting', 'auteur-framework'),
				'description' => esc_html__('Select sorting order.', 'auteur-framework'),
				'options'     => array(
					'DESC' => esc_html__('Descending', 'auteur-framework'),
					'ASC' => esc_html__('Ascending', 'auteur-framework'),
				),
				'default' => 'DESC',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);

		$this->add_control(
			'tabs',
			[
				'label' => esc_html__('Product Tabs', 'auteur-framework'),
				'type'      => Controls_Manager::REPEATER,
				'title_field' => '{{ tab_title }}',
				'default'     => [
					[
						'tab_title' => esc_html__( 'Sale Off', 'auteur-framework' ),
						'show' => 'sale',
						'orderby' => 'sales',
						'order' => 'DESC',
					],
					[
						'tab_title' => esc_html__( 'New In', 'auteur-framework' ),
						'show' => 'new-in',
						'order' => 'DESC',
					],
					[
						'tab_title' => esc_html__( 'Featured', 'auteur-framework' ),
						'show' => 'featured',
						'orderby' => 'date',
						'order' => 'DESC',
					],
				],
				'fields'    => $product_tabs->get_controls(),

			]
		);
	}

	protected function register_tabs_cate_filter_controls() {

		$this->add_control(
			'tabs_align',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Tabs Align','auteur-framework'),
				'options' => [
					'tabs-left' => esc_html__('Left', 'auteur-framework'),
					'tabs-center' => esc_html__('Center', 'auteur-framework'),
					'tabs-right' => esc_html__('Right', 'auteur-framework'),
				],
				'default' => 'tabs-left',
			]
		);
	}

	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'auteur-framework' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'show',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Show', 'auteur-framework'),
				'options' => [
					'' => esc_html__('All', 'auteur-framework'),
					'sale' => esc_html__('Sale Off', 'auteur-framework'),
					'new-in' => esc_html__('New In', 'auteur-framework'),
					'featured' => esc_html__('Featured', 'auteur-framework'),
					'top-rated' => esc_html__('Top rated', 'auteur-framework'),
					'recent-review' => esc_html__('Recent review', 'auteur-framework'),
					'best-selling' => esc_html__('Best Selling', 'auteur-framework'),
					'products' => esc_html__('Narrow Products', 'auteur-framework')
				],
				'default' => ''
			]

		);

		$this->register_cat_controls();
		$this->register_authors_controls();
		$this->register_product_ids_controls();
		$this->register_order_by_controls();
		$this->register_order_controls();
		$this->end_controls_section();
	}

	protected function register_cat_controls() {
		$this->add_control(
			'cat',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'product_cat'
				),
				'label' => esc_html__('Narrow Category','auteur-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter categories by names to narrow output.', 'auteur-framework'),
				'default' => '',
				'condition' => [
					'show!' => 'products',
				],
			]
		);
	}

	protected function register_authors_controls() {
		$this->add_control(
			'authors',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'select_type' => 'term',
				'data_args' => array(
					'taxonomy' => 'product_author'
				),
				'label' => esc_html__('Narrow Author','auteur-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter Author by names to narrow output.', 'auteur-framework'),
				'default' => '',
				'condition' => [
					'show!' => 'products',
				],
			]
		);
	}

	protected function register_product_ids_controls() {
		$this->add_control(
			'ids',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'data_args' => array(
					'post_type' => 'product'
				),
				'label' => esc_html__('Narrow Products','auteur-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter List of Products', 'auteur-framework'),
				'default' => '',
				'condition' => [
					'show' => 'products',
				],
			]
		);

	}

	protected function register_order_by_controls() {
		$this->add_control(
			'orderby',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Order by', 'auteur-framework'),
				'description' => esc_html__('Select how to sort retrieved products.', 'auteur-framework'),
				'options'     => array(
					'date' =>  esc_html__('Date', 'auteur-framework'),
					'price' => esc_html__('Price', 'auteur-framework'),
					'rand' => esc_html__('Random', 'auteur-framework'),
					'sales' => esc_html__('Sales', 'auteur-framework'),
				),
				'default' => 'date',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);


	}

	protected function register_order_controls() {
		$this->add_control(
			'order',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Sorting', 'auteur-framework'),
				'description' => esc_html__('Select sorting order.', 'auteur-framework'),
				'options'     => array(
					'DESC' => esc_html__('Descending', 'auteur-framework'),
					'ASC' => esc_html__('Ascending', 'auteur-framework'),
				),
				'default' => 'DESC',
				'condition' => [
					'show' => ['','sale','featured'],
				],
			]
		);
	}

	protected function register_image_size_section_controls() {

		$this->start_controls_section(
			'section_image_size',
			[
				'label' => esc_html__('Image Size', 'auteur-framework'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'post_layout!' => ['list','grid'],
				],
			]
		);

		$this->add_control(
			'image_size',
			[
				'label' => esc_html__('Image size', 'auteur-framework'),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter image size (Example: "woocommerce_thumbnail", "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 300x400).', 'auteur-framework' ),
				'default'     => 'woocommerce_thumbnail',
				'condition' => [
					'post_layout!' => ['list','grid'],
				],
			]
		);


		$this->add_control(
			'post_image_ratio_width',
			[
				'label' => esc_html__('Image Ratio Width', 'auteur-framework'),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'post_layout',
							'operator' => '!=',
							'value' => ['list','grid']
						],
						[
							'name' => 'image_size',
							'operator' => '=',
							'value' => 'full'
						]
					]
				],
			]
		);

		$this->add_control(
			'post_image_ratio_height',
			[
				'label' => esc_html__('Image Ratio Height', 'auteur-framework'),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'post_layout',
							'operator' => '!=',
							'value' => ['list','grid']
						],
						[
							'name' => 'image_size',
							'operator' => '=',
							'value' => 'full'
						]
					]
				],
			]
		);

		$this->end_controls_section();
	}

	public function get_query_args($query_args, $atts)
	{
		$product_visibility_term_ids = wc_get_product_visibility_term_ids();

		$query_args = array(
			'posts_per_page' => intval($atts['posts_per_page']),
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'meta_query'     => array(),
			'tax_query'      => array(
				'relation' => 'AND',
			),
		);

		if(($atts['show'] != 'products')) {
			if (!empty($atts['cat'])) {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_cat',
					'terms' =>  $atts['cat'],
					'field' => 'term_id',
					'operator' => 'IN'
				);
			}
			if (!empty($atts['authors'])) {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_author',
					'terms' => $atts['authors'],
					'field' => 'term_id',
					'operator' => 'IN'
				);
			}
		} else {
			$atts['cat'] = array();
			$atts['show_cate_filter'] = '';
		}
		switch($atts['show']) {
			case 'sale':
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
			case 'new-in':
				$query_args['orderby'] = 'date';
				$query_args['order'] = 'DESC';
				break;
			case 'featured':
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				);
				break;
			case 'top-rated':
				$query_args['meta_key'] = '_wc_average_rating';
				$query_args['orderby'] = 'meta_value_num';
				$query_args['order'] = 'DESC';
				$query_args['meta_query'] = WC()->query->get_meta_query();
				$query_args['tax_query'] = WC()->query->get_tax_query();
				break;
			case 'recent-review':
				add_filter( 'posts_clauses', array($this, 'order_by_comment_date_post_clauses' ) );
				break;
			case 'best-selling' :
				$query_args['meta_key'] = 'total_sales';
				$query_args['orderby'] = 'meta_value_num';
				break;
			case 'products':
				if ( ! empty( $atts['ids'] ) ) {
					$query_args['post__in'] = $atts['ids'];
					$query_args['posts_per_page'] = -1;
					$query_args['orderby'] = 'post__in';
				}
				break;
		}

		if (in_array($atts['show'],array('','sale','featured'))) {
			$query_args['order'] = $atts['order'];
			switch ( $atts['orderby'] ) {
				case 'price' :
					$query_args['meta_key'] = '_price';
					$query_args['orderby']  = 'meta_value_num';
					break;
				case 'rand' :
					$query_args['orderby']  = 'rand';
					break;
				case 'sales' :
					$query_args['meta_key'] = 'total_sales';
					$query_args['orderby']  = 'meta_value_num';
					break;
				default :
					$query_args['orderby']  = 'date';
			}
		}

		if ($atts['post_paging'] === 'none') {
			$query_args['no_found_rows'] = 1;
		}

		if ( $atts['show'] == 'recent-review' ) {
			remove_filter( 'posts_clauses', array( $this, 'order_by_comment_date_post_clauses' ) );
		}

		return apply_filters('g5_product_listing_query_args', $query_args, $atts);
	}

	protected function register_style_section_controls() {
		$this->register_style_title_section_controls();
		$this->register_style_price_section_controls();
		$this->register_style_author_section_controls();
	}

	protected function register_style_title_section_controls() {
		$this->start_controls_section(
			'section_design_title',
			[
				'label' => esc_html__( 'Title', 'auteur-framework' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .product_title',

			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'auteur-framework' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product_title' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'title_color_tabs');

		$this->start_controls_tab( 'title_color_normal',
			[
				'label' => esc_html__( 'Normal', 'auteur-framework' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'auteur-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product_title' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'title_color_hover',
			[
				'label' => esc_html__( 'Hover', 'auteur-framework' ),
			]
		);


		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Color', 'auteur-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product_title:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	protected function register_style_price_section_controls() {
		$this->start_controls_section(
			'section_design_price',
			[
				'label' => esc_html__( 'Price', 'auteur-framework' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'price_typography',
			[
				'label' => esc_html__('Size', 'auteur-framework'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .price' => 'font-size: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'price_spacing',
			[
				'label' => esc_html__( 'Spacing', 'auteur-framework' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .price' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Color', 'auteur-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .price' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_author_section_controls() {
		$this->start_controls_section(
			'section_design_product_author',
			[
				'label' => esc_html__( 'Author', 'auteur-framework' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_author_typography',
				'selector' => '{{WRAPPER}} .product-author',

			]
		);

		$this->add_control(
			'product_author_spacing',
			[
				'label' => esc_html__( 'Spacing', 'auteur-framework' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-author' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs( 'product_author_color_tabs');

		$this->start_controls_tab( 'product_author_color_normal',
			[
				'label' => esc_html__( 'Normal', 'auteur-framework' ),
			]
		);

		$this->add_control(
			'product_author_color',
			[
				'label' => esc_html__( 'Color', 'auteur-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-author a' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'product_author_color_hover',
			[
				'label' => esc_html__( 'Hover', 'auteur-framework' ),
			]
		);


		$this->add_control(
			'product_author_hover_color',
			[
				'label' => esc_html__( 'Color', 'auteur-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-author a:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}
}
