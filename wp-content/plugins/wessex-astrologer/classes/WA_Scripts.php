<?php

class WA_Scripts
{
    private $plugin_name;

    public function register_scripts( $page )
    {
        // css
        wp_register_style( 'wa-admin', plugins_url( $this->plugin_name . '/admin/css/plugin.css' ) );
        wp_enqueue_style( 'wa-admin' );

        // js

        // include on pages that require media uploader
        // if( $page === 'wa-some-media-page' ) {
        //     wp_enqueue_media();
        //     wp_enqueue_script( 'wa-media', plugins_url( $this->plugin_name . '/admin/js/media.js' ), array( 'jquery' ));
        // }

        wp_register_script( 'wa-jquery-ui', plugins_url( $this->plugin_name . '/admin/js/jquery-ui.js' ), array('jquery') );
        wp_register_script( 'wa-admin', plugins_url( $this->plugin_name . '/admin/js/plugin.js' ), array('jquery', 'ja-funerals-media') );
        wp_localize_script( 'wa-admin', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

        // enqueue
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'wa-jquery-ui' );

        wp_enqueue_script( 'wa-admin' );
    }

    public function __construct($plugin_name)
    {
        $this->plugin_name = $plugin_name;
        add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
    }
}

?>
