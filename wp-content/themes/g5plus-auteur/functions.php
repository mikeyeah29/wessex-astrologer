<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Include the main theme class.
 */
if (!class_exists('G5Plus_Auteur')) {
    class G5Plus_Auteur
    {

        /**
         * The instance of this object
         *
         * @static
         * @access private
         * @var null | object
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
            spl_autoload_register(array($this, 'incAutoload'));

            $this->hook()->init();

            $this->custom_css()->init();

            $this->custom_js()->init();

            $this->image_resize()->init();

            $this->requirePlugin()->init();

            $this->includes();

            if (class_exists( 'WooCommerce' )) {
                $this->woocommerce()->init();
                $this->authors()->init();
            }

            $this->portfolio()->init();

            if (class_exists( 'G5Plus_Auteur_Event' )) {
                $this->event()->init();
            }
        }

        private function includes()
        {
            require_once($this->themeDir('inc/theme-functions.php'));
        }



        /**
         * Get Theme Dir
         *
         * @param string $path
         * @return string
         */
        public function themeDir($path = '') {

            return trailingslashit(get_template_directory()) . $path;
        }

        /**
         * Get Theme url
         * @param string $path
         * @return string
         */
        public function themeUrl($path = '') {
            return trailingslashit(get_template_directory_uri()) . $path;
        }


        /**
         * Register sidebar
         */
        public function registerSidebar()
        {
            return G5Plus_Auteur_Register_Sidebar::getInstance();
        }


        /**
         * Inc library auto loader
         *
         * @param $class
         */
        public function incAutoload($class)
        {
            $file_name = preg_replace('/^G5Plus_Auteur_/', '', $class);
            if ($file_name !== $class) {
                $file_name = strtolower($file_name);
                $file_name = str_replace('_', '-', $file_name);
                $this->loadFile($this->themeDir("inc/{$file_name}.class.php"));
            }
        }


        public function loadFile($path) {
            if ( $path && is_readable($path) ) {
                include_once($path);
                return true;
            }
            return false;
        }


        /**
         * Custom Css Object
         *
         * @return G5Plus_Auteur_Custom_Css
         */
        public function custom_css()
        {
            return G5Plus_Auteur_Custom_Css::getInstance();
        }

        /**
         * Custom Js Object
         *
         * @return G5Plus_Auteur_Custom_Js
         */
        public function custom_js()
        {
            return G5Plus_Auteur_Custom_Js::getInstance();
        }

        /**
         * Breadcrumbs Object
         *
         * @return G5Plus_Auteur_Breadcrumbs|null|object
         */
        public function breadcrumbs()
        {
            return G5Plus_Auteur_Breadcrumbs::getInstance();
        }

        /**
         * Helper Object
         *
         * @return G5Plus_Auteur_Helper|null|object
         */
        public function helper()
        {
            return G5Plus_Auteur_Helper::getInstance();
            //return G5Plus_Helper::init();
        }

        /**
         * Template Object
         *
         * @return G5Plus_Auteur_Templates|null|object
         */
        public function templates()
        {
            return G5Plus_Auteur_Templates::getInstance();
        }

        /**
         * Blog Object
         *
         * @return G5Plus_Auteur_Blog|null|object
         */
        public function blog()
        {
            return G5Plus_Auteur_Blog::getInstance();
        }

        /**
         * Ajax Object
         * @return G5Plus_Auteur_Ajax|null|object
         */
        public function ajax()
        {
            return G5Plus_Auteur_Ajax::getInstance();
        }

        /**
         * Image Resize
         * @return G5Plus_Image_Resize|null|object
         */
        public function image_resize()
        {
            require_once(G5Plus_Auteur()->themeDir('inc/libs/class-g5plus-image-resize.php'));
            return G5Plus_Image_Resize::getInstance();
        }

        /**
         * Query
         * @return G5Plus_Auteur_Query|null|object
         */
        public function query() {
            return G5Plus_Auteur_Query::getInstance();
        }

        /**
         * G5Plus Assets
         *
         * @return G5Plus_Auteur_Assets
         */
        public function assets() {
            return G5Plus_Auteur_Assets::getInstance();
        }

        /**
         * @return G5Plus_Auteur_Hook
         */
        public function hook() {
            return G5Plus_Auteur_Hook::getInstance();
        }

        /**
         * @return G5Plus_Auteur_Options
         */
        public function options() {
            return G5Plus_Auteur_Options::getInstance();
        }

        /**
         * @return G5Plus_Auteur_Options_Skin
         */
        public function optionsSkin() {
            return G5Plus_Auteur_Options_Skin::getInstance();
        }

        /**
         * @return G5Plus_Auteur_MetaBox
         */
        public function metaBox() {
            return G5Plus_Auteur_MetaBox::getInstance();
        }

        /**
         * @return G5Plus_Auteur_MetaBox_Post
         */
        public function metaBoxPost() {
            return G5Plus_Auteur_MetaBox_Post::getInstance();
        }

        /**
         * @return G5Plus_Auteur_Theme_Setup
         */
        public function themeSetup() {
            return G5Plus_Auteur_Theme_Setup::getInstance();
        }

        /**
         * @return G5Plus_Auteur_Require_Plugin
         */
        public function requirePlugin() {
            return G5Plus_Auteur_Require_Plugin::getInstance();
        }

        /**
         * @return G5Plus_Auteur_Font_Icon
         */
        public function fontIcons() {
            return G5Plus_Auteur_Font_Icon::getInstance();
        }

        /**
         * @return G5Plus_Auteur_Term_Meta
         */
        public function termMeta() {
            return G5Plus_Auteur_Term_Meta::getInstance();
        }

        /**
         * @return G5Plus_Auteur_Term_Meta_Product
         */
        public function termMetaProduct() {
            return G5Plus_Auteur_Term_Meta_Product::getInstance();
        }
        /**
         * @return G5Plus_Auteur_User_Meta
         */
        public function userMeta() {
            return G5Plus_Auteur_User_Meta::getInstance();
        }

        /**
         * @return G5Plus_Auteur_Woocommerce
         */
        public function woocommerce() {
            return G5Plus_Auteur_Woocommerce::getInstance();
        }


	    /**
	     * @return G5Plus_Auteur_Authors
	     */
	    public function authors() {
		    return G5Plus_Auteur_Authors::getInstance();
	    }

        /**
         * @return G5Plus_Auteur_Portfolio
         */
        public function portfolio() {
            return G5Plus_Auteur_Portfolio::getInstance();
        }

        /**
         * @return G5Plus_Auteur_Event
         */
        public function event() {
            return G5Plus_Auteur_Event::getInstance();
        }

        /**
         * @return G5Plus_Auteur_MetaBox_Product
         */
        public function metaBoxProduct() {
            return G5Plus_Auteur_MetaBox_Product::getInstance();
        }

        /**
         * @return G5Plus_Auteur_Cache
         */
        public function cache() {
            return G5Plus_Auteur_Cache::getInstance();
        }

        /**
         * @return G5Plus_Auteur_MetaBox_Portfolio
         */
        public function metaBoxPortfolio() {
            return G5Plus_Auteur_MetaBox_Portfolio::getInstance();
        }
        /**
         * @return G5Plus_Auteur_MetaBox_Event
         */
        public function metaBoxEvent() {
            return G5Plus_Auteur_MetaBox_Event::getInstance();
        }
        public function getMetaPrefix() {
            if (function_exists('G5P')) {
                return G5P()->getMetaPrefix();
            }
            return 'gsf_auteur_';
        }
    }

    function G5Plus_Auteur()
    {
        return G5Plus_Auteur::getInstance();
    }

    G5Plus_Auteur()->init();
}
