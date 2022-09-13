<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('G5P_Inc_Hook')) {
    class G5P_Inc_Hook
    {
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        public function init()
        {
            $this->addAction();
            $this->addFilter();
        }

        private function addAction()
        {
            add_action('init', array($this, 'registerAssets'), 0);
            add_action('wp', array(G5P()->helper(), 'getCurrentPreset'), 1);
            add_action('wp_enqueue_scripts', array($this, 'frontEndAssets'));
            add_action('wp_enqueue_scripts', array(G5P()->assets(), 'dequeue_resource'), 11);
            add_action('admin_enqueue_scripts', array($this, 'adminAssets'));
            add_action('admin_enqueue_scripts', array(G5P()->assets(), 'dequeue_resource_admin'), 99);
            add_action('wp', array($this, 'setMetaBoxesToOption'), 20);
            add_action('wp', array($this, 'setTermMetaToOption'), 20);
            add_action('pre_get_posts', array($this, 'setPostLayoutToOption'), 5);
            add_action('wp', array($this, 'setProductLayoutToOption'), 5);
            add_action('wp', array($this, 'setPostSingleToOption'), 20);
            add_action('wp', array($this, 'setPortfolioLayoutToOption'), 20);
            add_action('wp', array($this, 'setPortfolioSingleToOption'), 20);
            add_action('wp', array($this, 'setProductSingleToOption'), 20);
            add_action('wp', array($this, 'setPageLayoutToOption'), 30);
            add_action('init', array($this, 'allowedPostTags'));
            add_action('pre_get_posts', array($this, 'changePostPerPage'), 6);

            //add_action( 'wp_ajax_g5plus_install_demo', array(G5P()->core()->dashboard()->install_demo(), 'install') );
	        add_action( 'wp_ajax_gsf_install_demo_data', array(G5P_Dashboard_Demo::getInstance(),'install'));

            /* share */
            add_action('g5plus_post_share', array($this, 'socialShare'));
            add_action('g5plus_single_post_share', array($this, 'socialShare'));
            // single product share
            add_action('woocommerce_share', array($this, 'shopSocialShare'));
            add_action('g5plus_portfolio_share', array($this, 'portfolioSocialShare'));
        }

        private function addFilter()
        {
            add_filter('gsf_theme_font_default', array($this, 'themeFontsDefault'));
            add_filter('gsf_plugin_url', array($this, 'changeSmartFrameworkUrl'));

        }

        public function changeSmartFrameworkUrl($url)
        {
            $pluginName = G5P()->pluginName();
            return "{$pluginName}/libs/smart-framework";
        }

        public function themeFontsDefault($fonts)
        {
            return array(
                array(
                    'family' => "Libre Baskerville",
                    'kind' => 'webfonts#webfont'
                ),
                array(
                    'family' => "Nunito Sans",
                    'kind' => 'webfonts#webfont'
                )
            );
        }


        /**
         * Register assets
         */
        public function registerAssets()
        {
            G5P()->assets()->registerScript();
            G5P()->assets()->registerStyle();
	        G5P()->assets()->registerShortCodeAssets();
        }

        public function frontEndAssets()
        {
            wp_enqueue_style(G5P()->assetsHandle('admin-bar'));
        }

        public function adminAssets()
        {
            wp_enqueue_style(G5P()->assetsHandle('admin-bar'));
            if ($this->isMetaPost()) {
                wp_enqueue_script(G5P()->assetsHandle('post-format'));
            }
        }

        public function isMetaPost($screen = null) {
            if ( ! ( $screen instanceof WP_Screen ) )
            {
                $screen = get_current_screen();
            }
            return 'post' == $screen->base && ($screen->post_type == 'post');
        }

        public function socialShare($args = array())
        {
            $defaults = array(
                'layout' => 'classic',
                'show_title' => false,
                'page_permalink' => '',
                'page_title' => '',
                'post_type' => 'post'
            );
            $defaults = wp_parse_args($args, $defaults);
            G5P()->helper()->getTemplate('inc/templates/social-share', $defaults);

        }

        public function shopSocialShare()
        {
            $this->socialShare(array(
                'post_type' => 'product',
            ));
        }

        public function portfolioSocialShare()
        {
            $this->socialShare(array(
                'post_type' => 'portfolio',
            ));
        }

        public function setMetaBoxesToOption()
        {
            $postType = G5P()->configMetaBox()->getPostType();
            if (is_singular($postType) || is_singular('post')) {
                $main_layout = G5P()->metaBox()->get_main_layout();
                if ($main_layout !== '') {
                    G5P()->options()->setOptions('main_layout', $main_layout);
                }


                $content_full_width = G5P()->metaBox()->get_content_full_width();
                if ($content_full_width !== '') {
                    G5P()->options()->setOptions('content_full_width', $content_full_width);
                }

                $custom_content_padding = G5P()->metaBox()->get_custom_content_padding();
                if ($custom_content_padding === 'on') {
                    G5P()->options()->setOptions('content_padding', G5P()->metaBox()->get_content_padding());
                }

                $mobile_custom_content_padding = G5P()->metaBox()->get_mobile_custom_content_padding();
                if ($mobile_custom_content_padding === 'on') {
                    G5P()->options()->setOptions('mobile_content_padding', G5P()->metaBox()->get_mobile_content_padding());
                }

                // sidebar layout
                $sidebar_layout = G5P()->metaBox()->get_sidebar_layout();
                if ($sidebar_layout !== '') {
                    G5P()->options()->setOptions('sidebar_layout', $sidebar_layout);
                }

                // sidebar
                $sidebar = G5P()->metaBox()->get_sidebar();
                if ($sidebar !== '') {
                    G5P()->options()->setOptions('sidebar', $sidebar);
                }

                $page_title_enable = G5P()->metaBox()->get_page_title_enable();
                if ($page_title_enable !== '') {
                    G5P()->options()->setOptions('page_title_enable', $page_title_enable);
                }

                $page_title_content_block = G5P()->metaBox()->get_page_title_content_block();
                if ($page_title_content_block !== '') {
                    G5P()->options()->setOptions('page_title_content_block', $page_title_content_block);
                }

            }
        }

        public function setTermMetaToOption()
        {
            $taxonomy = G5P()->configTermMeta()->getTaxonomy();
            if ((in_array('category', $taxonomy) && is_category()) || is_tax($taxonomy)) {
                $term = get_queried_object();
                if ($term && property_exists($term, 'term_id')) {
                    $term_id = $term->term_id;

                    $page_title_enable = G5P()->termMeta()->get_page_title_enable($term_id);
                    if ($page_title_enable !== '') {
                        G5P()->options()->setOptions('page_title_enable', $page_title_enable);
                    }

                    $page_title_content_block = G5P()->termMeta()->get_page_title_content_block($term_id);
                    if ($page_title_content_block !== '') {
                        G5P()->options()->setOptions('page_title_content_block', $page_title_content_block);
                    }
                }
            }
        }

        public function setPostSingleToOption()
        {
            if (is_singular('post')) {
                $prefix = G5P()->getMetaPrefix();
                $configs = array(
                    'single_post_layout',
                    'single_reading_process_enable',
                    'single_tag_enable',
                    'single_share_enable',
                    'single_navigation_enable',
                    'single_author_info_enable',
                    'single_related_post_enable',
                    'single_related_post_algorithm',
                    'single_related_post_carousel_enable',
                    'single_related_post_per_page',
                    'single_related_post_columns_gutter',
                    'single_related_post_columns',
                    'single_related_post_columns_md',
                    'single_related_post_columns_sm',
                    'single_related_post_columns_xs',
                    'single_related_post_paging',
                    'single_related_post_animation'
                );
                foreach ($configs as $config) {
                    $value = G5P()->metaBoxPost()->getMetaValue("{$prefix}{$config}");
                    if ($value !== '') {
                        G5P()->options()->setOptions($config, $value);
                    }
                }
            }
        }

        public function changePostPerPage($q)
        {
            $post_type = $q->get('post_type');
            if (!is_admin() && $q->is_main_query() && ($q->is_home() || $q->is_category() || $q->is_tag() || ($q->is_archive() && $post_type == 'post') || ($q->is_search() && ((is_array($post_type) && in_array('post', $post_type)) || $post_type == 'post' || $post_type == '' )))) {
                $posts_per_page = intval(G5P()->options()->get_posts_per_page());
                $custom_posts_per_page = isset($_GET['posts_per_page']) ? $_GET['posts_per_page'] : '';
                if (!empty($custom_posts_per_page)) {
                    $posts_per_page = $custom_posts_per_page;
                }
                if (!empty($posts_per_page)) {
                    $q->set('posts_per_page', $posts_per_page);
                }
            }
        }

        public function setPostLayoutToOption()
        {
            if (is_admin()) return;
            global $post;
            $post_type = get_post_type($post);
            $options = &GSF()->adminThemeOption()->getOptions(G5P()->getOptionName());
            $custom_post_layout_settings = G5P()->settings()->get_custom_post_layout_settings();
            foreach ($custom_post_layout_settings as $key => $value) {
                if ((($key === 'search') && is_search() && !is_admin()) ||
                    (($key === 'category') && is_category())
                ) {
                    $settings = array(
                        'post_layout',
                        'post_columns_gutter',
                        'post_columns',
                        'post_columns_md',
                        'post_columns_sm',
                        'post_columns_xs',
                        'post_columns_mb',
                        'post_image_size',
                        'post_image_width',
                        'post_paging',
                        'post_animation',
	                    'posts_per_page'
                    );

                    foreach ($settings as $setting) {
                        $setting_value = G5P()->options()->getOptions("{$key}_{$setting}");
                        if ($setting_value !== '') {
                            $options[$setting] = $setting_value;
                        }
                    }
                    break;
                }
            }
            // custom param
            if (is_home() || is_category() || is_tag() || (is_archive() && ($post_type == 'post')) || is_search()) {

                $post_layout = isset($_GET['post_layout']) ? $_GET['post_layout'] : '';
                if (array_key_exists($post_layout, G5P()->settings()->get_post_layout())) {
                    G5P()->options()->setOptions('post_layout', $post_layout);
                    G5P()->options()->setOptions('sidebar_layout', 'none');
                    if ($post_layout === 'grid') {
                        G5P()->options()->setOptions('post_columns', 3);
                        G5P()->options()->setOptions('post_columns_gutter', 50);
                        G5P()->options()->setOptions('post_image_size', '330x200');
                        G5P()->options()->setOptions('posts_per_page', 9);
                        G5P()->options()->setOptions('post_paging', 'pagination-ajax');
                        G5P()->options()->setOptions('post_animation', 'bottom-to-top');
                    } elseif ($post_layout === 'masonry') {
                        G5P()->options()->setOptions('post_columns', 3);
                        G5P()->options()->setOptions('post_columns_gutter', 50);
                        G5P()->options()->setOptions('post_image_width', 400);
                        G5P()->options()->setOptions('posts_per_page', 9);
                        G5P()->options()->setOptions('post_paging', 'pagination-ajax');
                        G5P()->options()->setOptions('post_animation', 'bottom-to-top');
                    } elseif ($post_layout === 'large-image') {
                        G5P()->options()->setOptions('post_image_size', '1170x655');
                        G5P()->options()->setOptions('sidebar_layout', 'right');
                        G5P()->options()->setOptions('posts_per_page', 5);
                        G5P()->options()->setOptions('post_paging', 'pagination-ajax');
                        G5P()->options()->setOptions('post_animation', 'bottom-to-top');
                    } elseif ($post_layout === 'medium-image') {
                        G5P()->options()->setOptions('post_image_size', '330x200');
                        G5P()->options()->setOptions('sidebar_layout', 'left');
                        G5P()->options()->setOptions('posts_per_page', 8);
                        G5P()->options()->setOptions('post_paging', 'pagination-ajax');
                        G5P()->options()->setOptions('post_animation', 'bottom-to-top');
                    } elseif ($post_layout === 'metro-01') {
                        G5P()->options()->setOptions('post_columns_gutter', 30);
                        G5P()->options()->setOptions('post_image_size', '500x500');
                        G5P()->options()->setOptions('posts_per_page', 9);
                        G5P()->options()->setOptions('post_paging', 'load-more');
                        G5P()->options()->setOptions('post_animation', 'bottom-to-top');
                    }
                }
            }
        }

        public function setProductLayoutToOption()
        {
            if (!is_admin() && is_main_query() && (is_post_type_archive('product') || is_tax(get_object_taxonomies('product_cat')))) {
                $product_catalog_layout = G5P()->options()->get_product_catalog_layout();
                if (isset($_COOKIE['product_layout']) && !empty($_COOKIE['product_layout']) && in_array($_COOKIE['product_layout'], array('grid', 'list')) && in_array($product_catalog_layout, array('grid', 'list'))) {
                    if (array_key_exists($product_catalog_layout, G5P()->settings()->get_product_catalog_layout())) {
                        G5P()->options()->setOptions('product_catalog_layout', $_COOKIE['product_layout']);
                    }
                }

                $product_catalog_layout = isset($_GET['product_layout']) ? $_GET['product_layout'] : '';
                if (array_key_exists($product_catalog_layout, G5P()->settings()->get_product_catalog_layout())) {
                    G5P()->options()->setOptions('product_catalog_layout', $product_catalog_layout);
                    G5P()->options()->setOptions('sidebar_layout', 'none');
                    if ($product_catalog_layout === 'grid') {
                        G5P()->options()->setOptions('product_columns', 4);
                        G5P()->options()->setOptions('product_columns_gutter', 30);
                        G5P()->options()->setOptions('product_paging', 'pagination-ajax');
                        G5P()->options()->setOptions('product_animation', 'bottom-to-top');
                    } elseif ($product_catalog_layout === 'list') {
                        G5P()->options()->setOptions('product_paging', 'load-more');
                        G5P()->options()->setOptions('product_animation', 'bottom-to-top');
                        G5P()->options()->setOptions('sidebar_layout', 'left');
                    } elseif ($product_catalog_layout === 'metro-01' || $product_catalog_layout === 'metro-02' || $product_catalog_layout === 'metro-03' || $product_catalog_layout === 'metro-04' || $product_catalog_layout === 'metro-05') {
                        G5P()->options()->setOptions('product_columns_gutter', 10);
                        G5P()->options()->setOptions('product_image_size', '500x500');
                        G5P()->options()->setOptions('product_paging', 'load-more');
                        G5P()->options()->setOptions('product_animation', 'bottom-to-top');
                    }
                }
                $product_columns = isset($_GET['product_columns']) ? $_GET['product_columns'] : 0;
                if(intval($product_columns) > 0) {
                    G5P()->options()->setOptions('product_columns', $product_columns);
                }
            }
            if (!is_admin() && is_main_query() && (is_singular('product'))) {
                $product_single_layout = isset($_GET['product_single_layout']) ? $_GET['product_single_layout'] : '';
                if (array_key_exists($product_single_layout, G5P()->settings()->get_product_single_layout())) {
                    G5P()->options()->setOptions('product_single_layout', $product_single_layout);
                    if ($product_single_layout === 'layout-02') {
                        G5P()->options()->setOptions('content_full_width', 'on');
                        G5P()->options()->setOptions('header_float_enable', 'off');
                        G5P()->options()->setOptions('page_title_enable', 'off');
                        G5P()->options()->setOptions('content_padding', array('left' => '100', 'right' => '100', 'top' => '', 'bottom' => ''));
                    }
                }
            }
        }

        public function setPageLayoutToOption()
        {
            $main_layout = isset($_GET['main_layout']) ? $_GET['main_layout'] : '';
            if (array_key_exists($main_layout, G5P()->settings()->get_main_layout())) {
                G5P()->options()->setOptions('main_layout', $main_layout);
            }

            $sidebar_layout = isset($_GET['sidebar_layout']) ? $_GET['sidebar_layout'] : '';
            if (array_key_exists($sidebar_layout, G5P()->settings()->get_sidebar_layout())) {
                G5P()->options()->setOptions('sidebar_layout', $sidebar_layout);
            }

            $content_full_width = isset($_GET['content_full_width']) ? $_GET['content_full_width'] : '';
            if ($content_full_width != '') {
                G5P()->options()->setOptions('content_full_width', $content_full_width);
            }
            $remove_content_padding = isset($_GET['remove_content_padding']) ? $_GET['remove_content_padding'] : '';
            if ($remove_content_padding == 'on') {
                G5P()->options()->setOptions('content_padding', array('left' => 0, 'right' => 0, 'top' => 0, 'bottom' => 0));
            }

            $page_title_enable = isset($_GET['page_title_enable']) ? $_GET['page_title_enable'] : '';
            if (in_array($page_title_enable, array('off', 'on'))) {
                G5P()->options()->setOptions('page_title_enable', ($page_title_enable == 'off') ? '' : $page_title_enable);
            }

            $header_float_enable = isset($_GET['header_float_enable']) ? $_GET['header_float_enable'] : '';
            if (in_array($header_float_enable, array('off', 'on'))) {
                G5P()->options()->setOptions('header_float_enable', ($header_float_enable == 'off') ? '' : $header_float_enable);
            }
            $header_above_border = isset($_GET['header_above_border']) ? $_GET['header_above_border'] : '';
            if (array_key_exists($header_above_border, G5P()->settings()->get_border_layout())) {
                G5P()->options()->setOptions('header_above_border', $header_above_border);
            }
        }

        public function setPortfolioLayoutToOption()
        {
            if (!is_admin() && is_main_query() && (is_post_type_archive('portfolio') || is_tax(get_object_taxonomies('portfolio_cat')))) {
                $portfolio_layout = isset($_GET['portfolio_layout']) ? $_GET['portfolio_layout'] : '';
                if (array_key_exists($portfolio_layout, G5P()->settings()->get_portfolio_layout())) {
                    G5P()->options()->setOptions('portfolio_layout', $portfolio_layout);
                    G5P()->options()->setOptions('sidebar_layout', 'none');
                    if ($portfolio_layout === 'grid') {
                        G5P()->options()->setOptions('portfolio_image_size', '553x420');
                        G5P()->options()->setOptions('portfolio_columns', 3);
                        G5P()->options()->setOptions('portfolio_columns_gutter', 30);
                        G5P()->options()->setOptions('portfolio_paging', 'pagination-ajax');
                        G5P()->options()->setOptions('portfolio_animation', 'bottom-to-top');
                    } elseif ($portfolio_layout === 'masonry') {
                        G5P()->options()->setOptions('portfolio_image_width', '400');
                        G5P()->options()->setOptions('portfolio_columns', 3);
                        G5P()->options()->setOptions('portfolio_columns_gutter', 30);
                        G5P()->options()->setOptions('portfolio_paging', 'pagination-ajax');
                        G5P()->options()->setOptions('portfolio_animation', 'bottom-to-top');
                    } elseif ($portfolio_layout === 'justified') {
                        G5P()->options()->setOptions('portfolio_row_height', 375);
                        G5P()->options()->setOptions('portfolio_row_max_height', 375);
                        G5P()->options()->setOptions('portfolio_columns_gutter', 10);
                        G5P()->options()->setOptions('portfolio_paging', 'infinite-scroll');
                    } elseif ($portfolio_layout === 'metro-1' || $portfolio_layout === 'metro-2' || $portfolio_layout === 'metro-3' || $portfolio_layout === 'metro-4' || $portfolio_layout === 'metro-5' || $portfolio_layout === 'metro-6' || $portfolio_layout === 'metro-7') {
                        G5P()->options()->setOptions('portfolio_columns_gutter', 10);
                        G5P()->options()->setOptions('portfolio_image_size', '480x480');
                        G5P()->options()->setOptions('portfolio_paging', 'load-more');
                        G5P()->options()->setOptions('portfolio_animation', 'bottom-to-top');
                    }
                }
                $portfolio_item_skin = isset($_GET['portfolio_item_skin']) ? $_GET['portfolio_item_skin'] : '';
                if (array_key_exists($portfolio_item_skin, G5P()->settings()->get_portfolio_item_skin())) {
                    G5P()->options()->setOptions('portfolio_item_skin', $portfolio_item_skin);
                    if($portfolio_item_skin === 'portfolio-item-skin-02') {
                        G5P()->options()->setOptions('portfolio_columns_gutter', 75);
                    }
                }
            }
        }

        public function setPortfolioSingleToOption()
        {
            if (is_singular('portfolio')) {
                $prefix = G5P()->getMetaPrefix();
                $portfolio_layout = G5P()->metaBoxPortfolio()->getMetaValue("{$prefix}single_portfolio_layout");
                if ('' !== $portfolio_layout) {
                    $configs_Single = array(
                        'single_portfolio_layout',
                        'single_portfolio_gallery_layout',
                        'single_portfolio_gallery_image_size',
                        'single_portfolio_gallery_image_ratio',
                        'single_portfolio_gallery_image_ratio_custom',
                        'single_portfolio_gallery_columns_gutter',
                        'single_portfolio_gallery_columns',
                        'single_portfolio_gallery_columns_md',
                        'single_portfolio_gallery_columns_sm',
                        'single_portfolio_gallery_columns_xs',
                        'single_portfolio_gallery_columns_mb',
                    );
                    foreach ($configs_Single as $config) {
                        $value = G5P()->metaBoxPortfolio()->getMetaValue("{$prefix}{$config}");
                        if ($value !== '') {
                            G5P()->options()->setOptions($config, $value);
                        }
                    }
                }

            }
        }

        public function setProductSingleToOption()
        {
            if (is_singular('product')) {
                $product_layout = G5P()->metaBoxProduct()->get_product_single_layout();
                if ($product_layout !== '') {
                    G5P()->options()->setOptions('product_single_layout',$product_layout);
                }
                $prefix = G5P()->getMetaPrefix();
                $configs_Single = array(
                    'product_single_layout',
                    'product_related_enable',
                    'product_related_algorithm',
                    'product_related_carousel_enable',
                    'product_related_columns_gutter',
                    'product_related_columns',
                    'product_related_columns_md',
                    'product_related_columns_sm',
                    'product_related_columns_xs',
                    'product_related_columns_mb',
                    'product_related_per_page',
                    'product_related_animation'
                );
                foreach ($configs_Single as $config) {
                    $value = G5P()->metaBoxProduct()->getMetaValue("{$prefix}{$config}");
                    if ($value !== '') {
                        G5P()->options()->setOptions($config, $value);
                    }
                }
            }
        }

        public function allowedPostTags()
        {
            global $allowedposttags;
            $allowedposttags['a']['data-hash'] = true;
            $allowedposttags['a']['data-product_id'] = true;
            $allowedposttags['a']['data-original-title'] = true;
            $allowedposttags['a']['aria-describedby'] = true;
            $allowedposttags['a']['data-quantity'] = true;
            $allowedposttags['a']['data-product_sku'] = true;
            $allowedposttags['a']['data-rel'] = true;
            $allowedposttags['a']['data-product-type'] = true;
            $allowedposttags['a']['data-product-id'] = true;
            $allowedposttags['a']['data-toggle'] = true;

            $allowedposttags['div']['data-owl-options'] = true;
            $allowedposttags['div']['data-plugin-options'] = true;
            $allowedposttags['div']['data-player'] = true;
            $allowedposttags['div']['data-audio'] = true;
            $allowedposttags['div']['data-title'] = true;
            $allowedposttags['div']['data-animsition-in-class'] = true;
            $allowedposttags['div']['data-animsition-out-class'] = true;
            $allowedposttags['div']['data-animsition-overlay'] = true;

            $allowedposttags['textarea']['placeholder'] = true;

            $allowedposttags['iframe']['align'] = true;
            $allowedposttags['iframe']['frameborder'] = true;
            $allowedposttags['iframe']['height'] = true;
            $allowedposttags['iframe']['longdesc'] = true;
            $allowedposttags['iframe']['marginheight'] = true;
            $allowedposttags['iframe']['marginwidth'] = true;
            $allowedposttags['iframe']['name'] = true;
            $allowedposttags['iframe']['sandbox'] = true;
            $allowedposttags['iframe']['scrolling'] = true;
            $allowedposttags['iframe']['seamless'] = true;
            $allowedposttags['iframe']['src'] = true;
            $allowedposttags['iframe']['srcdoc'] = true;
            $allowedposttags['iframe']['width'] = true;
            $allowedposttags['iframe']['defer'] = true;

            $allowedposttags['input']['accept'] = true;
            $allowedposttags['input']['align'] = true;
            $allowedposttags['input']['alt'] = true;
            $allowedposttags['input']['autocomplete'] = true;
            $allowedposttags['input']['autofocus'] = true;
            $allowedposttags['input']['checked'] = true;
            $allowedposttags['input']['class'] = true;
            $allowedposttags['input']['disabled'] = true;
            $allowedposttags['input']['form'] = true;
            $allowedposttags['input']['formaction'] = true;
            $allowedposttags['input']['formenctype'] = true;
            $allowedposttags['input']['formmethod'] = true;
            $allowedposttags['input']['formnovalidate'] = true;
            $allowedposttags['input']['formtarget'] = true;
            $allowedposttags['input']['height'] = true;
            $allowedposttags['input']['list'] = true;
            $allowedposttags['input']['max'] = true;
            $allowedposttags['input']['maxlength'] = true;
            $allowedposttags['input']['min'] = true;
            $allowedposttags['input']['multiple'] = true;
            $allowedposttags['input']['name'] = true;
            $allowedposttags['input']['pattern'] = true;
            $allowedposttags['input']['placeholder'] = true;
            $allowedposttags['input']['readonly'] = true;
            $allowedposttags['input']['required'] = true;
            $allowedposttags['input']['size'] = true;
            $allowedposttags['input']['src'] = true;
            $allowedposttags['input']['step'] = true;
            $allowedposttags['input']['type'] = true;
            $allowedposttags['input']['value'] = true;
            $allowedposttags['input']['width'] = true;
            $allowedposttags['input']['accesskey'] = true;
            $allowedposttags['input']['class'] = true;
            $allowedposttags['input']['contenteditable'] = true;
            $allowedposttags['input']['contextmenu'] = true;
            $allowedposttags['input']['dir'] = true;
            $allowedposttags['input']['draggable'] = true;
            $allowedposttags['input']['dropzone'] = true;
            $allowedposttags['input']['hidden'] = true;
            $allowedposttags['input']['id'] = true;
            $allowedposttags['input']['lang'] = true;
            $allowedposttags['input']['spellcheck'] = true;
            $allowedposttags['input']['style'] = true;
            $allowedposttags['input']['tabindex'] = true;
            $allowedposttags['input']['title'] = true;
            $allowedposttags['input']['translate'] = true;

            $allowedposttags['span']['data-id'] = true;
        }

    }
}