<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (!class_exists('G5Plus_Auteur_Event')) {
    class G5Plus_Auteur_Event
    {
        private static $_instance;

        public static function getInstance()
        {
            if (self::$_instance == NULL) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }
        public function init(){
            if(class_exists('Tribe__Events__Main')) {
                add_action('wp_head', array($this, 'single_page_title'), 5);
                add_filter('gsf_shorcodes', array($this, 'register_shortcode'));
                add_filter('g5plus_page_title', array($this, 'page_title'));
                add_filter('ube_page_title', array($this, 'page_title'));

	            add_action('pre_get_posts',array($this,'changePostPerPage'),7);
            }
        }
        public function single_page_title() {
            global $sidebar_layout_origin;
            if(is_singular(Tribe__Events__Main::POSTTYPE)) {
                add_action('g5plus_before_main_content', array(G5Plus_Auteur()->templates(), 'event_single_page_title'), 5);
                remove_action('g5plus_before_main_content',array(G5Plus_Auteur()->templates(),'page_title'),5);
                $sidebar_layout_origin = G5Plus_Auteur()->options()->get_sidebar_layout();
                if('none' === $sidebar_layout_origin) {
                    G5plus_Auteur()->options()->setOptions('sidebar', '');
                }
                add_filter('gsf_sidebar_condition', array($this, 'sidebar_condition'));
                G5Plus_Auteur()->options()->setOptions('sidebar_layout', 'right');
                add_action('gsf_before_sidebar_content', array(G5Plus_Auteur()->templates(), 'single_event_sidebar_top'), 10);
            }
        }
        public function sidebar_condition() {
            return true;
        }
        public function register_shortcode($shortcodes) {
            $shortcodes = array_merge($shortcodes, array(
                'gsf_event_countdown',
                'gsf_events'
            ));
            sort($shortcodes);
            return $shortcodes;
        }

        public function page_title($page_title)
        {
            if (is_post_type_archive(Tribe__Events__Main::POSTTYPE)) {
                if (!$page_title) {
                    $page_title = tribe_get_events_title();
                }
                $custom_page_title = G5plus_Auteur()->metaBox()->get_page_title_content();
                if ($custom_page_title) {
                    $page_title = $custom_page_title;
                }
            } elseif (is_singular(Tribe__Events__Main::POSTTYPE)) {
                $custom_page_title = G5P()->metaBox()->get_page_title_content();
                if ($custom_page_title) {
                    $page_title = $custom_page_title;
                }
            }
            return $page_title;
        }

        public function changePostPerPage($q) {
	        if (!is_admin() && $q->is_main_query() && ($q->is_post_type_archive(Tribe__Events__Main::POSTTYPE ) || $q->is_tax( get_object_taxonomies( Tribe__Events__Main::POSTTYPE )))) {
		        $post_per_page = G5Plus_Auteur()->options()->get_event_per_page();
				if (!empty($post_per_page)) {
					$q->set('posts_per_page',$post_per_page);
				}
	        }
        }
    }
}