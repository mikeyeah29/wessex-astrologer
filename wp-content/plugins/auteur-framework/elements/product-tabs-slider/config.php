<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;

if ( ! class_exists( 'G5Shop_Abstracts_Elements_Listing', false ) ) {
	G5P()->loadFile( G5P()->pluginDir( 'inc/abstract/elementor-listing-shop.class.php' ) );
}

class UBE_Element_Auteur_Product_Tabs_Slider extends G5Shop_Abstracts_Elements_Listing {
	public function get_name()
	{
		return 'auteur-product-tabs-slider';
	}
	public function get_title()
	{
		return esc_html__('Auteur Product Tabs Slider', 'auteur-framework');
	}
	public function get_ube_icon() {
		return 'eicon-products';
	}

	public function get_style_depends() {
		return array( 'product-singular' );
	}

	public function get_script_depends() {
		return array(G5P()->assetsHandle('product-tabs-slider'));
	}

	protected function register_controls()
	{
		$this->register_tabs_section_controls();
		$this->register_tabs_layout_section_controls();
		$this->register_slider_section_controls();
		$this->register_image_size_section_controls();
		$this->register_style_section_controls();
	}

	protected function register_tabs_layout_section_controls()
	{
		parent::register_tabs_layout_section_controls();
		$this->remove_control('post_paging');
		$this->update_control('post_layout',[
			'options' => array(
				'grid' => esc_html__('Grid', 'auteur-framework'),
				'list' => esc_html__('List', 'auteur-framework'),
			)
		]);
	}

	public function render() {
		G5P()->get_template_element( 'product-tabs-slider/template.php', array(
			'element' => $this
		) );
	}

}