<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('G5P_Widget_Social_Profile')) {
    class G5P_Widget_Social_Profile extends GSF_Widget
    {
        public function __construct()
        {
            $this->widget_cssclass = 'widget-social-profile';
            $this->widget_id = 'gsf-social-profile';
            $this->widget_name = esc_html__('G5Plus: Social Profile', 'auteur-framework');

            $this->settings = array(
                'fields' => array(
                    array(
                        'id' => 'title',
                        'type' => 'text',
                        'default' => '',
                        'title' => esc_html__('Title', 'auteur-framework')
                    ),
                    array(
                        'id' => 'style',
                        'title' => esc_html__('Layout Style ', 'auteur-framework'),
                        'type' => 'image_set',
                        'options' => array(
                            'classic' => array(
                                'label' => esc_html__('Classic', 'auteur-framework'),
                                'img' => G5P()->pluginUrl('assets/images/widget/social-classic.png'),
                            ),
                            'text' => array(
                                'label' => esc_html__('Text', 'auteur-framework'),
                                'img' => G5P()->pluginUrl('assets/images/widget/social-icon-text.jpg'),
                            ),
                        ),
                        'default' => 'text',

                    ),
                    array(
                        'id' => 'size',
                        'title' => esc_html__('Size: ', 'auteur-framework'),
                        'type' => 'select',
                        'default' => 'normal',
                        'options' => array(
                            'large' => esc_html__('Large', 'auteur-framework'),
                            'normal' => esc_html__('Normal', 'auteur-framework'),
                            'small' => esc_html__('Small', 'auteur-framework'),

                        )
                    ),
                    array(
                        'id' => "social_networks",
                        'title' => esc_html__('Social Networks', 'auteur-framework'),
                        'type' => 'selectize',
                        'multiple' => true,
                        'drag' => true,
                        'placeholder' => esc_html__('Select Social Networks', 'auteur-framework'),
                        'options' => G5P()->settings()->get_social_networks(),
                    ),
                )
            );

            parent::__construct();
        }

        public function widget($args, $instance)
        {
            extract($args, EXTR_SKIP);
            $title = (!empty($instance['title'])) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);

            echo wp_kses_post($args['before_widget']);
            if ($title) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            }
            if (function_exists('G5Plus_Auteur')) {
                G5Plus_Auteur()->templates()->social_networks($instance['social_networks'], $instance['style'], $instance['size']);
            }
            echo wp_kses_post($args['after_widget']);
        }
    }
}
