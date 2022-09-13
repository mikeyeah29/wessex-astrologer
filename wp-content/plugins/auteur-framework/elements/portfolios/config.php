<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

use \Elementor\Controls_Manager;

if ( ! class_exists( 'G5Portfolios_Abstracts_Elements_Listing', false ) ) {
	G5P()->loadFile( G5P()->pluginDir( 'inc/abstract/elementor-listing-portfolios.class.php' ) );
}

class UBE_Element_Auteur_Portfolios extends G5Portfolios_Abstracts_Elements_Listing {
	public function get_name()
	{
		return 'auteur-portfolios';
	}
	public function get_title()
	{
		return esc_html__('Auteur Portfolios', 'auteur-framework');
	}
	public function get_ube_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_script_depends() {
		return array(G5P()->assetsHandle('portfolios'));
	}

	protected function register_controls()
	{
		$this->register_layout_section_controls();
		$this->register_image_size_section_controls();
		$this->register_image_size_justified_controls();
		$this->register_query_section_controls();
		$this->register_style_section_controls();
	}

	protected function register_image_size_section_controls() {
		parent::register_image_size_section_controls();
		$this->update_control( 'section_image_size', [
			'condition' => [
				'post_layout!' => 'justified',
			]
		] );
		$this->update_control( 'post_image_width', [
			'condition' => [
				'post_layout' => 'masonry',
			]
		] );
		$this->update_control( 'image_size', [
			'condition' => [
				'post_layout!' => 'masonry',
			]
		] );
	}

	public function render() {
		G5P()->get_template_element( 'portfolios/template.php', array(
			'element' => $this
		) );
	}

}