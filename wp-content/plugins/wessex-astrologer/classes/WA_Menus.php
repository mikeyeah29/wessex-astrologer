<?php

class WA_Menus
{
    public function add_menus()
    {
        register_nav_menus(
            array(
                'wessex-astrologer-footer' => 'Wessex Astrologer Footer'
            )
        );
    }

    public function __construct()
    {
        add_action( 'init', array($this, 'add_menus') );
    }
}

?>
