<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;

if ( ! class_exists( 'G5Shop_Abstracts_Elements_Listing', false ) ) {
	G5P()->loadFile( G5P()->pluginDir( 'inc/abstract/elementor-listing-shop.class.php' ) );
}

class UBE_Element_Auteur_Products extends G5Shop_Abstracts_Elements_Listing {
	public function get_name()
	{
		return 'auteur-products';
	}
	public function get_title()
	{
		return esc_html__('Auteur Products', 'auteur-framework');
	}
	public function get_ube_icon() {
		return 'eicon-products';
	}

	public function get_script_depends() {
		return array(G5P()->assetsHandle('products'));
	}

	protected function register_controls()
	{
		$this->register_layout_section_controls();
		$this->register_image_size_section_controls();
		$this->register_query_section_controls();
		$this->register_style_section_controls();
	}

	public function render() {
		G5P()->get_template_element( 'products/template.php', array(
			'element' => $this
		) );
	}

}