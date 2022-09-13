<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;

if ( ! class_exists( 'G5Portfolios_Abstracts_Elements_Listing', false ) ) {
	G5P()->loadFile( G5P()->pluginDir( 'inc/abstract/elementor-listing-portfolios.class.php' ) );
}

class UBE_Element_Auteur_Portfolios_Category extends G5Portfolios_Abstracts_Elements_Listing {
	public function get_name()
	{
		return 'auteur-portfolios-category';
	}
	public function get_title()
	{
		return esc_html__('Auteur Portfolios Category', 'auteur-framework');
	}
	public function get_ube_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_script_depends() {
		return array(G5P()->assetsHandle('portfolio-category'));
	}

	protected function register_controls()
	{
		$this->start_controls_section('setting_section', [
			'label' => esc_html__('Setting', 'auteur-framework'),
			'tab' => Controls_Manager::TAB_CONTENT,
		]);

		$this->register_image_controls();
		$this->register_narrow_portfolio_cat_controls();
		$this ->register_height_mode_controls();

		$this->end_controls_section();
	}

	public function render() {
		G5P()->get_template_element( 'portfolios-category/template.php', array(
			'element' => $this
		) );
	}

}