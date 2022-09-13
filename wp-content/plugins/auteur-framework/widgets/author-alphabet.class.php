<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'G5P_Widget_Author_Alphabet' ) ) {
	class G5P_Widget_Author_Alphabet extends GSF_Widget {
		public function __construct() {
			$this->widget_cssclass = 'widget-author-alphabet';
			$this->widget_id       = 'gsf-author-alphabet';
			$this->widget_name     = esc_html__( 'G5Plus: Author Alphabet', 'auteur-framework' );

			$this->settings = array(
				'fields' => array(
					array(
						'id'      => 'title',
						'type'    => 'text',
						'default' => '',
						'title'   => esc_html__( 'Title:', 'auteur-framework' )
					),

					array(
						'id'      => 'show_all',
						'type'    => 'switch',
						'default' => 'on',
						'title'   => esc_html__( 'Show "All"?', 'auteur-framework' )
					),

					array(
						'id'      => 'filter_type',
						'title'   => esc_html__( 'Filter Type', 'auteur-framework' ),
						'type'    => 'select',
						'options' => array(
							'first-name' => esc_html__( 'First Name', 'auteur-framework' ),
							'last-name'  => esc_html__( 'Last Name', 'auteur-framework' ),
						),
						'default' => 'first-name'
					)
				)
			);

			parent::__construct();
		}

		public function widget( $args, $instance ) {
			extract( $args, EXTR_SKIP );
			$wrapper_classes = array(
				'widget-author-alphabet-content'
			);

			$title       = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
			$show_all    = ( isset( $instance['show_all'] ) ) ? $instance['show_all'] : 'on';
			$filter_type = ( ! empty( $instance['filter_type'] ) ) ? $instance['filter_type'] : 'first-name';
			$title       = apply_filters( 'widget_title', $title, $instance, $this->id_base );

			echo wp_kses_post( $args['before_widget'] );
			if ( $title ) {
				echo wp_kses_post( $args['before_title'] . $title . $args['after_title'] );
			}
			$wrapper_class = implode( ' ', array_filter( $wrapper_classes ) );
			$data_option   = array(
				'filterType' => esc_attr( $filter_type ),
			);
			if ( $show_all == 'on' ) {
				$data_option['showAll'] = 'on';
			}
			$authorsAttr = wp_json_encode( $data_option );
			?>
            <div class="<?php echo esc_attr( $wrapper_class ) ?>" data-options="<?php echo esc_attr( $authorsAttr ) ?>">
                <ul class="gf-author-alphabet">
                </ul>
            </div>
			<?php
			echo wp_kses_post( $args['after_widget'] );
		}
	}
}