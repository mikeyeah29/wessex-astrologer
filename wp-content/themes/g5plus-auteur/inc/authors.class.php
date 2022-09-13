<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'G5Plus_Auteur_Authors' ) ) {
	class G5Plus_Auteur_Authors {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {

		}


		public function archive_markup( $query_args = null, $settings = null ) {

			$paged = get_query_var( 'paged' );
			if ( isset( $_REQUEST['settings'] ) ) {
				$settings = wp_parse_args( $_REQUEST['settings'], $settings );
				$paged    = isset( $settings['currentPage']['paged'] ) ? $settings['currentPage']['paged'] : 1;
			}
			$query_args['paged'] = $paged;

			$items_per_page           = intval( $query_args['number'] );
			$settings['itemSelector'] = 'article';
			$is_slider                = $settings['is_slider'];
			$dots                     = $settings['dots'];
			$nav                      = $settings['nav'];
			$autoplay                 = $settings['autoplay'];
			$autoplay_timeout         = $settings['autoplay_timeout'];
			$nav_style                = $settings['nav_style'];
			$nav_position             = $settings['nav_position'];
			$nav_size                 = $settings['nav_size'];
			$nav_hover_scheme         = $settings['nav_hover_scheme'];
			$nav_hover_style          = $settings['nav_hover_style'];

			$authors     = $settings['authors'];
			$post_paging = $settings['post_paging'];
			$image_size  = $settings['image_size'];

			$columns        = intval( $settings['columns'] );
			$columns_gutter = intval( $settings['columns_gutter'] );
			$columns_xl     = intval( $settings['columns_xl'] );
			$columns_lg     = intval( $settings['columns_lg'] );
			$columns_md     = intval( $settings['columns_md'] );
			$columns_sm     = intval( $settings['columns_sm'] );

			if ( $items_per_page != 0 && $post_paging !== 'none' ) {
				$query_args['offset'] = ( max( 1, $paged ) - 1 ) * $items_per_page;
			}

			$id_authors = array();
			if ( ! empty( $authors ) ) {
				$slugs      = explode( ',', $authors );
				$slugs      = array_map( 'trim', $slugs );
				foreach ( $slugs as $slug ) {
					$term = get_term_by( 'slug', $slug, 'product_author' );
					if ( is_object( $term ) ) {
						$id_authors[] = $term->term_id;
					}
				}
				$query_args['include'] = $id_authors;
			}
			$product_authors = get_terms( $query_args );

			$item_class  = array( 'gsf-product-author-item' );
			$inner_class = $owl_args = array();
			if ( 'on' === $is_slider ) {
				$inner_class[] = 'owl-carousel owl-theme';
				$owl_args      = array(
					'items'           => $columns_xl,
					'margin'          => $columns == 1 ? 0 : $columns_gutter,
					'slideBy'         => $columns_xl,
					'dots'            => ( $dots === 'on' ) ? true : false,
					'nav'             => ( $nav === 'on' ) ? true : false,
					'responsive'      => array(
						'1200' => array(
							'items'   => $columns_xl,
							'margin'  => $columns_xl == 1 ? 0 : $columns_gutter,
							'slideBy' => $columns_xl,
						),
						'992'  => array(
							'items'   => $columns_lg,
							'margin'  => $columns_lg == 1 ? 0 : $columns_gutter,
							'slideBy' => $columns_lg,
						),
						'768'  => array(
							'items'   => $columns_md,
							'margin'  => $columns_md == 1 ? 0 : $columns_gutter,
							'slideBy' => $columns_md,
						),
						'576'  => array(
							'items'   => $columns_sm,
							'margin'  => $columns_sm == 1 ? 0 : $columns_gutter,
							'slideBy' => $columns_sm,
						),
						'0'    => array(
							'items'   => $columns,
							'margin'  => $columns == 1 ? 0 : $columns_gutter,
							'slideBy' => $columns,
						)
					),
					'autoHeight'      => true,
					'autoplay'        => ( $autoplay === 'on' ) ? true : false,
					'autoplayTimeout' => intval( $autoplay_timeout ),
				);
				if ( $nav_style == 'nav-square-text' || $nav_style == 'nav-circle-text' ) {
					$owl_args['navText'] = array(
						'<i class="fal fa-angle-left"></i> <span>' . esc_html__( 'Prev', 'auteur-framework' ) . '</span>',
						'<span>' . esc_html__( 'Next', 'auteur-framework' ) . '</span> <i class="fal fa-angle-right"></i>'
					);
				}

				if ( $nav === 'on' ) {
					$inner_class = array_merge( $inner_class, array(
						$nav_position,
						$nav_style,
						$nav_size,
						$nav_hover_scheme,
						$nav_hover_style
					) );
				}
			} else {
				$inner_class[] = 'gf-gutter-' . $columns_gutter;
				$inner_class[] = 'gf-blog-inner';
				$item_class[]  = 'grid-item';

				$columns      = array(
					'xl' => $columns_xl,
					'lg' => $columns_lg,
					'md' => $columns_md,
					'sm' => $columns_sm,
					''   => $columns
				);
				$item_class[] = G5Plus_Auteur()->helper()->get_bootstrap_columns( $columns );
			}

			$totalRecord = sizeof( $product_authors );
			if ( empty( $image_size ) ) {
				$image_size = 'full';
			}
			$settingId             = isset( $settings['settingId'] ) ? $settings['settingId'] : mt_rand();
			$settings['settingId'] = $settingId;
			?>
            <div data-items-wrapper="<?php echo esc_attr( $settingId ) ?>" class="product-authors clearfix">
				<?php
				if ( $totalRecord > 0 ): ?>
                    <div data-items-container="true"
                         class="gsf-product-authors-inner <?php echo join( ' ', $inner_class ); ?>"
                         data-owl-options='<?php echo json_encode( $owl_args ); ?>'>
						<?php foreach ( $product_authors as $author ):
							$prefix = G5P()->getMetaPrefix();
							$first_name = get_term_meta( $author->term_id, "{$prefix}product_author_first_name", true );
							$first_name_character = mb_substr( $first_name, 0, 1 );
							$last_name = get_term_meta( $author->term_id, "{$prefix}product_author_last_name", true );
							$last_name_character = mb_substr( $last_name, 0, 1 );
							?>
                            <article data-first-name="<?php echo esc_attr( $first_name_character ) ?>"
                                     data-last-name="<?php echo esc_attr( $last_name_character ) ?>" <?php post_class( $item_class ); ?>>
								<?php
								$id     = $author->term_id;
								$img    = G5P()->termMeta()->get_product_author_thumb( $id );
								$img_id = isset( $img['id'] ) && ! empty( $img['id'] ) ? $img['id'] : ''; ?>
                                <div class="entry-thumbnail-wrap">
                                    <a href="<?php echo esc_url( get_term_link( $id, 'product_author' ) ) ?>"
                                       title="<?php echo esc_attr( $author->name ) ?>"></a>
									<?php
									G5Plus_Auteur()->blog()->render_post_image_markup( array(
										'image_id'          => $img_id,
										'image_size'        => $image_size,
										'display_permalink' => false,
										'image_mode'        => 'background'
									) );
									?>
                                </div>
                                <h6 class="gsf-product-author-name fs-13 text-center mg-top-15 uppercase fw-bold"><a
                                            href="<?php echo esc_url( get_term_link( $id, 'product_author' ) ) ?>"
                                            class="transition03 gsf-link"
                                            title="<?php echo esc_attr( $author->name ) ?>"><?php echo esc_html( $author->name ) ?></a>
                                </h6>
                            </article>
						<?php endforeach; ?>
                    </div>
				<?php else: ?>
                    <div class="item-not-found"><?php esc_html_e( 'No item found', 'auteur-framework' ); ?></div>
				<?php endif;

				if ( $post_paging !== 'none' ) {
					$this->pagination_markup( $query_args, $settings );
				}
				?>
            </div>
			<?php
		}

		public function pagination_markup( $query_args = null, $settings = null ) {
			$post_paging = $settings['post_paging'];
			unset( $query_args['offset'] );
			$total    = wp_count_terms( $query_args['taxonomy'], $query_args );
			$per_page = $query_args['number'];
			if ( $per_page > 0 ) {
				$max_num_pages = ceil( $total / $per_page );
			} else {
				$max_num_pages = 1;
			}
			$paged        = isset( $settings['currentPage']['paged'] ) ? $settings['currentPage']['paged'] : get_query_var( 'paged', 1 );
			$pagenum_link = isset( $settings['pagenum_link'] ) ? $settings['pagenum_link'] : '';

			if ( ( ! isset( $_REQUEST['action'] ) || empty( $_REQUEST['action'] ) ) ) {
				$settings['pagenum_link'] = html_entity_decode( get_pagenum_link() );
				G5Plus_Auteur()->custom_js()->addJsVariable( array(
					'settings' => $settings,
					'query'    => $query_args
				), "gf_ajax_paginate_{$settings['settingId']}" );
			}

			if ( ( $max_num_pages > 1 ) && ( $post_paging !== '' ) && ( $post_paging !== 'none' ) ) {
				G5Plus_Auteur()->helper()->getTemplate( "paging/{$post_paging}", array(
					'settingId'     => $settings['settingId'],
					'pagenum_link'  => $pagenum_link,
					'isMainQuery'   => isset( $settings['isMainQuery'] ),
					'paged'         => $paged,
					'max_num_pages' => $max_num_pages
				) );
			}
		}

	}
}