<?php
/**
 * The template for displaying config.php
 *
 */
return array(
	'base' => 'gsf_breadcrumbs',
	'name' => esc_html__('Breadcrumbs', 'auteur-framework'),
	'category' => G5P()->shortcode()->get_category_name(),
    'icon' => 'fa fa-code',
	'params' => array(
		array(
			'type' => 'dropdown',
			'heading' => esc_html__('Alignment', 'auteur-framework'),
			'param_name' => 'align',
			'description' => esc_html__('Select text alignment.', 'auteur-framework'),
			'value' => array(
				esc_html__('Left', 'auteur-framework') => 'text-left',
				esc_html__('Center', 'auteur-framework') => 'text-center',
				esc_html__('Right', 'auteur-framework') => 'text-right',
				esc_html__('Justify', 'auteur-framework') => 'text-justify'
			),
			'std' => 'text-left',
			'admin_label' => true,
		),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	)
);