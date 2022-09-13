<?php
/**
 * Class Ajax
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if ( ! class_exists( 'Bpfw_Admin' ) ) {
	class Bpfw_Admin {
		private static $_instance;

		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function init() {
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes_bpfw' ), 25 );
		}

		public function add_meta_boxes_bpfw() {

			add_meta_box( 'bpfw-product-back-images', esc_html__( 'Product Back Image', 'bpfw' ), array(
				$this,
				'product_back_image_field_template'
			), 'product', 'side', 'low' );
		}

		/**
		 * @param $post WP_Post
		 */
		public function product_back_image_field_template( $post ) {
			BPFW()->get_plugin_template( 'admin/templates/back-image-field.php', array(
				'post' => $post
			) );
		}
	}
}