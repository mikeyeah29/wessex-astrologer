<?php
if (!class_exists('G5Plus_Auteur_Term_Meta_Product')) {
    class G5Plus_Auteur_Term_Meta_Product {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
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
                'g5plus_auteur_sub_title' => '',
            );
            return $default;
        }
    }
}