<?php
if (!class_exists('G5Plus_Auteur_MetaBox_Event')) {
    class G5Plus_Auteur_MetaBox_Event {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }
        public function get_organizer_position($id = ''){ return $this->getMetaValue('g5plus_auteur_organizer_position', $id); }
        public function get_organizer_avatar($id = ''){ return $this->getMetaValue('g5plus_auteur_organizer_avatar', $id); }
        public function get_section_event_schedule($id = ''){ return $this->getMetaValue('g5plus_auteur_section_event_schedule', $id); }
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
                'g5plus_auteur_organizer_position' => '',
                'g5plus_auteur_organizer_avatar' =>
                    array (
                        'id' => 0,
                        'url' => '',
                    ),
                'g5plus_auteur_section_event_schedule' =>
                    array (
                    ),
            );
            return $default;
        }
    }
}