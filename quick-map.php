<?php
/**
 * Plugin Name: Quick Map
 * Author: Ivan Harmat / Renzo Johnson
 * Plugin URI: https://github.com/ivanharmat/quick-map
 * Description: The easiest google map integration for your website.
 * Version: 1.0.0
 * Author URI: https://renzojohnson.com/
 * Text Domain: quick-map
 * Domain Path: /languages
 * @package Quick Map
 */

$quickmap = new Quick_Map();

/**
 * Class Quick_Map
 */
class Quick_Map {

	private $shortcode_tag   = 'quick-map';

	private $default_width   = '100%';

	private $default_height  = '300px';

	private $default_content = 'Orlando, FL';

	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		add_shortcode( $this->get_quick_shortcode_tag(), array( $this, 'quick_shortcode' ) );
	}

	private function get_quick_shortcode_tag() {
		return apply_filters( 'quickmap_shortcode_tag', $this->shortcode_tag );
	}

	/**
	 * Generate iframe code.
	 * @param array $args.
	 * @param null  $content Content inside the tags.
	 * @return string
	 */
	public function quick_shortcode($args, $content = null ) {
		if ( isset( $args['width'] ) && preg_match( '/^[0-9]+(%|px)$/', $args['width'] ) ) {
			$w = $args['width'];
		} else {
			$w = apply_filters( 'quickmap_default_width', $this->default_width );
		}
		if ( isset( $args['height'] ) && preg_match( '/^[0-9]+(%|px)$/', $args['height'] ) ) {
			$h = $args['height'];
		} else {
			$h = apply_filters( 'quickmap_default_height', $this->default_height );
		}
		if(is_null($content) || empty($content) || !$content) {
			$content = apply_filters( 'quickmap_default_content', $this->default_content);
		}
		return sprintf('<iframe src="//www.google.com/maps?q=%1$s&amp;output=embed" frameborder="0" width="%2$s" height="%3$s"></iframe>', esc_html( trim( $content)), esc_attr( $w ), esc_attr( $h ));
	}
}