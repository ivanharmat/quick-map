<?php 

require_once(QMAPS_PLUGIN_DIR.'/quick-maps.php');

class Quick_Maps_Widget extends WP_Widget {

	private $quickmaps;

	// class constructor
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'quick_maps_widget',
			'description' => 'Quickly integrate google maps to your page',
		);
		parent::__construct( 'quick_maps_widget', 'Quick Maps', $widget_ops );

		$this->quickmaps = new Quick_Maps();
	}
	
	// output the widget content on the front-end
	public function widget( $args, $instance ) {
		if ( isset( $instance['address']) && !empty($instance['address'])) {
			$address = $instance['address'];
		} else {
			$address = apply_filters( 'quickmaps_default_address', $this->quickmaps::get_default_place());
		}
		if ( isset( $instance['height'] ) && preg_match( '/^[0-9]+(%|px)$/', $instance['height'] ) ) {
			$height = $instance['height'];
		} else {
			$height = apply_filters( 'quickmaps_default_height', $this->quickmaps::get_default_height());
		}
		if ( isset( $instance['width'] ) && preg_match( '/^[0-9]+(%|px)$/', $instance['width'] ) ) {
			$width = $instance['width'];
		} else {
			$width = apply_filters( 'quickmaps_default_width', $this->quickmaps::get_default_width());
		}
		echo sprintf('<iframe src="//www.google.com/maps?q=%1$s&amp;output=embed" frameborder="0" width="%2$s" height="%3$s" data-quickmaps="%4$s" class="quickmaps"></iframe>', esc_html( trim( $address)), esc_attr( $width ), esc_attr( $height ), QMAPS_VERSION);

	}

	// output the option form field in admin Widgets screen
	public function form( $instance ) {
		$default_height = $this->quickmaps::get_default_height();
		$default_width = $this->quickmaps::get_default_width();
		$default_address = $this->quickmaps::get_default_place();

		$height = !empty( $instance['height'] ) ? $instance['height'] : esc_html__( $default_height, 'text_domain' );
		$width = !empty( $instance['width'] ) ? $instance['width'] : esc_html__( $default_width, 'text_domain' );
		$address = !empty( $instance['address'] ) ? $instance['address'] : esc_html__( $default_address, 'text_domain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>">
		<?php esc_attr_e( 'Address:', 'text_domain' ); ?>
		</label> 
		
		<input 
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $address ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>">
		<?php esc_attr_e( 'Height:', 'text_domain' ); ?>
		</label> 
		<input 
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $height ); ?>">
		</p>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>">
		<?php esc_attr_e( 'Height:', 'text_domain' ); ?>
		</label> 
		<input 
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $width ); ?>">
		</p>

		<?php

	}

	// save options
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['height'] = ( ! empty( $new_instance['height'] ) ) ? strip_tags( $new_instance['height'] ) : '';
		$instance['width'] = ( ! empty( $new_instance['width'] ) ) ? strip_tags( $new_instance['width'] ) : '';
		$instance['address'] = ( ! empty( $new_instance['address'] ) ) ? strip_tags( $new_instance['address'] ) : '';

		return $instance;
	}
}