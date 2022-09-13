<?php
// Do not allow directly accessing this file.
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;

if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5P_Elements_Listing_Abstract', false)) {
	G5P()->loadFile(G5P()->pluginDir('inc/abstract/elementor-listing.class.php'));
}


abstract class G5P_Elements_Listing_Events_Abstract extends G5P_Elements_Listing_Abstract
{

	public function layout_markup($query_args = null, $settings = null)
	{

		$inner_class = array(
			'gf-blog-inner clearfix layout-grid'
		);

		$item_class = array(
			'event_item'
		);


		if ($this->_atts['is_slider'] && !empty($settings['carousel_class'])) {
			$inner_class[] = 'owl-carousel owl-theme';
			$inner_class[] = $settings['carousel_class'];
		} else {
			$inner_class[] = 'row gf-gutter-' . $settings['post_columns_gutter'];
		}

		if (!$this->_atts['is_slider'] || isset($settings['carousel_rows'])) {
			$post_columns = is_array($settings['post_columns']) ? $settings['post_columns'] : array();
			$post_columns = G5P()->helper()->get_bootstrap_columns($post_columns);
			$class_post_columns = array($post_columns);
			$item_class = wp_parse_args($class_post_columns, $item_class);
		}

		$image_size = isset($settings['image_size']) ? $settings['image_size'] : '';
		$owl_args = isset($settings['carousel']) ? $settings['carousel'] : '';
		$post_animation = isset($settings['post_animation']) ? $settings['post_animation'] : '';

		$item_inner_class = array(
			'event-item-inner',
			G5Plus_Auteur()->helper()->getCSSAnimation($post_animation),
		);

		$query_args_event = $this->get_query_event_args();
		$query_args = wp_parse_args($query_args_event, $query_args);
		$data = tribe_get_events($query_args, true);
		$carousel_index = 0;
		if ($data->have_posts()) :?>
            <div class="<?php echo join(' ', $inner_class); ?>" <?php if (!empty($owl_args)): ?> data-owl-options='<?php echo json_encode($owl_args); ?>' <?php endif; ?>>
				<?php while ($data->have_posts()): $data->the_post();
					$post_id = get_the_ID();
					$attach_id = get_post_thumbnail_id();
					$image_ratio = $this->image_ratio($settings);

					if (isset($settings['carousel_rows']) && $carousel_index == 0) {
						echo '<div class="owl-item-inner gf-slider-item clearfix">';
					}
					?>
                    <article class="<?php echo join(' ', $item_class) ?>">
                        <div class="<?php echo join(' ', $item_inner_class); ?>">
							<?php $this->event_image(array(
								'post_id' => $post_id,
								'image_id' => $attach_id,
								'image_size' => $image_size,
								'image_ratio' => $image_ratio,
							)); ?>
							<?php $this->event_content($post_id); ?>
                        </div>
                    </article>
					<?php
					$carousel_index++;
					if (isset($settings['carousel_rows']) && $carousel_index == $settings['carousel_rows']['items_show']) {
						echo '</div>';
						$carousel_index = 0;
					}
					?>
					<?php wp_reset_postdata(); ?>
				<?php endwhile; ?>
            </div>
		<?php endif;
	}


	public function get_query_event_args($args = array())
	{
		$source = isset($this->_atts['source']) ? $this->_atts['source'] : '';
		$category = isset($this->_atts['cat']) ? $this->_atts['cat'] : '';
		$ids = isset($this->_atts['ids']) ? $this->_atts['ids'] : array();
		$order = isset($this->_atts['order']) ? $this->_atts['order'] : array();
		$orderby = isset($this->_atts['orderby']) ? $this->_atts['orderby'] : array();

		if ($source === '') {
			$source = 'list';
		}

		if ($source !== 'ids') {
			$query_args['eventDisplay'] = $source;
		}

		if (!empty($category)) {
			$args['tax_query'][] = array(
				'taxonomy' => Tribe__Events__Main::TAXONOMY,
				'terms' => $category,
				'field' => 'term_id',
				'operator' => 'IN'
			);
		}

		if ('ids' === $source && !empty($ids)) {
			$args['post__in'] = $ids;
			$args['orderby'] = 'post__in';
		}

		if ($source !== 'ids') {
			$args['order'] = $order;
			$args['orderby'] = $orderby;
		}

		return $args;

	}

	public function event_image($setting)
	{
		?>
        <div class="event-image">
			<?php
			G5Plus_Auteur()->blog()->render_post_image_markup(array(
				'post_id' => $setting['post_id'],
				'image_id' => $setting['image_id'],
				'image_size' => $setting['image_size'],
				'image_ratio' => $setting['image_ratio'],
				'display_permalink' => true,
				'image_mode' => 'background'
			)); ?>
            <a href="<?php echo esc_url(tribe_get_event_link()); ?>"
               class="btn btn-classic btn-white btn-md btn-square btn-icon-right"><?php esc_html_e('View More', 'auteur-framework') ?>
                <i class="fal fa-chevron-double-right"></i></a>
        </div>
		<?php
	}

