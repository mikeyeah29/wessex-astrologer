<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;

if ( ! class_exists( 'G5Shop_Abstracts_Elements_Listing', false ) ) {
	G5P()->loadFile( G5P()->pluginDir( 'inc/abstract/elementor-listing-shop.class.php' ) );
}

class UBE_Element_Auteur_Product_Singular extends G5Shop_Abstracts_Elements_Listing {
	public function get_name()
	{
		return 'auteur-product-singular';
	}
	public function get_title()
	{
		return esc_html__('Auteur Products Singular', 'auteur-framework');
	}
	public function get_ube_icon() {
		return 'eicon-products';
	}

	public function get_style_depends(){
		return array(G5P()->assetsHandle('product-singular'));
	}

	protected function register_controls()
	{

		$this->start_controls_section('setting_section', [
			'label' => esc_html__('Setting', 'auteur-framework'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->register_narrow_product_controls();

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Featured Text', 'auteur-framework' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your title', 'auteur-framework' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();
	}

	public function render() {
		G5P()->get_template_element( 'product-singular/template.php', array(
			'element' => $this
		) );
	}

}