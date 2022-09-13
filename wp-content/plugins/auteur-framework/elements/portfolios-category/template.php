<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @var $element UBE_Element_Auteur_Portfolios_Category
 */

$atts = $element->get_settings();
$wrapper_classes = array(
	'gf-portfolio-category',
	'ube-portfolio-category',
);
$element->set_render_attribute('wrapper', array(
	'class' => $wrapper_classes
));
$category = $atts['cat'];
$height_mode = $atts['height_mode'];
$height = $atts['height'];

if ($atts['image']['url'] !== '') {
	$bg_style = array();
	$pd_bottom = 66.6666666;

	if ($atts['image']['id'] !== '') {
		$media_image = wp_get_attachment_image_src($atts['image']['id'], 'full');
		$pd_bottom = ($media_image[2] / $media_image[1]) * 100;
	}

	if ($atts['height_mode'] !== 'custom' && $atts['height_mode'] !== 'original') {
		$pd_bottom = $atts['height_mode'];
	}

	if ($atts['height_mode'] === 'custom'){
		$pd_bottom = $atts['height'];
		$bg_style[] = "padding-bottom:{$pd_bottom}px";
	}

	if ($atts['height_mode'] !== 'custom') {
		$bg_style[] = "padding-bottom:{$pd_bottom}%";
	}

	$bg_style[] = "background-image : url({$atts['image']['url']})";

	$element->add_render_attribute('bg_attr', array(
		'class' => 'gf-portfolio-cat-bg effect-bg-image',
		'style' => join(";", $bg_style),
	));
}
?>
<?php if (!empty($category)): ?>
	<div <?php $element->print_render_attribute_string('wrapper') ?>>
		<?php $category = get_term_by('term_id', $category, 'portfolio_cat', 'OBJECT'); ?>
		<?php $cate_link = get_term_link($category, 'portfolio_cat'); ?>
		<?php if($category && !is_object($cate_link)): ?>
			<div <?php echo $element->get_render_attribute_string('bg_attr') ?>></div>
			<div class="gf-portfolio-cat-inner">
				<a href="<?php echo esc_url($cate_link); ?>" title="<?php echo esc_attr($category->name); ?>"
				   class="btn btn-classic btn-white btn-rounded"><?php esc_html_e('See all work', 'auteur-framework') ?></a>
				<h5><?php echo esc_html($category->name); ?></h5>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>