	public function event_content($post_id)
	{
		$date_no_year = tribe_get_date_option('dateWithoutYearFormat', Tribe__Date_Utils::DBDATEFORMAT);
		$date_no_year = empty($date_no_year) ? get_option('date_format') : $date_no_year;
		$event_start = tribe_get_start_date($post_id, false, $date_no_year); ?>
        <div class="event-content">
            <p class="event-start-time fw-extra-bold accent-color fs-15 uppercase"><a
                        class="tribe-event-url gsf-link transition03"
                        href="<?php echo esc_url(tribe_get_event_link()); ?>"
                        title="<?php the_title_attribute() ?>"
                        rel="bookmark"><?php echo esc_html($event_start); ?></a></p>
            <h3 class="tribe-events-list-event-title">
                <a class="transition03 gsf-link"
                   href="<?php echo esc_url(tribe_get_event_link()); ?>"
                   title="<?php the_title_attribute() ?>" rel="bookmark">
					<?php the_title() ?>
                </a>
            </h3>
			<?php $this->event_meta($post_id) ?>
			<?php $this->event_excerpt() ?>
        </div>
		<?php
	}

	public function event_meta($post_id)
	{
		$time_format = get_option('time_format');
		$time_range_separator = tribe_get_option('timeRangeSeparator', ' - ');
		$time_start = tribe_get_start_date($post_id, false, $time_format);
		$time_end = tribe_get_end_date($post_id, false, $time_format);
		?>
        <div class="event-meta">
			<?php
			$venue_details = tribe_get_venue_details();
			if (!empty($venue_details['address'])):?>
                <!-- Venue Display Info -->
                <div class="tribe-events-venue-details tribe-events-address">
                    <i class="fal fa-map-marker-alt"></i> <?php echo sprintf('%s', $venue_details['address']); ?>
                </div> <!-- .tribe-events-venue-details -->
			<?php endif; ?>
            <div class="tribe-event-time">
                <i class="fal fa-clock"></i> <span
                        class="tribe-time"><?php echo esc_html($time_start) . esc_html($time_range_separator) . esc_html($time_end) ?></span>
            </div>
        </div>
		<?php
	}

	public function event_excerpt()
	{
		?>
        <p class="event-excerpt"><?php echo get_the_excerpt(); ?></p>
		<?php
	}

	public function image_ratio($setting)
	{
		$image_ratio = isset($setting['image_ratio']) ? $setting['image_ratio'] : '';

		if ($image_ratio === 'custom') {
			if ($setting['image_ratio_custom']['width'] !== '' && $setting['image_ratio_custom']['height'] !== '') {
				$image_ratio_custom_width = intval($setting['image_ratio_custom']['width']);
				$image_ratio_custom_height = intval($setting['image_ratio_custom']['height']);
				$image_ratio = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";
			} else {
				$image_ratio = G5Plus_Auteur()->options()->get_event_image_ratio();
				if ($image_ratio === 'custom') {
					$image_ratio_custom = G5Plus_Auteur()->options()->get_event_image_ratio_custom();
					if (is_array($image_ratio_custom) && isset($image_ratio_custom['width']) && isset($image_ratio_custom['height'])) {
						$image_ratio_custom_width = intval($image_ratio_custom['width']);
						$image_ratio_custom_height = intval($image_ratio_custom['height']);
						if (($image_ratio_custom_width > 0) && ($image_ratio_custom_height > 0)) {
							$image_ratio = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";
						}
					}
				}
			}
		}
		return $image_ratio;
	}

