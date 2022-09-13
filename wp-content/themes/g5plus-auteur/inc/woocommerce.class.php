<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Auteur_Woocommerce')) {
    class G5Plus_Auteur_Woocommerce {
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init(){
            $this->filter();
            add_action('init',array($this,'hook'));
        }

        public function filter() {
            add_filter('gsf_shorcodes', array($this, 'register_shortcode'));

            //page title
            add_filter('g5plus_page_title',array($this,'page_title'));
            add_filter('ube_page_title',array($this,'page_title'));

            add_filter('g5plus_post_layout_matrix',array($this,'layout_matrix'));

            // remove shop page title
            add_filter('woocommerce_show_page_title','__return_false');

            add_filter('woocommerce_product_description_heading','__return_false');
            add_filter('woocommerce_product_additional_information_heading','__return_false');
            add_filter('woocommerce_product_review_heading','__return_false');

            add_filter('woocommerce_review_gravatar_size', array($this,'review_gravatar_size'));

            add_filter('gsf_page_setting_post_type',array($this,'page_setting'));

            add_filter( 'product_attributes_type_selector', array( $this, 'type_selector' ) );
            $attribute_taxonomies = wc_get_attribute_taxonomies();
            foreach ( $attribute_taxonomies as $attribute_taxonomy ) {
                add_filter("manage_edit-pa_{$attribute_taxonomy->attribute_name}_columns", array(
                    $this,
                    'swatches_custom_columns'
                ));
                add_filter("manage_pa_{$attribute_taxonomy->attribute_name}_custom_column", array(
                    $this,
                    'swatches_custom_columns_content'
                ), 10, 3);
            }

            // single product related
            add_filter('woocommerce_output_related_products_args', array($this, 'product_related_products_args'));
            add_filter('woocommerce_product_related_posts_relate_by_category',array($this, 'product_related_posts_relate_by_category'));
            add_filter('woocommerce_product_related_posts_relate_by_tag',array($this, 'product_related_posts_relate_by_tag'));

            add_filter('woocommerce_output_related_products_args', array($this, 'product_related_posts_per_page'));

            add_filter('woocommerce_upsells_total', array($this, 'product_up_sells_posts_per_page'));

            add_filter('woocommerce_cart_item_thumbnail', array($this, 'product_cart_item_thumbnail'), 10, 3);
            // Cross sells
            add_filter('woocommerce_cross_sells_total', array($this, 'product_cross_sells_posts_per_page'));
            add_filter('woocommerce_single_product_image_thumbnail_html', array($this, 'gallery_thumbnail_src'), 10, 2);

            add_filter('woocommerce_available_variation', array($this, 'change_variation_thumb_src'), 10, 3);

            add_filter('gsf_product_secondary_image',array($this,'change_product_secondary_image'),10,2);
        }

        public function hook() {
            // remove woocommerce sidebar
            remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);

            // remove Breadcrumb
            remove_action('woocommerce_before_main_content','woocommerce_breadcrumb',20);

            // remove archive description
            remove_action('woocommerce_archive_description','woocommerce_taxonomy_archive_description',10);
            remove_action('woocommerce_archive_description','woocommerce_product_archive_description',10);

            // remove result count and catalog ordering
            remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);
            remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);

            // remove pagination
            //remove_action('woocommerce_after_shop_loop','woocommerce_pagination',10);

            // remove product link close
            remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_product_link_close',5);
            remove_action('woocommerce_before_shop_loop_item','woocommerce_template_loop_product_link_open',10);

            //remove add to cart
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

            // remove product thumb
            remove_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail',10);

            // remove product title
            remove_action('woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10);

            // remove product rating
            remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5);

            // remove compare button
            global $yith_woocompare;
            if ( isset($yith_woocompare) && isset($yith_woocompare->obj)) {
                remove_action( 'woocommerce_after_shop_loop_item', array($yith_woocompare->obj,'add_compare_link'), 20 );
                remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
            }

            add_action('pre_get_posts',array($this,'changePostPerPage'),7);


            add_action( 'woocommerce_before_shop_loop_item_title', array( G5Plus_Auteur()->templates(), 'shop_swatches_loop' ), 9 );

            // product title
            add_action('woocommerce_shop_loop_item_title',array(G5Plus_Auteur()->templates(),'shop_loop_product_title'),10);
            // product cat
            add_action('woocommerce_shop_loop_item_title',array(G5Plus_Auteur()->templates(),'shop_loop_product_cat'),15);

            // product author
            add_action('woocommerce_after_shop_loop_item_title',array(G5Plus_Auteur()->templates(), 'shop_loop_product_author'),12);

            // product rating
            add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',15);

            // Product description
            add_action('woocommerce_after_shop_loop_item_title', array($this, 'shop_loop_product_excerpt'),20);

            // Sale count down
            add_action('woocommerce_before_shop_loop_item_title',array(G5Plus_Auteur()->templates(),'shop_loop_sale_count_down'),10);

            // product add to cart
            add_action('g5plus_woocommerce_product_actions',array(G5Plus_Auteur()->templates(),'shop_loop_grid_add_to_cart'),10);
            // product wishlist
            add_action('g5plus_woocommerce_product_actions',array(G5Plus_Auteur()->templates(),'shop_loop_wishlist'),10);

            // product actions
            add_action('g5plus_woocommerce_product_actions',array(G5Plus_Auteur()->templates(),'shop_loop_quick_view'),15);

            add_action('g5plus_woocommerce_product_actions',array(G5Plus_Auteur()->templates(),'shop_loop_compare'),20);

            // product actions 2
            add_action('g5plus_woocommerce_product_actions_2',array(G5Plus_Auteur()->templates(),'shop_loop_quick_view'),5);
            add_action('g5plus_woocommerce_product_actions_2',array(G5Plus_Auteur()->templates(),'shop_loop_grid_add_to_cart'),10);
            add_action('g5plus_woocommerce_product_actions_2',array(G5Plus_Auteur()->templates(),'shop_loop_compare'),15);

            // Product List actions
            add_action( 'g5plus_woocommerce_shop_loop_list_info',array(G5Plus_Auteur()->templates(),'shop_loop_list_add_to_cart'),10 );
            add_action('g5plus_woocommerce_shop_loop_list_info',array(G5Plus_Auteur()->templates(),'shop_loop_wishlist'),15);
            add_action( 'g5plus_woocommerce_shop_loop_list_info',array(G5Plus_Auteur()->templates(),'shop_loop_quick_view'),20 );
            add_action( 'g5plus_woocommerce_shop_loop_list_info',array(G5Plus_Auteur()->templates(),'shop_loop_compare'),25 );

            // single product
            remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

            add_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_loop_sale_flash', 10);


            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price',10);
            //add_action('woocommerce_single_product_summary', array(G5Plus_Auteur()->templates(),'shop_loop_product_author'),6);
            add_action('woocommerce_product_meta_start',array(G5Plus_Auteur()->templates(),'shop_single_meta_product_author'));
            add_action('woocommerce_product_meta_start',array(G5Plus_Auteur()->templates(),'shop_single_meta_additional_details'));
            add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price',4);
            add_action('woocommerce_single_product_summary',array(G5Plus_Auteur()->templates(),'shop_single_loop_sale_count_down'),15);

            // product author
            add_action( 'woocommerce_after_single_product_summary', array( G5Plus_Auteur()->templates(), 'shop_single_product_author'), 5 );

            // variations single
            $swatches_enable = G5Plus_Auteur()->options()->get_product_single_swatches_enable();
            if ( 'on' === $swatches_enable ) {
                remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
                add_action( 'woocommerce_variable_add_to_cart', array( G5Plus_Auteur()->templates(), 'swatches_single' ) );
            }

            // Quick view
            add_action( 'wp_footer', array( $this, 'quick_view' ));

            add_action('woocommerce_before_quick_view_product_summary','woocommerce_show_product_loop_sale_flash',10);
            add_action('woocommerce_before_quick_view_product_summary',array(G5Plus_Auteur()->templates(),'quick_view_show_product_images'),20);

            add_action('woocommerce_quick_view_product_summary',array(G5Plus_Auteur()->templates(),'quickview_rating'),4);
            add_action('woocommerce_quick_view_product_summary', array(G5Plus_Auteur()->templates(),'shop_loop_quick_view_product_title'),5);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_price',10);
            add_action('woocommerce_quick_view_product_summary',array(G5Plus_Auteur()->templates(),'shop_single_loop_sale_count_down'),15);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_excerpt',20);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_add_to_cart',30);

            add_action('woocommerce_after_add_to_cart_button', array(G5Plus_Auteur()->templates(),'shop_single_function'));

            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_meta',50);
            add_action('woocommerce_quick_view_product_summary','woocommerce_template_single_sharing',60);

            // Cart
            remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
            add_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display',20 );
            add_action('woocommerce_before_cart_totals','woocommerce_shipping_calculator',5);

            add_action('woocommerce_before_product_deal_product',array(G5Plus_Auteur()->templates(),'shop_loop_sale_count_down'),10);
            add_action('woocommerce_product_deal_product','woocommerce_template_loop_price',5);
            add_action('woocommerce_product_deal_product',array(G5Plus_Auteur()->templates(),'shop_loop_rating'),10);
            add_action('woocommerce_product_deal_product',array(G5Plus_Auteur()->templates(),'shop_loop_grid_add_to_cart'),10);

            add_action('woocommerce_product_thumbnails', array(G5Plus_Auteur()->templates(),'shop_single_video'), 25);

            add_action('gsf_product_singular_actions', array(G5Plus_Auteur()->templates(),'product_singular_quick_view'),10);
            add_action('gsf_product_singular_actions', 'woocommerce_template_loop_add_to_cart', 15);
        }

        public function get_product_thumb_size() {
            return apply_filters('gf_gallery_thumb_size', array(112, 150));
        }

        public function change_variation_thumb_src($args, $product_variation, $variation) {
            $size = $this->get_product_thumb_size();
            $attach_id = $variation->get_image_id();
            $image_src = G5Plus_Auteur()->image_resize()->resize(array(
                'image_id' => $attach_id,
                'width' => $size[0],
                'height' => $size[1]
            ));
            if (!empty($image_src) && isset($image_src['url'])) {
                $args['image']['gallery_thumbnail_src'] = $image_src['url'];
                $args['image']['gallery_thumbnail_src_w'] = $image_src['width'];
                $args['image']['gallery_thumbnail_src_h'] = $image_src['height'];
            }
            return $args;
        }

        public function gallery_thumbnail_src($html, $attach_id) {
            $size = $this->get_product_thumb_size();
            $image_src = G5Plus_Auteur()->image_resize()->resize(array(
                'image_id' => $attach_id,
                'width' => $size[0],
                'height' => $size[1]
            ));
            if (!empty($image_src) && isset($image_src['url'])) {
                $image_src = $image_src['url'];
            }
            $pattern = '/(data-thumb=[\"|\'])([^\"\']*)([\"|\'])/i';
            $replacement = '$1' . $image_src . '$3';
            return preg_replace($pattern, $replacement, $html);
        }

        public function type_selector( $attribute_types ) {

            global $pagenow;
            if ( ( $pagenow === 'post-new.php' ) || ( $pagenow === 'post.php' ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
                return $attribute_types;
            }
            $attribute_types['text'] = esc_html__( 'Text', 'g5plus-auteur' );
            $attribute_types['color'] = esc_html__( 'Color', 'g5plus-auteur' );
            $attribute_types['image'] = esc_html__( 'Image', 'g5plus-auteur' );
            return $attribute_types;
        }

        public function swatches_custom_columns( $columns ) {
            $columns['swatches_value']   = esc_html__('Swatches Value', 'g5plus-auteur');
            return $columns;
        }

        public function swatches_custom_columns_content( $columns, $column, $term_id ) {
            if ( $column == 'swatches_value' ) {
                $term      = get_term( $term_id );
                $attr_id   = wc_attribute_taxonomy_id_by_name( $term->taxonomy );
                $attr_info = wc_get_attribute( $attr_id );
                switch ( $attr_info->type ) {
                    case 'image':
                        $val = G5Plus_Auteur()->termMeta()->get_product_taxonomy_image($term_id);
                        $image_id = isset($val['id']) ? $val['id'] : 0;
                        echo '<img style="display: inline-block; width: 40px; height: 40px; background-color: #eee; box-sizing: border-box; border: 1px solid #eee;" src="' . esc_url( wp_get_attachment_thumb_url( $image_id ) ) . '"/>';
                        break;
                    case 'color':
                        $val = G5Plus_Auteur()->termMeta()->get_product_taxonomy_color($term_id);
                        echo '<span style="display: inline-block; width: 40px; height: 40px; background-color: ' . esc_attr( $val ) . '; box-sizing: border-box; border: 1px solid #eee;"></span>';
                        break;
                    case 'text':
                        $val = G5Plus_Auteur()->termMeta()->get_product_taxonomy_text($term_id);
                        echo '<span style="display: inline-block; height: 40px; line-height: 40px; padding: 0 15px; border: 1px solid #eee; background-color: #fff; min-width: 44px; box-sizing: border-box;">' . esc_html( $val ) . '</span>';
                        break;
                }
            }
        }

        public function register_shortcode($shortcodes) {
            $shortcodes = array_merge($shortcodes, array(
                'gsf_products',
                'gsf_product_authors',
                'gsf_product_category',
                'gsf_product_reviews',
                'gsf_product_singular',
                'gsf_product_tabs'
            ));
            sort($shortcodes);
            return $shortcodes;
        }

        public function changePostPerPage($q) {
            if (!is_admin() && $q->is_main_query() && ($q->is_post_type_archive( 'product' ) || $q->is_tax( get_object_taxonomies( 'product' )))) {
                $woocommerce_customize = G5Plus_Auteur()->options()->get_woocommerce_customize();
                if(!isset($woocommerce_customize['Disable']) || !array_key_exists('items-show', $woocommerce_customize['Disable'])) {
                    $product_per_page = G5Plus_Auteur()->options()->get_woocommerce_customize_item_show();
                } else {
                    $product_per_page = G5Plus_Auteur()->options()->get_product_per_page();
                }

                if(!empty($product_per_page)) {
                    $product_per_page_arr = explode(",", $product_per_page);
                } else {
                    $product_per_page_arr = array(intval(get_option( 'posts_per_page')));
                }
                $product_per_page = isset( $_GET['product_per_page'] ) ? wc_clean( $_GET['product_per_page'] ) : $product_per_page_arr[0];

                $q->set('posts_per_page',$product_per_page);
            }
        }

        /**
         * Get Post Layout Settings
         *
         * @return mixed
         */
        public function get_layout_settings()
        {
            $catalog_layout = G5Plus_Auteur()->options()->get_product_catalog_layout();
            return array(
                'post_layout'            => $catalog_layout,
                'post_columns'           => array(
                    'xl' => intval(G5Plus_Auteur()->options()->get_product_columns()),
                    'lg' => intval(G5Plus_Auteur()->options()->get_product_columns_md()),
                    'md' => intval(G5Plus_Auteur()->options()->get_product_columns_sm()),
                    'sm' => intval(G5Plus_Auteur()->options()->get_product_columns_xs()),
                    '' => intval(G5Plus_Auteur()->options()->get_product_columns_mb()),
                ),
                'post_columns_gutter'    => intval(G5Plus_Auteur()->options()->get_product_columns_gutter()),
                'image_size'        => G5Plus_Auteur()->options()->get_product_image_size(),
                'post_paging'            => G5Plus_Auteur()->options()->get_product_paging(),
                'post_animation'         => G5Plus_Auteur()->options()->get_product_animation(),
                'itemSelector'           => 'article',
                'category_filter_enable' => false,
                'post_type' => 'product',
                'taxonomy'               => 'product_cat'
            );
        }


        public function layout_matrix($matrix) {
            $post_settings = G5Plus_Auteur()->blog()->get_layout_settings();
            if ($post_settings['post_type'] !== 'product') {
                $post_settings = G5Plus_Auteur()->woocommerce()->get_layout_settings();
            }
            $columns = isset($post_settings['post_columns']) ? $post_settings['post_columns'] : array(
                'xl' => 3,
                'lg' => 3,
                'md' => 2,
                'sm' => 1,
                '' => 1
            );
            $columns = G5Plus_Auteur()->helper()->get_bootstrap_columns($columns);
            $columns_gutter = intval(isset($post_settings['post_columns_gutter']) ? $post_settings['post_columns_gutter'] : 30);
            $image_size = isset($post_settings['image_size']) ? $post_settings['image_size'] : 'medium';
            $matrix['product'] = array(
                'list'    => array(
                    'image_size' => 'shop_catalog',
                    'placeholder_enable' => true,
                    'columns_gutter' => $columns_gutter,
                    'layout'             => array(
                        array('columns' => $columns, 'template' => 'content-product'),
                    )
                ),
                'grid'           => array(
                    'placeholder_enable' => true,
                    'columns_gutter' => $columns_gutter,
                    'image_size' => 'shop_catalog',
                    'layout'         => array(
                        array('columns' => $columns, 'template' => 'content-product')
                    )
                ),
                'metro-01' => array(
                    'columns_gutter'     => $columns_gutter,
                    'placeholder_enable' => true,
                    'isotope'            => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => $image_size,
                    'layout'             => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '2x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '2x1'),

                    )
                ),
                'metro-02' => array(
                    'columns_gutter'     => $columns_gutter,
                    'placeholder_enable' => true,
                    'isotope'            => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => $image_size,
                    'layout'             => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '2x1'),

                    )
                ),
                'metro-03' => array(
                    'columns_gutter'     => $columns_gutter,
                    'placeholder_enable' => true,
                    'isotope'            => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => $image_size,
                    'layout'             => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro','layout_ratio' => '1x1'),
                    )
                ),
                'metro-04' => array(
                    'columns_gutter'     => $columns_gutter,
                    'placeholder_enable' => true,
                    'isotope'            => array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => $image_size,
                    'layout'             => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x1'),
                    )
                ),
                'metro-05' => array(
                    'columns_gutter' => $columns_gutter,
                    'placeholder_enable' => true,
                    'image_size' => $image_size,
                    'isotope' =>  array(
                        'itemSelector' => 'article',
                        'layoutMode'   => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'layout'             => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'content-product-metro', 'layout_ratio' => '2x1')
                    )
                ),
            );
            return $matrix;
        }

        public function page_setting($post_type) {
            $post_type[] = 'product';
            return $post_type;
        }

        public function get_product_class() {
            $settings = G5Plus_Auteur()->blog()->get_layout_settings();
            if ($settings['post_type'] !== 'product') {
                $settings = G5Plus_Auteur()->woocommerce()->get_layout_settings();
            }
            $post_classes = array(
                'clearfix',
                'product-item-wrap',
                'product-grid'
            );
            if ( !isset( $settings['carousel'] ) || isset($settings['carousel_rows']) ) {
                if ( isset($settings['columns']) && ($settings['columns'] !== '') && !isset($settings['isMainQuery'])) {
                    $columns_lg = absint($settings['columns']);
                    $columns = array(
                        'xl' => $columns_lg,
                        'lg' => $columns_lg > 4 ? 3 : $columns_lg,
                        'md' => $columns_lg > 2 ? 2 : $columns_lg,
                        'sm' => 1,
                        '' => 1
                    );
                } else {
                    $columns = isset($settings['post_columns']) ? $settings['post_columns'] : array(
                        'xl' => 3,
                        'lg' => 3,
                        'md' => 2,
                        'sm' => 1,
                        '' => 1
                    );
                }
                $columns = G5Plus_Auteur()->helper()->get_bootstrap_columns($columns);
                $post_classes[] = $columns;
            }
            return implode(' ', $post_classes);
        }

        public function get_product_inner_class() {
            $post_settings = G5Plus_Auteur()->blog()->get_layout_settings();
            if ($post_settings['post_type'] !== 'product') {
                $post_settings = G5Plus_Auteur()->woocommerce()->get_layout_settings();
            }
            $post_animation = isset( $post_settings['post_animation'] ) ? $post_settings['post_animation'] : '';

            $post_inner_classes = array(
                'product-item-inner',
                'clearfix',
                G5Plus_Auteur()->helper()->getCSSAnimation( $post_animation )
            );
            return implode( ' ', array_filter( $post_inner_classes ) );
        }

        public function render_product_thumbnail_markup($args = array()){
            $defaults = array(
                'post_id'            => get_the_ID(),
                'image_size'         => 'shop_catalog',
                'placeholder_enable' => true,
                'image_mode'         => 'image',
                'display_permalink' => true,
            );
            $defaults = wp_parse_args($args, $defaults);
            G5Plus_Auteur()->helper()->getTemplate('woocommerce/loop/product-thumbnail', $defaults);
        }


        public function shop_loop_product_excerpt(){
            global $post;
            if ( ! $post->post_excerpt ) {
                return;
            }
            ?>
            <div class="product-description">
                <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
            </div>
            <?php
        }

        public function archive_markup($query_args = null, $settings = null) {
            if (isset($_REQUEST['settings']) && !isset($query_args)) {
                $settings = wp_parse_args($_REQUEST['settings'],$settings);
            }

            if (isset($settings['tabs']) && isset($settings['tabs'][0]['query_args'])) {
                $query_args = $settings['tabs'][0]['query_args'];
            }

            if (!isset($query_args)) {
                $settings['isMainQuery'] = true;
            }
            $settings = wp_parse_args($settings,$this->get_layout_settings());
            G5Plus_Auteur()->blog()->set_layout_settings($settings);

            G5Plus_Auteur()->query()->query_posts($query_args);

            if (isset($settings['isMainQuery']) && ($settings['isMainQuery'] == true) && (!isset($settings['shop_catalog_filter']) || $settings['shop_catalog_filter'])) {
                add_action('g5plus_before_archive_wrapper',array(G5Plus_Auteur()->templates(),'shop_catalog_filter'),5);
            }


            if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
                add_action('g5plus_before_archive_wrapper', array(G5Plus_Auteur()->blog(), 'category_filter_markup'));
            }

            if (isset($settings['tabs'])) {
                add_action('g5plus_before_archive_wrapper', array(G5Plus_Auteur()->blog(), 'tabs_markup'));
            }

            //if (have_posts()) {
            if (isset($settings['isMainQuery']) && ($settings['isMainQuery'] == true)) {
                /**
                 * woocommerce_before_shop_loop hook.
                 *
                 * @hooked wc_print_notices - 10
                 */
                do_action( 'woocommerce_before_shop_loop' );
            }

            woocommerce_product_loop_start();

            if (G5Plus_Auteur()->query()->have_posts()) {
                $post_settings = &G5Plus_Auteur()->blog()->get_layout_settings();
                $post_layout = isset( $post_settings['post_layout'] ) ? $post_settings['post_layout'] : 'grid';
                $layout_matrix = G5Plus_Auteur()->blog()->get_layout_matrix( $post_layout );
                $post_paging = isset( $post_settings['post_paging'] ) ? $post_settings['post_paging'] : 'pagination';
                $post_animation = isset( $post_settings['post_animation'] ) ? $post_settings['post_animation'] : '';
                $placeholder_enable = isset( $layout_matrix['placeholder_enable'] ) ? $layout_matrix['placeholder_enable'] : false;
                $paged = G5Plus_Auteur()->query()->query_var_paged();
                $image_size = isset($post_settings['image_size']) ? $post_settings['image_size'] : (isset($layout_matrix['image_size']) ? $layout_matrix['image_size'] :  'shop_catalog');

                $image_size_base = $image_size;
                $image_ratio = '';
                if (in_array($post_layout, array('metro-01','metro-02','metro-03','metro-04','metro-05')) && in_array($image_size,array('full','large','medium','thumbnail'))) {
                    $image_ratio = isset($post_settings['image_ratio']) ? $post_settings['image_ratio'] : '';
                    if (empty($image_ratio)) {
                        $image_ratio = G5Plus_Auteur()->options()->get_product_image_ratio();
                    }

                    if ($image_ratio === 'custom') {
                        $image_ratio_custom = isset($post_settings['image_ratio_custom']) ? $post_settings['image_ratio_custom'] : G5Plus_Auteur()->options()->get_product_image_ratio_custom();
                        if (is_array($image_ratio_custom) && isset($image_ratio_custom['width']) && isset($image_ratio_custom['height'])) {
                            $image_ratio_custom_width = intval($image_ratio_custom['width']);
                            $image_ratio_custom_height = intval($image_ratio_custom['height']);
                            if (($image_ratio_custom_width > 0) && ($image_ratio_custom_height > 0)) {
                                $image_ratio = "{$image_ratio_custom_width}x{$image_ratio_custom_height}";
                            }
                        } elseif (preg_match('/x/',$image_ratio_custom)) {
                            $image_ratio = $image_ratio_custom;
                        }
                    }

                    if ($image_ratio === 'custom') {
                        $image_ratio = '1x1';
                    }
                }

                $image_ratio_base = $image_ratio;

                if (in_array($post_layout,array('grid','list'))) {
	                $image_size = 'shop_catalog';
                }


                if ( isset( $layout_matrix['layout'] ) ) {
                    $layout_settings = $layout_matrix['layout'];
                    $index = intval( G5Plus_Auteur()->query()->get_query()->get( 'index', 0 ) );

                    $post_classes = array(
                        'clearfix',
                        'product-item-wrap',
                    );

                    $post_inner_classes = array(
                        'product-item-inner',
                        'clearfix',
                        G5Plus_Auteur()->helper()->getCSSAnimation( $post_animation )
                    );
                    $carousel_index = 0;
                    while ( G5Plus_Auteur()->query()->have_posts() ) : G5Plus_Auteur()->query()->the_post();
                        $index = $index % sizeof( $layout_settings );
                        $current_layout = $layout_settings[$index];
                        $isFirst = isset( $current_layout['isFirst'] ) ? $current_layout['isFirst'] : false;
                        if ( $isFirst && ( $paged > 1 ) && in_array( $post_paging, array( 'load-more', 'infinite-scroll' ) ) ) {
                            if ( isset( $layout_settings[$index + 1] ) ) {
                                $current_layout = $layout_settings[$index + 1];
                            } else {
                                continue;
                            }
                        }
                        $post_inner_attributes = array();

                        if (isset($current_layout['layout_ratio'])) {
                            $layout_ratio = !empty($current_layout['layout_ratio']) ? $current_layout['layout_ratio'] : '1x1';
                            if ($image_size_base !== 'full') {
                                $image_size = G5Plus_Auteur()->helper()->get_metro_image_size($image_size_base,$layout_ratio,$layout_matrix['columns_gutter']);
                            } else {
                                $image_ratio =  G5Plus_Auteur()->helper()->get_metro_image_ratio($image_ratio_base,$layout_ratio);
                            }
                            $post_inner_attributes[] = 'data-ratio="'. $layout_ratio .'"';
                        }

                        $post_columns = $current_layout['columns'];
                        $template = $current_layout['template'];

                        $classes = array(
                            "product-{$template}"
                        );
                        if(isset($settings['carousel_rows']) && $carousel_index == 0) {
                            echo '<div class="owl-item-inner gf-slider-item clearfix">';
                        }
                        if ( !isset( $post_settings['carousel'] ) || isset($settings['carousel_rows']) ) {
                            $classes[] = $post_columns;
                        }
                        $classes = wp_parse_args( $classes, $post_classes );
                        $post_class = implode( ' ', array_filter( $classes ) );
                        $post_inner_class = implode( ' ', array_filter( $post_inner_classes ) );

                        wc_get_template( "{$template}.php", array(
                            'image_size' => $image_size,
                            'image_ratio' => $image_ratio,
                            'post_class' => $post_class,
                            'post_inner_class' => $post_inner_class,
                            'placeholder_enable' => $placeholder_enable,
                            'post_inner_attributes' => $post_inner_attributes
                        ));

                        if ( $isFirst ) {
                            unset( $layout_settings[$index] );
                            $layout_settings = array_values( $layout_settings );
                        }

                        if ( $isFirst && $paged === 1 ) {
                            $index = 0;
                        } else {
                            $index++;
                        }
                        $carousel_index++;
                        if(isset($settings['carousel_rows']) && $carousel_index == $settings['carousel_rows']['items_show']) {
                            echo '</div>';
                            $carousel_index = 0;
                        }
                    endwhile;
                    if(isset($settings['carousel_rows']) && $carousel_index != $settings['carousel_rows']['items_show'] && $carousel_index != 0) {
                        echo '</div>';
                    }
                }
            } else{
                /**
                 * woocommerce_no_products_found hook.
                 *
                 * @hooked wc_no_products_found - 10
                 */
                do_action( 'woocommerce_no_products_found' );
            }




            woocommerce_product_loop_end();
            if (isset($settings['tabs'])) {
                remove_action('g5plus_before_archive_wrapper', array(G5Plus_Auteur()->blog(), 'tabs_markup'));
            }

            if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
                remove_action('g5plus_before_archive_wrapper', array(G5Plus_Auteur()->blog(), 'category_filter_markup'));
            }

            if (isset($settings['isMainQuery']) && ($settings['isMainQuery'] == true) && (!isset($settings['shop_catalog_filter']) || $settings['shop_catalog_filter'])) {
                remove_action('g5plus_before_archive_wrapper',array(G5Plus_Auteur()->templates(),'shop_catalog_filter'),5);
            }

            G5Plus_Auteur()->blog()->unset_layout_settings();

            G5Plus_Auteur()->query()->reset_query();
        }
        public function page_title($page_title){
            if (is_post_type_archive('product')) {
                $shop_page_id = wc_get_page_id( 'shop' );
                if ($shop_page_id) {
                    if (!$page_title) {
                        $page_title   = get_the_title( $shop_page_id );
                    }
                    $custom_page_title = G5Plus_Auteur()->metaBox()->get_page_title_content($shop_page_id);
                    if ($custom_page_title) {
                        $page_title = $custom_page_title;
                    }
                }
            } elseif (is_tax('product_author')) {
                $term = get_queried_object();
                $page_title = esc_html__('Author', 'g5plus-auteur');
                $custom_page_title = G5Plus_Auteur()->termMeta()->get_page_title_content($term->term_id);
                if ($custom_page_title) {
                    $page_title = $custom_page_title;
                }
            }
            return $page_title;
        }
        public function quick_view(){
            $product_quick_view = G5Plus_Auteur()->options()->get_product_quick_view_enable();
            if ('on' === $product_quick_view) {
                wp_enqueue_script( 'wc-add-to-cart-variation' );
                if( version_compare( WC()->version, '3.0.0', '>=' ) ) {
                    if( current_theme_supports('wc-product-gallery-zoom') ) {
                        wp_enqueue_script('zoom');
                    }
                    if( current_theme_supports('wc-product-gallery-lightbox') ) {
                        wp_enqueue_script('photoswipe-ui-default');
                        wp_enqueue_style('photoswipe-default-skin');
                        if( has_action('wp_footer', 'woocommerce_photoswipe') === FALSE ) {
                            add_action('wp_footer', 'woocommerce_photoswipe', 15);
                        }
                    }
                    wp_enqueue_script('flexslider');
                    wp_enqueue_script('wc-single-product');
                }
                return true;
            }
        }

        public function product_related_products_args() {
            $products_per_page = intval(G5Plus_Auteur()->options()->get_product_related_per_page());
            $args['posts_per_page'] = $products_per_page;
            return $args;
        }

        public function product_related_posts_relate_by_category() {
            $product_algorithm = G5Plus_Auteur()->options()->get_product_related_algorithm();
            return (in_array($product_algorithm, array('cat', 'cat-tag'))) ? true : false;
        }
        public function product_related_posts_relate_by_tag() {
            $product_algorithm = G5Plus_Auteur()->options()->get_product_related_algorithm();
            return (in_array($product_algorithm, array('tag', 'cat-tag'))) ? true : false;
        }

        public function product_related_posts_per_page($args) {
            $related_per_page = G5Plus_Auteur()->options()->get_product_related_per_page();
            $args = array(
                'posts_per_page' 	=> intval($related_per_page),
                'columns' 			=> 4,
                'orderby' 			=> 'rand'
            );
            return $args;
        }

        public function product_cart_item_thumbnail($image, $cart_item, $cart_item_key)
        {
            if (isset($cart_item['product_id'])) {
                $image_id = get_post_thumbnail_id($cart_item['product_id']);
                $image = G5Plus_Auteur()->image_resize()->resize(array(
                    'image_id' => $image_id,
                    'width' => '85',
                    'height' => '100'
                ));
                $image_attributes = array(
                    'src="' . esc_url($image['url']) . '"',
                    'width="' . esc_attr($image['width']) . '"',
                    'height="' . esc_attr($image['height']) . '"',
                    'title="' . esc_attr(get_the_title($cart_item['product_id'])) . '"'
                );
                $image = '<img ' . implode(' ', $image_attributes) . '>';
            }
            return $image;
        }
        public function product_up_sells_posts_per_page() {
            $up_sells_per_page = G5Plus_Auteur()->options()->get_product_up_sells_per_page();
            return $up_sells_per_page;
        }

        public function product_cross_sells_posts_per_page() {
            $cross_sells_per_page = G5Plus_Auteur()->options()->get_product_cross_sells_per_page();
            return $cross_sells_per_page;
        }

        public function review_gravatar_size() {
            return 100;
        }

        public function change_product_secondary_image($image, $product) {
            if (function_exists('RBA')) {
                $rba_back_img = get_post_meta($product->get_id(),'rba_back_img',true);
                if (!empty($rba_back_img)) {
                    $image = $rba_back_img;
                }
            }
            return $image;
        }
    }
}