<?php
/*
    Plugin Name: Wessage Astrologer
    Plugin URI: https://www.rockettwd.co.uk
    description: A Plugin for Wessex Astrologer
    Version: 1
    Author: RWD
    Author URI: https://www.rockettwd.co.uk
    License: GPL2
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

class WessexAstrologer
{
    public $plugin_name;

    private function load_dependencies()
    {
        $files = [];

        // general helper functions
        $files[] = 'WA_Database.php';
        $files[] = 'WA_AdminMenu.php';
        $files[] = 'WA_Scripts.php';
        $files[] = 'WA_CPT.php';
        $files[] = 'WA_Options.php';
        $files[] = 'WA_Content.php';
        $files[] = 'WA_Menus.php';

        foreach ($files as $file) {
            require_once plugin_dir_path( dirname( __FILE__ ) ) . $this->plugin_name . '/classes/' . $file;
        }
    }

    public function activate_plugin()
    {
        $dbs = new WA_Database();
        $dbs->createTables();
    }

    public function __construct()
    {
        $this->plugin_name = 'wessex-astrologer';
        $this->load_dependencies();

        $menu = new WA_AdminMenu();
        $scripts = new WA_Scripts($this->plugin_name);
        $cpts = new WA_CPT();
        $menus = new WA_Menus();

        // activate plugin
        register_activation_hook( __FILE__, array($this, 'activate_plugin') );
    }
}

$wessexastrologer = new WessexAstrologer();

?>
