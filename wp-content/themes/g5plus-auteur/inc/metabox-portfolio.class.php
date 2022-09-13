<?php
if (!class_exists('G5Plus_Auteur_MetaBox_Portfolio')) {
    class G5Plus_Auteur_MetaBox_Portfolio {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
        public function get_single_portfolio_layout($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_layout', $id); }
        public function get_single_portfolio_gallery_layout($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_gallery_layout', $id); }
        public function get_single_portfolio_gallery_image_size($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_gallery_image_size', $id); }
        public function get_single_portfolio_gallery_image_ratio($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_gallery_image_ratio', $id); }
        public function get_single_portfolio_gallery_image_ratio_custom($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_gallery_image_ratio_custom', $id); }
        public function get_single_portfolio_gallery_columns_gutter($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_gallery_columns_gutter', $id); }
        public function get_single_portfolio_gallery_columns($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_gallery_columns', $id); }
        public function get_single_portfolio_gallery_columns_md($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_gallery_columns_md', $id); }
        public function get_single_portfolio_gallery_columns_sm($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_gallery_columns_sm', $id); }
        public function get_single_portfolio_gallery_columns_xs($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_gallery_columns_xs', $id); }
        public function get_single_portfolio_gallery_columns_mb($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_gallery_columns_mb', $id); }
        public function get_single_portfolio_custom_link($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_custom_link', $id); }
        public function get_single_portfolio_media_type($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_media_type', $id); }
        public function get_single_portfolio_gallery($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_gallery', $id); }
        public function get_single_portfolio_video($id = ''){ return $this->getMetaValue('g5plus_auteur_single_portfolio_video', $id); }
        public function get_portfolio_details_date($id = ''){ return $this->getMetaValue('g5plus_auteur_portfolio_details_date', $id); }
        public function get_portfolio_details_client($id = ''){ return $this->getMetaValue('g5plus_auteur_portfolio_details_client', $id); }
        public function get_portfolio_details_type($id = ''){ return $this->getMetaValue('g5plus_auteur_portfolio_details_type', $id); }
        public function get_portfolio_details_author($id = ''){ return $this->getMetaValue('g5plus_auteur_portfolio_details_author', $id); }
        public function getMetaValue($meta_key, $id = '') {
            if ($id === '') {
                $id = get_the_ID();
            }

            $value = get_post_meta($id, $meta_key, true);

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
                'g5plus_auteur_single_portfolio_layout' => '',
                'g5plus_auteur_single_portfolio_gallery_layout' => 'carousel',
                'g5plus_auteur_single_portfolio_gallery_image_size' => 'medium',
                'g5plus_auteur_single_portfolio_gallery_image_ratio' => '1x1',
                'g5plus_auteur_single_portfolio_gallery_image_ratio_custom' =>
                    array (
                        'width' => '',
                        'height' => '',
                    ),
                'g5plus_auteur_single_portfolio_gallery_columns_gutter' => '10',
                'g5plus_auteur_single_portfolio_gallery_columns' => '3',
                'g5plus_auteur_single_portfolio_gallery_columns_md' => '3',
                'g5plus_auteur_single_portfolio_gallery_columns_sm' => '2',
                'g5plus_auteur_single_portfolio_gallery_columns_xs' => '2',
                'g5plus_auteur_single_portfolio_gallery_columns_mb' => '1',
                'g5plus_auteur_single_portfolio_custom_link' => '',
                'g5plus_auteur_single_portfolio_media_type' => 'image',
                'g5plus_auteur_single_portfolio_gallery' => '',
                'g5plus_auteur_single_portfolio_video' =>
                    array (
                        0 => '',
                    ),
                'g5plus_auteur_portfolio_details_date' => '',
                'g5plus_auteur_portfolio_details_client' => '',
                'g5plus_auteur_portfolio_details_type' => '',
                'g5plus_auteur_portfolio_details_author' => '',
            );
            return $default;
        }
    }
}