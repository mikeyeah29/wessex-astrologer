<?php
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

if (!class_exists('G5P_Inc_Config_User_Meta')) {
    class G5P_Inc_Config_User_Meta
    {
	    /*
	 * loader instances
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
            // Defined Theme Options
            add_filter('gsf_user_meta_config', array($this, 'register_user_meta'));
        }


        public function register_user_meta()
        {
            $prefix = G5P()->getMetaPrefix();
            /**
             * CUSTOM PAGE SETTINGS
             */
            $configs['gsf_user_meta_setting'] = array(
                'name' => esc_html__('Social Networks', 'auteur-framework'),
                'layout' => 'inline',
	            'fields' => array(
		            array(
			            'id' => "{$prefix}social_networks",
			            'title' => esc_html__('Social Networks', 'auteur-framework'),
			            'desc' => esc_html__('Define here all the social networks you will need.', 'auteur-framework'),
			            'type' => 'panel',
			            'toggle_default' => false,
			            'default' => G5P()->settings()->get_social_networks_default(),
			            'panel_title' => 'social_name',
			            'fields' => array(
				            array(
					            'id' => 'social_name',
					            'title' => esc_html__('Title', 'auteur-framework'),
					            'subtitle' => esc_html__('Enter your social network name', 'auteur-framework'),
					            'type' => 'text',
				            ),
				            array(
					            'id' => 'social_id',
					            'title' => esc_html__('Unique Social Id', 'auteur-framework'),
					            'subtitle' => esc_html__('This value is created automatically and it shouldn\'t be edited unless you know what you are doing.', 'auteur-framework'),
					            'type' => 'text',
					            'input_type' => 'unique_id',
					            'default' => 'social-'
				            ),
				            array(
					            'id' => 'social_icon',
					            'title' => esc_html__('Social Network Icon', 'auteur-framework'),
					            'subtitle' => esc_html__('Specify the social network icon', 'auteur-framework'),
					            'type' => 'icon',
				            ),
				            array(
					            'id' => 'social_link',
					            'title' => esc_html__('Social Network Link', 'auteur-framework'),
					            'subtitle' => esc_html__('Enter your social network link', 'auteur-framework'),
					            'type' => 'text',
				            )
			            )
		            )
	            )
            );




            return $configs;
        }
    }
}