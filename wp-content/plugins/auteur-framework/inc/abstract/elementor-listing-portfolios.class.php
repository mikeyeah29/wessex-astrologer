<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if (!class_exists('G5P_Elements_Listing_Abstract', false)) {
	G5P()->loadFile(G5P()->pluginDir('inc/abstract/elementor-listing.class.php'));
}

abstract class G5Portfolios_Abstracts_Elements_Listing extends G5P_Elements_Listing_Abstract {

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'auteur-framework' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_layout_controls();
		$this->register_skin_controls();

		$this->register_columns_controls();
		$this->register_columns_gutter_controls( array(
			'post_layout!' => [ 'carousel-3d', 'scattered' ]
		) );
		$this->register_post_count_control();
		$this->register_post_paging_controls();
		$this->register_light_box_controls();
		$this->register_post_animation_controls();
		$this->register_cate_filter_controls();
		$this->end_controls_section();
	}

	protected function register_post_paging_controls() {
		parent::register_post_paging_controls();
		$this->update_control( 'post_paging', [
			'condition' => [
				'post_layout!' => 'carousel-3d',
			]
		] );
	}

	protected function register_skin_controls() {
		$this->add_control(
			'item_skin',
			[
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Item Skin', 'auteur-framework' ),
				'description' => esc_html__( 'Specify your product item skin', 'auteur-framework' ),
				'options'     => $this->get_config_product_skins(),
				'default'     => 'portfolio-item-skin-01'
			]
		);
	}

	protected function register_layout_controls() {
		$this->add_control(
			'post_layout',
			[
				'type'        => Controls_Manager::SELECT,
				'label'       => esc_html__( 'Product Layout', 'auteur-framework' ),
				'description' => esc_html__( 'Specify your product layout', 'auteur-framework' ),
				'options'     => $this->get_config_product_layout(),
				'default'     => 'grid',
			]
		);
	}

	protected function register_columns_controls() {
		$this->add_control(
			'columns',
			[
				'type'      => UBE_Controls_Manager::BOOTSTRAP_RESPONSIVE,
				'label'     => esc_html__( 'Columns', 'auteur-framework' ),
				'data_type' => 'select',
				'options'   => $this->get_post_columns(),
				'default'   => '4',
				'condition' => [
					'post_layout' => [ 'grid', 'masonry' ]
				],
			]
		);
	}

	protected function register_light_box_controls() {
		$this->add_control(
			'light_box',
			[
				'label'   => esc_html__( 'Light Box', 'auteur-framework' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''           => 'Inherit',
					'feature'    => esc_html__( 'Feature Image', 'auteur-framework' ),
					'media'  => esc_html__( 'Media Gallery', 'auteur-framework' ),
				],
				'default' => '',
			]
		);
	}

	protected function register_image_size_controls() {
		$this->add_control(
			'image_size',
			[
				'label'       => esc_html__( 'Image size', 'auteur-framework' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter your portfolio image size' ),
				'default'     => '845x520',
			]
		);
	}

	protected function register_image_size_justified_controls()
	{
		$this->start_controls_section(
			'section_justified_image_size',
			[
				'label' => esc_html__('Image Size', 'auteur-framework'),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'post_layout' => 'justified',
				]
			]
		);


		$this->add_control(
			'post_image_justified_width',
			[
				'label' => esc_html__('Image Width', 'auteur-framework'),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
			]
		);

		$this->add_control(
			'post_image_justified_height',
			[
				'label' => esc_html__('Image Height', 'auteur-framework'),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
			]
		);

		$this->end_controls_section();
	}


	public function get_config_product_layout() {
		$config = apply_filters( 'auteur_elementor_portfolios_layout', array(
			'grid'        => array(
				'label'    => esc_html__( 'Grid', 'auteur-framework' ),
				'priority' => 10,
			),
			'masonry'     => array(
				'label'    => esc_html__( 'Masonry', 'auteur-framework' ),
				'priority' => 20,
			),
			'scattered'   => array(
				'label'    => esc_html__( 'Scattered', 'auteur-framework' ),
				'priority' => 30,
			),
			'justified'   => array(
				'label'    => esc_html__( 'Justified', 'auteur-framework' ),
				'priority' => 40,
			),
			'metro-1'     => array(
				'label'    => esc_html__( 'Metro 01', 'auteur-framework' ),
				'priority' => 50,
			),
			'metro-2'     => array(
				'label'    => esc_html__( 'Metro 02', 'auteur-framework' ),
				'priority' => 60,
			),
			'metro-3'     => array(
				'label'    => esc_html__( 'Metro 03', 'auteur-framework' ),
				'priority' => 70,
			),
			'metro-4'     => array(
				'label'    => esc_html__( 'Metro 04', 'auteur-framework' ),
				'priority' => 80,
			),
			'metro-5'     => array(
				'label'    => esc_html__( 'Metro 05', 'auteur-framework' ),
				'priority' => 90,
			),
			'metro-6'     => array(
				'label'    => esc_html__( 'Metro 06', 'auteur-framework' ),
				'priority' => 100,
			),
			'metro-7'     => array(
				'label'    => esc_html__( 'Metro 07', 'auteur-framework' ),
				'priority' => 110,
			),
			'propeller'   => array(
				'label'    => esc_html__( 'Propeller', 'auteur-framework' ),
				'priority' => 120,
			),
			'carousel-3d' => array(
				'label'    => esc_html__( 'Carousel 3D', 'auteur-framework' ),
				'priority' => 120,
			),
		) );
		$result = array();
		foreach ( $config as $k => $v ) {
			$result[ $k ] = $v['label'];
		}
		return $result;

	}

	public function get_config_product_skins() {

		$config = apply_filters( 'auteur_elementor_portfolios_skin', array(
			'portfolio-item-skin-01' => array(
				'label'    => esc_html__( 'Skin 01', 'auteur-framework' ),
				'priority' => 10,
			),
			'portfolio-item-skin-02' => array(
				'label'    => esc_html__( 'Skin 02', 'auteur-framework' ),
				'priority' => 20,
			),
			'portfolio-item-skin-03' => array(
				'label'    => esc_html__( 'Skin 03', 'auteur-framework' ),
				'priority' => 30,
			),
			'portfolio-item-skin-04' => array(
				'label'    => esc_html__( 'Skin 04', 'auteur-framework' ),
				'priority' => 30,
			),
			'portfolio-item-skin-05' => array(
				'label'    => esc_html__( 'Skin 05', 'auteur-framework' ),
				'priority' => 30,
			),
		) );
		$result = array();
		foreach ( $config as $k => $v ) {
			$result[ $k ] = $v['label'];
		}
		return $result;
	}

	protected function register_narrow_portfolio_cat_controls() {
		$this->add_control(
			'cat',
			[
				'type'        => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple'    => false,
				'select_type' => 'term',
				'data_args'   => array(
					'taxonomy' => 'portfolio_cat'
				),
				'label'       => esc_html__( 'Narrow Portfolio', 'auteur-framework' ),
				'label_block' => true,
				'description' => esc_html__( 'Enter Portfolio by names to narrow output.', 'auteur-framework' ),
				'default'     => '',
			]
		);
	}

	protected function register_image_controls() {
		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'auteur-framework' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
	}

	protected function register_height_mode_controls() {
		$this->add_control(
			'height_mode',
			[
				'label'   => esc_html__( 'Height Mode', 'auteur-framework' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'100'           => '1:1',
					'original'      => esc_html__( 'Original', 'auteur-framework' ),
					'133.333333333' => '4:3',
					'75'            => '3:4',
					'177.777777778' => '16:9',
					'56.25'         => '9:16',
					'custom'        => esc_html__( 'Custom', 'auteur-framework' ),
				],
				'default' => 'original',
			]
		);
		$this->add_control(
			'height',
			[
				'label'       => esc_html__( 'Height', 'auteur-framework' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'step'        => 1,
				'min'         => 1,
				'max'         => 1000,
				'default'     => 420,
				'description' => esc_html__( 'Enter custom height(px)', 'auteur-framework' ),
				'condition'   => [
					'height_mode' => 'custom',
				]
			]
		);
	}

	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Query', 'auteur-framework' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'show',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Show', 'auteur-framework' ),
				'options' => [
					''              => esc_html__( 'All', 'auteur-framework' ),
					'featured'      => esc_html__( 'Featured', 'auteur-framework' ),
					'portfolios'      => esc_html__( 'Narrow Portfolios', 'auteur-framework' )
				],
				'default' => ''
			]
		);

		$this->register_cat_controls();
		$this->register_portfolios_ids_controls();
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
					'taxonomy' => 'portfolio_cat'
				),
				'label' => esc_html__('Narrow Category','auteur-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter categories by names to narrow output.', 'auteur-framework'),
				'default' => '',
				'condition' => [
					'show!' => 'portfolios',
				],
			]
		);
	}

	protected function register_portfolios_ids_controls() {
		$this->add_control(
			'ids',
			[
				'type' => UBE_Controls_Manager::AUTOCOMPLETE,
				'multiple' => true,
				'data_args' => array(
					'post_type' => 'portfolio'
				),
				'label' => esc_html__('Narrow Portfolios','auteur-framework'),
				'label_block' => true,
				'description' => esc_html__('Enter List of Portfolios', 'auteur-framework'),
				'default' => '',
				'condition' => [
					'show' => 'portfolios',
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
				'description' => esc_html__('Select how to sort retrieved portfolios.', 'auteur-framework'),
				'options'     => array(
					'date' =>  esc_html__('Date', 'auteur-framework'),
					'ID' => esc_html__('Portfolio Id', 'auteur-framework'),
					'title' => esc_html__('Portfolio Title', 'auteur-framework'),
				),
				'default' => 'date',
				'condition' => [
					'show' => '',
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
					'show' => '',
				],
			]
		);
	}

	public function get_query_args($query_args, $atts)
	{
		$query_args = array(
			'posts_per_page' => intval($atts['posts_per_page']),
			'post_status'    => 'publish',
			'post_type'      => 'portfolio',
			'meta_query'     => array(),
			'tax_query'      => array(
				'relation' => 'AND',
			),
		);

		switch ($atts['show']) {
			case '':
				$query_args['orderby'] = $atts['orderby'];
				$query_args['order'] = $atts['order'];
				break;
			case 'featured':
				$query_args = array(
					'tax_query' => array(
						array(
							'taxonomy' => 'portfolio_visibility',
							'field' => 'slug',
							'terms' => 'featured',
						),
					),
				);
				$query = new WP_Query($query_args);
				$portfolio_ids = wp_list_pluck($query->posts, 'ID');
				wp_reset_postdata();
				if (!empty($portfolio_ids)) {
					$query_args['post__in'] = $portfolio_ids;
					$query_args['orderby'] = 'post__in';
				}
				break;
			case 'portfolios':
				if (!empty($atts['ids'])) {
					$portfolio_ids_array = $atts['ids'];
					// Split ids into post_in and post_not_in
					$post_in = array();
					foreach ($portfolio_ids_array as $post_id) {
						$post_id = trim($post_id);
						if (is_numeric($post_id) || intval($post_id) > 0) {
							$post_in[] = intval($post_id);
						}
					}
					if (!empty($post_in)) {
						$query_args['post__in'] = $post_in;
						$query_args['orderby'] = 'post__in';
					}
				}
				break;
			default :
				break;
		}

		if ($atts['post_paging'] === 'none') {
			$query_args['no_found_rows'] = 1;
		}
		if (!empty($atts['cat'])) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'portfolio_cat',
				'terms'    => $atts['cat'],
				'field'    => 'term_id',
				'operator' => 'IN'
			);
		}

		return apply_filters('g5_portfolio_listing_query_args', $query_args, $atts);
	}

	protected function register_style_section_controls() {
		$this->register_style_title_section_controls();
		$this->register_style_cat_section_controls();
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
				'selector' => '{{WRAPPER}} .gsf-portfolio-title',

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
					'{{WRAPPER}} .portfolio-info' => 'padding-top: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .gsf-portfolio-title a' => 'color: {{VALUE}} !important;',
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
					'{{WRAPPER}} .gsf-portfolio-title a:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->end_controls_section();
	}

	protected function register_style_cat_section_controls() {
		$this->start_controls_section(
			'section_design_cat',
			[
				'label' => esc_html__( 'Cat', 'auteur-framework' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cat_typography',
				'selector' => '{{WRAPPER}} .portfolio-cat',

			]
		);

		$this->add_control(
			'cat_spacing',
			[
				'label' => esc_html__( 'Spacing', 'auteur-framework' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .portfolio-cat' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'cat_color_tabs');

		$this->start_controls_tab( 'cat_color_normal',
			[
				'label' => esc_html__( 'Normal', 'auteur-framework' ),
			]
		);

		$this->add_control(
			'cat_color',
			[
				'label' => esc_html__( 'Color', 'auteur-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .portfolio-cat a' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'cat_color_hover',
			[
				'label' => esc_html__( 'Hover', 'auteur-framework' ),
			]
		);


		$this->add_control(
			'cat_hover_color',
			[
				'label' => esc_html__( 'Color', 'auteur-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .portfolio-cat a:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
}


