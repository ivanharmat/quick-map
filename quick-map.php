<?php
/**
 * Plugin Name: Quick Map
 * Author: Ivan Harmat / Renzo Johnson
 * Plugin URI: https://github.com/ivanharmat/quick-map
 * Description: The easiest google map integration to your website.
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

	/**
	 * Shortcode tag name.
	 * @var string
	 */
	private $shortcode_tag  = 'quick-map';

	/**
	 * Default class name.
	 * @var string
	 */
	private $class_name     = 'quickmap';

	/**
	 * Quick_Map constructor.
	 */
	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Init function.
	 */
	public function init() {
		// add_action( 'wp_head', array( $this, 'wp_head' ) );
		add_shortcode( $this->get_shortcode_tag(), array( $this, 'quick_shortcode' ) );
	}

	/**
	 * Get shortcode tag.
	 *
	 * @return mixed
	 */
	private function get_shortcode_tag() {

		return apply_filters( 'quickmap_shortcode_tag', $this->shortcode_tag );
	}

	/**
	 * Output tags at footer.
	 * @param array $p Width,height,zoom.
	 * @param null  $content Content.
	 * @return string
	 */
	public function quick_shortcode($p, $content = null ) {
		return sprintf('<iframe src="https://www.google.com/maps?q=%1$s&amp;output=embed&amp;title=" ivan""="" height="200" frameborder="0" style="border:0"></iframe>', esc_html( trim( $content)));
	}
}