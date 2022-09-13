<?php
if (!class_exists('G5P_Inc_Term_Meta')) {
    class G5P_Inc_Term_Meta {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
        public function get_page_title_enable($id = ''){ return $this->getMetaValue('g5plus_auteur_page_title_enable', $id); }
        public function get_page_title_content_block($id = ''){ return $this->getMetaValue('g5plus_auteur_page_title_content_block', $id); }
        public function get_page_title_content($id = ''){ return $this->getMetaValue('g5plus_auteur_page_title_content', $id); }
        public function get_page_subtitle_content($id = ''){ return $this->getMetaValue('g5plus_auteur_page_subtitle_content', $id); }

        public function get_product_author_thumb($id = ''){ return $this->getMetaValue('g5plus_auteur_product_author_thumb', $id); }
        public function get_product_author_quote($id = ''){ return $this->getMetaValue('g5plus_auteur_product_author_quote', $id); }
        public function get_author_additional_details($id = ''){ return $this->getMetaValue('g5plus_auteur_author_additional_details', $id); }
        public function get_author_social_networks($id = ''){ return $this->getMetaValue('g5plus_auteur_author_social_networks', $id); }

        public function get_product_taxonomy_color($id = ''){ return $this->getMetaValue('g5plus_auteur_product_taxonomy_color', $id); }
        public function get_product_taxonomy_text($id = ''){ return $this->getMetaValue('g5plus_auteur_product_taxonomy_text', $id); }
        public function get_product_taxonomy_image($id = ''){ return $this->getMetaValue('g5plus_auteur_product_taxonomy_image', $id); }
        public function getMetaValue($meta_key, $id = '') {
            if ($id === '') {
                $queried_object = get_queried_object();
                $id = $queried_object->term_id;
            }

            $value = get_term_meta($id, $meta_key, true);
            if ($value === '') {
                $default = &$this->getDefault();
                if (isset($default[$meta_key])) {
                    $value = $default[$meta_key];
                }
            }
            return $value;
        }


        public function &getDefault() {
            $default = array (
                'g5plus_auteur_page_title_enable' => '',
                'g5plus_auteur_page_title_content_block' => '',
                'g5plus_auteur_page_title_content' => '',
                'g5plus_auteur_page_subtitle_content' => '',

                'g5plus_auteur_product_author_thumb' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'g5plus_auteur_product_author_quote' => '',
                'g5plus_auteur_author_additional_details' =>
                    array (
                    ),
                'g5plus_auteur_author_social_networks' =>
                    array (
                        0 =>
                            array (
                                'social_name' => 'Facebook',
                                'social_id' => 'social-facebook',
                                'social_icon' => 'fab fa-facebook-f',
                                'social_link' => '',
                            ),
                        1 =>
                            array (
                                'social_name' => 'Twitter',
                                'social_id' => 'social-twitter',
                                'social_icon' => 'fab fa-twitter',
                                'social_link' => '',
                            ),
                        2 =>
                            array (
                                'social_name' => 'Pinterest',
                                'social_id' => 'social-pinterest',
                                'social_icon' => 'fab fa-pinterest',
                                'social_link' => '',
                            ),
                        3 =>
                            array (
                                'social_name' => 'Dribbble',
                                'social_id' => 'social-dribbble',
                                'social_icon' => 'fab fa-dribbble',
                                'social_link' => '',
                            ),
                        4 =>
                            array (
                                'social_name' => 'LinkedIn',
                                'social_id' => 'social-linkedIn',
                                'social_icon' => 'fab fa-linkedin',
                                'social_link' => '',
                            ),
                        5 =>
                            array (
                                'social_name' => 'Vimeo',
                                'social_id' => 'social-vimeo',
                                'social_icon' => 'fab fa-vimeo',
                                'social_link' => '',
                            ),
                        6 =>
                            array (
                                'social_name' => 'Tumblr',
                                'social_id' => 'social-tumblr',
                                'social_icon' => 'fab fa-tumblr',
                                'social_link' => '',
                            ),
                        7 =>
                            array (
                                'social_name' => 'Skype',
                                'social_id' => 'social-skype',
                                'social_icon' => 'fab fa-skype',
                                'social_link' => '',
                            ),
                        8 =>
                            array (
                                'social_name' => 'Google+',
                                'social_id' => 'social-google-plus',
                                'social_icon' => 'fab fa-google-plus',
                                'social_link' => '',
                            ),
                        9 =>
                            array (
                                'social_name' => 'Flickr',
                                'social_id' => 'social-flickr',
                                'social_icon' => 'fab fa-flickr',
                                'social_link' => '',
                            ),
                        10 =>
                            array (
                                'social_name' => 'YouTube',
                                'social_id' => 'social-youTube',
                                'social_icon' => 'fab fa-youtube',
                                'social_link' => '',
                            ),
                        11 =>
                            array (
                                'social_name' => 'Foursquare',
                                'social_id' => 'social-foursquare',
                                'social_icon' => 'fab fa-foursquare',
                                'social_link' => '',
                            ),
                        12 =>
                            array (
                                'social_name' => 'Instagram',
                                'social_id' => 'social-instagram',
                                'social_icon' => 'fab fa-instagram',
                                'social_link' => '',
                            ),
                        13 =>
                            array (
                                'social_name' => 'GitHub',
                                'social_id' => 'social-gitHub',
                                'social_icon' => 'fab fa-github',
                                'social_link' => '',
                            ),
                        14 =>
                            array (
                                'social_name' => 'Xing',
                                'social_id' => 'social-xing',
                                'social_icon' => 'fab fa-xing',
                                'social_link' => '',
                            ),
                        15 =>
                            array (
                                'social_name' => 'Behance',
                                'social_id' => 'social-behance',
                                'social_icon' => 'fab fa-behance',
                                'social_link' => '',
                            ),
                        16 =>
                            array (
                                'social_name' => 'Deviantart',
                                'social_id' => 'social-deviantart',
                                'social_icon' => 'fab fa-deviantart',
                                'social_link' => '',
                            ),
                        17 =>
                            array (
                                'social_name' => 'Sound Cloud',
                                'social_id' => 'social-soundCloud',
                                'social_icon' => 'fab fa-soundcloud',
                                'social_link' => '',
                            ),
                        18 =>
                            array (
                                'social_name' => 'Yelp',
                                'social_id' => 'social-yelp',
                                'social_icon' => 'fab fa-yelp',
                                'social_link' => '',
                            ),
                        19 =>
                            array (
                                'social_name' => 'RSS Feed',
                                'social_id' => 'social-rss',
                                'social_icon' => 'fas fa-rss',
                                'social_link' => '',
                            ),
                        20 =>
                            array (
                                'social_name' => 'VK',
                                'social_id' => 'social-vk',
                                'social_icon' => 'fab fa-vk',
                                'social_link' => '',
                            ),
                        21 =>
                            array (
                                'social_name' => 'Email',
                                'social_id' => 'social-email',
                                'social_icon' => 'fas fa-envelope',
                                'social_link' => '',
                            ),
                    ),
                'g5plus_auteur_product_taxonomy_color' => '',
                'g5plus_auteur_product_taxonomy_text' => '',
                'g5plus_auteur_product_taxonomy_image' => ''
            );
            return $default;
        }
    }
}