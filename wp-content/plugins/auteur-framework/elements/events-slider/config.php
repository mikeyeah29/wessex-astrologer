<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! class_exists( 'G5P_Elements_Listing_Events_Abstract', false ) ) {
	G5P()->loadFile( G5P()->pluginDir( 'inc/abstract/elementor-listing-events.class.php' ) );
}

class UBE_Element_Auteur_Events_Slider extends G5P_Elements_Listing_Events_Abstract {
	public function get_name()
	{
		return 'auteur-events-slider';
	}

	public function get_ube_icon()
	{
		return 'eicon-carousel';
	}

	public function get_ube_keywords() {
		return array('events slider','slider', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type','ube','g5' );
	}

	public function get_script_depends() {
		return array(G5P()->assetsHandle('events-slider'));
	}

	public function get_title()
	{
		return esc_html__('Auteur Events Slider', 'auteur-framework');
	}
	protected function register_controls() {
		$this->register_layout_section_controls();
		$this->register_image_size_section_controls();
		$this->register_query_section_section_controls();
		$this->register_slider_section_controls();
		$this->register_columns_responsive_section_controls();
		$this->register_style_section_controls();
	}

	public function render() {
		G5P()->get_template_element( 'events-slider/template.php', array(
			'element' => $this
		) );
	}
}