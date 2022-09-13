<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Auteur_Portfolio')) {
    class G5Plus_Auteur_Portfolio
    {
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        private $_post_type = 'portfolio';
        private $_taxonomy_category = 'portfolio_cat';

        public function get_post_type()
        {
            return $this->_post_type;
        }

        public function get_taxonomy_category()
        {
            return $this->_taxonomy_category;
        }

        public function init()
        {
            add_filter('g5plus_post_layout_matrix', array($this, 'layout_matrix'), 10, 4);
            add_action('g5plus_after_single_portfolio', array($this, 'portfolio_controls'), 15);
            add_action('g5plus_after_single_portfolio', array($this, 'portfolio_related'), 15);
        }

        public function render_thumbnail_markup($args = array())
        {
            $defaults = array(
                'post_id' => get_the_ID(),
                'image_size' => 'thumbnail',
                'image_mode' => 'background',
                'placeholder_enable' => true,
                'image_ratio' => '',
                'portfolio_layout' => '',
                'display_permalink' => true,
            );
            $defaults = wp_parse_args($args, $defaults);
            G5Plus_Auteur()->helper()->getTemplate('portfolio/thumbnail', $defaults);
        }

        public function layout_matrix($matrix)
        {
            $post_settings = G5Plus_Auteur()->blog()->get_layout_settings();
            if ($post_settings['post_type'] !== 'portfolio') {
                $post_settings = G5Plus_Auteur()->portfolio()->get_layout_settings();
            }
            $columns = isset($post_settings['post_columns']) ? $post_settings['post_columns'] : array(
                'xl' => 3,
                'lg' => 3,
                'md' => 2,
                'sm' => 1,
                '' => 1
            );
            $columns_class = G5Plus_Auteur()->helper()->get_bootstrap_columns($columns);
            $columns_gutter = intval(isset($post_settings['post_columns_gutter']) ? $post_settings['post_columns_gutter'] : 30);
            $matrix[$this->get_post_type()] = array(
                'grid' => array(
                    'image_size' => G5Plus_Auteur()->options()->get_portfolio_image_size(),
                    'placeholder_enable' => true,
                    'columns_gutter' => $columns_gutter,
                    'layout' => array(
                        array('columns' => $columns_class, 'template' => 'grid')
                    )
                ),
                'carousel' => array(
                    'image_size' => G5Plus_Auteur()->options()->get_portfolio_image_size(),
                    'placeholder_enable' => true,
                    'columns_gutter' => $columns_gutter,
                    'layout' => array(
                        array('columns' => $columns_class, 'template' => 'grid')
                    )
                ),
                'masonry' => array(
                    'columns_gutter' => $columns_gutter,
                    'isotope' => array(
                        'itemSelector' => 'article',
                        'layoutMode' => 'masonry',
                    ),
                    'layout' => array(
                        array('columns' => $columns_class, 'template' => 'grid')
                    )
                ),
                'scattered' => array(
                    'columns_gutter' => '0',
                    'layout' => array(
                        array('columns' => 'scattered-index-1 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => 'grid', 'image_size' => '320x320'),
                        array('columns' => 'scattered-index-2 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => 'grid', 'image_size' => '280x470'),
                        array('columns' => 'scattered-index-3 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => 'grid', 'image_size' => '320x240'),
                        array('columns' => 'scattered-index-4 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 1.5, 'lg' => 1.5, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => 'grid', 'image_size' => '570x240'),
                        array('columns' => 'scattered-index-5 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => 'grid', 'image_size' => '280x360'),
                        array('columns' => 'scattered-index-6 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => 'grid', 'image_size' => '320x320'),
                        array('columns' => 'scattered-index-7 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => 'grid', 'image_size' => '320x240'),
                        array('columns' => 'scattered-index-8 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 3, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => 'grid', 'image_size' => '320x320'),

                    )
                ),
                'propeller' => array(
                    'columns_gutter' => $columns_gutter,
                    'layout' => array(
                        array('columns' => 'propeller-index-1 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'image_size' => '370x370'),
                        array('columns' => 'propeller-index-2 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'image_size' => '370x470'),
                        array('columns' => 'propeller-index-3 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'image_size' => '370x470'),
                        array('columns' => 'propeller-index-4 ' . G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'image_size' => '370x370')
                    )
                ),
                'justified' => array(
                    'placeholder_enable' => false,
                    'layout' => array(
                        array('template' => 'grid')
                    )
                ),
                'metro-1' => array(
                    'columns_gutter' => $columns_gutter,
                    'isotope' => array(
                        'itemSelector' => 'article',
                        'layoutMode' => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => G5Plus_Auteur()->options()->get_portfolio_image_size(),
                    'layout' => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),

                    )
                ),
                'metro-2' => array(
                    'columns_gutter' => $columns_gutter,
                    'isotope' => array(
                        'itemSelector' => 'article',
                        'layoutMode' => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => G5Plus_Auteur()->options()->get_portfolio_image_size(),
                    'layout' => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),

                    )
                ),
                'metro-3' => array(
                    'columns_gutter' => $columns_gutter,
                    'isotope' => array(
                        'itemSelector' => 'article',
                        'layoutMode' => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => G5Plus_Auteur()->options()->get_portfolio_image_size(),
                    'layout' => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '2x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '2x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 4, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                    )
                ),
                'metro-4' => array(
                    'columns_gutter' => $columns_gutter,
                    'isotope' => array(
                        'itemSelector' => 'article',
                        'layoutMode' => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'image_size' => G5Plus_Auteur()->options()->get_portfolio_image_size(),
                    'layout' => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1.344512195'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1.344512195'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1.344512195'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1.344512195'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                    )
                ),
                'metro-5' => array(
                    'columns_gutter' => $columns_gutter,
                    'image_size' => G5Plus_Auteur()->options()->get_portfolio_image_size(),
                    'isotope' => array(
                        'itemSelector' => 'article',
                        'layoutMode' => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'layout' => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'grid', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'grid', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'grid', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4,'lg' => 4,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'grid', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2,'lg' => 2,'md' => 2,'sm' => 2,'' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1')
                    )
                ),
                'metro-6' => array(
                    'columns_gutter' => $columns_gutter,
                    'image_size' => G5Plus_Auteur()->options()->get_portfolio_image_size(),
                    'isotope' => array(
                        'itemSelector' => 'article',
                        'layoutMode' => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'layout' => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 1.5, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '2x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 1.5, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 3, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                    )
                ),
                'metro-7' => array(
                    'columns_gutter' => $columns_gutter,
                    'image_size' => G5Plus_Auteur()->options()->get_portfolio_image_size(),
                    'isotope' => array(
                        'itemSelector' => 'article',
                        'layoutMode' => 'masonry',
                        'percentPosition' => true,
                        'masonry' => array(
                            'columnWidth' => '.gsf-col-base',
                        ),
                        'metro' => true
                    ),
                    'layout' => array(
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 4, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '1x1'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '2x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 2, 'md' => 2, 'sm' => 2, '' => 1)), 'template' => 'grid', 'layout_ratio' => '2x2'),
                        array('columns' => G5Plus_Auteur()->helper()->get_bootstrap_columns(array('xl' => 2, 'lg' => 1, 'md' => 1, 'sm' => 1, '' => 1)), 'template' => 'grid', 'layout_ratio' => '2x1'),
                    )
                ),
                'carousel-3d' => array(
                    'carousel' => array(
                        'items' => 2,
                        'center' => true,
                        'loop' => true,
                        'responsive' => array(
                            0 => array(
                                'items' => 1,
                                'center' => false
                            ),
                            600 => array(
                                'items' => 2
                            )
                        )
                    ),
                    'carousel_class' => 'carousel-3d',
                    'image_size' => G5Plus_Auteur()->options()->get_portfolio_image_size(),
                    'layout' => array(
                        array('template' => 'grid')
                    )
                )
            );
            return $matrix;
        }

        public function get_layout_settings()
        {
            return array(
                'post_layout' => G5Plus_Auteur()->options()->get_portfolio_layout(),
                'portfolio_item_skin' => G5Plus_Auteur()->options()->get_portfolio_item_skin(),
                'post_columns' => array(
                    'xl' => intval(G5Plus_Auteur()->options()->get_portfolio_columns()),
                    'lg' => intval(G5Plus_Auteur()->options()->get_portfolio_columns_md()),
                    'md' => intval(G5Plus_Auteur()->options()->get_portfolio_columns_sm()),
                    'sm' => intval(G5Plus_Auteur()->options()->get_portfolio_columns_xs()),
                    '' => intval(G5Plus_Auteur()->options()->get_portfolio_columns_mb()),
                ),
                'post_columns_gutter' => intval(G5Plus_Auteur()->options()->get_portfolio_columns_gutter()),
                'portfolio_light_box' => G5Plus_Auteur()->options()->get_portfolio_light_box(),
                'post_paging' => G5Plus_Auteur()->options()->get_portfolio_paging(),
                'post_animation' => G5Plus_Auteur()->options()->get_portfolio_animation(),
                'image_size' => G5Plus_Auteur()->options()->get_portfolio_image_size(),
                'itemSelector' => 'article',
                'category_filter_enable' => false,
                'post_type' => $this->get_post_type(),
                'taxonomy' => $this->get_taxonomy_category()
            );
        }

        public function archive_markup($query_args = null, $settings = null)
        {
            if (isset($_REQUEST['settings']) && !isset($query_args)) {
                $settings = wp_parse_args($_REQUEST['settings'],$settings);
            }

            if (isset($settings['tabs']) && isset($settings['tabs'][0]['query_args'])) {
                $query_args = $settings['tabs'][0]['query_args'];
            }

            if (!isset($query_args)) {
                $settings['isMainQuery'] = true;
            }

            $settings = wp_parse_args($settings, $this->get_layout_settings());
            G5Plus_Auteur()->blog()->set_layout_settings($settings);


            G5Plus_Auteur()->query()->query_posts($query_args);

            if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
                add_action('g5plus_before_archive_wrapper', array(G5Plus_Auteur()->blog(), 'category_filter_markup'));
            }

            if (isset($settings['tabs'])) {
                add_action('g5plus_before_archive_wrapper', array(G5Plus_Auteur()->blog(), 'tabs_markup'));
            }

            G5Plus_Auteur()->helper()->getTemplate('portfolio/archive');
            if (isset($settings['tabs'])) {
                remove_action('g5plus_before_archive_wrapper', array(G5Plus_Auteur()->blog(), 'tabs_markup'));
            }

            if (isset($settings['category_filter_enable']) && $settings['category_filter_enable'] === true) {
                remove_action('g5plus_before_archive_wrapper', array(G5Plus_Auteur()->blog(), 'category_filter_markup'));
            }

            G5Plus_Auteur()->blog()->unset_layout_settings();

            G5Plus_Auteur()->query()->reset_query();


        }

        public function the_permalink($post = 0)
        {
            $custom_link = G5Plus_Auteur()->metaBoxPortfolio()->get_single_portfolio_custom_link();
            if (!empty($custom_link)) {
                echo esc_url($custom_link);
            } else {
                the_permalink($post);
            }
        }

        public function get_category_parents($id, $link = false, $separator = '/', $nicename = false, $deprecated = array())
        {

            if (!empty($deprecated)) {
                _deprecated_argument(__FUNCTION__, '4.8.0');
            }

            $format = $nicename ? 'slug' : 'name';

            $args = array(
                'separator' => $separator,
                'link' => $link,
                'format' => $format,
            );

            return get_term_parents_list($id, $this->get_taxonomy_category(), $args);
        }

        public function get_category_link($category)
        {
            if (!is_object($category))
                $category = (int)$category;

            $category = get_term_link($category, $this->get_taxonomy_category());

            if (is_wp_error($category))
                return '';

            return $category;
        }

        public function the_category($separator = '', $parents = '', $post_id = false)
        {
            echo sprintf('%s',$this->get_the_category_list($separator, $parents, $post_id));
        }

        public function get_the_category_list($separator = '', $parents = '', $post_id = false)
        {
            $categories = get_the_terms($post_id, $this->get_taxonomy_category());
            if (empty($categories)) {
                /** This filter is documented in wp-includes/category-template.php */
                return apply_filters('the_portfolio_category', esc_html__('Uncategorized', 'g5plus-auteur'), $separator, $parents);
            }

            $thelist = '';
            if ('' == $separator) {
                $thelist .= '<ul class="portfolio-categories">';
                foreach ($categories as $category) {
                    $thelist .= "\n\t<li>";
                    switch (strtolower($parents)) {
                        case 'multiple':
                            if ($category->parent)
                                $thelist .= $this->get_category_parents($category->parent, true, $separator);
                            $thelist .= '<a href="' . esc_url($this->get_category_link($category->term_id)) . '">' . $category->name . '</a></li>';
                            break;
                        case 'single':
                            $thelist .= '<a href="' . esc_url($this->get_category_link($category->term_id)) . '">';
                            if ($category->parent)
                                $thelist .= $this->get_category_parents($category->parent, false, $separator);
                            $thelist .= $category->name . '</a></li>';
                            break;
                        case '':
                        default:
                            $thelist .= '<a href="' . esc_url($this->get_category_link($category->term_id)) . '">' . $category->name . '</a></li>';
                    }
                }
                $thelist .= '</ul>';
            } else {
                $i = 0;
                foreach ($categories as $category) {
                    if (0 < $i)
                        $thelist .= $separator;
                    switch (strtolower($parents)) {
                        case 'multiple':
                            if ($category->parent)
                                $thelist .= $this->get_category_parents($category->parent, true, $separator);
                            $thelist .= '<a href="' . esc_url($this->get_category_link($category->term_id)) . '">' . $category->name . '</a>';
                            break;
                        case 'single':
                            $thelist .= '<a href="' . esc_url($this->get_category_link($category->term_id)) . '">';
                            if ($category->parent)
                                $thelist .= $this->get_category_parents($category->parent, false, $separator);
                            $thelist .= "$category->name</a>";
                            break;
                        case '':
                        default:
                            $thelist .= '<a href="' . esc_url($this->get_category_link($category->term_id)) . '">' . $category->name . '</a>';
                    }
                    ++$i;
                }
            }

            return apply_filters('the_portfolio_category', $thelist, $separator, $parents);
        }

        public function portfolio_related()
        {
            G5Plus_Auteur()->helper()->getTemplate('portfolio/single/portfolio-related');
        }

        public function portfolio_controls()
        {
            G5Plus_Auteur()->helper()->getTemplate('portfolio/single/portfolio-controls');
        }

        function get_portfolio_term_ids($portfolio_id)
        {
            $terms = get_the_terms($portfolio_id, $this->get_taxonomy_category());
            return (empty($terms) || is_wp_error($terms)) ? array() : wp_list_pluck($terms, 'term_id');
        }
    }
}