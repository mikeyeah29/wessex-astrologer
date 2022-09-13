<?php
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}

if (!class_exists('G5P_Inc_Config_Options')) {
	class G5P_Inc_Config_Options
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
			add_filter('gsf_option_config', array($this, 'define_theme_options'));
		}
		
		public function define_theme_options($configs)
		{
			$configs['gsf_skins'] = array(
				'layout'      => 'inline',
				'page_title'  => esc_html__('Auteur Skin Options', 'auteur-framework'),
				'menu_title'  => esc_html__('Skins Options', 'auteur-framework'),
				'option_name' => G5P()->getOptionSkinName(),
				'permission'  => 'manage_options',
				'parent_slug' => 'gsf_welcome',
				'fields'      => array(
					// Color Skin
					$this->get_config_section_color_skin(),
				),
			);
			
			$configs['gsf_options'] = array(
				'layout'      => 'inline',
				'page_title'  => esc_html__('Auteur Theme Options', 'auteur-framework'),
				'menu_title'  => esc_html__('Theme Options', 'auteur-framework'),
				'option_name' => G5P()->getOptionName(),
				'permission'  => 'manage_options',
				'parent_slug' => 'gsf_welcome',
				'preset'      => true,
				'section'     => array(
					
					// General
					$this->get_config_section_general(),
					
					
					// Layout
					$this->get_config_section_layout(),
					
					// Top Drawer
					$this->get_config_section_top_drawer(),
					
					// Top Bar
					$this->get_config_section_top_bar(),
					
					// Header
					$this->get_config_section_header(),
					
					// Logo
					$this->get_config_section_logo(),
					
					// Page Title
					$this->get_config_section_page_title(),
					
					// Footer
					$this->get_config_section_footer(),
					
					// Typography
					$this->get_config_section_typography(),
					
					// Color
					$this->get_config_section_colors(),
					
					// Connections
					$this->get_config_section_connections(),
					
					// Blog
					$this->get_config_section_blog(),

                    // Post Types
                    $this->get_config_section_custom_post_type(),
				)
			);

			if(class_exists('WooCommerce')) {
                $configs['gsf_options']['section'][] =  $this->get_config_section_woocommerce();
            }
			if(class_exists( 'Tribe__Events__Main' )) {
                $configs['gsf_options']['section'][] =  $this->get_config_section_event();
            }
            $custom_post_type_disable = G5P()->options()->get_custom_post_type_disable();
            if(!in_array('portfolio', $custom_post_type_disable)) {
                $configs['gsf_options']['section'][] = $this->get_config_section_portfolio();
            }
            $configs['gsf_options']['section'][] = $this->get_config_section_preset();
            $configs['gsf_options']['section'][] = $this->get_config_section_code();

			return $configs;
		}
		
		/**
		 * Get Config General
		 *
		 * @return array
		 */
		public function get_config_section_general()
		{
			return array(
				'id'              => 'section_general',
				'title'           => esc_html__('General', 'auteur-framework'),
				'icon'            => 'dashicons dashicons-admin-site',
				'general_options' => true,
				'fields'          => array(
					/**
					 * General
					 */
					array(
						'id'     => 'section_general_group_general',
						'title'  => esc_html__('General', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id'       => 'lazy_load_images',
								'title'    => esc_html__('Lazy Load Images', 'auteur-framework'),
								'subtitle' => esc_html__('If enabled, images will only be loaded when they come to view', 'auteur-framework'),
								'default'  => ''
							)),
							
							array(
								'id'     => 'section_general_group_custom_scroll',
								'title'  => esc_html__('Custom Scroll', 'auteur-framework'),
								'type'   => 'group',
								'fields' => array(
									$this->get_config_toggle(array(
										'id'       => 'custom_scroll',
										'title'    => esc_html__('Custom Scroll', 'auteur-framework'),
										'subtitle' => esc_html__('Turn On this option if you want to custom scroll', 'auteur-framework'),
										'default'  => ''
									)),
									array(
										'id'         => 'custom_scroll_width',
										'type'       => 'text',
										'input_type' => 'number',
										'title'      => esc_html__('Custom Scroll Width', 'auteur-framework'),
										'subtitle'   => esc_html__('This must be numeric (no px) or empty.', 'auteur-framework'),
										'default'    => 10,
										'required'   => array('custom_scroll', '=', 'on'),
									),
									array(
										'id'       => 'custom_scroll_color',
										'type'     => 'color',
										'title'    => esc_html__('Custom Scroll Color', 'auteur-framework'),
										'default'  => '#19394B',
										'required' => array('custom_scroll', '=', 'on'),
									),
									array(
										'id'       => 'custom_scroll_thumb_color',
										'type'     => 'color',
										'title'    => esc_html__('Custom Scroll Thumb Color', 'auteur-framework'),
										'default'  => '#69d2e7',
										'required' => array('custom_scroll', '=', 'on'),
									),
								)
							),
							$this->get_config_toggle(array(
								'id'       => 'back_to_top',
								'title'    => esc_html__('Back To Top', 'auteur-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to disable back to top', 'auteur-framework'),
								'default'  => 'on'
							)),
							
							$this->get_config_toggle(array(
								'id'       => 'rtl_enable',
								'title'    => esc_html__('RTL Mode', 'auteur-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable rtl mode', 'auteur-framework'),
								'default'  => ''
							)),
							array(
                                'id'              => 'google_map_api_key',
                                'type'            => 'text',
                                'title'           => esc_html__('Google Map API Key', 'auteur-framework'),
                                'desc'            => sprintf(__('Note: you must create personal <a href="%s">Google Map API key</a> for accurate and long-term use', 'auteur-framework'),'Note: you must create personal'),
                                'default'         => 'AIzaSyB_RmOPuQi5SzCecy6SyHn8M0HJtxvs2gY'
                            ),
							array(
								'id'     => 'section_general_group_social_meta',
								'title'  => esc_html__('Social Meta', 'auteur-framework'),
								'type'   => 'group',
								'fields' => array(
									
									$this->get_config_toggle(array(
										'id'       => 'social_meta_enable',
										'title'    => esc_html__('Enable Social Meta Tags', 'auteur-framework'),
										'subtitle' => esc_html__('Turn On this option if you want to enable social meta', 'auteur-framework'),
										'default'  => ''
									)),
									array(
										'id'       => 'twitter_author_username',
										'type'     => 'text',
										'title'    => esc_html__('Twitter Username', 'auteur-framework'),
										'subtitle' => esc_html__('Enter your twitter username here, to be used for the Twitter Card date. Ensure that you do not include the @ symbol.', 'auteur-framework'),
										'default'  => '',
										'required' => array('social_meta_enable', '=', 'on'),
									),
									array(
										'id'       => 'googleplus_author',
										'type'     => 'text',
										'title'    => esc_html__('Google+ Username', 'auteur-framework'),
										'subtitle' => esc_html__('Enter your Google+ username here, to be used for the authorship meta.', 'auteur-framework'),
										'default'  => '',
										'required' => array('social_meta_enable', '=', 'on'),
									),
								)
							),

                            array(
                                'id'             => 'section_general_group_breadcrumb',
                                'title'          => esc_html__( 'Breadcrumb', 'auteur-framework' ),
                                'type'           => 'group',
                                'toggle_default' => false,
                                'fields'         => array(
                                    $this->get_config_toggle( array(
                                        'id'       => 'breadcrumb_enable',
                                        'title'    => esc_html__( 'Show Breadcrumb', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Turn On this option if you want to enable breadcrumb', 'auteur-framework' ),
                                        'default'  => 'on'
                                    ) ),
                                    $this->get_config_toggle( array(
                                        'id'       => 'breadcrumb_show_categories',
                                        'title'    => esc_html__( 'Show Post Categories in Breadcrumb', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Turn on to display the post categories in the breadcrumbs path', 'auteur-framework' ),
                                        'default'  => '',
                                        'required' => array( 'breadcrumb_enable', '=', 'on' )
                                    ) ),
                                    $this->get_config_toggle( array(
                                        'id'       => 'breadcrumb_show_post_type_archive',
                                        'title'    => esc_html__( 'Show Post Type Archives in Breadcrumb', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Turn on to display post type archives in the breadcrumbs path.', 'auteur-framework' ),
                                        'default'  => '',
                                        'required' => array( 'breadcrumb_enable', '=', 'on' )
                                    ) ),
                                )
                            ),
							
							array(
								'id'     => 'section_general_group_search_popup',
								'title'  => esc_html__('Search Popup', 'auteur-framework'),
								'type'   => 'group',
								'fields' => array(
									array(
										'id'       => 'search_popup_post_type',
										'type'     => 'checkbox_list',
										'title'    => esc_html__('Post Type For Ajax Search', 'auteur-framework'),
										'options'  => G5P()->settings()->get_search_ajax_popup_post_type(),
										'multiple' => true,
										'default'  => array('post', 'product'),
									),
									array(
										'id'         => 'search_popup_result_amount',
										'type'       => 'text',
										'input_type' => 'number',
										'title'      => esc_html__('Amount Of Search Result', 'auteur-framework'),
										'default'    => 8,
									)
								)
							),
						)
					),
					/**
					 * Maintenance
					 */
					array(
						'id'             => 'section_general_group_maintenance',
						'title'          => esc_html__('Maintenance', 'auteur-framework'),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							array(
								'id'      => 'maintenance_mode',
								'type'    => 'button_set',
								'title'   => esc_html__('Maintenance Mode', 'auteur-framework'),
								'options' => G5P()->settings()->get_maintenance_mode(),
								'default' => '0'
							),
							array(
								'id'          => 'maintenance_mode_page',
								'title'       => esc_html__('Maintenance Mode Page', 'auteur-framework'),
								'subtitle'    => esc_html__('Select the page that is your maintenance page, if you would like to show a custom page instead of the standard WordPress message. You should use the Holding Page template for this page.', 'auteur-framework'),
								'type'        => 'selectize',
								'placeholder' => esc_html__('Select Page', 'auteur-framework'),
								'data'        => 'page',
								'data_args'   => array(
									'numberposts' => -1
								),
								'edit_link'   => true,
								'default'     => '',
								'required'    => array('maintenance_mode', '=', '2'),
							
							),
						)
					),
					/**
					 * Page Transition Section
					 * *******************************************************
					 */
					array(
						'id'             => 'section_general_group_page_transition',
						'title'          => esc_html__('Page Transition', 'auteur-framework'),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							$this->get_config_toggle(array(
								'id'       => 'page_transition',
								'title'    => esc_html__('Page Transition', 'auteur-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable page transition', 'auteur-framework'),
								'default'  => ''
							)),
							array(
								'id'       => 'loading_animation',
								'type'     => 'select',
								'title'    => esc_html__('Loading Animation', 'auteur-framework'),
								'subtitle' => esc_html__('Select type of pre load animation', 'auteur-framework'),
								'options'  => G5P()->settings()->get_loading_animation(),
								'default'  => ''
							),
							array(
								'id'       => 'loading_logo',
								'type'     => 'image',
								'title'    => esc_html__('Logo Loading', 'auteur-framework'),
								'required' => array('loading_animation', '!=', ''),
							),
							
							array(
								'id'       => 'loading_animation_bg_color',
								'title'    => esc_html__('Loading Background Color', 'auteur-framework'),
								'type'     => 'color',
								'alpha'    => true,
								'default'  => '#fff',
								'required' => array('loading_animation', '!=', ''),
							),
							
							array(
								'id'       => 'spinner_color',
								'title'    => esc_html__('Spinner color', 'auteur-framework'),
								'type'     => 'color',
								'default'  => '',
								'required' => array('loading_animation', '!=', ''),
							),
						
						)
					),
					/**
					 * Custom Favicon
					 * *******************************************************
					 */
					array(
						'id'             => 'section_general_group_custom_favicon',
						'title'          => esc_html__('Custom Favicon', 'auteur-framework'),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							array(
								'id'       => 'custom_favicon',
								'type'     => 'image',
								'title'    => esc_html__('Custom favicon', 'auteur-framework'),
								'subtitle' => esc_html__('Upload a 16px x 16px Png/Gif/ico image that will represent your website favicon', 'auteur-framework'),
							),
							array(
								'id'       => 'custom_ios_title',
								'type'     => 'text',
								'title'    => esc_html__('Custom iOS Bookmark Title', 'auteur-framework'),
								'subtitle' => esc_html__('Enter a custom title for your site for when it is added as an iOS bookmark.', 'auteur-framework'),
								'default'  => ''
							),
							array(
								'id'       => 'custom_ios_icon57',
								'type'     => 'image',
								'title'    => esc_html__('Custom iOS 57x57', 'auteur-framework'),
								'subtitle' => esc_html__('Upload a 57px x 57px Png image that will be your website bookmark on non-retina iOS devices.', 'auteur-framework'),
							),
							array(
								'id'       => 'custom_ios_icon72',
								'type'     => 'image',
								'title'    => esc_html__('Custom iOS 72x72', 'auteur-framework'),
								'subtitle' => esc_html__('Upload a 72px x 72px Png image that will be your website bookmark on non-retina iOS devices.', 'auteur-framework'),
							),
							array(
								'id'       => 'custom_ios_icon114',
								'type'     => 'image',
								'title'    => esc_html__('Custom iOS 114x114', 'auteur-framework'),
								'subtitle' => esc_html__('Upload a 114px x 114px Png image that will be your website bookmark on retina iOS devices.', 'auteur-framework'),
							),
							array(
								'id'       => 'custom_ios_icon144',
								'type'     => 'image',
								'title'    => esc_html__('Custom iOS 144x144', 'auteur-framework'),
								'subtitle' => esc_html__('Upload a 144px x 144px Png image that will be your website bookmark on retina iOS devices.', 'auteur-framework'),
							),
						)
					),
					/**
					 * 404 Setting Section
					 * *******************************************************
					 */
					array(
						'id'             => 'section_general_group_404',
						'title'          => esc_html__('404 Page', 'auteur-framework'),
						'type'           => 'group',
						'toggle_default' => false,
						'fields'         => array(
							$this->get_config_content_block(array(
								'id'       => '404_content_block',
								'subtitle' => esc_html__('Specify the Content Block to use as a 404 page content.', 'auteur-framework'),
								'required' => array('404_content_block_enable', '=', '1')
							)),
							array(
								'id'       => '404_content',
								'title'    => esc_html__('404 Page Content', 'auteur-framework'),
								'default'  => '',
								'type'     => 'editor',
								'required' => array('404_content_block', '=', '')
							)
						)
					),
				)
			);
		}
		
		public function get_config_section_preset()
		{
			
			$configs = G5P()->settings()->getPresetPostType();
			$fields = array();
			foreach ($configs as $key => $config) {
				if (isset($config['preset']) && is_array($config['preset'])) {
					$group_fields = array();
					foreach ($config['preset'] as $presetKey => $presetValue) {
						$group_fields[] = $this->get_config_preset(array(
							'id'          => "preset_{$presetKey}",
							'title'       => $presetValue['title'],
							'create_link' => false,
							'link_target' => false,
						));
					}
					$group = array(
						'type'   => 'group',
						'title'  => $config['title'],
						'fields' => $group_fields
					);
					$fields[] = $group;
				} else {
					$fields[] = $this->get_config_preset(array(
						'id'          => "preset_{$key}",
						'title'       => $config['title'],
						'create_link' => false,
						'link_target' => false,
					));
				}
			}
			
			return array(
				'id'              => 'section_preset',
				'title'           => esc_html__('Preset Setting', 'auteur-framework'),
				'icon'            => 'dashicons dashicons-admin-generic',
				'general_options' => true,
				'fields'          => $fields
			);
		}
		
		/**
		 * Get Config Layout
		 *
		 * @return array
		 */
		public function get_config_section_layout()
		{
			return array(
				'id'     => 'section_layout',
				'title'  => esc_html__('Layout', 'auteur-framework'),
				'icon'   => 'dashicons dashicons-editor-table',
				'fields' => array(
					array(
						'id'      => 'main_layout',
						'title'   => esc_html__('Site Layout', 'auteur-framework'),
						'type'    => 'image_set',
						'options' => G5P()->settings()->get_main_layout(),
						'default' => 'wide',
					),
					
					
					array(
						'id'     => 'section_layout_group_main_content',
						'title'  => esc_html__('Main Content', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id'       => 'content_full_width',
								'title'    => esc_html__('Content Full Width', 'auteur-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to expand the content area to full width.', 'auteur-framework'),
								'default'  => '',
							)),
							array(
								'id'       => 'content_padding',
								'title'    => esc_html__('Content Padding', 'auteur-framework'),
								'subtitle' => esc_html__('Set content padding', 'auteur-framework'),
								'type'     => 'spacing',
								'default'  => array('left' => 0, 'right' => 0, 'top' => 50, 'bottom' => 50),
							),
							$this->get_config_sidebar_layout(array('id' => 'sidebar_layout')),
							$this->get_config_sidebar(array(
								'id'       => 'sidebar',
								'default'  => 'main',
								'required' => array('sidebar_layout', '!=', 'none')
							)),
							array(
								'id'       => 'sidebar_width',
								'title'    => esc_html__('Sidebar Width', 'auteur-framework'),
								'type'     => 'button_set',
								'options'  => G5P()->settings()->get_sidebar_width(),
								'default'  => 'small',
								'required' => array('sidebar_layout', '!=', 'none'),
							),
							$this->get_config_toggle(array(
								'id'       => 'sidebar_sticky_enable',
								'title'    => esc_html__('Sidebar Sticky', 'auteur-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable sidebar sticky', 'auteur-framework'),
								'default'  => '',
								'required' => array('sidebar_layout', '!=', 'none'),
							))
						
						)
					),
					
					array(
						'id'     => 'section_layout_group_mobile',
						'title'  => esc_html__('Mobile', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id'       => 'mobile_sidebar_enable',
								'title'    => esc_html__('Sidebar Mobile', 'auteur-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to disable sidebar on mobile', 'auteur-framework'),
								'default'  => 'on',
								'required' => array('sidebar_layout', '!=', 'none'),
							)),
							array(
								'id'       => 'mobile_content_padding',
								'title'    => esc_html__('Content Padding Mobile', 'auteur-framework'),
								'subtitle' => esc_html__('Set content top/bottom padding', 'auteur-framework'),
								'type'     => 'spacing',
                                'default'  => array('left' => 0, 'right' => 0, 'top' => 50, 'bottom' => 50),
							),
						)
					),
				)
			);
		}
		
		/**
		 * Get Config Top Drawer
		 *
		 * @return array
		 */
		public function get_config_section_top_drawer()
		{
			return array(
				'id'     => 'section_top_drawer',
				'title'  => esc_html__('Top Drawer', 'auteur-framework'),
				'icon'   => 'dashicons dashicons-archive',
				'fields' => array(
					array(
						'id'      => 'top_drawer_mode',
						'title'   => esc_html__('Top Drawer Mode', 'auteur-framework'),
						'type'    => 'button_set',
						'options' => G5P()->settings()->get_top_drawer_mode(),
						'default' => 'hide'
					),
					$this->get_config_content_block(array(
						'id'       => 'top_drawer_content_block',
						'subtitle' => esc_html__('Specify the Content Block to use as a top drawer content.', 'auteur-framework'),
						'required' => array('top_drawer_mode', '!=', 'hide')
					)),
					$this->get_config_toggle(array(
						'id'       => 'top_drawer_content_full_width',
						'title'    => esc_html__('Top Drawer Full Width', 'auteur-framework'),
						'subtitle' => esc_html__('Turn On this option if you want to expand the content area to full width.', 'auteur-framework'),
						'default'  => '',
						'required' => array('top_drawer_mode', '!=', 'hide')
					)),
					array(
						'id'       => "top_drawer_padding",
						'title'    => esc_html__('Padding', 'auteur-framework'),
						'subtitle' => esc_html__('Set top drawer padding', 'auteur-framework'),
						'type'     => 'spacing',
						'default'  => array(
							'top'    => 10,
							'bottom' => 10
						),
						'required' => array('top_drawer_mode', '!=', 'hide')
					),
					$this->get_config_border_bottom('top_drawer_border', array(
						'required' => array('top_drawer_mode', '!=', 'hide')
					)),
					$this->get_config_toggle(array(
						'id'       => 'mobile_top_drawer_enable',
						'title'    => esc_html__('Mobile Enable', 'auteur-framework'),
						'subtitle' => esc_html__('Turn On this option if you want to enable top drawer on mobile', 'auteur-framework'),
						'default'  => '',
						'required' => array('top_drawer_mode', '!=', 'hide')
					)),
				)
			);
		}
		
		/**
		 * Get Config Top Bar
		 *
		 * @return array
		 */
		public function get_config_section_top_bar()
		{
			return array(
				'id'     => 'section_top_bar',
				'title'  => esc_html__('Top Bar', 'auteur-framework'),
				'icon'   => 'dashicons dashicons-schedule',
				'fields' => array(
					array(
						'id'       => 'section_top_bar_group_desktop',
						'title'    => esc_html__('Desktop', 'auteur-framework'),
						'type'     => 'group',
						'required' => array('header_layout', 'not in', array('header-8', 'header-9','header-11', 'header-12')),
						'fields'   => array(
							$this->get_config_toggle(array(
								'id'       => 'top_bar_enable',
								'title'    => esc_html__('Top Bar Enable', 'auteur-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable top bar', 'auteur-framework'),
								'default'  => ''
							)),
							$this->get_config_content_block(array(
								'id'       => 'top_bar_content_block',
								'subtitle' => esc_html__('Specify the Content Block to use as a top bar content.', 'auteur-framework'),
								'required' => array('top_bar_enable', '=', 'on')
							)),
						)),
					
					array(
						'id'     => 'section_top_bar_group_mobile',
						'title'  => esc_html__('Mobile', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id'       => 'mobile_top_bar_enable',
								'title'    => esc_html__('Top Bar Enable', 'auteur-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable top bar', 'auteur-framework'),
								'default'  => ''
							)),
							$this->get_config_content_block(array(
								'id'       => 'mobile_top_bar_content_block',
								'subtitle' => esc_html__('Specify the Content Block to use as a top bar content.', 'auteur-framework'),
								'required' => array('mobile_top_bar_enable', '=', 'on')
							)),
						)),
				)
			);
		}
		
		/**
		 * Get Config Header
		 *
		 * @return array
		 */
		public function get_config_section_header()
		{
			return array(
				'id'     => 'section_header',
				'title'  => esc_html__('Header', 'auteur-framework'),
				'icon'   => 'dashicons dashicons-editor-kitchensink',
				'fields' => array(
					G5P()->configOptions()->get_config_toggle(array(
						'id'       => 'header_enable',
						'title'    => esc_html__('Header Enable', 'auteur-framework'),
						'default'  => 'on',
						'subtitle' => esc_html__('Turn Off this option if you want to hide header', 'auteur-framework'),
					)),
					array(
						'id'       => 'header_responsive_breakpoint',
						'type'     => 'select',
						'title'    => esc_html__('Header Responsive Breakpoint', 'auteur-framework'),
						'options'  => array(
							'1199' => esc_html__('Large Devices: < 1200px', 'auteur-framework'),
							'991'  => esc_html__('Medium Devices: < 992px', 'auteur-framework'),
							'767'  => esc_html__('Tablet Portrait: < 768px', 'auteur-framework'),
						),
						'default'  => '991',
						'required' => array('header_enable', '=', 'on')
					),
					array(
						'id'       => 'section_header_group_header_desktop',
						'title'    => esc_html__('Desktop', 'auteur-framework'),
						'type'     => 'group',
						'required' => array('header_enable', '=', 'on'),
						'fields'   => array(
							array(
								'id'      => 'header_layout',
								'title'   => esc_html__('Header Layout', 'auteur-framework'),
								'type'    => 'image_set',
								'options' => G5P()->settings()->get_header_layout(),
								'default' => 'header-1',
							),

							$this->get_config_group_header_customize('section_header_group_customize_nav', esc_html__('Customize Navigation', 'auteur-framework'), 'header_customize_nav', array('search'), array('header_layout', 'in', G5P()->settings()->get_header_customize_nav_required())),
							$this->get_config_group_header_customize('section_header_group_customize_left', esc_html__('Customize Left', 'auteur-framework'), 'header_customize_left', array(), array('header_layout', 'in', G5P()->settings()->get_header_customize_left_required())),
							$this->get_config_group_header_customize('section_header_group_customize_right', esc_html__('Customize Right', 'auteur-framework'), 'header_customize_right', array(), array('header_layout', 'in', G5P()->settings()->get_header_customize_right_required())),
							$this->get_config_toggle(array(
								'id'       => 'header_content_full_width',
								'title'    => esc_html__('Header Full Width', 'auteur-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to expand the content area to full width', 'auteur-framework'),
								'default'  => '',
								'required' => array('header_layout', 'not in', array('header-8', 'header-9', 'header-10','header-11', 'header-12'))
							)),
							$this->get_config_toggle(array(
								'id'       => 'header_float_enable',
								'title'    => esc_html__('Header Float', 'auteur-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable header float', 'auteur-framework'),
								'default'  => '',
								'required' => array('header_layout', 'not in', array('header-8', 'header-9','header-11', 'header-12'))
							)),
                            $this->get_config_toggle(array(
                                'id' => 'header_sticky',
                                'title' => esc_html__('Header Sticky', 'auteur-framework'),
                                'default' => 'scroll_up',
                                'options' => array(
                                    '' => esc_html__('Disable', 'auteur-framework'),
                                    'always_show' => esc_html__('Always Show', 'auteur-framework'),
                                    'scroll_up' => esc_html__('Show On Scroll Up', 'auteur-framework')
                                ),
                                'required' => array('header_layout','not in', array('header-8','header-9','header-11', 'header-12'))
                            ), true),
							$this->get_config_border_bottom('header_border', array(
								'required' => array('header_layout', 'not in', array('header-8', 'header-9','header-11', 'header-12'))
							)),
							$this->get_config_border_bottom('header_above_border', array(
								'title'    => esc_html__('Header Above Border Bottom', 'auteur-framework'),
								'required' => array('header_layout', 'in', array('header-4'))
							)),
							array(
								'id'       => 'header_padding',
								'type'     => 'spacing',
								'title'    => esc_html__('Header Padding', 'auteur-framework'),
								'subtitle' => esc_html__('If you would like to override the default header padding, then you can do so here.', 'auteur-framework'),
								'required' => array('header_layout', 'not in', array('header-8', 'header-9','header-11', 'header-12'))
							),
							
							array(
								'id'       => 'section_header_group_navigation',
								'title'    => esc_html__('Navigation', 'auteur-framework'),
								'type'     => 'group',
								'required' => array('header_layout', 'not in', array('header-8', 'header-9', 'header-10','header-11', 'header-12')),
								'fields'   => array(
                                    array(
                                        'id'      => 'navigation_style',
                                        'title'   => esc_html__('Navigation Style', 'auteur-framework'),
                                        'type'    => 'image_set',
                                        'options' => G5P()->settings()->get_navigation_style(),
                                        'default' => 'navigation-1',
                                        'required' => array('header_layout', 'not in', array('header-5','header-8', 'header-9','header-11', 'header-12'))
                                    ),
									array(
										'id'       => 'navigation_height',
										'type'     => 'dimension',
										'title'    => esc_html__('Navigation Height', 'auteur-framework'),
										'subtitle' => esc_html__('If you would like to override the default navigation height, then you can do so here.', 'auteur-framework'),
										'width'    => false,
                                        'required' => array('header_layout', 'in', array('header-4'))
									),
									$this->get_config_spacing('navigation_spacing', array(
										'title' => esc_html__('Navigation Spacing', 'auteur-framework')
									))
								)
							)
						)
					),
					
					array(
						'id'       => 'section_header_group_header_mobile',
						'title'    => esc_html__('Mobile', 'auteur-framework'),
						'type'     => 'group',
						'required' => array('header_enable', '=', 'on'),
						'fields'   => array(
							array(
								'id'      => 'mobile_header_layout',
								'title'   => esc_html__('Header Layout', 'auteur-framework'),
								'type'    => 'image_set',
								'options' => G5P()->settings()->get_header_mobile_layout(),
								'default' => 'header-1'
							),
							$this->get_config_toggle(array(
								'id'       => 'mobile_header_search_enable',
								'title'    => esc_html__('Search Box', 'auteur-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable search box', 'auteur-framework'),
								'default'  => '',
							)),
                            $this->get_config_toggle(array(
                                'id'       => 'mobile_header_float_enable',
                                'title'    => esc_html__('Header Float', 'auteur-framework'),
                                'subtitle' => esc_html__('Turn On this option if you want to enable header float', 'auteur-framework'),
                                'default'  => ''
                            )),
                            $this->get_config_toggle(array(
                                'id' => 'mobile_header_sticky',
                                'title' => esc_html__('Header Sticky', 'auteur-framework'),
                                'default' => '',
                                'options' => array(
                                    '' => esc_html__('Disable', 'auteur-framework'),
                                    'always_show' => esc_html__('Always Show', 'auteur-framework'),
                                    'scroll_up' => esc_html__('Show On Scroll Up', 'auteur-framework')
                                ),
                            ),true),
                            $this->get_config_border_bottom('mobile_header_border'),
							$this->get_config_group_mobile_header_customize('section_mobile_header_group_customize', esc_html__('Customize', 'auteur-framework'), 'header_customize_mobile', array('search')),
							array(
								'id'       => 'mobile_header_padding',
								'type'     => 'spacing',
								'title'    => esc_html__('Header Padding', 'auteur-framework'),
								'left'     => false,
								'right'    => false,
								'subtitle' => esc_html__('If you would like to override the default header padding, then you can do so here.', 'auteur-framework'),
							),
						)
					)
				
				)
			);
		}
		
		/**
		 * Get Config Logo
		 *
		 * @return array
		 */
		public function get_config_section_logo()
		{
			return array(
				'id'     => 'section_logo',
				'title'  => esc_html__('Logo', 'auteur-framework'),
				'icon'   => 'dashicons dashicons-image-filter',
				'fields' => array(
					array(
						'id'     => 'section_logo_group_desktop',
						'title'  => esc_html__('Desktop', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							array(
								'id'       => 'logo',
								'title'    => esc_html__('Logo', 'auteur-framework'),
								'subtitle' => esc_html__('By default, a text-based logo is created using your site title. But you can also upload an image-based logo here.', 'auteur-framework'),
								'type'     => 'image',
							),
							array(
								'id'       => 'logo_retina',
								'title'    => esc_html__('Logo Retina (2x)', 'auteur-framework'),
								'subtitle' => esc_html__('If you want to upload a Retina Image, It\'s Image Size should be exactly double in compare with your normal Logo.', 'auteur-framework'),
								'type'     => 'image',
								'default'  => ''
							),
							array(
								'id'       => 'sticky_logo',
								'title'    => esc_html__('Sticky Logo', 'auteur-framework'),
								'type'     => 'image',
								'required' => array('header_sticky', '!=', '')
							),
							array(
								'id'       => 'sticky_logo_retina',
								'title'    => esc_html__('Sticky Logo Retina', 'auteur-framework'),
								'subtitle' => esc_html__('If you want to upload a Retina Image, It\'s Image Size should be exactly double in compare with your normal Logo.', 'auteur-framework'),
								'type'     => 'image',
								'default'  => '',
                                'required' => array('header_sticky', '!=', '')
							),
							array(
								'id'       => 'logo_max_height',
								'title'    => esc_html__('Logo Max Height', 'auteur-framework'),
								'subtitle' => esc_html__('If you would like to override the default logo max height, then you can do so here.', 'auteur-framework'),
								'type'     => 'dimension',
								'width'    => false
							),
							array(
								'id'       => 'logo_padding',
								'title'    => esc_html__('Logo Padding', 'auteur-framework'),
								'subtitle' => esc_html__('If you would like to override the default logo top/bottom padding, then you can do so here.', 'auteur-framework'),
								'type'     => 'spacing',
								'left'     => false,
								'right'    => false,
							)
						)
					),
					array(
						'id'     => 'section_logo_group_mobile',
						'title'  => esc_html__('Mobile', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							array(
								'id'       => 'mobile_logo',
								'title'    => esc_html__('Logo', 'auteur-framework'),
								'subtitle' => esc_html__('By default, a text-based logo is created using your site title. But you can also upload an image-based logo here.', 'auteur-framework'),
								'type'     => 'image',
							),
							array(
								'id'       => 'mobile_logo_retina',
								'title'    => esc_html__('Logo Retina (2x)', 'auteur-framework'),
								'subtitle' => esc_html__('If you want to upload a Retina Image, It\'s Image Size should be exactly double in compare with your normal Logo.', 'auteur-framework'),
								'type'     => 'image',
								'default'  => ''
							),
                            array(
                                'id'       => 'mobile_sticky_logo',
                                'title'    => esc_html__('Sticky Logo', 'auteur-framework'),
                                'type'     => 'image',
                                'required' => array('mobile_header_sticky', '!=', '')
                            ),
                            array(
                                'id'       => 'mobile_sticky_logo_retina',
                                'title'    => esc_html__('Sticky Logo Retina', 'auteur-framework'),
                                'subtitle' => esc_html__('If you want to upload a Retina Image, It\'s Image Size should be exactly double in compare with your normal Logo.', 'auteur-framework'),
                                'type'     => 'image',
                                'default'  => '',
                                'required' => array('mobile_header_sticky', '!=', '')
                            ),
							array(
								'id'       => 'mobile_logo_max_height',
								'title'    => esc_html__('Logo Max Height', 'auteur-framework'),
								'subtitle' => esc_html__('If you would like to override the default logo max height, then you can do so here.', 'auteur-framework'),
								'type'     => 'dimension',
								'width'    => false
							),
							array(
								'id'       => 'mobile_logo_padding',
								'title'    => esc_html__('Logo Padding', 'auteur-framework'),
								'subtitle' => esc_html__('If you would like to override the default logo top/bottom padding, then you can do so here.', 'auteur-framework'),
								'type'     => 'spacing',
								'left'     => false,
								'right'    => false,
							)
						)
					),
				)
			);
		}
		
		/**
		 * Get Config Page Title
		 *
		 * @return array
		 */
		public function get_config_section_page_title()
		{
			return array(
				'id'     => 'section_page_title',
				'title'  => esc_html__('Page Title', 'auteur-framework'),
				'icon'   => 'dashicons dashicons-media-spreadsheet',
				'fields' => array(
					$this->get_config_toggle(array(
						'id'       => 'page_title_enable',
						'title'    => esc_html__('Page Title Enable', 'auteur-framework'),
						'subtitle' => esc_html__('Turn Of this option if you want to disable page title', 'auteur-framework'),
						'default'  => 'on',
					)),
					$this->get_config_content_block(array(
						'id'       => 'page_title_content_block',
						'subtitle' => esc_html__('Specify the Content Block to use as a page title content.', 'auteur-framework'),
						'required' => array('page_title_enable', '=', 'on')
					))
				)
			);
		}
		
		/**
		 * Get Config Footer
		 *
		 * @return array
		 */
		public function get_config_section_footer()
		{
			return array(
				'id'     => 'section_footer',
				'title'  => esc_html__('Footer', 'auteur-framework'),
				'icon'   => 'dashicons dashicons-feedback',
				'fields' => array(
					$this->get_config_toggle(array(
						'id'       => 'footer_enable',
						'title'    => esc_html__('Footer Enable', 'auteur-framework'),
						'subtitle' => esc_html__('Turn Off this option if you want to disable footer', 'auteur-framework'),
						'default'  => 'on'
					)),
					$this->get_config_content_block(array(
						'id'       => 'footer_content_block',
						'subtitle' => esc_html__('Specify the Content Block to use as a footer content.', 'auteur-framework'),
						'required' => array('footer_enable', '=', 'on')
					)),
					$this->get_config_toggle(array(
						'id'       => 'footer_fixed_enable',
						'title'    => esc_html__('Footer Fixed', 'auteur-framework'),
						'default'  => '',
						'required' => array('footer_enable', '=', 'on'),
					)),
				)
			);
		}
		
		/**
		 * Get Config Typography
		 *
		 * @return array
		 */
        public function get_config_section_typography()
        {
            return array(
                'id' => 'section_typography',
                'title' => esc_html__('Typography', 'auteur-framework'),
                'icon' => 'dashicons dashicons-editor-textcolor',
                'general_options' => true,
                'fields' => array(
                    array(
                        'id' => 'section_typography_group_general',
                        'title' => esc_html__('General', 'auteur-framework'),
                        'type' => 'group',
                        'fields' => array(
                            array(
                                'id' => 'body_font',
                                'title' => esc_html__('Body Font', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the body font.', 'auteur-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Nunito Sans",
                                    'font_size' => '16px',
                                    'font_weight' => 'regular'
                                )
                            ),
                            array(
                                'id' => 'primary_font',
                                'title' => esc_html__('Primary Font', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the primary font family.', 'auteur-framework'),
                                'type' => 'typography',
                                'default' => array(
                                    'font_family' => "Libre Baskerville",
                                )
                            )
                        )
                    ),
                    array(
                        'id' => 'section_typography_group_heading',
                        'title' => esc_html__('Heading Fonts', 'auteur-framework'),
                        'type' => 'group',
                        'fields' => array(
                            array(
                                'id' => 'h1_font',
                                'title' => esc_html__('H1 Font', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the h1 font.', 'auteur-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Libre Baskerville",
                                    'font_size' => '56px',
                                    'font_weight' => '400'
                                )
                            ),
                            array(
                                'id' => 'h2_font',
                                'title' => esc_html__('H2 Font', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the h2 font.', 'auteur-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Libre Baskerville",
                                    'font_size' => '40px',
                                    'font_weight' => '400'
                                )
                            ),
                            array(
                                'id' => 'h3_font',
                                'title' => esc_html__('H3 Font', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the h3 font.', 'auteur-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Libre Baskerville",
                                    'font_size' => '34px',
                                    'font_weight' => '400'
                                )
                            ),
                            array(
                                'id' => 'h4_font',
                                'title' => esc_html__('H4 Font', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the h4 font.', 'auteur-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Libre Baskerville",
                                    'font_size' => '24px',
                                    'font_weight' => '400'
                                )
                            ),
                            array(
                                'id' => 'h5_font',
                                'title' => esc_html__('H5 Font', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the h5 font.', 'auteur-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Libre Baskerville",
                                    'font_size' => '18px',
                                    'font_weight' => '400'
                                )
                            ),
                            array(
                                'id' => 'h6_font',
                                'title' => esc_html__('H6 Font', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the h6 font.', 'auteur-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Libre Baskerville",
                                    'font_size' => '14px',
                                    'font_weight' => '400'
                                )
                            )
                        )
                    ),
                    array(
                        'id' => 'section_typography_group_menu',
                        'title' => esc_html__('Menu', 'auteur-framework'),
                        'type' => 'group',
                        'fields' => array(
                            array(
                                'id' => 'menu_font',
                                'title' => esc_html__('Menu Font', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the menu font.', 'auteur-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Nunito Sans",
                                    'font_size' => '14px',
                                    'font_weight' => '800'
                                )
                            ),
                            array(
                                'id' => 'sub_menu_font',
                                'title' => esc_html__('Sub Menu Font', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the sub menu font.', 'auteur-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Nunito Sans",
                                    'font_size' => '14px',
                                    'font_weight' => '700'
                                )
                            ),
                            array(
                                'id' => 'mobile_menu_font',
                                'title' => esc_html__('Mobile Font', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the Mobile menu font.', 'auteur-framework'),
                                'type' => 'typography',
                                'font_size' => true,
                                'font_variants' => true,
                                'default' => array(
                                    'font_family' => "Nunito Sans",
                                    'font_size' => '13px',
                                    'font_weight' => '700'
                                )
                            )
                        )
                    ),
                )
            );
        }
		
		/**
		 * Get Config Color Skin
		 *
		 * @return array
		 */
        public function get_config_section_color_skin()
        {
            return array(
                'id' => 'color_skin',
                'title' => esc_html__('Skin', 'auteur-framework'),
                'desc' => esc_html__('Define here all the color skin you will need.', 'auteur-framework'),
                'type' => 'panel',
                'sort' => true,
                'toggle_default' => false,
                'default' => G5P()->settings()->get_color_skin_default(),
                'panel_title' => 'skin_name',
                'fields' => array(
                    array(
                        'id' => 'skin_name',
                        'title' => esc_html__('Title', 'auteur-framework'),
                        'subtitle' => esc_html__('Enter your color skin name', 'auteur-framework'),
                        'type' => 'text',
                    ),
                    array(
                        'id' => 'skin_id',
                        'title' => esc_html__('Unique Skin Id', 'auteur-framework'),
                        'subtitle' => esc_html__('This value is created automatically and it shouldn\'t be edited unless you know what you are doing.', 'auteur-framework'),
                        'type' => 'text',
                        'input_type' => 'unique_id',
                        'default' => 'skin-'
                    ),
                    array(
                        'id' => 'section_color_skin_row_color_1',
                        'type' => 'row',
                        'col' => 4,
                        'fields' => array(
                            array(
                                'id' => 'background_color',
                                'title' => esc_html__('Background Color', 'auteur-framework'),
                                'desc' => esc_html__('Specify the background color', 'auteur-framework'),
                                'type' => 'color',
                                'alpha' => true,
                                'default' => '#fff',
                                'layout' => 'full',
                            ),
                            array(
                                'id' => 'text_color',
                                'title' => esc_html__('Text Color', 'auteur-framework'),
                                'desc' => esc_html__('Specify the text color', 'auteur-framework'),
                                'type' => 'color',
                                'alpha' => true,
                                'default' => '#696969',
                                'layout' => 'full',
                            ),
                            array(
                                'id' => 'text_hover_color',
                                'title' => esc_html__('Text hover Color', 'auteur-framework'),
                                'desc' => esc_html__('Customize text hover color, set empty to use accent color', 'auteur-framework'),
                                'type' => 'color',
                                'alpha' => true,
                                'default' => '',
                                'layout' => 'full',
                            )
                        )
                    ),
                    array(
                        'id' => 'section_color_skin_row_color_2',
                        'type' => 'row',
                        'col' => 4,
                        'fields' => array(
                            array(
                                'id' => 'heading_color',
                                'title' => esc_html__('Heading Color', 'auteur-framework'),
                                'desc' => esc_html__('Specify the heading color', 'auteur-framework'),
                                'type' => 'color',
                                'alpha' => true,
                                'default' => '#333',
                                'layout' => 'full',
                            ),

                            array(
                                'id' => 'disable_color',
                                'title' => esc_html__('Disable Color', 'auteur-framework'),
                                'desc' => esc_html__('Specify the disable color', 'auteur-framework'),
                                'type' => 'color',
                                'alpha' => true,
                                'default' => '#ababab',
                                'layout' => 'full',
                            ),
                            array(
                                'id' => 'border_color',
                                'title' => esc_html__('Border Color', 'auteur-framework'),
                                'desc' => esc_html__('Specify the border color', 'auteur-framework'),
                                'type' => 'color',
                                'alpha' => true,
                                'default' => '#ededed',
                                'layout' => 'full',
                            ),
                        )
                    ),
                ),
            );
        }
		
		/**
		 * Get Config Color
		 *
		 * @return array
		 */
        public function get_config_section_colors()
        {
            return array(
                'id' => 'section_colors',
                'title' => esc_html__('Colors', 'auteur-framework'),
                'icon' => 'dashicons dashicons-admin-customizer',
                'fields' => array(
                    array(
                        'id' => 'section_color_group_general',
                        'title' => esc_html__('General', 'auteur-framework'),
                        'type' => 'group',
                        'fields' => array(
                            array(
                                'id' => 'body_background',
                                'title' => esc_html__('Body Background', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the body background color and media.', 'auteur-framework'),
                                'type' => 'background',
                            ),

                            array(
                                'id' => 'accent_color',
                                'title' => esc_html__('Accent Color', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the accent color', 'auteur-framework'),
                                'type' => 'color',
                                'default' => '#e4573d',
                            ),

                            array(
                                'id' => 'foreground_accent_color',
                                'title' => esc_html__('Foreground Accent Color', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the foreground accent color', 'auteur-framework'),
                                'type' => 'color',
                                'default' => '#fff',
                            ),

                            array(
                                'id' => 'primary_color',
                                'title' => esc_html__('Primary Color', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the Primary color', 'auteur-framework'),
                                'type' => 'color',
                                'default' => '#c5a374',
                            ),
                            array(
                                'id' => 'content_skin',
                                'title' => esc_html__('Content Skin', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the content color skin', 'auteur-framework'),
                                'type' => 'select',
                                'options' => G5P()->settings()->get_color_skin(),
                                'default' => 'skin-light'
                            ),
                            array(
                                'id' => 'content_background_color',
                                'title' => esc_html__('Content Background Color', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify a custom content background color.', 'auteur-framework'),
                                'type' => 'color',
                                'alpha' => true,
                                'default' => ''
                            )
                        )
                    ),
                    array(
                        'id' => 'section_color_group_top_drawer',
                        'title' => esc_html__('Top Drawer', 'auteur-framework'),
                        'type' => 'group',
                        'toggle_default' => false,
                        'required' => array('top_drawer_mode', '!=', 'hide'),
                        'fields' => array(
                            array(
                                'id' => 'top_drawer_skin',
                                'title' => esc_html__('Top Drawer Skin', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the top drawer color skin', 'auteur-framework'),
                                'type' => 'selectize',
                                'placeholder' => esc_html__('Select Color Skin', 'auteur-framework'),
                                'options' => G5P()->settings()->get_color_skin(true),
                                'default' => 'skin-dark'
                            ),
                            array(
                                'id' => 'top_drawer_background_color',
                                'title' => esc_html__('Top Drawer Background Color', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify a custom top drawer background color.', 'auteur-framework'),
                                'type' => 'color',
                                'alpha' => true,
                                'default' => ''
                            )
                        )
                    ),
                    array(
                        'id' => 'section_color_group_header',
                        'title' => esc_html__('Header', 'auteur-framework'),
                        'type' => 'group',
                        'toggle_default' => false,
                        'required' => array('header_enable', '=', 'on'),
                        'fields' => array(
                            array(
                                'id'      => 'header_skin',
                                'title'   => esc_html__( 'Preset Skin', 'auteur-framework' ),
                                'type'    => 'button_set',
                                'options' => array(
                                    'light' => esc_html__( 'Light', 'auteur-framework' ),
                                    'dark'  => esc_html__( 'Dark', 'auteur-framework' )
                                ),
                                'default' => 'light',
                                'preset'  => array(
                                    array(
                                        'op'     => '=',
                                        'value'  => 'light',
                                        'fields' => array(
                                            array( 'header_background', array('background_color' => '#fff')),
                                            array( 'logo_text_color', '#222' ),
                                            array( 'header_text_color', '#696969' ),
                                            array( 'header_text_hover_color', '#333' ),
                                            array( 'menu_customize_text_color', '#333'),
                                            array( 'header_border_color', '#ededed')
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'dark',
                                        'fields' => array(
                                            array( 'header_background', array('background_color' => '#222')),
                                            array( 'logo_text_color', '#fff' ),
                                            array( 'header_text_color', 'rgba(255,255,255,0.7)' ),
                                            array( 'header_text_hover_color', '#fff' ),
                                            array( 'menu_customize_text_color', '#fff'),
                                            array( 'header_border_color', 'rgba(255,255,255,0.3)')
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id' => 'header_background',
                                'title' => esc_html__('Header Background', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify a custom header background', 'auteur-framework'),
                                'type' => 'background',
                                'default' => ''
                            ),
                            array(
                                'id'       => 'logo_text_color',
                                'title'    => esc_html__( 'Logo Text Color', 'auteur-framework' ),
                                'subtitle' => esc_html__( 'Specify the logo text color', 'auteur-framework' ),
                                'type'     => 'color',
                                'required' => array(
                                    array('logo[url]', '=', '' )
                                ),
                                'alpha'    => true,
                                'default'  => '#333',
                            ),
                            array(
                                'id'       => 'header_border_color',
                                'title'    => esc_html__( 'Border Color', 'auteur-framework' ),
                                'subtitle' => esc_html__( 'Specify the border color', 'auteur-framework' ),
                                'type'     => 'color',
                                'alpha'    => true,
                                'default'  => '#ededed',
                            ),
                            array(
                                'id'       => 'header_text_color',
                                'title'    => esc_html__( 'Text Color', 'auteur-framework' ),
                                'subtitle' => esc_html__( 'Specify the header text color', 'auteur-framework' ),
                                'type'     => 'color',
                                'required' => array('header_layout', 'in', array('header-1', 'header-2', 'header-3', 'header-5', 'header-6', 'header-11', 'header-12')),
                                'alpha'    => true,
                                'default'  => '#696969',
                            ),
                            array(
                                'id'       => 'header_text_hover_color',
                                'title'    => esc_html__( 'Text Hover Color', 'auteur-framework' ),
                                'subtitle' => esc_html__( 'Specify the header text hover color', 'auteur-framework' ),
                                'type'     => 'color',
                                'required' => array('header_layout', 'in', array('header-1', 'header-2', 'header-3', 'header-5', 'header-6', 'header-11', 'header-12')),
                                'alpha'    => true,
                                'default'  => '#333',
                            ),
                            array(
                                'id'             => 'section_color_group_menu',
                                'title'          => esc_html__( 'Menu', 'auteur-framework' ),
                                'type'           => 'group',
                                'required' => array('header_layout', 'in', array('header-4', 'header-7', 'header-8', 'header-9')),
                                'toggle_default' => false,
                                'fields'         => array(
                                    array(
                                        'id'      => 'menu_skin',
                                        'title'   => esc_html__( 'Preset Skin', 'auteur-framework' ),
                                        'type'    => 'button_set',
                                        'options' => array(
                                            'light' => esc_html__( 'Light', 'auteur-framework' ),
                                            'dark'  => esc_html__( 'Dark', 'auteur-framework' )
                                        ),
                                        'default' => 'light',
                                        'preset'  => array(
                                            array(
                                                'op'     => '=',
                                                'value'  => 'light',
                                                'fields' => array(
                                                    array( 'menu_background_color', '#fff' ),
                                                    array( 'menu_text_color', '#696969' ),
                                                    array( 'menu_text_hover_color', '#333' )
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'dark',
                                                'fields' => array(
                                                    array( 'menu_background_color', '#222' ),
                                                    array( 'menu_text_color', 'rgba(255,255,255,0.7)' ),
                                                    array( 'menu_text_hover_color', '#fff' )
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'       => 'menu_background_color',
                                        'title'    => esc_html__( 'Background Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu background color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#fff'
                                    ),
                                    array(
                                        'id'       => 'menu_text_color',
                                        'title'    => esc_html__( 'Text Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu text color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#696969',
                                    ),
                                    array(
                                        'id'       => 'menu_text_hover_color',
                                        'title'    => esc_html__( 'Text Hover Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu text hover color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#333',
                                    )
                                )
                            ),

                            array(
                                'id'             => 'section_color_group_sub_menu',
                                'title'          => esc_html__( 'SubMenu', 'auteur-framework' ),
                                'type'           => 'group',
                                'toggle_default' => false,
                                'required'       => array('header_layout', 'not in', array('header-7', 'header-8', 'header-9', 'header-10', 'header-11', 'header-12')),
                                'fields'         => array(
                                    array(
                                        'id'              => 'menu_transition',
                                        'type'            => 'select',
                                        'title'           => esc_html__('Menu Transition', 'auteur-framework'),
                                        'default'         => 'x-fadeInUp',
                                        'general_options' => true,
                                        'options'         => array(
                                            'none'          => esc_html__('None', 'auteur-framework'),
                                            'x-fadeIn'      => esc_html__('Fade In', 'auteur-framework'),
                                            'x-fadeInUp'    => esc_html__('Fade In Up', 'auteur-framework'),
                                            'x-fadeInDown'  => esc_html__('Fade In Down', 'auteur-framework'),
                                            'x-fadeInLeft'  => esc_html__('Fade In Left', 'auteur-framework'),
                                            'x-fadeInRight' => esc_html__('Fade In Right', 'auteur-framework'),
                                            'x-flipInX'     => esc_html__('Flip In X', 'auteur-framework'),
                                            'x-slideInUp'   => esc_html__('Slide In Up', 'auteur-framework')
                                        )
                                    ),
                                    array(
                                        'id'      => 'submenu_skin',
                                        'title'   => esc_html__( 'Preset Skin', 'auteur-framework' ),
                                        'type'    => 'button_set',
                                        'options' => array(
                                            'light' => esc_html__( 'Light', 'auteur-framework' ),
                                            'dark'  => esc_html__( 'Dark', 'auteur-framework' )
                                        ),
                                        'default' => 'light',
                                        'preset'  => array(
                                            array(
                                                'op'     => '=',
                                                'value'  => 'light',
                                                'fields' => array(
                                                    array( 'submenu_background_color', '#fff' ),
                                                    array( 'submenu_text_color', '#696969' ),
                                                    array( 'submenu_text_hover_color', '' ),
                                                    array( 'submenu_heading_color', '#333' ),
                                                    array( 'submenu_border_color', '#ededed' )
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'dark',
                                                'fields' => array(
                                                    array( 'submenu_background_color', '#222' ),
                                                    array( 'submenu_text_color', 'rgba(255,255,255,0.7)' ),
                                                    array( 'submenu_text_hover_color', '' ),
                                                    array( 'submenu_heading_color', '#fff' ),
                                                    array( 'submenu_border_color', 'rgba(255,255,255,0.1)' )
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'       => 'submenu_background_color',
                                        'title'    => esc_html__( 'Background Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the submenu background color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#fff'
                                    ),
                                    array(
                                        'id'       => 'submenu_text_color',
                                        'title'    => esc_html__( 'Text Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the submenu text color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#696969'
                                    ),
                                    array(
                                        'id'       => 'submenu_text_hover_color',
                                        'title'    => esc_html__( 'Text Hover Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the submenu text hover color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => ''
                                    ),
                                    array(
                                        'id'       => 'submenu_heading_color',
                                        'title'    => esc_html__( 'Heading Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the submenu heading color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#333'
                                    ),
                                    array(
                                        'id'       => 'submenu_border_color',
                                        'title'    => esc_html__( 'Border Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the submenu border color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#ededed'
                                    )
                                )
                            ),
                            array(
                                'id'             => 'section_color_group_menu_customize',
                                'title'          => esc_html__( 'Menu Customize', 'auteur-framework' ),
                                'type'           => 'group',
                                'toggle_default' => false,
                                'required'       => array('header_layout', 'not in', array( 'header-10' )),
                                'fields'         => array(
                                    array(
                                        'id'       => 'menu_customize_text_color',
                                        'title'    => esc_html__( 'Text Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu customize text color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#333',
                                    ),
                                    array(
                                        'id'       => 'menu_customize_text_hover_color',
                                        'title'    => esc_html__( 'Text Hover Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu customize text hover color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '',
                                    )
                                )
                            ),
                            array(
                                'id' => 'section_color_canvas_sidebar',
                                'title' => esc_html__('Canvas Sidebar', 'auteur-framework'),
                                'type' => 'group',
                                'required' => array( array(
                                    array('header_customize_nav', 'contain', 'canvas-sidebar'),
                                    array('header_customize_left', 'contain', 'canvas-sidebar'),
                                    array('header_customize_right', 'contain', 'canvas-sidebar'),
                                )),
                                'fields' => array(
                                    array(
                                        'id' => 'canvas_sidebar_skin',
                                        'title' => esc_html__('Canvas Sidebar Skin', 'auteur-framework'),
                                        'subtitle' => esc_html__('Specify the canvas sidebar color skin', 'auteur-framework'),
                                        'type' => 'select',
                                        'options' => G5P()->settings()->get_color_skin(),
                                        'default' => 'skin-dark'
                                    ),
                                    array(
                                        'id' => 'canvas_sidebar_background_color',
                                        'title' => esc_html__('Canvas Sidebar Background Color', 'auteur-framework'),
                                        'subtitle' => esc_html__('Specify a custom canvas sidebar background color', 'auteur-framework'),
                                        'type' => 'color',
                                        'alpha' => true,
                                        'default' => ''
                                    )
                                )
                            ),
                        )
                    ),
                    array(
                        'id' => 'section_color_group_header_sticky',
                        'title' => esc_html__('Header Sticky', 'auteur-framework'),
                        'type' => 'group',
                        'toggle_default' => false,
                        'required' => array(
                            array('header_enable', '=', 'on'),
                            array('header_sticky', '!=', ''),
                            array('header_layout','not in',array('header-8', 'header-9','header-11', 'header-12'))
                        ),
                        'fields' => array(
                            array(
                                'id'      => 'header_sticky_skin',
                                'title'   => esc_html__( 'Preset Skin', 'auteur-framework' ),
                                'type'    => 'button_set',
                                'options' => array(
                                    'light' => esc_html__( 'Light', 'auteur-framework' ),
                                    'dark'  => esc_html__( 'Dark', 'auteur-framework' )
                                ),
                                'default' => 'light',
                                'preset'  => array(
                                    array(
                                        'op'     => '=',
                                        'value'  => 'light',
                                        'fields' => array(
                                            array( 'header_sticky_background', array('background_color' => '#fff')),
                                            array( 'logo_sticky_text_color', '#222' ),
                                            array( 'header_sticky_text_color', '#696969' ),
                                            array( 'header_sticky_text_hover_color', '#333' ),
                                            array( 'menu_customize_sticky_text_color', '#333')
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'dark',
                                        'fields' => array(
                                            array( 'header_sticky_background', array('background_color' => '#222')),
                                            array( 'logo_sticky_text_color', '#fff' ),
                                            array( 'header_sticky_text_color', 'rgba(255,255,255,0.7)' ),
                                            array( 'header_sticky_text_hover_color', '#fff' ),
                                            array( 'menu_customize_sticky_text_color', '#fff')
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id' => 'header_sticky_background',
                                'title' => esc_html__('Header Sticky Background', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify a custom header sticky background', 'auteur-framework'),
                                'type' => 'background',
                                'default' => ''
                            ),
                            array(
                                'id'       => 'logo_sticky_text_color',
                                'title'    => esc_html__( 'Logo Text Color', 'auteur-framework' ),
                                'subtitle' => esc_html__( 'Specify the logo text color', 'auteur-framework' ),
                                'type'     => 'color',
                                'required' => array(
                                    array('logo[url]', '=', '' )
                                ),
                                'alpha'    => true,
                                'default'  => '#333',
                            ),
                            array(
                                'id'       => 'header_sticky_text_color',
                                'title'    => esc_html__( 'Text Color', 'auteur-framework' ),
                                'subtitle' => esc_html__( 'Specify the header text color', 'auteur-framework' ),
                                'type'     => 'color',
                                'required' => array('header_layout', 'in', array('header-1', 'header-2', 'header-3', 'header-5', 'header-6')),
                                'alpha'    => true,
                                'default'  => '#696969',
                            ),
                            array(
                                'id'       => 'header_sticky_text_hover_color',
                                'title'    => esc_html__( 'Text Hover Color', 'auteur-framework' ),
                                'subtitle' => esc_html__( 'Specify the header text hover color', 'auteur-framework' ),
                                'type'     => 'color',
                                'required' => array('header_layout', 'in', array('header-1', 'header-2', 'header-3', 'header-5', 'header-6')),
                                'alpha'    => true,
                                'default'  => '#333',
                            ),
                            array(
                                'id'             => 'section_color_group_sticky_menu',
                                'title'          => esc_html__( 'Menu', 'auteur-framework' ),
                                'type'           => 'group',
                                'toggle_default' => false,
                                'required' => array('header_layout', 'in', array('header-4')),
                                'fields'         => array(
                                    array(
                                        'id'      => 'menu_sticky_skin',
                                        'title'   => esc_html__( 'Preset Skin', 'auteur-framework' ),
                                        'type'    => 'button_set',
                                        'options' => array(
                                            'light' => esc_html__( 'Light', 'auteur-framework' ),
                                            'dark'  => esc_html__( 'Dark', 'auteur-framework' )
                                        ),
                                        'default' => 'light',
                                        'preset'  => array(
                                            array(
                                                'op'     => '=',
                                                'value'  => 'light',
                                                'fields' => array(
                                                    array( 'menu_sticky_background_color', '#fff' ),
                                                    array( 'menu_sticky_text_color', '#696969' ),
                                                    array( 'menu_sticky_text_hover_color', '#333' )
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'dark',
                                                'fields' => array(
                                                    array( 'menu_sticky_background_color', '#222' ),
                                                    array( 'menu_sticky_text_color', 'rgba(255,255,255,0.7)' ),
                                                    array( 'menu_sticky_text_hover_color', '#fff' )
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'       => 'menu_sticky_background_color',
                                        'title'    => esc_html__( 'Background Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu background color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#fff'
                                    ),
                                    array(
                                        'id'       => 'menu_sticky_text_color',
                                        'title'    => esc_html__( 'Text Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu text color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#696969',
                                    ),
                                    array(
                                        'id'       => 'menu_sticky_text_hover_color',
                                        'title'    => esc_html__( 'Text Hover Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu text hover color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#333',
                                    )
                                )
                            ),
                            array(
                                'id'             => 'section_color_group_menu_sticky_customize',
                                'title'          => esc_html__( 'Menu Customize', 'auteur-framework' ),
                                'type'           => 'group',
                                'toggle_default' => false,
                                'required' => array('header_layout', 'not in', array('header-10')),
                                'fields'         => array(
                                    array(
                                        'id'       => 'menu_customize_sticky_text_color',
                                        'title'    => esc_html__( 'Text Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu customize text color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#333',
                                    ),
                                    array(
                                        'id'       => 'menu_customize_sticky_text_hover_color',
                                        'title'    => esc_html__( 'Text Hover Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu customize text hover color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '',
                                    )
                                )
                            )
                        )
                    ),
                    array(
                        'id' => 'section_color_group_mobile_header',
                        'title' => esc_html__('Header Mobile', 'auteur-framework'),
                        'type' => 'group',
                        'toggle_default' => false,
                        'required' => array('header_enable', '=', 'on'),
                        'fields' => array(
                            array(
                                'id'      => 'mobile_header_skin',
                                'title'   => esc_html__( 'Preset Skin', 'auteur-framework' ),
                                'type'    => 'button_set',
                                'options' => array(
                                    'light' => esc_html__( 'Light', 'auteur-framework' ),
                                    'dark'  => esc_html__( 'Dark', 'auteur-framework' )
                                ),
                                'default' => 'light',
                                'preset'  => array(
                                    array(
                                        'op'     => '=',
                                        'value'  => 'light',
                                        'fields' => array(
                                            array( 'mobile_header_background', array('background_color' => '#fff')),
                                            array( 'mobile_logo_text_color', '#222' ),
                                            array('mobile_header_border_color','#ededed'),
                                            array( 'mobile_menu_customize_text_color', '#333')
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'dark',
                                        'fields' => array(
                                            array( 'mobile_header_background', array('background_color' => '#222')),
                                            array( 'mobile_logo_text_color', '#fff' ),
                                            array('mobile_header_border_color','rgba(255,255,255,0.3)'),
                                            array( 'mobile_menu_customize_text_color', '#fff')
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id' => 'mobile_header_background',
                                'title' => esc_html__('Header Mobile Background', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify a custom header mobile background', 'auteur-framework'),
                                'type' => 'background',
                                'default' => ''
                            ),
                            array(
                                'id'       => 'mobile_logo_text_color',
                                'title'    => esc_html__( 'Logo Text Color', 'auteur-framework' ),
                                'subtitle' => esc_html__( 'Specify the logo text color', 'auteur-framework' ),
                                'type'     => 'color',
                                'required' => array(
                                    array('mobile_logo[url]', '=', '' )
                                ),
                                'alpha'    => true,
                                'default'  => '#333',
                            ),
                            array(
                                'id'       => 'mobile_header_border_color',
                                'title'    => esc_html__( 'Border Color', 'auteur-framework' ),
                                'subtitle' => esc_html__( 'Specify the border color', 'auteur-framework' ),
                                'type'     => 'color',
                                'alpha'    => true,
                                'default'  => '#ededed',
                            ),
                            array(
                                'id'             => 'section_color_group_mobile_menu',
                                'title'          => esc_html__( 'Menu', 'auteur-framework' ),
                                'type'           => 'group',
                                'toggle_default' => false,
                                'fields'         => array(
                                    array(
                                        'id'      => 'mobile_menu_skin',
                                        'title'   => esc_html__( 'Preset Skin', 'auteur-framework' ),
                                        'type'    => 'button_set',
                                        'options' => array(
                                            'light' => esc_html__( 'Light', 'auteur-framework' ),
                                            'dark'  => esc_html__( 'Dark', 'auteur-framework' )
                                        ),
                                        'default' => 'dark',
                                        'preset'  => array(
                                            array(
                                                'op'     => '=',
                                                'value'  => 'light',
                                                'fields' => array(
                                                    array( 'mobile_menu_background_color', '#fff' ),
                                                    array( 'mobile_menu_text_color', '#696969' ),
                                                    array( 'mobile_menu_text_hover_color', '#333' )
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'dark',
                                                'fields' => array(
                                                    array( 'mobile_menu_background_color', '#222' ),
                                                    array( 'mobile_menu_text_color', 'rgba(255,255,255,0.7)' ),
                                                    array( 'mobile_menu_text_hover_color', '#fff' )
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'       => 'mobile_menu_background_color',
                                        'title'    => esc_html__( 'Background Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu background color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#222'
                                    ),
                                    array(
                                        'id'       => 'mobile_menu_text_color',
                                        'title'    => esc_html__( 'Text Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu text color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => 'rgba(255,255,255,0.7)',
                                    ),
                                    array(
                                        'id'       => 'mobile_menu_text_hover_color',
                                        'title'    => esc_html__( 'Text Hover Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu text hover color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#fff',
                                    )
                                )
                            ),
                            array(
                                'id'             => 'section_color_group_mobile_menu_customize',
                                'title'          => esc_html__( 'Menu Customize', 'auteur-framework' ),
                                'type'           => 'group',
                                'toggle_default' => false,
                                'fields'         => array(
                                    array(
                                        'id'       => 'mobile_menu_customize_text_color',
                                        'title'    => esc_html__( 'Text Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu customize text color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#333',
                                    ),
                                    array(
                                        'id'       => 'mobile_menu_customize_text_hover_color',
                                        'title'    => esc_html__( 'Text Hover Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu customize text hover color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '',
                                    )
                                )
                            )
                        )
                    ),
                    array(
                        'id' => 'section_color_group_mobile_header_sticky',
                        'title' => esc_html__('Header Mobile Sticky', 'auteur-framework'),
                        'type' => 'group',
                        'toggle_default' => false,
                        'required' => array(
                            array('header_enable', '=', 'on'),
                            array('mobile_header_sticky', '!=', '')
                        ),
                        'fields' => array(
                            array(
                                'id'      => 'mobile_header_sticky_skin',
                                'title'   => esc_html__( 'Preset Skin', 'auteur-framework' ),
                                'type'    => 'button_set',
                                'options' => array(
                                    'light' => esc_html__( 'Light', 'auteur-framework' ),
                                    'dark'  => esc_html__( 'Dark', 'auteur-framework' )
                                ),
                                'default' => 'light',
                                'preset'  => array(
                                    array(
                                        'op'     => '=',
                                        'value'  => 'light',
                                        'fields' => array(
                                            array( 'mobile_header_sticky_background', array('background_color' => '#fff') ),
                                            array( 'mobile_logo_sticky_text_color', '#222' ),
                                            array( 'mobile_menu_customize_sticky_text_color', '#333')
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'dark',
                                        'fields' => array(
                                            array( 'mobile_header_sticky_background', array('background_color' => '#222') ),
                                            array( 'mobile_logo_sticky_text_color', '#fff' ),
                                            array( 'mobile_menu_customize_sticky_text_color', '#fff')
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id' => 'mobile_header_sticky_background',
                                'title' => esc_html__('Header Sticky Background', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify a custom header sticky background', 'auteur-framework'),
                                'type' => 'background',
                                'default' => ''
                            ),
                            array(
                                'id'       => 'mobile_logo_sticky_text_color',
                                'title'    => esc_html__( 'Logo Text Color', 'auteur-framework' ),
                                'subtitle' => esc_html__( 'Specify the logo text color', 'auteur-framework' ),
                                'type'     => 'color',
                                'required' => array(
                                    array('mobile_logo[url]', '=', '' )
                                ),
                                'alpha'    => true,
                                'default'  => '#333',
                            ),
                            array(
                                'id'             => 'section_color_group_mobile_menu_sticky_customize',
                                'title'          => esc_html__( 'Menu Customize', 'auteur-framework' ),
                                'type'           => 'group',
                                'toggle_default' => false,
                                'fields'         => array(
                                    array(
                                        'id'       => 'mobile_menu_customize_sticky_text_color',
                                        'title'    => esc_html__( 'Text Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu customize text color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '#333',
                                    ),
                                    array(
                                        'id'       => 'mobile_menu_customize_sticky_text_hover_color',
                                        'title'    => esc_html__( 'Text Hover Color', 'auteur-framework' ),
                                        'subtitle' => esc_html__( 'Specify the menu customize text hover color', 'auteur-framework' ),
                                        'type'     => 'color',
                                        'alpha'    => true,
                                        'default'  => '',
                                    )
                                )
                            )
                        )
                    ),
                    array(
                        'id' => 'section_color_group_page_title',
                        'title' => esc_html__('Page Title', 'auteur-framework'),
                        'type' => 'group',
                        'toggle_default' => false,
                        'required' => array('page_title_enable', '=', 'on'),
                        'fields' => array(
                            array(
                                'id' => 'page_title_skin',
                                'title' => esc_html__('Page Title Skin', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify the page title color skin', 'auteur-framework'),
                                'type' => 'select',
                                'options' => G5P()->settings()->get_color_skin(true),
                                'default' => '0'
                            ),
                            array(
                                'id' => 'page_title_background_color',
                                'title' => esc_html__('Page Title Background Color', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify a custom page title background color', 'auteur-framework'),
                                'type' => 'color',
                                'alpha' => true,
                                'default' => ''
                            ),
                        )
                    ),
                )
            );
        }
		
		/**
		 * Get Config Section Connections
		 *
		 * @return array
		 */
		public function get_config_section_connections()
		{
			return array(
				'id'              => 'section_connections',
				'title'           => esc_html__('Connections', 'auteur-framework'),
				'icon'            => 'dashicons dashicons-share',
				'general_options' => true,
				'fields'          => array(
					array(
						'id'     => 'section_connections_group_social_share',
						'title'  => esc_html__('Social Share', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							array(
								'id'       => 'social_share',
								'title'    => esc_html__('Social Share', 'auteur-framework'),
								'subtitle' => esc_html__('Select active social share links and sort them', 'auteur-framework'),
								'type'     => 'sortable',
								'options'  => G5P()->settings()->get_social_share(),
								'default'  => array(
									'facebook'  => 'facebook',
									'twitter'   => 'twitter',
									'linkedin'  => 'linkedin',
									'tumblr'    => 'tumblr',
									'pinterest' => 'pinterest'
								)
							),
						)
					),
					array(
						'id'     => 'section_connections_group_social_networks',
						'title'  => esc_html__('Social Networks', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							array(
								'id'             => 'social_networks',
								'title'          => esc_html__('Social Networks', 'auteur-framework'),
								'desc'           => esc_html__('Define here all the social networks you will need.', 'auteur-framework'),
								'type'           => 'panel',
								'toggle_default' => false,
								'default'        => G5P()->settings()->get_social_networks_default(),
								'panel_title'    => 'social_name',
								'fields'         => array(
									array(
										'id'       => 'social_name',
										'title'    => esc_html__('Title', 'auteur-framework'),
										'subtitle' => esc_html__('Enter your social network name', 'auteur-framework'),
										'type'     => 'text',
									),
									array(
										'id'         => 'social_id',
										'title'      => esc_html__('Unique Social Id', 'auteur-framework'),
										'subtitle'   => esc_html__('This value is created automatically and it shouldn\'t be edited unless you know what you are doing.', 'auteur-framework'),
										'type'       => 'text',
										'input_type' => 'unique_id',
										'default'    => 'social-'
									),
									array(
										'id'       => 'social_icon',
										'title'    => esc_html__('Social Network Icon', 'auteur-framework'),
										'subtitle' => esc_html__('Specify the social network icon', 'auteur-framework'),
										'type'     => 'icon',
									),
									array(
										'id'       => 'social_link',
										'title'    => esc_html__('Social Network Link', 'auteur-framework'),
										'subtitle' => esc_html__('Enter your social network link', 'auteur-framework'),
										'type'     => 'text',
									),
									array(
										'id'       => 'social_color',
										'title'    => esc_html__('Social Network Color', 'auteur-framework'),
										'subtitle' => sprintf(wp_kses_post(__('Specify the social network color. Reference in <a target="_blank" href="%s">brandcolors.net</a>', 'auteur-framework')), 'https://brandcolors.net/'),
										'type'     => 'color'
									)
								)
							)
						)
					),
				)
			);
		}
		
		/**
		 * Get Config Section Blog
		 *
		 * @return array
		 */
		public function get_config_section_blog()
		{
			return array(
				'id'              => 'section_blog',
				'title'           => esc_html__('Blog', 'auteur-framework'),
				'icon'            => 'dashicons dashicons-media-text',
				'general_options' => true,
				'fields'          => array(
					$this->get_config_section_blog_listing('', '', false, array(
                        array(
                            'id' => 'blog_cate_filter',
                            'title' => esc_html__('Category Filter', 'auteur-framework'),
                            'type' => 'button_set',
                            'options' => array(
                                '' => esc_html__('Disable', 'auteur-framework'),
                                'cate-filter-left' => esc_html__('Left', 'auteur-framework'),
                                'cate-filter-center' => esc_html__('Center', 'auteur-framework'),
                                'cate-filter-right' => esc_html__('Right', 'auteur-framework')
                            ),
                            'default'=> ''
                        ),
                        array(
                            'id'     => 'post_default_thumbnail_group',
                            'title'  => esc_html__('Post Default Thumbnail', 'auteur-framework'),
                            'type'   => 'group',
                            'fields' => array(
                                $this->get_config_toggle(array(
                                    'id' => 'default_thumbnail_placeholder_enable',
                                    'title' => esc_html__('Enable Default Thumbnail Placeholder', 'auteur-framework'),
                                    'desc' => esc_html__('You can set default thumbnail for post that haven\' featured image with enabling this option and uploading default image in following field', 'auteur-framework'),
                                    'default' => ''
                                )),
                                array(
                                    'id' => 'default_thumbnail_image',
                                    'type' => 'image',
                                    'title' => esc_html__('Default Thumbnail Image', 'auteur-framework'),
                                    'desc' => esc_html__('By default, the post thumbnail will be shown but when the post haven\'nt thumbnail then this will be replaced', 'auteur-framework'),
                                    'required' => array('default_thumbnail_placeholder_enable', '=', 'on'),
                                ),
                                $this->get_config_toggle(array(
                                    'id' => 'first_image_as_post_thumbnail',
                                    'title' => esc_html__('First Image as Post Thumbnail', 'auteur-framework'),
                                    'desc' => esc_html__('With enabling this options if any post have not thumbnail then theme will shows first content image as post thumbnail.', 'auteur-framework'),
                                    'default' => '',
                                ))
                            )
                        )
					)),
					$this->get_config_section_blog_listing(esc_html__('Search Listing', 'auteur-framework'), 'search', true),
					$this->get_config_group_single_blog()
				)
			);
		}
		
		/**
		 * Get Config group single blog
		 *
		 * @return array
		 */
		public function get_config_group_single_blog()
		{
			return array(
				'id'     => 'section_blog_group_single_blog',
				'title'  => esc_html__('Single Blog', 'auteur-framework'),
				'type'   => 'group',
				'fields' => array(
					array(
						'id'       => 'single_post_layout',
						'title'    => esc_html__('Post Layout', 'auteur-framework'),
						'subtitle' => esc_html__('Specify your post layout', 'auteur-framework'),
						'type'     => 'image_set',
						'options'  => G5P()->settings()->get_single_post_layout(),
						'default'  => 'layout-1'
					),
					$this->get_config_toggle(array(
						'id'       => 'single_reading_process_enable',
						'title'    => esc_html__('Reading Process', 'auteur-framework'),
						'subtitle' => esc_html__('Turn Off this option if you want to hide reading process on single blog', 'auteur-framework'),
						'default'  => 'on'
					)),
					$this->get_config_toggle(array(
						'id'       => 'single_tag_enable',
						'title'    => esc_html__('Tags', 'auteur-framework'),
						'subtitle' => esc_html__('Turn Off this option if you want to hide tags on single blog', 'auteur-framework'),
						'default'  => 'on'
					)),
					$this->get_config_toggle(array(
						'id'       => 'single_share_enable',
						'title'    => esc_html__('Share', 'auteur-framework'),
						'subtitle' => esc_html__('Turn Off this option if you want to hide share on single blog', 'auteur-framework'),
						'default'  => 'on'
					)),
					$this->get_config_toggle(array(
						'id'       => 'single_navigation_enable',
						'title'    => esc_html__('Navigation', 'auteur-framework'),
						'subtitle' => esc_html__('Turn Off this option if you want to hide navigation on single blog', 'auteur-framework'),
						'default'  => 'on'
					)),
					$this->get_config_toggle(array(
						'id'       => 'single_author_info_enable',
						'title'    => esc_html__('Author Info', 'auteur-framework'),
						'subtitle' => esc_html__('Turn Off this option if you want to hide author info area on single blog', 'auteur-framework'),
						'default'  => 'on'
					)),
					array(
						'id'     => 'group_single_related_posts',
						'title'  => esc_html__('Related Posts', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id'       => 'single_related_post_enable',
								'title'    => esc_html__('Related Posts', 'auteur-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to hide related posts area on single blog', 'auteur-framework'),
								'default'  => ''
							)),
							array(
								'id'       => 'single_related_post_algorithm',
								'title'    => esc_html__('Related Posts Algorithm', 'auteur-framework'),
								'subtitle' => esc_html__('Specify the algorithm of related posts', 'auteur-framework'),
								'type'     => 'select',
								'options'  => G5P()->settings()->get_related_post_algorithm(),
								'default'  => 'cat',
								'required' => array('single_related_post_enable', '=', 'on')
							),
							$this->get_config_toggle(array(
								'id'       => 'single_related_post_carousel_enable',
								'title'    => esc_html__('Carousel Mode', 'auteur-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable carousel mode', 'auteur-framework'),
								'default'  => 'on',
								'required' => array('single_related_post_enable', '=', 'on')
							)),
							array(
								'id'         => 'single_related_post_per_page',
								'title'      => esc_html__('Posts Per Page', 'auteur-framework'),
								'subtitle'   => esc_html__('Enter number of posts per page you want to display', 'auteur-framework'),
								'type'       => 'text',
								'input_type' => 'number',
								'default'    => 6,
								'required'   => array('single_related_post_enable', '=', 'on')
							),
							array(
								'id'       => 'single_related_post_columns_gutter',
								'title'    => esc_html__('Post Columns Gutter', 'auteur-framework'),
								'subtitle' => esc_html__('Specify your horizontal space between post.', 'auteur-framework'),
								'type'     => 'select',
								'options'  => G5P()->settings()->get_post_columns_gutter(),
								'default'  => '20',
								'required' => array('single_related_post_enable', '=', 'on')
							),
							array(
								'id'       => 'single_related_post_columns_group',
								'title'    => esc_html__('Post Columns', 'auteur-framework'),
								'type'     => 'group',
								'required' => array('single_related_post_enable', '=', 'on'),
								'fields'   => array(
									array(
										'id'     => 'single_related_post_columns_row_1',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											array(
												'id'      => 'single_related_post_columns',
												'title'   => esc_html__('Large Devices', 'auteur-framework'),
												'desc'    => esc_html__('Specify your post columns on large devices (>= 1200px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '3',
												'layout'  => 'full',
											),
											array(
												'id'      => 'single_related_post_columns_md',
												'title'   => esc_html__('Medium Devices', 'auteur-framework'),
												'desc'    => esc_html__('Specify your post columns on medium devices (>= 992px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '3',
												'layout'  => 'full',
											),
											array(
												'id'      => 'single_related_post_columns_sm',
												'title'   => esc_html__('Small Devices', 'auteur-framework'),
												'desc'    => esc_html__('Specify your post columns on small devices (>= 768px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '2',
												'layout'  => 'full',
											),
											array(
												'id'      => 'single_related_post_columns_xs',
												'title'   => esc_html__('Extra Small Devices ', 'auteur-framework'),
												'desc'    => esc_html__('Specify your post columns on extra small devices (< 768px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '2',
												'layout'  => 'full',
											),
											array(
												'id'      => "single_related_post_columns_mb",
												'title'   => esc_html__('Extra Extra Small Devices ', 'auteur-framework'),
												'desc'    => esc_html__('Specify your post columns on extra extra small devices (< 480px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '1',
												'layout'  => 'full',
											)
										)
									),
								)
							),
							array(
								'id'       => 'single_related_post_paging',
								'title'    => esc_html__('Post Paging', 'auteur-framework'),
								'subtitle' => esc_html__('Specify your post paging mode', 'auteur-framework'),
								'type'     => 'select',
								'options'  => G5P()->settings()->get_post_paging_small_mode(),
								'default'  => 'none',
								'required' => array('single_related_post_enable', '=', 'on')
							),
							array(
								'id'       => 'single_related_post_animation',
								'title'    => esc_html__('Animation', 'auteur-framework'),
								'subtitle' => esc_html__('Specify your post animation', 'auteur-framework'),
								'type'     => 'select',
								'options'  => G5P()->settings()->get_animation(true),
								'default'  => '-1',
								'required' => array('single_related_post_enable', '=', 'on')
							),
						)
					)
				)
			);
		}
		
		/**
		 * Get Config Section Customize Css & Javascript
		 *
		 * @return array
		 */
		public function get_config_section_code()
		{
			return array(
				'id'              => 'section_code',
				'title'           => esc_html__('Css & Javascript', 'auteur-framework'),
				'icon'            => 'dashicons dashicons-editor-code',
				'general_options' => true,
				'fields'          => array(
					array(
						'id'       => 'custom_css',
						'title'    => esc_html__('Custom Css', 'auteur-framework'),
						'subtitle' => esc_html__('Enter here your custom CSS. Please do not include any style tags.', 'auteur-framework'),
						'type'     => 'ace_editor',
						'mode'     => 'css',
						'theme'    => 'monokai',
						'min_line' => 20
					),
					array(
						'id'       => 'custom_js',
						'title'    => esc_html__('Custom Javascript', 'auteur-framework'),
						'subtitle' => esc_html__('Enter here your custom javascript code. Please do not include any script tags.', 'auteur-framework'),
						'type'     => 'ace_editor',
						'mode'     => 'javascript',
						'theme'    => 'monokai',
						'min_line' => 20
					),
				)
			);
		}
		
		/**
		 * Get Config Content Block
		 *
		 * @param $id
		 * @param array $args
		 * @param bool $inherit
		 * @return array
		 */
		public function get_config_content_block($args = array())
		{
			$defaults = array(
				'title'       => esc_html__('Content Block', 'auteur-framework'),
				'placeholder' => esc_html__('Select Content Block', 'auteur-framework'),
				'type'        => 'selectize',
				'allow_clear' => true,
				'data'        => G5P()->cpt()->get_content_block_post_type(),
				'data_args'   => array(
					'numberposts' => -1,
				)
			);
			
			$defaults = wp_parse_args($args, $defaults);
			return $defaults;
		}
		
		/**
		 * Get Config Sidebar Layout
		 *
		 * @param $id
		 * @param bool $inherit
		 * @param array $args
		 * @return array
		 */
		public function get_config_sidebar_layout($args = array(), $inherit = false)
		{
			$defaults = array(
				'title'   => esc_html__('Sidebar Layout', 'auteur-framework'),
				'type'    => 'image_set',
				'options' => G5P()->settings()->get_sidebar_layout($inherit),
				'default' => $inherit ? '' : 'right'
			);
			
			$defaults = wp_parse_args($args, $defaults);
			return $defaults;
		}
		
		/**
		 * Get Config Sidebar
		 *
		 * @param $id
		 * @param array $args
		 * @param $inherit
		 * @return array
		 */
		public function get_config_sidebar($args = array(), $inherit = false)
		{
			$defaults = array(
				'title'       => esc_html__('Sidebar', 'auteur-framework'),
				'type'        => 'selectize',
				'placeholder' => esc_html__('Select Sidebar', 'auteur-framework'),
				'data'        => 'sidebar',
				'allow_clear' => true,
				'default'     => ''
			);
			
			$defaults = wp_parse_args($args, $defaults);
			return $defaults;
		}
		
		
		/**
		 * Get Config Border Bottom
		 *
		 * @param $id
		 * @param array $args
		 * @param bool $inherit
		 * @return array
		 */
		public function get_config_border_bottom($id, $args = array(), $inherit = false)
		{
			$defaults = array(
				'id'       => $id,
				'type'     => 'select',
				'title'    => esc_html__('Border Bottom', 'auteur-framework'),
				'subtitle' => esc_html__('Specify the border bottom mode.', 'auteur-framework'),
				'options'  => G5P()->settings()->get_border_layout($inherit),
				'default'  => $inherit ? '' : 'none'
			);
			$defaults = wp_parse_args($args, $defaults);
			return $defaults;
		}
		
		/**
		 * Get Config Group Header Customize
		 *
		 * @param $id
		 * @param $title
		 * @param $prefixId
		 * @param array $default
		 * @param array $required
		 * @return array
		 */
		public function get_config_group_header_customize($id, $title, $prefixId, $default = array(), $required = array())
		{
			return array(
				'id'             => $id,
				'title'          => $title,
				'type'           => 'group',
				'toggle_default' => true,
				'required'       => $required,
				'fields'         => array(
					array(
						'id'      => $prefixId,
						'title'   => esc_html__('Items', 'auteur-framework'),
						'type'    => 'sortable',
						'options' => G5P()->settings()->get_header_customize(),
						'default' => $default
					),
					$this->get_config_toggle(array(
						'id'       => "{$prefixId}_separator",
						'title'    => esc_html__('Items separator enable', 'auteur-framework'),
						'default'  => '',
						'required' => array('header_layout', 'not in', array('header-8', 'header-9','header-11', 'header-12'))
					)),
					array(
						'id'       => "{$prefixId}_separator_bg_color",
						'title'    => esc_html__('Items separator background color', 'auteur-framework'),
						'default'  => '#e0e0e0',
						'type'     => 'color',
						'alpha'    => true,
						'required' => array(
							array('header_layout', 'not in', array('header-8', 'header-9','header-11', 'header-12')),
							array("{$prefixId}_separator", '=', 'on')
						)
					),
					$this->get_config_toggle(array(
						'id'       => "{$prefixId}_search_type",
						'title'    => esc_html__('Search type', 'auteur-framework'),
						'type'     => 'button_set',
						'default'  => 'icon',
						'options'  => array(
							'icon' => esc_html__('Icon', 'auteur-framework'),
							'box'  => esc_html__('Box', 'auteur-framework')
						),
						'required' => array($prefixId, 'contain', 'search')
					)),
					$this->get_config_sidebar(array(
						'id'       => "{$prefixId}_sidebar",
						'required' => array($prefixId, 'contain', 'sidebar')
					)),
					array(
						'id'          => "{$prefixId}_social_networks",
						'title'       => esc_html__('Social Networks', 'auteur-framework'),
						'type'        => 'selectize',
						'multiple'    => true,
						'drag'        => true,
						'placeholder' => esc_html__('Select Social Networks', 'auteur-framework'),
						'options'     => G5P()->settings()->get_social_networks(),
						'required'    => array($prefixId, 'contain', 'social-networks')
					),
					array(
						'id'       => "{$prefixId}_custom_html",
						'title'    => esc_html__('Custom Html Content', 'auteur-framework'),
						'type'     => 'ace_editor',
						'mode'     => 'html',
						'required' => array($prefixId, 'contain', 'custom-html')
					),
					$this->get_config_spacing("{$prefixId}_spacing", array(
						'title'   => esc_html__('Items Spacing', 'auteur-framework'),
						'default' => 25
					)),
					array(
						'id'      => "{$prefixId}_custom_css",
						'type'    => 'text',
						'title'   => esc_html__('Custom Css Class', 'auteur-framework'),
						'default' => ''
					)
				)
			);
		}

        public function get_config_group_mobile_header_customize($id, $title, $prefixId, $default = array(), $required = array())
        {
            return array(
                'id'             => $id,
                'title'          => $title,
                'type'           => 'group',
                'toggle_default' => true,
                'required'       => $required,
                'fields'         => array(
                    array(
                        'id'      => $prefixId,
                        'title'   => esc_html__('Items', 'auteur-framework'),
                        'type'    => 'sortable',
                        'options' => G5P()->settings()->get_mobile_header_customize(),
                        'default' => $default
                    ),
                    $this->get_config_toggle(array(
                        'id'       => "{$prefixId}_separator",
                        'title'    => esc_html__('Items separator enable', 'auteur-framework'),
                        'default'  => '',
                    )),
                    array(
                        'id'       => "{$prefixId}_separator_bg_color",
                        'title'    => esc_html__('Items separator background color', 'auteur-framework'),
                        'default'  => '#e0e0e0',
                        'type'     => 'color',
                        'alpha'    => true,
                        'required' => array(
                            array("{$prefixId}_separator", '=', 'on')
                        )
                    ),
                    array(
                        'id'          => "{$prefixId}_social_networks",
                        'title'       => esc_html__('Social Networks', 'auteur-framework'),
                        'type'        => 'selectize',
                        'multiple'    => true,
                        'drag'        => true,
                        'placeholder' => esc_html__('Select Social Networks', 'auteur-framework'),
                        'options'     => G5P()->settings()->get_social_networks(),
                        'required'    => array($prefixId, 'contain', 'social-networks')
                    ),
                    array(
                        'id'       => "{$prefixId}_custom_html",
                        'title'    => esc_html__('Custom Html Content', 'auteur-framework'),
                        'type'     => 'ace_editor',
                        'mode'     => 'html',
                        'required' => array($prefixId, 'contain', 'custom-html')
                    ),
                    $this->get_config_spacing("{$prefixId}_spacing", array(
                        'title'   => esc_html__('Items Spacing', 'auteur-framework'),
                        'default' => 25
                    )),
                    array(
                        'id'      => "{$prefixId}_custom_css",
                        'type'    => 'text',
                        'title'   => esc_html__('Custom Css Class', 'auteur-framework'),
                        'default' => ''
                    )
                )
            );
        }
		
		/**
		 * Get Config Spacing
		 *
		 * @param $id
		 * @param array $args
		 * @return array
		 */
		public function get_config_spacing($id, $args = array())
		{
			$defaults = array(
				'id'         => $id,
				'type'       => 'slider',
				'js_options' => array(
					'step' => 1,
					'min'  => 1,
					'max'  => 100
				),
				'default'    => 35,
			);
			
			$defaults = wp_parse_args($args, $defaults);
			return $defaults;
		}
		
		
		/**
		 * Get Toggle Config
		 *
		 * @param array $args
		 * @param bool $inherit
		 * @return array
		 */
		public function get_config_toggle($args = array(), $inherit = false)
		{
			
			if (!$inherit) {
				$defaults = array(
					'type' => 'switch'
				);
			} else {
				$defaults = array(
					'type'    => 'button_set',
					'options' => G5P()->settings()->get_toggle($inherit),
					'default' => '',
				);
			}
			$defaults = wp_parse_args($args, $defaults);
			return $defaults;
		}
		
		public function get_config_section_blog_listing($title = '', $prefix = '', $inherit = false, $addition = array())
		{
			if ($prefix !== '') {
				$prefix = "{$prefix}_";
			}
			
			if ($title === '') {
				$title = esc_html__('Blog Listing', 'auteur-framework');
			}
			
			$fields = array_merge(array(
				array(
					'id'       => "{$prefix}post_layout",
					'title'    => esc_html__('Post Layout', 'auteur-framework'),
					'subtitle' => esc_html__('Specify your post layout', 'auteur-framework'),
					'type'     => 'image_set',
					'options'  => G5P()->settings()->get_post_layout($inherit),
					'default'  => $inherit ? '' : 'large-image',
					'preset'   => array(
						array(
							'op'     => '=',
							'value'  => 'large-image',
							'fields' => array(
								array("{$prefix}post_image_size", 'full'),
                                array("{$prefix}posts_per_page", ''),
							)
						),
                        array(
                            'op'     => '=',
                            'value'  => 'medium-image',
                            'fields' => array(
                                array("{$prefix}post_image_size", '330x200'),
                            )
                        ),
						array(
							'op'     => '=',
							'value'  => 'grid',
							'fields' => array(
								array("{$prefix}post_columns_gutter", 30),
								array("{$prefix}post_image_size", '330x200'),
							)
						),
						array(
							'op'     => '=',
							'value'  => 'masonry',
							'fields' => array(
								array("{$prefix}post_columns_gutter", 30),
								array('post_image_width', '400'),
							)
						),
					)
				)
			),
				array(
					array(
						'id'     => "{$prefix}post_image_size_group",
						'title'  => esc_html__('Post Image Size', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							array(
								'id'       => "{$prefix}post_image_size",
								'title'    => esc_html__('Image size', 'auteur-framework'),
								'subtitle' => esc_html__('Enter your post image size', 'auteur-framework'),
								'desc'     => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'auteur-framework'),
								'type'     => 'text',
								'default'  => 'full',
								'required' => array("{$prefix}post_layout", 'not in', array('masonry')),
							),
							array(
								'id'         => "{$prefix}post_image_width",
								'title'      => esc_html__('Image width', 'auteur-framework'),
								'subtitle'   => esc_html__('Enter your post image width', 'auteur-framework'),
								'type'     => 'dimension',
								'height'   => false,
								'default'  => array(
									'width' => '400'
								),
								'required'   => array("{$prefix}post_layout", 'in', array('masonry')),
							),
							array(
								'id'       => "{$prefix}post_image_ratio",
								'title'    => esc_html__('Image ratio', 'auteur-framework'),
								'subtitle' => esc_html__('Specify your image post ratio', 'auteur-framework'),
								'type'     => 'select',
								'options'  => G5P()->settings()->get_image_ratio(),
								'default'  => '4x3',
								'required' => array(
									array("{$prefix}post_image_size", 'in',array('full','large','medium','thumbnail') ),
									array("{$prefix}post_layout", 'not in', array('masonry','large-image')),
								)
							),
							array(
								'id'       => "{$prefix}post_image_ratio_custom",
								'title'    => esc_html__('Image ratio custom', 'auteur-framework'),
								'subtitle' => esc_html__('Enter custom image ratio', 'auteur-framework'),
								'type'     => 'dimension',
								'required' => array(
									array("{$prefix}post_image_size", 'in', array('full','large','medium','thumbnail')),
									array("{$prefix}post_image_ratio", '=', 'custom'),
									array("{$prefix}post_layout", 'not in', array('masonry','large-image')),
								)
							)
						)
					)
				),
				$addition,
				array(
					array(
						'id'       => "{$prefix}post_columns_gutter",
						'title'    => esc_html__('Post Columns Gutter', 'auteur-framework'),
						'subtitle' => esc_html__('Specify your horizontal space between post.', 'auteur-framework'),
						'type'     => 'select',
						'options'  => G5P()->settings()->get_post_columns_gutter($inherit),
						'default'  => $inherit ? '' : '30',
						'required' => array("{$prefix}post_layout", 'not in', array('large-image','medium-image'))
					),
					array(
						'id'       => "{$prefix}post_columns_group",
						'title'    => esc_html__('Post Columns', 'auteur-framework'),
						'type'     => 'group',
						'required' => array("{$prefix}post_layout", 'in', array('grid', 'masonry')),
						'fields'   => array(
							array(
								'id'     => "{$prefix}post_columns_row_1",
								'type'   => 'row',
								'col'    => 3,
								'fields' => array(
									array(
										'id'      => "{$prefix}post_columns",
										'title'   => esc_html__('Large Devices', 'auteur-framework'),
										'desc'    => esc_html__('Specify your post columns on large devices (>= 1200px)', 'auteur-framework'),
										'type'    => 'select',
										'options' => G5P()->settings()->get_post_columns($inherit),
										'default' => $inherit ? '' : '3',
										'layout'  => 'full',
									),
									array(
										'id'      => "{$prefix}post_columns_md",
										'title'   => esc_html__('Medium Devices', 'auteur-framework'),
										'desc'    => esc_html__('Specify your post columns on medium devices (>= 992px)', 'auteur-framework'),
										'type'    => 'select',
										'options' => G5P()->settings()->get_post_columns($inherit),
										'default' => $inherit ? '' : '2',
										'layout'  => 'full',
									),
									array(
										'id'      => "{$prefix}post_columns_sm",
										'title'   => esc_html__('Small Devices', 'auteur-framework'),
										'desc'    => esc_html__('Specify your post columns on small devices (>= 768px)', 'auteur-framework'),
										'type'    => 'select',
										'options' => G5P()->settings()->get_post_columns($inherit),
										'default' => $inherit ? '' : '2',
										'layout'  => 'full',
									),
									array(
										'id'      => "{$prefix}post_columns_xs",
										'title'   => esc_html__('Extra Small Devices ', 'auteur-framework'),
										'desc'    => esc_html__('Specify your post columns on extra small devices (< 768px)', 'auteur-framework'),
										'type'    => 'select',
										'options' => G5P()->settings()->get_post_columns($inherit),
										'default' => $inherit ? '' : '2',
										'layout'  => 'full',
									),
									array(
										'id'      => "{$prefix}post_columns_mb",
										'title'   => esc_html__('Extra Extra Small Devices ', 'auteur-framework'),
										'desc'    => esc_html__('Specify your post columns on extra extra small devices (< 576px)', 'auteur-framework'),
										'type'    => 'select',
										'options' => G5P()->settings()->get_post_columns($inherit),
										'default' => $inherit ? '' : '1',
										'layout'  => 'full',
									)
								)
							),
						)
					),
					array(
						'id'         => "{$prefix}posts_per_page",
						'title'      => esc_html__('Posts Per Page', 'auteur-framework'),
						'subtitle'   => esc_html__('Enter number of posts per page you want to display.', 'auteur-framework'),
						'type'       => 'text',
						'input_type' => 'number',
					),
					array(
						'id'       => "{$prefix}post_paging",
						'title'    => esc_html__('Post Paging', 'auteur-framework'),
						'subtitle' => esc_html__('Specify your post paging mode', 'auteur-framework'),
						'type'     => 'select',
						'options'  => G5P()->settings()->get_post_paging_mode($inherit),
						'default'  => $inherit ? '' : 'pagination'
					),
					array(
						'id'       => "{$prefix}post_animation",
						'title'    => esc_html__('Animation', 'auteur-framework'),
						'subtitle' => esc_html__('Specify your post animation', 'auteur-framework'),
						'type'     => 'select',
						'options'  => G5P()->settings()->get_animation($inherit),
						'default'  => $inherit ? '' : 'none'
					)
				));
			
			if ($prefix === '') {
				$fields[] = array(
					'id'          => 'post_ads',
					'title'       => esc_html__('Advertisement', 'auteur-framework'),
					'desc'        => esc_html__('Define here all the advertisement for listing post you will need.', 'auteur-framework'),
					'type'        => 'panel',
					'required'    => array('post_layout', 'in', array('large-image', 'medium-image')),
					'panel_title' => 'name',
					'fields'      => array(
						array(
							'id'       => 'name',
							'title'    => esc_html__('Title', 'auteur-framework'),
							'subtitle' => esc_html__('Enter your advertisement name', 'auteur-framework'),
							'type'     => 'text',
						),
						array(
							'id'       => 'content',
							'title'    => esc_html__('Content', 'auteur-framework'),
							'subtitle' => esc_html__('Enter your advertisement content', 'auteur-framework'),
							'type'     => 'editor',
						),
						array(
							'id'         => 'position',
							'title'      => esc_html__('Position', 'auteur-framework'),
							'subtitle'   => esc_html__('Enter your advertisement position', 'auteur-framework'),
							'desc'       => esc_html__('After how many post the ad will display.', 'auteur-framework'),
							'type'       => 'text',
							'input_type' => 'number'
						),
					)
				);
			}
			if ($prefix === 'search_') {
				$fields[] = array(
					'id'       => 'search_post_type',
					'type'     => 'checkbox_list',
					'title'    => esc_html__('Post Type For Search', 'auteur-framework'),
					'options'  => G5P()->settings()->get_search_ajax_popup_post_type(),
					'multiple' => true,
					'default'  => array('post'),
				);
			}
			$options = array(
				'id'     => "{$prefix}section_blog_group_blog_listing",
				'title'  => $title,
				'type'   => 'group',
				'fields' => $fields
			);
			return $options;
		}
		
		/**
		 * Get preset config
		 *
		 * @param array $args
		 * @return array
		 */
		public function get_config_preset($args = array())
		{
			$defaults = array(
				'title'       => esc_html__('Preset', 'auteur-framework'),
				'type'        => 'selectize',
				'allow_clear' => true,
				'data'        => 'preset',
				'data-option' => G5P()->getOptionName(),
				'create_link' => admin_url('admin.php?page=gsf_options'),
				'edit_link'   => admin_url('admin.php?page=gsf_options'),
				'placeholder' => esc_html__('Select Preset', 'auteur-framework'),
				'multiple'    => false,
				'desc'        => esc_html__('Optionally you can choose to override the setting that is used on the page', 'auteur-framework'),
			);
			return wp_parse_args($args, $defaults);
		}

        public function get_config_section_custom_post_type() {
            return array(
                'id'     => 'section_custom_post_type',
                'title'  => esc_html__('Custom Post Type', 'auteur-framework'),
                'icon'   => 'dashicons dashicons-grid-view',
                'general_options' => true,
                'fields' => array(
                    array(
                        'id'       => 'custom_post_type_disable',
                        'type'     => 'checkbox_list',
                        'value_inline' => false,
                        'multiple' => true,
                        'title'    => esc_html__('Disable Custom Post Types', 'auteur-framework'),
                        'subtitle' => esc_html__('You can disable the custom post types used within the theme here, by checking the corresponding box. NOTE: If you do not want to disable any, then make sure none of the boxes are checked.','auteur-framework'),
                        'options'  => array(
                            'portfolio' => esc_html__('Portfolio', 'auteur-framework'),
                        )
                    ),
                )
            );
        }
		/**
		 * Get Woocommerce config
		 */
		public function get_config_section_woocommerce()
		{
			return array(
				'id'              => 'section_woocommerce',
				'title'           => esc_html__('Woocommerce', 'auteur-framework'),
				'icon'            => 'dashicons dashicons-cart',
				'general_options' => true,
				'fields'          => array(
					array(
						'id'     => 'section_woocommerce_group_general',
						'title'  => esc_html__('General', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id'       => 'product_featured_label_enable',
								'title'    => esc_html__('Show Featured Label', 'auteur-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to disable featured label', 'auteur-framework'),
								'default'  => 'on'
							)),
							array(
								'id'       => 'product_featured_label_text',
								'type'     => 'text',
								'title'    => esc_html__('Featured Label Text', 'auteur-framework'),
								'subtitle' => esc_html__('Enter product featured label text', 'auteur-framework'),
								'default'  => esc_html__('Hot', 'auteur-framework'),
								'required' => array('product_featured_label_enable', '=', 'on')
							),
							$this->get_config_toggle(array(
								'id'       => 'product_sale_label_enable',
								'title'    => esc_html__('Show Sale Label', 'auteur-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to disable sale label', 'auteur-framework'),
								'default'  => 'on'
							)),
							array(
								'id'       => 'product_sale_flash_mode',
								'title'    => esc_html__('Sale Flash Mode', 'auteur-framework'),
								'type'     => 'button_set',
								'options'  => array(
									'text'    => esc_html__('Text', 'auteur-framework'),
									'percent' => esc_html__('Percent', 'auteur-framework')
								),
								'default'  => 'text',
								'required' => array('product_sale_label_enable', '=', 'on')
							),
							array(
								'id'       => 'product_sale_label_text',
								'type'     => 'text',
								'title'    => esc_html__('Sale Label Text', 'auteur-framework'),
								'subtitle' => esc_html__('Enter product sale label text', 'auteur-framework'),
								'default'  => esc_html__('Sale', 'auteur-framework'),
								'required' => array(
									array('product_sale_label_enable', '=', 'on'),
									array('product_sale_flash_mode', '=', 'text')
								)
							),
							$this->get_config_toggle(array(
								'id'       => 'product_new_label_enable',
								'title'    => esc_html__('Show New Label', 'auteur-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to disable new label', 'auteur-framework'),
								'default'  => ''
							)),
							array(
								'id'         => 'product_new_label_since',
								'type'       => 'text',
								'input_type' => 'number',
								'title'      => esc_html__('Mark New After Published (Days)', 'auteur-framework'),
								'subtitle'   => esc_html__('Enter the number of days after the publication is marked as new', 'auteur-framework'),
								'default'    => '5',
								'required'   => array('product_new_label_enable', '=', 'on')
							),
							array(
								'id'       => 'product_new_label_text',
								'type'     => 'text',
								'title'    => esc_html__('New Label Text', 'auteur-framework'),
								'subtitle' => esc_html__('Enter product new label text', 'auteur-framework'),
								'default'  => esc_html__('New', 'auteur-framework'),
								'required' => array('product_new_label_enable', '=', 'on')
							),
							
							$this->get_config_toggle(array(
								'id'       => 'product_sale_count_down_enable',
								'title'    => esc_html__('Show Sale Count Down', 'auteur-framework'),
								'subtitle' => esc_html__('Turn On this option if you want to enable sale count down', 'auteur-framework'),
								'default'  => ''
							)),
							
							$this->get_config_toggle(array(
								'id'       => 'product_add_to_cart_enable',
								'title'    => esc_html__('Show Add To Cart Button', 'auteur-framework'),
								'subtitle' => esc_html__('Turn Off this option if you want to disable add to cart button', 'auteur-framework'),
								'default'  => 'on'
							))
						)),
					array(
						'id'     => 'section_woocommerce_group_archive',
						'title'  => esc_html__('Shop and Category Page', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							array(
								'id'       => 'product_catalog_layout',
								'title'    => esc_html__('Layout', 'auteur-framework'),
								'subtitle' => esc_html__('Specify your product layout', 'auteur-framework'),
								'type'     => 'image_set',
								'options'  => G5P()->settings()->get_product_catalog_layout(),
								'default'  => 'grid',
								'preset'   => array(
									array(
										'op'     => '=',
										'value'  => 'grid',
										'fields' => array(
											array('product_per_page', 9),
											array('product_columns_gutter', 30)
										)
									),
									array(
										'op'     => '=',
										'value'  => 'list',
										'fields' => array(
											array('product_per_page', 5),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'metro-01',
										'fields' => array(
											array('product_per_page', 8),
											array('product_columns_gutter', 10),
											array('product_image_size', '500x500'),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'metro-02',
										'fields' => array(
											array('product_per_page', 8),
											array('product_columns_gutter', 10),
											array('product_image_size', '500x500'),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'metro-03',
										'fields' => array(
											array('product_per_page', 10),
											array('product_columns_gutter', 10),
											array('product_image_size', '500x500'),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'metro-04',
										'fields' => array(
											array('product_per_page', 8),
											array('product_columns_gutter', 10),
											array('product_image_size', '500x500'),
										)
									),
									array(
										'op'     => '=',
										'value'  => 'metro-05',
										'fields' => array(
											array('product_per_page', 8),
											array('product_columns_gutter', 10),
											array('product_image_size', '500x500'),
										)
									),
								)
							),
							array(
								'id'       => 'product_image_size_group',
								'title'    => esc_html__('Product Image Size', 'auteur-framework'),
								'type'     => 'group',
								'required' => array('product_catalog_layout', 'not in', array('grid', 'list')),
								'fields'   => array(
									array(
										'id'       => 'product_image_size',
										'title'    => esc_html__('Image size', 'auteur-framework'),
										'subtitle' => esc_html__('Enter your product image size', 'auteur-framework'),
										'desc'     => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'auteur-framework'),
										'type'     => 'text',
										'default'  => 'medium'
									),
									array(
										'id'       => 'product_image_ratio',
										'title'    => esc_html__('Image ratio', 'auteur-framework'),
										'subtitle' => esc_html__('Specify your image product ratio', 'auteur-framework'),
										'type'     => 'select',
										'options'  => G5P()->settings()->get_image_ratio(),
										'default'  => '1x1',
										'required' => array('product_image_size', 'in', array('full','large','medium','thumbnail') )
									),
									array(
										'id'       => 'product_image_ratio_custom',
										'title'    => esc_html__('Image ratio custom', 'auteur-framework'),
										'subtitle' => esc_html__('Enter custom image ratio', 'auteur-framework'),
										'type'     => 'dimension',
										'required' => array(
											array('product_image_size', 'in', array('full','large','medium','thumbnail')),
											array('product_image_ratio', '=', 'custom')
										)
									)
								)
							),

							array(
								'id'       => 'product_columns_gutter',
								'title'    => esc_html__('Product Columns Gutter', 'auteur-framework'),
								'subtitle' => esc_html__('Specify your horizontal space between product.', 'auteur-framework'),
								'type'     => 'select',
								'options'  => array(
                                    'none' => esc_html__('None', 'auteur-framework'),
                                    '10' => '10px',
                                    '20' => '20px',
                                    '30' => '30px',
                                ),
								'default'  => '30',
								'required' => array('product_catalog_layout', '!=', 'list')
							),
							array(
								'id'       => 'product_columns_group',
								'title'    => esc_html__('Product Columns', 'auteur-framework'),
								'type'     => 'group',
                                'required' => array('product_catalog_layout', 'in', array('grid')),
								'fields'   => array(
									array(
										'id'     => 'product_columns_row_1',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											array(
												'id'      => 'product_columns',
												'title'   => esc_html__('Large Devices', 'auteur-framework'),
												'desc'    => esc_html__('Specify your product columns on large devices (>= 1200px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '3',
												'layout'  => 'full',
											),
											array(
												'id'      => 'product_columns_md',
												'title'   => esc_html__('Medium Devices', 'auteur-framework'),
												'desc'    => esc_html__('Specify your product columns on medium devices (>= 992px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '3',
												'layout'  => 'full',
											),
											array(
												'id'      => 'product_columns_sm',
												'title'   => esc_html__('Small Devices', 'auteur-framework'),
												'desc'    => esc_html__('Specify your product columns on small devices (>= 768px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '2',
												'layout'  => 'full',
											),
											array(
												'id'      => 'product_columns_xs',
												'title'   => esc_html__('Extra Small Devices ', 'auteur-framework'),
												'desc'    => esc_html__('Specify your product columns on extra small devices (< 768px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '1',
												'layout'  => 'full',
											),
											array(
												'id'      => "product_columns_mb",
												'title'   => esc_html__('Extra Extra Small Devices ', 'auteur-framework'),
												'desc'    => esc_html__('Specify your product columns on extra extra small devices (< 576px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '1',
												'layout'  => 'full',
											)
										)
									),
								)
							),
							array(
								'id'       => 'product_per_page',
								'title'    => esc_html__('Products Per Page', 'auteur-framework'),
								'subtitle' => esc_html__('Enter number of products per page you want to display. Default 9', 'auteur-framework'),
								'type'     => 'text',
								'default'  => '9',
								'required' => array("woocommerce_customize[Disable]", 'contain', 'items-show')
							),


							$this->get_config_toggle(array(
                                'id'       => 'product_swatches_enable',
                                'title'    => esc_html__('Swatches Enable', 'auteur-framework'),
                                'subtitle' => esc_html__('Enable Swatches on Shop and Category Page', 'auteur-framework'),
                                'default'  => 'on'
                            )),
							array(
                                'id'       => 'product_swatches_taxonomies',
                                'title'    => esc_html__('Attributes to show', 'auteur-framework'),
                                'subtitle' => esc_html__('Select Attributes list to show on Shop and Category page', 'auteur-framework'),
                                'type'     => 'checkbox_list',
                                'options'  => G5P()->settings()->get_swatches_taxomnomies(),
                                'value_inline' => false,
                                'multiple' => true,
                                'default'  => array(),
                                'required' => array('product_swatches_enable', '=', 'on')
                            ),
							array(
								'id'       => 'product_paging',
								'title'    => esc_html__('Product Paging', 'auteur-framework'),
								'subtitle' => esc_html__('Specify your product paging mode', 'auteur-framework'),
								'type'     => 'select',
								'options'  => G5P()->settings()->get_post_paging_mode(),
								'default'  => 'pagination'
							),
							array(
								'id'       => 'product_animation',
								'title'    => esc_html__('Animation', 'auteur-framework'),
								'subtitle' => esc_html__('Specify your product animation', 'auteur-framework'),
								'type'     => 'select',
								'options'  => G5P()->settings()->get_animation(),
								'default'  => 'none'
							),
							array(
								'id'       => 'product_image_hover_effect',
								'type'     => 'select',
								'title'    => esc_html__('Product Image Hover Effect', 'auteur-framework'),
								'subtitle' => esc_html__('Specify your product image hover effect', 'auteur-framework'),
								'desc'     => '',
								'options'  => G5P()->settings()->get_product_image_hover_effect(),
								'default'  => 'change-image'
							),
							array(
								'type'   => 'group',
								'id'     => 'section_woocommerce_group_customize',
								'title'  => esc_html__('Shop Above Customize', 'auteur-framework'),
								'fields' => array(
                                    array(
                                        'type'   => 'group',
                                        'id'     => 'section_woocommerce_group_customize_desktop',
                                        'title'  => esc_html__('Desktop Settings', 'auteur-framework'),
                                        'fields' => array(
                                            array(
                                                'id'      => 'woocommerce_customize',
                                                'title'   => esc_html__('Shop Above Customize Options', 'auteur-framework'),
                                                'type'    => 'sorter',
                                                'default' => array(
                                                    'Left'    => array(
                                                        'result-count' => esc_html__('Result Count', 'auteur-framework')
                                                    ),
                                                    'Right'   => array(
                                                        'ordering'      => esc_html__('Ordering', 'auteur-framework')
                                                    ),
                                                    'Disable' => array(
                                                        'cat-filter' => esc_html__('Category Filter', 'auteur-framework'),
                                                        'items-show' => esc_html__('Items Show', 'auteur-framework'),
                                                        'sidebar'    => esc_html__('Sidebar', 'auteur-framework'),
                                                        'switch-layout' => esc_html__('Switch Layout', 'auteur-framework'),
                                                        'filter'     => esc_html__('Filter', 'auteur-framework')
                                                    )
                                                ),
                                            ),
                                            $this->get_config_toggle(array(
                                                'id'       => 'woocommerce_customize_full_width',
                                                'title'    => esc_html__('Shop Above Customize Full Width', 'auteur-framework'),
                                                'default'  => ''
                                            )),
                                            array(
                                                'id'       => 'woocommerce_customize_padding',
                                                'title'    => esc_html__('Shop Above Customize Padding', 'auteur-framework'),
                                                'subtitle' => esc_html__('Set Shop Above Customize Padding', 'auteur-framework'),
                                                'type'     => 'spacing',
                                                'top'     => false,
                                                'bottom'    => false,
                                                'required' => array( 'woocommerce_customize_full_width', '=', 'on')
                                            ),
                                        )
                                    ),
                                    array(
                                        'type'   => 'group',
                                        'id'     => 'section_woocommerce_group_customize_mobile',
                                        'title'  => esc_html__('Mobile Settings', 'auteur-framework'),
                                        'fields' => array(
                                            array(
                                                'id'      => 'woocommerce_customize_mobile',
                                                'title'   => esc_html__('Shop Above Customize Options', 'auteur-framework'),
                                                'type'    => 'sorter',
                                                'default' => array(
                                                    'Left'    => array(
                                                        'ordering'      => esc_html__('Ordering', 'auteur-framework'),
                                                    ),
                                                    'Right'   => array(
                                                        'filter'     => esc_html__('Filter', 'auteur-framework')
                                                    ),
                                                    'Disable' => array(
                                                        'result-count' => esc_html__('Result Count', 'auteur-framework'),
                                                        'items-show' => esc_html__('Items Show', 'auteur-framework')
                                                    )
                                                ),
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'       => 'woocommerce_customize_filter_columns_group',
                                        'title'    => esc_html__('Filter Columns', 'auteur-framework'),
                                        'type'     => 'group',
                                        'required' => array(
                                            array(
                                                array('woocommerce_customize[Left]', 'contain', 'filter'),
                                                array('woocommerce_customize[Right]', 'contain', 'filter'),
                                                array('woocommerce_customize_mobile[Left]', 'contain', 'filter'),
                                                array('woocommerce_customize_mobile[Right]', 'contain', 'filter')
                                            )
                                        ),
                                        'fields'   => array(
                                            array(
                                                'id'     => 'filter_columns_row_1',
                                                'type'   => 'row',
                                                'col'    => 3,
                                                'fields' => array(
                                                    array(
                                                        'id'      => 'filter_columns',
                                                        'title'   => esc_html__('Large Devices', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your shop filter columns on large devices (>= 1200px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '4',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'filter_columns_md',
                                                        'title'   => esc_html__('Medium Devices', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your shop filter columns on medium devices (>= 992px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '3',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'filter_columns_sm',
                                                        'title'   => esc_html__('Small Devices', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your shop filter columns on small devices (>= 768px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'filter_columns_xs',
                                                        'title'   => esc_html__('Extra Small Devices ', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your shop filter columns on extra small devices (< 768px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id' => "filter_columns_mb",
                                                        'title' => esc_html__('Extra Extra Small Devices ', 'auteur-framework'),
                                                        'desc' => esc_html__('Specify your shop filter columns on extra extra small devices (< 576px)', 'auteur-framework'),
                                                        'type' => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '1',
                                                        'layout' => 'full',
                                                    )
                                                )
                                            )
                                        )
                                    ),
									array(
										'id'        => 'woocommerce_customize_item_show',
										'title'     => esc_html__('Products per page', 'auteur-framework'),
										'type'      => 'text',
										'default'   => '6,12,18',
										'sub_title' => esc_html__('Input products per page (exp: 6,12,18)', 'auteur-framework'),
										'required'  => array(
											array(
												array('woocommerce_customize[Left]', 'contain', 'items-show'),
												array('woocommerce_customize[Right]', 'contain', 'items-show')
											)
										)
									),
									$this->get_config_sidebar(array(
										'id'       => 'woocommerce_customize_sidebar',
										'required' => array(
											array(
												array('woocommerce_customize[Left]', 'contain', 'sidebar'),
												array('woocommerce_customize[Right]', 'contain', 'sidebar')
											)
										)
									))
								)
							),
							$this->get_config_toggle(array(
								'id'      => 'product_category_enable',
								'title'   => esc_html__('Show Category', 'auteur-framework'),
								'default' => ''
							)),
							$this->get_config_toggle(array(
								'id'      => 'product_rating_enable',
								'title'   => esc_html__('Show Rating', 'auteur-framework'),
								'default' => ''
							)),
							$this->get_config_toggle(array(
								'id'      => 'product_quick_view_enable',
								'title'   => esc_html__('Show Quick View', 'auteur-framework'),
								'default' => 'on'
							)),
							$this->get_config_toggle(array(
								'id'      => 'product_author_enable',
								'title'   => esc_html__('Show Author', 'auteur-framework'),
								'default' => 'on'
							))
						)
					),
					array(
						'id'     => 'section_woocommerce_group_single',
						'title'  => esc_html__('Single Product', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
                            array(
                                'id' => 'product_single_layout',
                                'title' => esc_html__('Layout','auteur-framework'),
                                'subtitle' => esc_html__('Specify your product single layout','auteur-framework'),
                                'type'     => 'image_set',
                                'options'  => G5P()->settings()->get_product_single_layout(),
                                'default'  => 'layout-01'
                            ),
							$this->get_config_toggle(array(
								'id'      => 'product_single_author_enable',
								'title'   => esc_html__('Show Author', 'auteur-framework'),
								'default' => 'on'
							)),
                            $this->get_config_toggle(array(
                                'id'       => 'product_single_swatches_enable',
                                'title'    => esc_html__('Swatches Enable', 'auteur-framework'),
                                'subtitle' => esc_html__('Enable Swatches on Single Product Page', 'auteur-framework'),
                                'default'  => 'on'
                            )),
							array(
								'id'     => 'product_related_group',
								'title'  => esc_html__('Product Related', 'auteur-framework'),
								'type'   => 'group',
								'fields' => array(
									$this->get_config_toggle(array(
										'id'      => 'product_related_enable',
										'title'   => esc_html__('Show Product related', 'auteur-framework'),
										'default' => 'on'
									)),
									array(
										'id'       => 'product_related_algorithm',
										'title'    => esc_html__('Related Products Algorithm', 'auteur-framework'),
										'subtitle' => esc_html__('Specify the algorithm of related products', 'auteur-framework'),
										'type'     => 'select',
										'options'  => G5P()->settings()->get_related_product_algorithm(),
										'default'  => 'cat-tag',
										'required' => array('product_related_enable', '=', 'on')
									),
									$this->get_config_toggle(array(
										'id'       => 'product_related_carousel_enable',
										'title'    => esc_html__('Carousel Mode', 'auteur-framework'),
										'subtitle' => esc_html__('Turn On this option if you want to enable carousel mode', 'auteur-framework'),
										'default'  => '',
										'required' => array('product_related_enable', '=', 'on')
									)),
									array(
										'id'       => 'product_related_columns_gutter',
										'title'    => esc_html__('Product Columns Gutter', 'auteur-framework'),
										'subtitle' => esc_html__('Specify your horizontal space between product.', 'auteur-framework'),
										'type'     => 'select',
                                        'options'  => array(
                                            'none' => esc_html__('None', 'auteur-framework'),
                                            '10' => '10px',
                                            '20' => '20px',
                                            '30' => '30px',
                                        ),
										'default'  => '30',
										'required' => array('product_related_enable', '=', 'on')
									),
									array(
										'id'       => 'product_related_columns_group',
										'title'    => esc_html__('Product Columns', 'auteur-framework'),
										'type'     => 'group',
										'required' => array('product_related_enable', '=', 'on'),
										'fields'   => array(
											array(
												'id'     => 'product_related_columns_row_1',
												'type'   => 'row',
												'col'    => 3,
												'fields' => array(
													array(
														'id'      => 'product_related_columns',
														'title'   => esc_html__('Large Devices', 'auteur-framework'),
														'desc'    => esc_html__('Specify your product related columns on large devices (>= 1200px)', 'auteur-framework'),
														'type'    => 'select',
														'options' => G5P()->settings()->get_post_columns(),
														'default' => '4',
														'layout'  => 'full',
													),
													array(
														'id'      => 'product_related_columns_md',
														'title'   => esc_html__('Medium Devices', 'auteur-framework'),
														'desc'    => esc_html__('Specify your product related columns on medium devices (>= 992px)', 'auteur-framework'),
														'type'    => 'select',
														'options' => G5P()->settings()->get_post_columns(),
														'default' => '2',
														'layout'  => 'full',
													),
													array(
														'id'      => 'product_related_columns_sm',
														'title'   => esc_html__('Small Devices', 'auteur-framework'),
														'desc'    => esc_html__('Specify your product related columns on small devices (>= 768px)', 'auteur-framework'),
														'type'    => 'select',
														'options' => G5P()->settings()->get_post_columns(),
														'default' => '2',
														'layout'  => 'full',
													),
													array(
														'id'      => 'product_related_columns_xs',
														'title'   => esc_html__('Extra Small Devices ', 'auteur-framework'),
														'desc'    => esc_html__('Specify your product related columns on extra small devices (< 768px)', 'auteur-framework'),
														'type'    => 'select',
														'options' => G5P()->settings()->get_post_columns(),
														'default' => '2',
														'layout'  => 'full',
													),
													array(
														'id'      => "product_related_columns_mb",
														'title'   => esc_html__('Extra Extra Small Devices ', 'auteur-framework'),
														'desc'    => esc_html__('Specify your product related columns on extra extra small devices (< 576px)', 'auteur-framework'),
														'type'    => 'select',
														'options' => G5P()->settings()->get_post_columns(),
														'default' => '1',
														'layout'  => 'full',
													)
												)
											),
										)
									),
									array(
										'id'         => 'product_related_per_page',
										'title'      => esc_html__('Products Per Page', 'auteur-framework'),
										'subtitle'   => esc_html__('Enter number of products per page you want to display. Default 6', 'auteur-framework'),
										'type'       => 'text',
										'input_type' => 'number',
										'default'    => '6',
										'required'   => array('product_related_enable', '=', 'on')
									),
									array(
										'id'       => 'product_related_animation',
										'title'    => esc_html__('Animation', 'auteur-framework'),
										'subtitle' => esc_html__('Specify your product animation', 'auteur-framework'),
										'type'     => 'select',
										'options'  => G5P()->settings()->get_animation(true),
										'default'  => '',
										'required' => array('product_related_enable', '=', 'on')
									),
								)
							),
							array(
								'id'     => 'product_up_sells_group',
								'title'  => esc_html__('Product Up Sells', 'auteur-framework'),
								'type'   => 'group',
								'fields' => array(
									$this->get_config_toggle(array(
										'id'      => 'product_up_sells_enable',
										'title'   => esc_html__('Show Product Up Sells', 'auteur-framework'),
										'default' => 'on'
									)),
									array(
										'id'       => 'product_up_sells_columns_gutter',
										'title'    => esc_html__('Product Columns Gutter', 'auteur-framework'),
										'subtitle' => esc_html__('Specify your horizontal space between product.', 'auteur-framework'),
										'type'     => 'select',
										'options'  => G5P()->settings()->get_post_columns_gutter(),
										'default'  => '30',
										'required' => array('product_up_sells_enable', '=', 'on')
									),
									array(
										'id'       => 'product_up_sells_columns_group',
										'title'    => esc_html__('Product Columns', 'auteur-framework'),
										'type'     => 'group',
										'required' => array('product_up_sells_enable', '=', 'on'),
										'fields'   => array(
											array(
												'id'     => 'product_related_columns_row_1',
												'type'   => 'row',
												'col'    => 3,
												'fields' => array(
													array(
														'id'      => 'product_up_sells_columns',
														'title'   => esc_html__('Large Devices', 'auteur-framework'),
														'desc'    => esc_html__('Specify your product up sells columns on large devices (>= 1200px)', 'auteur-framework'),
														'type'    => 'select',
														'options' => G5P()->settings()->get_post_columns(),
														'default' => '4',
														'layout'  => 'full',
													),
													array(
														'id'      => 'product_up_sells_columns_md',
														'title'   => esc_html__('Medium Devices', 'auteur-framework'),
														'desc'    => esc_html__('Specify your product up sells columns on medium devices (>= 992px)', 'auteur-framework'),
														'type'    => 'select',
														'options' => G5P()->settings()->get_post_columns(),
														'default' => '2',
														'layout'  => 'full',
													),
													array(
														'id'      => 'product_up_sells_columns_sm',
														'title'   => esc_html__('Small Devices', 'auteur-framework'),
														'desc'    => esc_html__('Specify your product up sells columns on small devices (>= 768px)', 'auteur-framework'),
														'type'    => 'select',
														'options' => G5P()->settings()->get_post_columns(),
														'default' => '2',
														'layout'  => 'full',
													),
													array(
														'id'      => 'product_up_sells_columns_xs',
														'title'   => esc_html__('Extra Small Devices ', 'auteur-framework'),
														'desc'    => esc_html__('Specify your product up sells columns on extra small devices (< 768px)', 'auteur-framework'),
														'type'    => 'select',
														'options' => G5P()->settings()->get_post_columns(),
														'default' => '2',
														'layout'  => 'full',
													),
													array(
														'id'      => "product_up_sells_columns_mb",
														'title'   => esc_html__('Extra Extra Small Devices ', 'auteur-framework'),
														'desc'    => esc_html__('Specify your product up sells columns on extra extra small devices (< 576px)', 'auteur-framework'),
														'type'    => 'select',
														'options' => G5P()->settings()->get_post_columns(),
														'default' => '1',
														'layout'  => 'full',
													)
												)
											),
										)
									),
									array(
										'id'         => 'product_up_sells_per_page',
										'title'      => esc_html__('Products Per Page', 'auteur-framework'),
										'subtitle'   => esc_html__('Enter number of products per page you want to display. Default 6', 'auteur-framework'),
										'type'       => 'text',
										'input_type' => 'number',
										'default'    => '6',
										'required'   => array('product_up_sells_enable', '=', 'on')
									),
									array(
										'id'       => 'product_up_sells_animation',
										'title'    => esc_html__('Animation', 'auteur-framework'),
										'subtitle' => esc_html__('Specify your product animation', 'auteur-framework'),
										'type'     => 'select',
										'options'  => G5P()->settings()->get_animation(true),
										'default'  => '',
										'required' => array('product_up_sells_enable', '=', 'on')
									),
								)
							)
						)
					),
					array(
						'id'     => 'product_cart_page_group',
						'title'  => esc_html__('Cart Page', 'auteur-framework'),
						'type'   => 'group',
						'fields' => array(
							$this->get_config_toggle(array(
								'id'      => 'product_cross_sells_enable',
								'title'   => esc_html__('Show Product Cross Sells', 'auteur-framework'),
								'default' => 'on'
							)),
							array(
								'id'       => 'product_cross_sells_columns_gutter',
								'title'    => esc_html__('Product Cross Sells Columns Gutter', 'auteur-framework'),
								'subtitle' => esc_html__('Specify your horizontal space between product.', 'auteur-framework'),
								'type'     => 'select',
								'options'  => G5P()->settings()->get_post_columns_gutter(),
								'default'  => '30',
								'required' => array('product_cross_sells_enable', '=', 'on')
							),
							array(
								'id'       => 'product_cross_sells_columns_group',
								'title'    => esc_html__('Product Cross Sells Columns', 'auteur-framework'),
								'type'     => 'group',
								'required' => array('product_cross_sells_enable', '=', 'on'),
								'fields'   => array(
									array(
										'id'     => 'product_related_columns_row_1',
										'type'   => 'row',
										'col'    => 3,
										'fields' => array(
											array(
												'id'      => 'product_cross_sells_columns',
												'title'   => esc_html__('Large Devices', 'auteur-framework'),
												'desc'    => esc_html__('Specify your product cross sells columns on large devices (>= 1200px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '4',
												'layout'  => 'full',
											),
											array(
												'id'      => 'product_cross_sells_columns_md',
												'title'   => esc_html__('Medium Devices', 'auteur-framework'),
												'desc'    => esc_html__('Specify your product cross sells columns on medium devices (>= 992px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '2',
												'layout'  => 'full',
											),
											array(
												'id'      => 'product_cross_sells_columns_sm',
												'title'   => esc_html__('Small Devices', 'auteur-framework'),
												'desc'    => esc_html__('Specify your product cross sells columns on small devices (>= 768px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '2',
												'layout'  => 'full',
											),
											array(
												'id'      => 'product_cross_sells_columns_xs',
												'title'   => esc_html__('Extra Small Devices ', 'auteur-framework'),
												'desc'    => esc_html__('Specify your product cross sells columns on extra small devices (< 768px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '2',
												'layout'  => 'full',
											),
											array(
												'id'      => "product_cross_sells_columns_mb",
												'title'   => esc_html__('Extra Extra Small Devices ', 'auteur-framework'),
												'desc'    => esc_html__('Specify your product cross sells columns on extra extra small devices (< 576px)', 'auteur-framework'),
												'type'    => 'select',
												'options' => G5P()->settings()->get_post_columns(),
												'default' => '1',
												'layout'  => 'full',
											)
										)
									),
								)
							),
							array(
								'id'         => 'product_cross_sells_per_page',
								'title'      => esc_html__('Cross Sells Products Per Page', 'auteur-framework'),
								'subtitle'   => esc_html__('Enter number of products per page you want to display. Default 6', 'auteur-framework'),
								'type'       => 'text',
								'input_type' => 'number',
								'default'    => '6',
								'required'   => array('product_cross_sells_enable', '=', 'on')
							),
							array(
								'id'       => 'product_cross_sells_animation',
								'title'    => esc_html__('Animation', 'auteur-framework'),
								'subtitle' => esc_html__('Specify your product animation', 'auteur-framework'),
								'type'     => 'select',
								'options'  => G5P()->settings()->get_animation(true),
								'default'  => '',
								'required' => array('product_cross_sells_enable', '=', 'on')
							),
						)
					)
				)
			);
		}

        /**
         * Get Woocommerce config
         */
        public function get_config_section_event()
        {
            return array(
                'id' => 'section_event',
                'title' => esc_html__('Event', 'auteur-framework'),
                'icon' => 'dashicons dashicons-calendar-alt',
                'general_options' => true,
                'fields' => array(
                    array(
                        'id' => 'section_event_group_general',
                        'title' => esc_html__('General', 'auteur-framework'),
                        'type' => 'group',
                        'fields' => array(
                            array(
                                'id'     => 'event_image_size_group',
                                'title'  => esc_html__('Event Image Size', 'auteur-framework'),
                                'type'   => 'group',
                                'fields' => array(
                                    array(
                                        'id'       => 'event_image_size',
                                        'title'    => esc_html__('Image size', 'auteur-framework'),
                                        'subtitle' => esc_html__('Enter your event image size', 'auteur-framework'),
                                        'desc'     => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'auteur-framework'),
                                        'type'     => 'text',
                                        'default'  => '555x300'
                                    ),
                                    array(
                                        'id'       => 'event_image_ratio',
                                        'title'    => esc_html__('Image ratio', 'auteur-framework'),
                                        'subtitle' => esc_html__('Specify your image event ratio', 'auteur-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_image_ratio(),
                                        'default'  => '1x1',
                                        'required' => array(
                                            array('event_image_size', 'in', array('full','large','medium','thumbnail') )
                                        )
                                    ),
                                    array(
                                        'id'       => 'event_image_ratio_custom',
                                        'title'    => esc_html__('Image ratio custom', 'auteur-framework'),
                                        'subtitle' => esc_html__('Enter custom image ratio', 'auteur-framework'),
                                        'type'     => 'dimension',
                                        'required' => array(
                                            array('event_image_size', 'in', array('full','large','medium','thumbnail') ),
                                            array('event_image_ratio', '=', 'custom')
                                        )
                                    )
                                )
                            ),

                            array(
                                'id'       => 'event_columns_gutter',
                                'title'    => esc_html__('Event Columns Gutter', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify your horizontal space between event.', 'auteur-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_post_columns_gutter(),
                                'default'  => '50'
                            ),
                            array(
                                'id'       => 'event_columns_group',
                                'title'    => esc_html__('Event Columns', 'auteur-framework'),
                                'type'     => 'group',
                                'fields'   => array(
                                    array(
                                        'id'     => 'event_columns_row_1',
                                        'type'   => 'row',
                                        'col'    => 3,
                                        'fields' => array(
                                            array(
                                                'id'      => 'event_columns',
                                                'title'   => esc_html__('Large Devices', 'auteur-framework'),
                                                'desc'    => esc_html__('Specify your event columns on large devices (>= 1200px)', 'auteur-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '2',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'event_columns_md',
                                                'title'   => esc_html__('Medium Devices', 'auteur-framework'),
                                                'desc'    => esc_html__('Specify your event columns on medium devices (>= 992px)', 'auteur-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '2',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'event_columns_sm',
                                                'title'   => esc_html__('Small Devices', 'auteur-framework'),
                                                'desc'    => esc_html__('Specify your event columns on small devices (>= 768px)', 'auteur-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '2',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'event_columns_xs',
                                                'title'   => esc_html__('Extra Small Devices ', 'auteur-framework'),
                                                'desc'    => esc_html__('Specify your event columns on extra small devices (< 768px)', 'auteur-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '2',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => "event_columns_mb",
                                                'title'   => esc_html__('Extra Extra Small Devices ', 'auteur-framework'),
                                                'desc'    => esc_html__('Specify your event columns on extra extra small devices (< 576px)', 'auteur-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '1',
                                                'layout'  => 'full',
                                            )
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id'       => 'event_per_page',
                                'title'    => esc_html__('Event Items Per Page', 'auteur-framework'),
                                'subtitle' => esc_html__('Controls the number of posts that display per page for event archive pages. Set to -1 to display all. Set to 0 to use the number of posts from Settings > Reading.', 'auteur-framework'),
                                'type'     => 'text',
                                'default'  => '9',
                            ),
                            array(
                                'id'       => 'event_animation',
                                'title'    => esc_html__('Animation', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify your event animation', 'auteur-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_animation(),
                                'default'  => 'none'
                            ),
                        )
                    )
                )
            );
        }
        /**
         * Get Portfolio config
         */
        public function get_config_section_portfolio()
        {
            return array(
                'id'              => 'section_portfolio',
                'title'           => esc_html__('Portfolios', 'auteur-framework'),
                'icon'            => 'dashicons dashicons-images-alt2',
                'general_options' => true,
                'fields'          => array(
                    array(
                        'id'     => 'section_portfolio_group_archive',
                        'title'  => esc_html__('Archive and Category', 'auteur-framework'),
                        'type'   => 'group',
                        'fields' => array(
                            array(
                                'id' => 'portfolio_cate_filter',
                                'title' => esc_html__('Category Filter', 'auteur-framework'),
                                'type' => 'button_set',
                                'options' => array(
                                    '' => esc_html__('Disable', 'auteur-framework'),
                                    'cate-filter-left' => esc_html__('Left', 'auteur-framework'),
                                    'cate-filter-center' => esc_html__('Center', 'auteur-framework'),
                                    'cate-filter-right' => esc_html__('Right', 'auteur-framework')
                                ),
                                'default'=> 'cate-filter-center'
                            ),
                            array(
                                'id'       => 'portfolio_layout',
                                'title'    => esc_html__('Layout', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify your portfolio layout', 'auteur-framework'),
                                'type'     => 'image_set',
                                'options'  => G5P()->settings()->get_portfolio_layout(),
                                'default'  => 'grid',
                                'preset'   => array(
                                    array(
                                        'op'     => '=',
                                        'value'  => 'grid',
                                        'fields' => array(
                                            array('portfolio_per_page', 9),
                                            array('portfolio_image_size', '553x420'),
                                            array('portfolio_columns_gutter', 30),
                                            array('portfolio_columns', 3),
                                            array('portfolio_columns_md', 3),
                                            array('portfolio_columns_sm', 2),
                                            array('portfolio_columns_xs', 2),
                                            array('portfolio_columns_xs', 1),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'masonry',
                                        'fields' => array(
                                            array('portfolio_per_page', 9),
                                            array('portfolio_image_width[width]', 480),
                                            array('portfolio_columns_gutter', 10),
                                            array('portfolio_columns', 3),
                                            array('portfolio_columns_md', 3),
                                            array('portfolio_columns_sm', 2),
                                            array('portfolio_columns_xs', 2),
                                            array('portfolio_columns_xs', 1),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'scattered',
                                        'fields' => array(
                                            array('portfolio_per_page', 8),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'justified',
                                        'fields' => array(
                                            array('portfolio_per_page', 10),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-1',
                                        'fields' => array(
                                            array('portfolio_per_page', 8),
                                            array('portfolio_columns_gutter', 20),
                                            array('portfolio_image_size', '480x480'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-2',
                                        'fields' => array(
                                            array('portfolio_per_page', 8),
                                            array('portfolio_columns_gutter', 20),
                                            array('portfolio_image_size', '480x480'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-3',
                                        'fields' => array(
                                            array('portfolio_per_page', 10),
                                            array('portfolio_columns_gutter', 20),
                                            array('portfolio_image_size', '480x480'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-4',
                                        'fields' => array(
                                            array('portfolio_per_page', 8),
                                            array('portfolio_columns_gutter', 'none'),
                                            array('portfolio_image_size', '480x480'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-5',
                                        'fields' => array(
                                            array('portfolio_per_page', 8),
                                            array('portfolio_columns_gutter', 'none'),
                                            array('portfolio_image_size', '480x480'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-6',
                                        'fields' => array(
                                            array('portfolio_per_page', 7),
                                            array('portfolio_columns_gutter', '30'),
                                            array('portfolio_image_size', '480x480'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'metro-7',
                                        'fields' => array(
                                            array('portfolio_per_page', 5),
                                            array('portfolio_columns_gutter', '30'),
                                            array('portfolio_image_size', '480x480'),
                                        )
                                    ),
                                    array(
                                        'op'     => '=',
                                        'value'  => 'carousel-3d',
                                        'fields' => array(
                                            array('portfolio_per_page', 9),
                                            array('portfolio_image_size', '804x468'),
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id'       => 'portfolio_item_skin',
                                'title'    => esc_html__('Portfolio Item Skin', 'auteur-framework'),
                                'type'     => 'image_set',
                                'options'  => G5P()->settings()->get_portfolio_item_skin(),
                                'desc'     => esc_html__('Note: Skin 01, Skin 02 only apply for Grid Layout and Masonry Layout', 'auteur-framework'),
                                'default'  => 'portfolio-item-skin-01'
                            ),
                            array(
                                'id'     => 'portfolio_image_size_group',
                                'title'  => esc_html__('Portfolio Image Size', 'auteur-framework'),
                                'type'   => 'group',
                                'fields' => array(
                                    array(
                                        'id'       => 'portfolio_image_size',
                                        'title'    => esc_html__('Image size', 'auteur-framework'),
                                        'subtitle' => esc_html__('Enter your portfolio image size', 'auteur-framework'),
                                        'desc'     => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'auteur-framework'),
                                        'type'     => 'text',
                                        'default'  => '553x420',
                                        'required' => array('portfolio_layout', 'not in', array('masonry', 'scattered','justified'))
                                    ),
                                    array(
                                        'id'       => 'portfolio_row_height',
                                        'title'    => esc_html__('Row Height', 'auteur-framework'),
                                        'subtitle' => esc_html__('Enter your portfolio row height', 'auteur-framework'),
                                        'type'     => 'dimension',
                                        'width'   => false,
                                        'default'  => array(
                                            'height' => '375'
                                        ),
                                        'required' => array('portfolio_layout', 'in', array('justified'))
                                    ),
                                    array(
                                        'id'       => 'portfolio_row_max_height',
                                        'title'    => esc_html__('Row Max Height', 'auteur-framework'),
                                        'subtitle' => esc_html__('Enter your portfolio row max height', 'auteur-framework'),
                                        'type'     => 'dimension',
                                        'width'   => false,
                                        'required' => array('portfolio_layout', 'in', array('justified'))
                                    ),
                                    array(
                                        'id'       => 'portfolio_image_ratio',
                                        'title'    => esc_html__('Image ratio', 'auteur-framework'),
                                        'subtitle' => esc_html__('Specify your image portfolio ratio', 'auteur-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_image_ratio(),
                                        'default'  => '1x1',
                                        'required' => array(
                                            array('portfolio_layout', 'not in', array('masonry', 'scattered')),
                                            array('portfolio_image_size', 'in', array('full','large','medium','thumbnail') )
                                        )
                                    ),
                                    array(
                                        'id'       => 'portfolio_image_ratio_custom',
                                        'title'    => esc_html__('Image ratio custom', 'auteur-framework'),
                                        'subtitle' => esc_html__('Enter custom image ratio', 'auteur-framework'),
                                        'type'     => 'dimension',
                                        'required' => array(
                                            array('portfolio_layout', 'not in', array('masonry', 'scattered')),
                                            array('portfolio_image_size', 'in', array('full','large','medium','thumbnail') ),
                                            array('portfolio_image_ratio', '=', 'custom')
                                        )
                                    ),
                                    array(
                                        'id'       => 'portfolio_image_width',
                                        'title'    => esc_html__('Image Width', 'auteur-framework'),
                                        'subtitle' => esc_html__('Enter image width', 'auteur-framework'),
                                        'type'     => 'dimension',
                                        'height'   => false,
                                        'default'  => array(
                                            'width' => '480'
                                        ),
                                        'required' => array('portfolio_layout', 'in', array('masonry'))
                                    )
                                )
                            ),

                            array(
                                'id'       => 'portfolio_columns_gutter',
                                'title'    => esc_html__('Portfolio Columns Gutter', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify your horizontal space between portfolio.', 'auteur-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_post_columns_gutter(),
                                'default'  => '30',
                                'required' => array('portfolio_layout', 'not in', array('scattered', 'carousel-3d'))
                            ),
                            array(
                                'id'       => 'portfolio_columns_group',
                                'title'    => esc_html__('Portfolio Columns', 'auteur-framework'),
                                'type'     => 'group',
                                'required' => array('portfolio_layout', 'in', array('grid', 'masonry')),
                                'fields'   => array(
                                    array(
                                        'id'     => 'portfolio_columns_row_1',
                                        'type'   => 'row',
                                        'col'    => 3,
                                        'fields' => array(
                                            array(
                                                'id'      => 'portfolio_columns',
                                                'title'   => esc_html__('Large Devices', 'auteur-framework'),
                                                'desc'    => esc_html__('Specify your portfolio columns on large devices (>= 1200px)', 'auteur-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '3',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'portfolio_columns_md',
                                                'title'   => esc_html__('Medium Devices', 'auteur-framework'),
                                                'desc'    => esc_html__('Specify your portfolio columns on medium devices (>= 992px)', 'auteur-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '3',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'portfolio_columns_sm',
                                                'title'   => esc_html__('Small Devices', 'auteur-framework'),
                                                'desc'    => esc_html__('Specify your portfolio columns on small devices (>= 768px)', 'auteur-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '2',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => 'portfolio_columns_xs',
                                                'title'   => esc_html__('Extra Small Devices ', 'auteur-framework'),
                                                'desc'    => esc_html__('Specify your portfolio columns on extra small devices (< 768px)', 'auteur-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '2',
                                                'layout'  => 'full',
                                            ),
                                            array(
                                                'id'      => "portfolio_columns_mb",
                                                'title'   => esc_html__('Extra Extra Small Devices ', 'auteur-framework'),
                                                'desc'    => esc_html__('Specify your portfolio columns on extra extra small devices (< 576px)', 'auteur-framework'),
                                                'type'    => 'select',
                                                'options' => G5P()->settings()->get_post_columns(),
                                                'default' => '1',
                                                'layout'  => 'full',
                                            )
                                        )
                                    ),
                                )
                            ),
                            array(
                                'id'       => 'portfolio_per_page',
                                'title'    => esc_html__('Portfolio Items Per Page', 'auteur-framework'),
                                'subtitle' => esc_html__('Controls the number of posts that display per page for portfolio archive pages. Set to -1 to display all. Set to 0 to use the number of posts from Settings > Reading.', 'auteur-framework'),
                                'type'     => 'text',
                                'default'  => '9',
                            ),
                            array(
                                'id'       => 'portfolio_paging',
                                'title'    => esc_html__('Portfolio Paging', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify your portfolio paging mode', 'auteur-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_post_paging_mode(),
                                'default'  => 'load-more'
                            ),
                            array(
                                'id'       => 'portfolio_animation',
                                'title'    => esc_html__('Animation', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify your portfolio animation', 'auteur-framework'),
                                'type'     => 'select',
                                'options'  => G5P()->settings()->get_animation(),
                                'default'  => 'none'
                            ),
                            array(
                                'id'       => 'portfolio_light_box',
                                'type'     => 'select',
                                'title'    => esc_html__('Light Box', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify your portfolio light box', 'auteur-framework'),
                                'options'  => array(
                                    'feature' => esc_html__('Feature Image', 'auteur-framework'),
                                    'media'   => esc_html__('Media Gallery', 'auteur-framework')
                                ),
                                'default'  => 'feature'
                            )
                        )
                    ),
                    array(
                        'id'     => 'section_portfolio_group_details',
                        'title'  => esc_html__('Portfolio Details', 'auteur-framework'),
                        'type'   => 'group',
                        'fields' => array(
                            array(
                                'id'             => 'single_portfolio_details',
                                'title'          => esc_html__('Portfolio Details', 'auteur-framework'),
                                'desc'           => esc_html__('Define here all the portfolio details you will need.', 'auteur-framework'),
                                'type'           => 'panel',
                                'toggle_default' => false,
                                'sort'           => true,
                                'default'        => G5P()->settings()->get_portfolio_details_default(),
                                'panel_title'    => 'title',
                                'fields'         => array(
                                    array(
                                        'id'       => 'title',
                                        'title'    => esc_html__('Title', 'auteur-framework'),
                                        'subtitle' => esc_html__('Enter your portfolio details title', 'auteur-framework'),
                                        'type'     => 'text',
                                    ),
                                    array(
                                        'id'         => 'id',
                                        'title'      => esc_html__('Unique portfolio details Id', 'auteur-framework'),
                                        'subtitle'   => esc_html__('This value is created automatically and it shouldn\'t be edited unless you know what you are doing.', 'auteur-framework'),
                                        'type'       => 'text',
                                        'input_type' => 'unique_id',
                                        'default'    => 'portfolio_details_'
                                    ),
                                )
                            ),
                        )
                    ),
                    array(
                        'id'     => 'section_portfolio_group_single',
                        'title'  => esc_html__('Single Portfolio', 'auteur-framework'),
                        'type'   => 'group',
                        'fields' => array(
                            array(
                                'id'       => 'single_portfolio_layout',
                                'title'    => esc_html__('Layout', 'auteur-framework'),
                                'subtitle' => esc_html__('Specify your single portfolio layout', 'auteur-framework'),
                                'type'     => 'image_set',
                                'options'  => G5P()->settings()->get_single_portfolio_layout(),
                                'default'  => 'layout-1'
                            ),
                            array(
                                'id'       => 'single_portfolio_gallery_group',
                                'title'    => esc_html__('Gallery', 'auteur-framework'),
                                'type'     => 'group',
                                'required' => array('single_portfolio_layout', '!=', 'layout-5'),
                                'fields'   => array(
                                    array(
                                        'id'       => 'single_portfolio_gallery_layout',
                                        'title'    => esc_html__('Layout', 'auteur-framework'),
                                        'subtitle' => esc_html__('Specify your single portfolio gallery layout', 'auteur-framework'),
                                        'type'     => 'image_set',
                                        'options'  => G5P()->settings()->get_single_portfolio_gallery_layout(),
                                        'default'  => 'carousel',
                                        'preset' => array(
                                            array(
                                                'op'     => '=',
                                                'value'  => 'carousel',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', 'full'),
                                                    array('single_portfolio_gallery_image_ratio', '4x3'),
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'thumbnail',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', 'full'),
                                                    array('single_portfolio_gallery_image_ratio', '4x3'),
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'carousel-center',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', 'full'),
                                                    array('single_portfolio_gallery_image_ratio', '4x3'),
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'grid',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', 'medium')
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'carousel-3d',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', '804x468')
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'metro-1',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', '370x370')
                                                )
                                            ),
                                            array(
                                                'op'     => '=',
                                                'value'  => 'metro-2',
                                                'fields' => array(
                                                    array('single_portfolio_gallery_image_size', '570x420')
                                                )
                                            )

                                        )
                                    ),
                                    array(
                                        'id'     => 'single_portfolio_gallery_image_size_group',
                                        'title'  => esc_html__('Image Size', 'auteur-framework'),
                                        'type'   => 'group',
                                        'fields' => array(
                                            array(
                                                'id'       => 'single_portfolio_gallery_image_size',
                                                'title'    => esc_html__('Image size', 'auteur-framework'),
                                                'subtitle' => esc_html__('Enter your portfolio gallery image size', 'auteur-framework'),
                                                'desc'     => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'auteur-framework'),
                                                'type'     => 'text',
                                                'default'  => 'medium'
                                            ),
                                            array(
                                                'id'       => 'single_portfolio_gallery_image_ratio',
                                                'title'    => esc_html__('Image ratio', 'auteur-framework'),
                                                'subtitle' => esc_html__('Specify your image portfolio gallery ratio', 'auteur-framework'),
                                                'type'     => 'select',
                                                'options'  => G5P()->settings()->get_image_ratio(),
                                                'default'  => '1x1',
                                                'required' => array(
                                                    array('single_portfolio_gallery_image_size', '=', 'full')
                                                )
                                            ),
                                            array(
                                                'id'       => 'single_portfolio_gallery_image_ratio_custom',
                                                'title'    => esc_html__('Image ratio custom', 'auteur-framework'),
                                                'subtitle' => esc_html__('Enter custom image ratio', 'auteur-framework'),
                                                'type'     => 'dimension',
                                                'required' => array(
                                                    array('single_portfolio_gallery_image_size', '=', 'full'),
                                                    array('single_portfolio_gallery_image_ratio', '=', 'custom')
                                                )
                                            )
                                        )
                                    ),
                                    array(
                                        'id'       => 'single_portfolio_gallery_columns_gutter',
                                        'title'    => esc_html__('Portfolio Gallery Columns Gutter', 'auteur-framework'),
                                        'subtitle' => esc_html__('Specify your horizontal space between portfolio gallery.', 'auteur-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_post_columns_gutter(),
                                        'default'  => '10',
                                        'required' => array('single_portfolio_gallery_layout', 'not in', array('thumbnail', 'carousel-3d'))
                                    ),
                                    array(
                                        'id'       => 'single_portfolio_gallery_columns_group',
                                        'title'    => esc_html__('Portfolio Gallery Columns', 'auteur-framework'),
                                        'type'     => 'group',
                                        'required' => array('single_portfolio_gallery_layout', 'not in', array('thumbnail', 'carousel-3d', 'metro-1','metro-2')),
                                        'fields'   => array(
                                            array(
                                                'id'     => 'single_portfolio_gallery_columns_row_1',
                                                'type'   => 'row',
                                                'col'    => 3,
                                                'fields' => array(
                                                    array(
                                                        'id'      => 'single_portfolio_gallery_columns',
                                                        'title'   => esc_html__('Large Devices', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio gallery columns on large devices (>= 1200px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '3',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_gallery_columns_md',
                                                        'title'   => esc_html__('Medium Devices', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio gallery columns on medium devices (>= 992px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '3',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_gallery_columns_sm',
                                                        'title'   => esc_html__('Small Devices', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio gallery columns on small devices (>= 768px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_gallery_columns_xs',
                                                        'title'   => esc_html__('Extra Small Devices ', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio gallery columns on extra small devices (< 768px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_gallery_columns_mb',
                                                        'title'   => esc_html__('Extra Extra Small Devices ', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio gallery columns on extra extra small devices (< 576px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '1',
                                                        'layout'  => 'full',
                                                    )
                                                )
                                            ),
                                        )
                                    ),

                                )

                            ),
                            array(
                                'id' => 'single_portfolio_related_group',
                                'title' => esc_html__('Portfolio Related','auteur-framework'),
                                'type' => 'group',
                                'fields' => array(
                                    $this->get_config_toggle(array(
                                        'id' => 'single_portfolio_related_enable',
                                        'title' => esc_html__('Portfolio Related Enable','auteur-framework'),
                                        'default' => 'on',
                                        'subtitle' => esc_html__('Turn Off this option if you want to hide related portfolio area on single portfolio','auteur-framework')
                                    )),
                                    $this->get_config_toggle(array(
                                        'id' => 'single_portfolio_related_full_width_enable',
                                        'title' => esc_html__('Project Related Full Width','auteur-framework'),
                                        'default' => '',
                                        'subtitle' => esc_html__('Turn on this option if you want to project relate display full width','auteur-framework')
                                    )),
                                    array(
                                        'id'       => 'single_portfolio_related_algorithm',
                                        'title'    => esc_html__('Related Portfolio Algorithm', 'auteur-framework'),
                                        'subtitle' => esc_html__('Specify the algorithm of related portfolio', 'auteur-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_portfolio_related_algorithm(),
                                        'default'  => 'cat',
                                        'required' => array('single_portfolio_related_enable', '=', 'on')
                                    ),
                                    $this->get_config_toggle(array(
                                        'id'       => 'single_portfolio_related_carousel_enable',
                                        'title'    => esc_html__('Carousel Mode', 'auteur-framework'),
                                        'subtitle' => esc_html__('Turn Off this option if you want to disable carousel mode', 'auteur-framework'),
                                        'default'  => 'on',
                                        'required' => array('single_portfolio_related_enable', '=', 'on')
                                    )),
                                    array(
                                        'id'         => 'single_portfolio_related_per_page',
                                        'title'      => esc_html__('Posts Per Page', 'auteur-framework'),
                                        'subtitle'   => esc_html__('Enter number of posts per page you want to display', 'auteur-framework'),
                                        'type'       => 'text',
                                        'input_type' => 'number',
                                        'default'    => 6,
                                        'required'   => array('single_portfolio_related_enable', '=', 'on')
                                    ),
                                    array(
                                        'id'     => 'single_portfolio_related_image_size_group',
                                        'title'  => esc_html__('Portfolio Related Image Size', 'auteur-framework'),
                                        'type'   => 'group',
                                        'required' => array('single_portfolio_related_enable', '=', 'on'),
                                        'fields' => array(
                                            array(
                                                'id'       => 'single_portfolio_related_image_size',
                                                'title'    => esc_html__('Image size', 'auteur-framework'),
                                                'subtitle' => esc_html__('Enter your portfolio related image size', 'auteur-framework'),
                                                'desc'     => esc_html__('Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'auteur-framework'),
                                                'type'     => 'text',
                                                'default'  => 'medium',
                                            ),
                                            array(
                                                'id'       => 'single_portfolio_related_image_ratio',
                                                'title'    => esc_html__('Image ratio', 'auteur-framework'),
                                                'subtitle' => esc_html__('Specify your image portfolio related ratio', 'auteur-framework'),
                                                'type'     => 'select',
                                                'options'  => G5P()->settings()->get_image_ratio(),
                                                'default'  => '1x1',
                                                'required' => array('single_portfolio_related_image_size', '=', 'full')
                                            ),
                                            array(
                                                'id'       => 'single_portfolio_related_image_ratio_custom',
                                                'title'    => esc_html__('Image ratio custom', 'auteur-framework'),
                                                'subtitle' => esc_html__('Enter custom image ratio', 'auteur-framework'),
                                                'type'     => 'dimension',
                                                'required' => array(
                                                    array('single_portfolio_related_image_size', '=', 'full'),
                                                    array('single_portfolio_related_image_ratio', '=', 'custom')
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'       => 'single_portfolio_related_columns_gutter',
                                        'title'    => esc_html__('Portfolio Related Columns Gutter', 'auteur-framework'),
                                        'subtitle' => esc_html__('Specify your horizontal space between portfolio related.', 'auteur-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_post_columns_gutter(),
                                        'default'  => '30',
                                        'required' => array('single_portfolio_related_enable', '=', 'on')
                                    ),
                                    array(
                                        'id'       => 'single_portfolio_related_columns_group',
                                        'title'    => esc_html__('Portfolio Related Columns', 'auteur-framework'),
                                        'type'     => 'group',
                                        'required' => array('single_portfolio_related_enable', '=', 'on'),
                                        'fields'   => array(
                                            array(
                                                'id'     => 'single_portfolio_related_columns_row_1',
                                                'type'   => 'row',
                                                'col'    => 3,
                                                'fields' => array(
                                                    array(
                                                        'id'      => 'single_portfolio_related_columns',
                                                        'title'   => esc_html__('Large Devices', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio related columns on large devices (>= 1200px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '3',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_related_columns_md',
                                                        'title'   => esc_html__('Medium Devices', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio related columns on medium devices (>= 992px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '3',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_related_columns_sm',
                                                        'title'   => esc_html__('Small Devices', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio related columns on small devices (>= 768px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_related_columns_xs',
                                                        'title'   => esc_html__('Extra Small Devices ', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio related columns on extra small devices (< 768px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '2',
                                                        'layout'  => 'full',
                                                    ),
                                                    array(
                                                        'id'      => 'single_portfolio_related_columns_mb',
                                                        'title'   => esc_html__('Extra Extra Small Devices ', 'auteur-framework'),
                                                        'desc'    => esc_html__('Specify your portfolio related columns on extra extra small devices (< 576px)', 'auteur-framework'),
                                                        'type'    => 'select',
                                                        'options' => G5P()->settings()->get_post_columns(),
                                                        'default' => '1',
                                                        'layout'  => 'full',
                                                    )
                                                )
                                            ),
                                        )
                                    ),
                                    array(
                                        'id'       => 'single_portfolio_related_post_paging',
                                        'title'    => esc_html__('Post Paging', 'auteur-framework'),
                                        'subtitle' => esc_html__('Specify your post paging mode', 'auteur-framework'),
                                        'type'     => 'select',
                                        'options'  => G5P()->settings()->get_post_paging_small_mode(),
                                        'default'  => 'none',
                                        'required' => array(
                                            array('single_portfolio_related_carousel_enable', '!=' ,'on'),
                                            array('single_portfolio_related_enable', '=', 'on')
                                        )
                                    )
                                )
                            )

                        )
                    )
                )
            );
        }
	}
}