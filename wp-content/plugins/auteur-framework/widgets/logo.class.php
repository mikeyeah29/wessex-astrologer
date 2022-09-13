<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
if (!class_exists('G5P_Widget_Logo')) {
	class G5P_Widget_Logo extends  GSF_Widget
	{
		public function __construct() {
			$this->widget_cssclass    = 'widget-logo';
			$this->widget_id          = 'gsf-logo';
			$this->widget_name        = esc_html__( 'G5Plus: Logo', 'auteur-framework' );
			$this->widget_description = esc_html__( 'Display logo in theme options', 'auteur-framework' );

			$this->settings = array(
				'fields' => array(
					array(
						'id'      => 'title',
						'type'    => 'text',
						'default' => '',
						'title'   => esc_html__('Title:', 'auteur-framework')
					)
				)
			);

			parent::__construct();
		}

		public function widget($args, $instance) {
            extract($args, EXTR_SKIP);
            $title = (!empty($instance['title'])) ? $instance['title'] : '';
            $title = apply_filters('widget_title', $title, $instance, $this->id_base);
            echo wp_kses_post($args['before_widget']);
            if ($title) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            }

            $logo = G5P()->options()->get_logo();
            $logo_id = absint(isset($logo['id']) ? $logo['id'] : 0);
            $logo_url = isset($logo['url']) ? $logo['url'] : '';

            $logo_retina = G5P()->options()->get_logo_retina();
            $logo_retina_url = isset($logo_retina['url']) ? $logo_retina['url'] : '';

            $logo_title = esc_attr(get_bloginfo('name', 'display')) . '-' . get_bloginfo('description', 'display');
            $logo_attributes = array();
            if ($logo_retina_url && ($logo_retina_url != $logo_url)) {
                $logo_attributes[] = sprintf('data-retina="%s"',esc_url($logo_retina_url));
            }

            if (!empty($logo_id)) {
                $logo_attr = wp_get_attachment_image_src($logo_id, 'full');
                if ($logo_attr) {
                    $logo_width = isset($logo_attr[1]) ? $logo_attr[1] : '';
                    $logo_height = isset($logo_attr[2]) ? $logo_attr[2] : '';

                    if (!empty($logo_width)) {
                        $logo_attributes[] = sprintf('width="%s"',esc_attr($logo_width));
                    }

                    if (!empty($logo_height)) {
                        $logo_attributes[] = sprintf('height="%s"',esc_attr($logo_height));
                    }

                }
            }
            ?>
            <?php if (!empty($logo_url)): ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr($logo_title) ?>">
                    <img <?php echo implode(' ', $logo_attributes); ?> src="<?php echo esc_url($logo_url) ?>" alt="<?php echo esc_attr($logo_title) ?>">
                </a>
            <?php endif; ?>
            <?php

            echo wp_kses_post($args['after_widget']);
		}
	}
}