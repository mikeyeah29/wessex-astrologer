<?php

class WA_Content
{
    public static function getContact()
    {
        return WA_Options::get('wes_astr_contact');
    }

    public static function getFooterAbout()
    {
        return stripslashes(WA_Options::get('wes_astr_footer_about'));
    }
}

?>
