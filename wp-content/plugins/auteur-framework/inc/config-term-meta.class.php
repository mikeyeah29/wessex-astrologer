<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if (!class_exists('G5P_Inc_Config_Term_Meta')) {
    class G5P_Inc_Config_Term_Meta
    {
        /*
     * loader instances
     */
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
            // Defined Theme Options
            add_filter('gsf_term_meta_config', array($this, 'register_term_meta'));
	        add_action( 'created_term', array($this,'process_author_name') ,10,3 );
	        add_action( 'edited_term', array($this,'process_author_name') ,10,3 );
	        add_action('init',array($this,'fix_author_name'));

        }

        public function process_author_name($term_id, $tt_id, $taxonomy) {
			if ($taxonomy === 'product_author') {
				$product_author = get_term($term_id);
				$product_author_name = trim($product_author->name) ;
				$product_author_name_attr = explode(' ', $product_author_name);
				$product_author_last_name = array_pop($product_author_name_attr);
				$product_author_first_name = join(' ', $product_author_name_attr);
				if ($product_author_first_name === '') {
					$product_author_first_name = $product_author_last_name;
				}
				$prefix = G5P()->getMetaPrefix();
				update_term_meta($term_id,"{$prefix}product_author_first_name",$product_author_first_name);
				update_term_meta($term_id,"{$prefix}product_author_last_name",$product_author_last_name);
			}
        }

        public function fix_author_name() {
	        $prefix = G5P()->getMetaPrefix();
        	$hasFix = get_option("{$prefix}has_fix_product_author_name");
        	if ($hasFix == 1) {
        		return;
	        }

            $product_authors = get_categories(array(
	            'taxonomy' => 'product_author'
            ));
            foreach ($product_authors as $product_author) {
	            $product_author_name = trim($product_author->name) ;
	            $product_author_name_attr = explode(' ', $product_author_name);
	            $product_author_last_name = array_pop($product_author_name_attr);
	            $product_author_first_name = join(' ', $product_author_name_attr);
	            if ($product_author_first_name === '') {
		            $product_author_first_name = $product_author_last_name;
	            }
	            $prefix = G5P()->getMetaPrefix();
	            update_term_meta($product_author->term_id,"{$prefix}product_author_first_name",$product_author_first_name);
	            update_term_meta($product_author->term_id,"{$prefix}product_author_last_name",$product_author_last_name);
            }

            update_option("{$prefix}has_fix_product_author_name",1);


        }

        public function getProductTaxonomy() {
            $taxonomies = array();
            if(class_exists('WooCommerce')) {
                $attribute_taxonomies = wc_get_attribute_taxonomies();
                if (!empty($attribute_taxonomies)) {
                    foreach ($attribute_taxonomies as $tax) {
                        if (wc_attribute_taxonomy_name($tax->attribute_name)) {
                            $taxonomies['pa_' . $tax->attribute_name] = $tax->attribute_type;
                        }
                    }
                }
            }
            return $taxonomies;
        }

        public function getTaxonomy()
        {
            return apply_filters('gsf_term_meta_taxonomy', array('category','product_cat', 'portfolio_cat'));
        }

        public function register_term_meta()
        {
            $prefix = G5P()->getMetaPrefix();

            $configs['gsf_taxonomy_setting'] = array(
                'name' => esc_html__('Advance Setting', 'auteur-framework'),
                'layout' => 'horizontal',
                'taxonomy' => $this->getTaxonomy(),
                'fields' => array(
                    array(
                        'id' => "{$prefix}group_page_title",
                        'type' => 'group',
                        'title' => esc_html__('Page Title', 'auteur-framework'),
                        'fields' => array(
                            G5P()->configOptions()->get_config_toggle(array(
                                'title' => esc_html__('Page Title Enable', 'auteur-framework'),
                                'id' => "{$prefix}page_title_enable"
                            ), true),
                            G5P()->configOptions()->get_config_content_block(array(
                                'id' => "{$prefix}page_title_content_block",
                                'desc' => esc_html__('Specify the Content Block to use as a page title content.', 'auteur-framework'),
                                'required' => array("{$prefix}page_title_enable", '!=', 'off')
                            ), true),

                            array(
                                'title' => esc_html__('Custom Page title', 'auteur-framework'),
                                'id' => "{$prefix}page_title_content",
                                'type' => 'text',
                                'default' => '',
                                'required' => array("{$prefix}page_title_enable", '!=', 'off'),
                                'desc' => esc_html__('Enter custom page title for this page', 'auteur-framework')
                            ),
                            array(
                                'title' => esc_html__('Custom Page Subtitle', 'auteur-framework'),
                                'id' => "{$prefix}page_subtitle_content",
                                'type' => 'text',
                                'default' => '',
                                'required' => array("{$prefix}page_title_enable", '!=', 'off'),
                                'desc' => esc_html__('Enter custom page subtitle for this page', 'auteur-framework')
                            )
                        )
                    )
                )
            );
            $configs['gsf_product_author_setting'] = array(
                'name' => esc_html__('Advance Setting', 'auteur-framework'),
                'layout' => 'horizontal',
                'taxonomy' => array('product_author'),
                'fields' => array(
                    array(
                        'title' => esc_html__('Thumbnail', 'auteur-framework'),
                        'id' => "{$prefix}product_author_thumb",
                        'type' => 'image',
                        'default' => ''
                    ),
                    array(
                        'title' => esc_html__('Quote of the author', 'auteur-framework'),
                        'id' => "{$prefix}product_author_quote",
                        'type' => 'textarea',
                        'default' => ''
                    ),
                    array(
                        'id'      => "{$prefix}author_additional_details",
                        'type'    => 'repeater',
                        'title'   => esc_html__( 'Additional details', 'auteur-framework' ),
                        'sort'    => true,
                        'default' => array(
                        ),
                        'fields'  => array(
                            array(
                                'title'   => esc_html__( 'Title', 'auteur-framework' ),
                                'id'      => "title",
                                'type'    => 'text',
                                'col'     => '4',
                                'default' => '',
                                'desc'    => esc_html__( 'Enter additional title', 'auteur-framework' ),
                            ),
                            array(
                                'title'   => esc_html__( 'Value', 'auteur-framework' ),
                                'id'      => "value",
                                'type'    => 'text',
                                'col'     => '8',
                                'width'   => '100%',
                                'default' => '',
                                'desc'    => esc_html__( 'Enter additional value', 'auteur-framework' ),
                            ),
                        )
                    ),
                    array(
                        'id'     => "{$prefix}group_social_networks",
                        'title'  => esc_html__('Social Networks', 'auteur-framework'),
                        'type'   => 'group',
                        'fields' => array(
                            array(
                                'id'             => "{$prefix}author_social_networks",
                                'title'          => esc_html__('Social Networks', 'auteur-framework'),
                                'desc'           => esc_html__('Define here all the social networks you will need.', 'auteur-framework'),
                                'type'           => 'panel',
                                'toggle_default' => false,
                                'default'        => G5P()->settings()->get_social_networks_default(),
                                'panel_title'    => 'social_name',
                                'sort'           => true,
                                'fields'         => array(
                                    array(
                                        'id'       => 'social_name',
                                        'title'    => esc_html__('Title', 'auteur-framework'),
                                        'subtitle' => esc_html__('Enter your social network name', 'auteur-framework'),
                                        'type'     => 'text',
                                    ),
                                    array(
                                        'id'         => 'social_id',
                                        'title'      => esc_html__('Unique Social Id', 'auteur-framework'),
                                        'subtitle'   => esc_html__('This value is created automatically and it shouldn\'t be edited unless you know what you are doing.', 'auteur-framework'),
                                        'type'       => 'text',
                                        'input_type' => 'unique_id',
                                        'default'    => 'social-'
                                    ),
                                    array(
                                        'id'       => 'social_icon',
                                        'title'    => esc_html__('Social Network Icon', 'auteur-framework'),
                                        'subtitle' => esc_html__('Specify the social network icon', 'auteur-framework'),
                                        'type'     => 'icon',
                                    ),
                                    array(
                                        'id'       => 'social_link',
                                        'title'    => esc_html__('Social Network Link', 'auteur-framework'),
                                        'subtitle' => esc_html__('Enter your social network link', 'auteur-framework'),
                                        'type'     => 'text',
                                    )
                                )
                            )
                        )
                    ),
                    array(
                        'id' => "{$prefix}group_page_title",
                        'type' => 'group',
                        'title' => esc_html__('Page Title', 'auteur-framework'),
                        'fields' => array(
                            G5P()->configOptions()->get_config_toggle(array(
                                'title' => esc_html__('Page Title Enable', 'auteur-framework'),
                                'id' => "{$prefix}page_title_enable"
                            ), true),
                            G5P()->configOptions()->get_config_content_block(array(
                                'id' => "{$prefix}page_title_content_block",
                                'desc' => esc_html__('Specify the Content Block to use as a page title content.', 'auteur-framework'),
                                'required' => array("{$prefix}page_title_enable", '!=', 'off')
                            ), true),

                            array(
                                'title' => esc_html__('Custom Page title', 'auteur-framework'),
                                'id' => "{$prefix}page_title_content",
                                'type' => 'text',
                                'default' => '',
                                'required' => array("{$prefix}page_title_enable", '!=', 'off'),
                                'desc' => esc_html__('Enter custom page title for this page', 'auteur-framework')
                            )
                        )
                    )
                )
            );
            if($this->getProductTaxonomy()) {
                foreach ($this->getProductTaxonomy() as $key => $value) {
                    if('select' !== $value) {
                        $configs['gsf_product_' . $key . '_setting'] = array(
                            'name' => esc_attr__('Additional Fields', 'auteur-framework'),
                            'layout' => 'horizontal',
                            'taxonomy' => array($key),
                            'fields' => array(
                                array(
                                    'title' => ucfirst($value),
                                    'id' => "{$prefix}product_taxonomy_" . $value,
                                    'type' => $value,
                                    'default' => ''
                                )
                            )
                        );
                    }
                }
            }

            return $configs;
        }
    }
}