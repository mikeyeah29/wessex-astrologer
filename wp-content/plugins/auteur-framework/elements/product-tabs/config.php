<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;

if ( ! class_exists( 'G5Shop_Abstracts_Elements_Listing', false ) ) {
	G5P()->loadFile( G5P()->pluginDir( 'inc/abstract/elementor-listing-shop.class.php' ) );
}

class UBE_Element_Auteur_Product_Tabs extends G5Shop_Abstracts_Elements_Listing {
	public function get_name()
	{
		return 'auteur-product-tabs';
	}
	public function get_title()
	{
		return esc_html__('Auteur Product Tabs', 'auteur-framework');
	}
	public function get_ube_icon() {
		return 'eicon-products';
	}

	public function get_script_depends() {
		return array(G5P()->assetsHandle('product-tabs'));
	}

	protected function register_controls()
	{
		$this->register_tabs_section_controls();
		$this->register_tabs_layout_section_controls();
		$this->register_image_size_section_controls();
		$this->register_style_section_controls();
	}

	public function render() {
		G5P()->get_template_element( 'product-tabs/template.php', array(
			'element' => $this
		) );
	}

}