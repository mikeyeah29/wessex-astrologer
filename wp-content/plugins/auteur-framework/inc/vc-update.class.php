<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (!class_exists('G5P_Inc_Vc_Update')) {
    class G5P_Inc_Vc_Update {
        private static $_instance;
        public static function getInstance() {
            if (self::$_instance == NULL) { self::$_instance = new self(); }
            return self::$_instance;
        }

        public function init() {
            add_filter( 'upgrader_pre_download', array($this, 'remove_check_vc_update'), 15, 4 );
        }

        function remove_check_vc_update($reply, $package, $updater) {
            if (!function_exists('vc_plugin_name')) {
                return $reply;
            }

            $condition1 = isset( $updater->skin->plugin ) && vc_plugin_name() === $updater->skin->plugin;

            $condition2 = isset( $updater->skin->plugin_info ) && 'WPBakery Page Builder' === $updater->skin->plugin_info['Name'];
            if ( ! $condition1 && ! $condition2 ) {
                return $reply;
            }

            return false;
        }
    }
}