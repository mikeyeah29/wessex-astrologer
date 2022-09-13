<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * @var $element UBE_Element_Auteur_Products_Review
 */

$atts = $element->get_settings();
$atts['show']  = $atts['order'] =  $atts['orderby'] = '';
$wrapper_classes = array(
	'gf-product-reviews',
	'ube-product-reviews',
);
$element->set_render_attribute('wrapper', array(
	'class' => $wrapper_classes
));

$query_args = $settings = array();
$comments = get_comments(
	array(
		'number'      => $atts['items_per_page'],
		'status'      => 'approve',
		'post_status' => 'publish',
		'post_type'   => 'product',
		'parent'      => 0,
	)
);
$totalRecord = sizeof($comments);
$item_class = array('gsf-product-review-item');
$atts['columns_xl'] = absint($atts['columns']['xl']);
$atts['columns_lg'] = $atts['columns']['lg'] == '' ? $atts['columns_xl'] : absint($atts['columns']['lg']);
$atts['columns_md'] = $atts['columns']['md'] == '' ? $atts['columns_lg'] : absint($atts['columns']['md']);
$atts['columns_sm'] = $atts['columns']['sm'] == '' ? $atts['columns_md'] : absint($atts['columns']['sm']);
$atts['columns'] = $atts['columns']['xs'] == '' ? $atts['columns_sm'] : absint($atts['columns']['xs']);
$inner_class = $owl_args = array();
if('on' === $atts['is_slider']) {
	$inner_class[] = 'owl-carousel owl-theme';
	$inner_class[] = 'gsf-slider-container item-gutter-' . $atts['post_columns_gutter'];
	$owl_args = array(
		'items' => $atts['columns_xl'],
		'slideBy' => $atts['columns_xl'],
		'dots' => ($atts['dots'] === 'on') ? true : false,
		'nav' => ($atts['nav'] === 'on') ? true : false,
		'responsive' => array(
			'1200' => array(
				'items' => $atts['columns_xl'],
				'slideBy' => $atts['columns_xl'],
			),
			'992' => array(
				'items' => $atts['columns_lg'],
				'slideBy' => $atts['columns_lg'],
			),
			'768' => array(
				'items' => $atts['columns_md'],
				'slideBy' => $atts['columns_md'],
			),
			'576' => array(
				'items' => $atts['columns_sm'],
				'slideBy' => $atts['columns_sm'],
			),
			'0' => array(
				'items' => $atts['columns'],
				'slideBy' => $atts['columns'],
			)
		),
		'autoHeight' => true,
		'autoplay' => ($atts['autoplay'] === 'on') ? true : false,
		'autoplayTimeout' => intval($atts['autoplay_timeout']),
	);
	if($atts['nav_style'] == 'nav-square-text' || $atts['nav_style'] == 'nav-circle-text') {
		$owl_args['navText'] = array('<i class="fal fa-angle-left"></i> <span>'.esc_html__( 'Prev', 'auteur-framework' ).'</span>', '<span>'.esc_html__( 'Next', 'auteur-framework' ).'</span> <i class="fal fa-angle-right"></i>');
	}

	if($atts['nav'] === 'on') {
		$inner_class = array_merge($inner_class, array($atts['nav_position'], $atts['nav_style'], $atts['nav_size'], $atts['nav_hover_scheme'], $atts['nav_hover_style']));
	}


} else{
	$inner_class[] = 'gf-gutter-' . $atts['post_columns_gutter'];
	$inner_class[] = 'gf-blog-inner';
	$item_class[] = 'grid-item';
	$columns = array(
		'xl' => $atts['columns_xl'] ,
		'lg' => $atts['columns_lg'],
		'md' => $atts['columns_md'],
		'sm' => $atts['columns'],
		'' => $atts['columns'],
	);
	$item_class[] = G5Plus_Auteur()->helper()->get_bootstrap_columns($columns);
}

$element->set_render_attribute('item_class', array( 'class' => $item_class ));

?>
<div <?php $element->print_render_attribute_string('wrapper') ?>>
	<?php if($totalRecord > 0): ?>
		<div class="gsf-product-reviews-inner <?php echo join(' ', $inner_class); ?>" data-owl-options='<?php echo json_encode($owl_args); ?>'>
			<?php foreach ($comments as $comment):
				$product = wc_get_product( $comment->comment_post_ID );
				?>
				<article <?php $element->print_render_attribute_string('item_class') ?>>
					<div class="product-review-item-inner">
						<div class="entry-thumbnail-wrap">
							<div class="entry-thum-inner bubba-effect">
								<div class="effect-content">
									<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="transition03 gsf-link"><?php esc_html_e('View Book', 'auteur-framework'); ?></a>
									<?php echo wp_kses_post($product->get_image()); ?>
								</div>
							</div>
						</div>
						<div class="review-info">
							<h4 class="product-title"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"
							                             class="transition03 gsf-link"><?php echo esc_html($product->get_name()); ?></a></h4>
							<span class="reviewer"><?php echo sprintf( esc_html__( 'By %s', 'auteur-framework' ), strtoupper(get_comment_author( $comment->comment_ID )) ); ?></span>
							<?php if(isset($comment->comment_content) && !empty($comment->comment_content)): ?>
								<p class="review-content"><?php echo esc_html($comment->comment_content); ?></p>
							<?php endif; ?>
							<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="product-categories heading-color">', '</div>' ); ?>
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"
							   class="btn btn-link btn-md btn-accent btn-icon-right"><?php esc_html_e('Read the review', 'auteur-framework') ?><i class="fal fa-chevron-double-right"></i></a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<div class="item-not-found"><?php esc_html_e('No item found','auteur-framework'); ?></div>
	<?php endif; ?>
</div>

