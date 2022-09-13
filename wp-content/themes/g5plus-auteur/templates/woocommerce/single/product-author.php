<?php
$terms = wc_get_product_terms( get_the_ID(), 'product_author', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
$author_count = count($terms);
if ($author_count === 0)  {
	return;
}
$sidebar_layout = G5Plus_Auteur()->options()->get_sidebar_layout();
$sidebar = G5Plus_Auteur()->cache()->get_sidebar();
$sidebar_condition = apply_filters('gsf_sidebar_condition', ($sidebar_layout !== 'none' && is_active_sidebar($sidebar)));
$author_info_classes = array('author-main-info-wrap','row');
$inner_classes = array('product-author-inner');
$inner_attributes = array();
if ($author_count > 1) {
	$inner_classes[] = 'owl-carousel';
	$inner_classes[] = 'owl-theme';
	$inner_attributes[] = sprintf("data-owl-options='%s'",json_encode(array(
		'items' => 1,
		'margin' => 0,
		'slideBy' => 1,
		'dots' => false,
		'nav' => true,
		'autoHeight' => true,
		'autoplay' => true,
		'autoplayTimeout' => 5000
	)));
	$author_info_classes[] = 'author-carousel-item';
}
$inner_class = implode(' ', $inner_classes);
$author_info_class = implode(' ', $author_info_classes);
?>
<div class="product-author-wrap pd-top-100 pd-bottom-100 md-pd-top-70 md-pd-bottom-70 sm-pd-top-60 sm-pd-bottom-60 mg-top-70 md-mg-top-50 text-center">
    <h2 class="gf-heading-title"><?php esc_html_e('Meet The Author', 'g5plus-auteur'); ?></h2>
	<div class="<?php echo esc_attr($inner_class)?>" <?php echo implode(' ', $inner_attributes)?>>
		<?php foreach ($terms as $term): ?>
			<?php
				$id = $term->term_id;
				$slug = $term->slug;
				$img = G5Plus_Auteur()->termMeta()->get_product_author_thumb($id);
				$img_id = isset($img['id']) && !empty($img['id']) ? $img['id'] : '';

				$author_quote = G5Plus_Auteur()->termMeta()->get_product_author_quote($id);
				$addition_details = G5Plus_Auteur()->termMeta()->get_author_additional_details($id);
				$social_networks = G5Plus_Auteur()->termMeta()->get_author_social_networks($id);

				$author_link = get_term_link( $term, 'product_author' );
				$author_name = $term->name;

			?>
			<div class="<?php echo esc_attr($author_info_class)?>">
				<div class="author-main-info col-md-4">
					<div class="author-avatar-wrap">
						<?php
							G5Plus_Auteur()->blog()->render_post_image_markup(array(
								'image_id'          => $img_id,
								'image_size'        => '300x400',
								'display_permalink' => false,
								'image_mode'        => 'background'
							));
						?>
					</div>
					<div class="author-info hover-light">
						<h4 class="author-name mg-top-0"><a class="gsf-link transition03" href="<?php echo esc_url($author_link); ?>" title="<?php echo esc_attr($author_name) ?>"><?php echo esc_html($author_name) ?></a></h4>
						<?php G5Plus_Auteur()->helper()->getTemplate('woocommerce/loop/product-author-socials', array('social_networks' => $social_networks))?>
					</div>
				</div>
				<div class="author-products col-md-8">
					<?php if(!empty($author_quote)): ?>
						<div class="author-quote">"<?php echo wp_kses_post($author_quote); ?>"</div>
					<?php endif; ?>
					<?php
					$query_args = array(
						'posts_per_page' => 6,
						'post_status'    => 'publish',
						'post_type'      => 'product',
						'meta_query'     => array(),
						'post__not_in'   => array(get_the_ID()),
						'tax_query'      => array(
							'relation' => 'AND',
							array(
								'taxonomy' => 'product_author',
								'terms' => array($slug),
								'field' => 'slug',
								'operator' => 'IN'
							)
						)
					);
					$columns = !$sidebar_condition ? 3 : 2;
					$columns_lg = !$sidebar_condition ? 3 : 2;
					$owl_args = array(
						'items' => $columns,
						'margin' => 0,
						'slideBy' => $columns,
						'dots' => true,
						'nav' => false,
						'responsive' => array(
							'1200' => array(
								'items' => $columns,
								'slideBy' => 2,
							),
							'992' => array(
								'items' => $columns_lg,
								'slideBy' => 2,
							),
							'768' => array(
								'items' => 2,
								'slideBy' => 2,
							),
							'576' => array(
								'items' => 2,
								'slideBy' => 2,
							),
							'0' => array(
								'items' => 1,
								'slideBy' => 1,
							)
						),
						'autoHeight' => true,
						'autoplay' => false
					);
					$settings = array(
						'post_layout'            => 'grid',
						'post_columns_gutter'    => '30',
						'post_paging'            => 'none',
						'itemSelector'           => 'article',
						'category_filter_enable' => false,
						'post_type'              => 'product',
						'carousel'               => $owl_args,
						'carousel_class'         => 'gsf-slider-container item-gutter-30'
					);
					G5Plus_Auteur()->woocommerce()->archive_markup($query_args, $settings);
					?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>