	protected function register_layout_section_controls()
	{
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__('Layout', 'auteur-framework'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_layout_controls();
		$this->register_columns_gutter_controls();
		$this->register_post_count_control();
		$this->register_post_animation_controls();

		$this->end_controls_section();
	}

	protected function register_layout_controls()
	{
		parent::register_layout_controls();
		$this->update_control('post_layout', [
			'default' => 'style-01'
		]);
	}

	protected function register_query_section_section_controls()
	{
		$this->start_controls_section(
			'section_query_section',
			[
				'label' => esc_html__('Query', 'auteur-framework'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_source_controls();
		$this->register_cat_controls();
		$this->register_post_ids_controls();
		$this->register_order_by_controls();
		$this->register_order_controls();

		$this->end_controls_section();
	}

	protected function register_style_section_controls()
	{
		$this->register_style_title_section_controls();
		$this->register_style_date_section_controls();
		$this->register_style_meta_section_controls();
		$this->register_style_excerpt_section_controls();
	}

	protected function register_style_title_section_controls()
	{
		$this->start_controls_section(
			'section_design_title',
			[
				'label' => esc_html__('Title', 'auteur-framework'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .tribe-events-list-event-title',
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__('Spacing', 'auteur-framework'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .tribe-events-list-event-title' => 'margin-top: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs('title_color_tabs');

		$this->start_controls_tab('title_color_normal',
			[
				'label' => esc_html__('Normal', 'auteur-framework'),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'auteur-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tribe-events-list-event-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('title_color_hover',
			[
				'label' => esc_html__('Hover', 'auteur-framework'),
			]
		);


		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__('Color', 'auteur-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tribe-events-list-event-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_date_section_controls()
	{
		$this->start_controls_section(
			'section_design_date',
			[
				'label' => esc_html__('Date', 'auteur-framework'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'date_typography',
				'selector' => '{{WRAPPER}} .event-start-time .tribe-event-url',
			]
		);

		$this->add_control(
			'date_spacing',
			[
				'label' => esc_html__('Spacing', 'auteur-framework'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gf-event-style-02 .event-start-time' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gf-event-style-01 .event-start-time' => 'margin-top: {{SIZE}}{{UNIT}};',
				]
			]
		);


		$this->start_controls_tabs('date_color_tabs');

		$this->start_controls_tab('date_color_normal',
			[
				'label' => esc_html__('Normal', 'auteur-framework'),
			]
		);

		$this->add_control(
			'date_color',
			[
				'label' => esc_html__('Color', 'auteur-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .event-start-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab('date_color_hover',
			[
				'label' => esc_html__('Hover', 'auteur-framework'),
			]
		);


		$this->add_control(
			'date_hover_color',
			[
				'label' => esc_html__('Color', 'auteur-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .event-start-time a:hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_meta_section_controls()
	{
		$this->start_controls_section(
			'section_design_meta',
			[
				'label' => esc_html__('Meta', 'auteur-framework'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'selector' => '{{WRAPPER}} .event-meta,{{WRAPPER}} .event-meta .tribe-address',
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' => esc_html__('Color', 'auteur-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .event-meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_spacing',
			[
				'label' => esc_html__('Spacing', 'auteur-framework'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .event-meta' => 'margin-top: {{SIZE}}{{UNIT}};',
				]
			]
		);


		$this->end_controls_section();
	}

	protected function register_style_excerpt_section_controls()
	{
		$this->start_controls_section(
			'section_design_excerpt',
			[
				'label' => esc_html__('Excerpt', 'auteur-framework'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'post_layout' => ['style-02'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .event-excerpt',
			]
		);

		$this->add_control(
			'excerpt_spacing',
			[
				'label' => esc_html__('Spacing', 'auteur-framework'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .event-excerpt' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => esc_html__('Color', 'auteur-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .event-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_source_controls()
	{
		$this->add_control(
			'source',
			[
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Source', 'auteur-framework'),
				'label_block' => true,
				'options' => array(
					'all' => esc_html__('All', 'auteur-framework'),
					'upcoming' => esc_html__('Upcoming', 'auteur-framework'),
					'list' => esc_html__('Ongoing', 'auteur-framework'),
					'past' => esc_html__('Event passed', 'auteur-framework'),
					'ids' => esc_html__('Events', 'auteur-framework'),
				),
				'default' => 'list',
			]
		);
	}

	protected function register_cat_controls()
	{
		parent::register_cat_controls();
		$this->update_control('cat', [
			'data_args' => array(
				'taxonomy' => Tribe__Events__Main::TAXONOMY,
			),
			'condition' => [
				'source!' => 'ids',
			],
		]);

	}

	protected function register_post_ids_controls()
	{
		parent::register_post_ids_controls();
		$this->update_control('ids', [
			'data_args' => array(
				'post_type' => Tribe__Events__Main::POSTTYPE
			),
			'label' => esc_html__('Narrow Event', 'auteur-framework'),
			'description' => esc_html__('Choose event(s) to show', 'auteur-framework'),
			'condition' => [
				'source' => 'ids',
			],
		]);
	}

	protected function register_order_by_controls()
	{
		parent::register_order_by_controls();
		$this->update_control('orderby', [
			'options' => array(
				'post_date' => esc_html__('Create Date', 'auteur-framework'),
				'title' => esc_html__('Title', 'auteur-framework'),
				'rand' => esc_html__('Random', 'auteur-framework'),
				'event_date' => esc_html__('Event Date', 'auteur-framework'),
			),
			'default' => 'event_date',
		]);
	}

	protected function register_order_controls()
	{
		parent::register_order_controls();
		$this->update_control('order', [
			'default' => 'ASC'
		]);
	}

	protected function register_image_size_section_controls()
	{
		parent::register_image_size_section_controls();
		$this->update_control('section_image_size', [
			'condition' => [
				'post_layout!' => ['style-02'],
			],
		]);
		$this->remove_control('post_image_width');
	}

	public function get_config_post_layout()
	{
		$config = apply_filters('g5p_elementor_event_layout', array(
			'style-01' => array(
				'label' => esc_html__('Style 01', 'auteur-framework'),
			),
			'style-02' => array(
				'label' => esc_html__('Style 02', 'auteur-framework'),
			),
		));


		$result = array();
		foreach ($config as $k => $v) {
			$result[$k] = $v['label'];
		}
		return $result;

	}
}