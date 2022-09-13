<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5P_Elements_Listing_Events_Abstract', false)) {
	G5P()->loadFile(G5P()->pluginDir('inc/abstract/elementor-listing-events.class.php'));
}

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;

class UBE_Element_Auteur_Event_Countdown extends G5P_Elements_Listing_Events_Abstract
{
	public function get_name()
	{
		return 'auteur-event-countdown';
	}

	public function get_ube_icon()
	{
		return 'eicon-posts-grid';
	}

	public function get_ube_keywords()
	{
		return array('events', 'countdown', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type', 'ube', 'g5');
	}

	public function get_script_depends()
	{
		return array(G5P()->assetsHandle('event-countdown'));
	}

	public function get_style_depends(){
		return array(G5P()->assetsHandle('event-countdown'));
	}

	public function get_title()
	{
		return esc_html__('Auteur Events Countdown', 'auteur-framework');
	}

	protected function register_controls()
	{
		$this->register_layout_section_controls();
		$this->register_style_section_controls();
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
		$this->register_countdown_day_enable_controls();
		$this->register_countdown_align_controls();
		$this->end_controls_section();
	}

	protected function register_style_section_controls()
	{
		$this->register_style_date_section_controls();
		$this->register_style_lable_section_controls();
	}

	protected function register_countdown_day_enable_controls()
	{
		$this->add_control(
			'day_enable',
			[
				'label' => esc_html__('Countdown Day Enable', 'auteur-framework'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__('On', 'auteur-framework'),
				'label_off' => esc_html__('Off', 'auteur-framework'),
				'return_value' => 'on',
				'default' => 'on',
			]
		);
	}

	protected function register_countdown_align_controls()
	{
		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__('Align', 'auteur-framework'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'auteur-framework'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'auteur-framework'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'auteur-framework'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);
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

		$this->add_control(
			'date_color',
			[
				'label' => esc_html__('Color', 'auteur-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .countdown-value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'date_typography',
				'selector' => '{{WRAPPER}} .countdown-value',
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
					'{{WRAPPER}} .countdown-value' => 'margin-top: {{SIZE}}{{UNIT}};',
				]
			]
		);


		$this->end_controls_section();
	}

	protected function register_style_lable_section_controls()
	{
		$this->start_controls_section(
			'section_design_lable',
			[
				'label' => esc_html__('Label', 'auteur-framework'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lable_color',
			[
				'label' => esc_html__('Color', 'auteur-framework'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .countdown-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'lable_typography',
				'selector' => '{{WRAPPER}} .countdown-text',
			]
		);

		$this->add_control(
			'lable_spacing',
			[
				'label' => esc_html__('Spacing', 'auteur-framework'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .countdown-text' => 'margin-top: {{SIZE}}{{UNIT}};',
				]
			]
		);


		$this->end_controls_section();
	}

	public function get_config_post_layout()
	{
		$config = apply_filters('g5p_elementor_event_countdown_layout', array(
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

	public function render()
	{
		G5P()->get_template_element('event-countdown/template.php', array(
			'element' => $this
		));
	}
}