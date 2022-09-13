<?php

class WA_Options
{
    public static $defaults = [
        // contact
        'wes_astr_contact' => array(
            'ADDRESS' => '',
            'PHONE_UK' => '',
            'PHONE_INTERNATIONAL' => '',
            'EMAIL' => ''
        ),
        // footer about
        'wes_astr_footer_about' => ''
    ];
    public $about = 'wes_astr_about';

    private static function getDefaults($option_name)
    {
        if(isset(Self::$defaults[$option_name])) {
            return Self::$defaults[$option_name];
        }
        return false;
    }

    public static function get($option_name, $key = false)
    {
        $default = Self::getDefaults($option_name);
        $options = get_option($option_name, $default);

        if($key) {
            return (isset($options[$key]) ? $options[$key] : '');
        }

        // no option set so return all options
        return $options;
    }

    public static function update($option_name, $option_value)
    {
        update_option($option_name, $option_value);
    }
}

?>
