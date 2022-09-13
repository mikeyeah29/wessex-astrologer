<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;

if ( ! class_exists( 'G5Shop_Abstracts_Elements_Listing', false ) ) {
	G5P()->loadFile( G5P()->pluginDir( 'inc/abstract/elementor-listing-shop.class.php' ) );
}

class UBE_Element_Auteur_Products_Review extends G5Shop_Abstracts_Elements_Listing {
	public function get_name()
	{
		return 'auteur-products-review';
	}
	public function get_title()
	{
		return esc_html__('Auteur Products Review', 'auteur-framework');
	}
	public function get_ube_icon() {
		return 'eicon-products';
	}

	public function get_script_depends() {
		return array(G5P()->assetsHandle('products-review'));
	}

	public function get_style_depends(){
		return array(G5P()->assetsHandle('product-reviews'));
	}

	protected function register_controls()
	{
		$this->start_controls_section('setting_section', [
			'label' => esc_html__('Setting', 'auteur-framework'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->add_control(
			'items_per_page',
			[
				'label' => esc_html__('Items to show', 'auteur-framework'),
				'type' => Controls_Manager::NUMBER,
				'description' => esc_html__('Enter number you want to display', 'auteur-framework'),
				'default' => '',
			]
		);
		$this->add_control(
			'columns',
			[
				'type' => UBE_Controls_Manager::BOOTSTRAP_RESPONSIVE,
				'label' => esc_html__('Columns', 'auteur-framework'),
				'data_type' => 'select',
				'options' => $this->get_post_columns(),
				'default' => '2',
			]
		);

		$this->register_columns_gutter_controls();
		$this->register_is_slider_controls();

		$this->end_controls_section();

		$this->register_slider_section_controls();
	}

	protected function register_slider_section_controls() {
		parent::register_slider_section_controls();
		$this->update_control('section_slider',[
			'condition' => [
				'is_slider' => 'on',
			],
		]);
		$this->remove_control('slider_rows');
	}

	public function render() {
		G5P()->get_template_element( 'products-review/template.php', array(
			'element' => $this
		) );
	}

}