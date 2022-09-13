<?php
/**
 * The template for displaying config.php
 *
 * @package WordPress
 * @subpackage auteur
 * @since auteur 1.0
 */
return array(
	'base' => 'gsf_portfolio_singular',
	'name' => esc_html__('Portfolio Singular', 'auteur-framework'),
	'category' => G5P()->shortcode()->get_category_name(),
	'icon' => 'fa fa-windows',
	'params' => array(
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose product to show', 'auteur-framework' ),
			'param_name' => 'portfolio_ids',
            'settings' => array(
                'multiple' => true,
                'unique_values' => true,
                'display_inline' => true
            ),
            'save_always' => true,
		),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Image Size', 'auteur-framework'),
            'description' => esc_html__('Enter image size ("thumbnail" or "full"). Alternatively enter size in pixels (Example: 280x180, 330x180, 380x180 (Not Include Unit, Space)).', 'auteur-framework'),
            'param_name' => 'image_size',
            'std' => '845x520',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
		G5P()->shortcode()->vc_map_add_css_animation(),
		G5P()->shortcode()->vc_map_add_animation_duration(),
		G5P()->shortcode()->vc_map_add_animation_delay(),
		G5P()->shortcode()->vc_map_add_extra_class(),
		G5P()->shortcode()->vc_map_add_css_editor(),
		G5P()->shortcode()->vc_map_add_responsive()
	)
);