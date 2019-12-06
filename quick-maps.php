<?php
/**
 * Plugin Name: Quick Maps
 * Plugin URI: https://quickmaps.io
 * Description: The easiest google map integration for your website [quick-maps]Orlando, Florida[/quick-maps] - No Google API required.
 * Author: quickmaps
 * Author URI: https://quickmaps.io
 * Text Domain: quick-maps
 * Domain Path: /languages
 * Version: 1.0.4
 * @package Quick Maps
 */

// require settings file
require_once(dirname( __FILE__ ).'/settings.php');

// require all other php librady files
$all_library_php_files = glob(QMAPS_PLUGIN_DIR.'/lib/*.php');
foreach($all_library_php_files as $php_file) {
	require_once($php_file);
}

$quickmaps = new Quick_Maps();

/**
 * Class Quick_Map
 */
class Quick_Maps {

	private $shortcode_tag   = 'quick-maps';

	public static $default_width   = '100%';

	public static $default_height  = '300px';

	public static $default_content = 'Orlando International Airport, Jeff Fuqua Boulevard, Orlando, FL';

	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'widgets_init', function(){
			register_widget('Quick_Maps_Widget');
		});
	}

	public function init() {
		add_shortcode( $this->get_quick_shortcode_tag(), [$this, 'quick_shortcode']);
	}

	private function get_quick_shortcode_tag() {
		return apply_filters( 'quickmaps_shortcode_tag', $this->shortcode_tag );
	}

	/**
	 * Generate iframe code.
	 * @param array $args.
	 * @param null  $content Content inside the tags.
	 * @return string
	 */
	public function quick_shortcode($args, $content = null ) {
		if ( isset( $args['width'] ) && (preg_match('/^[0-9]+(%|px)$/', $args['width']) || is_numeric($args['width']))) {
			if(is_numeric($args['width'])) {
				$w = $args['width'].'px';
			} else {
				$w = $args['width'];
			}
		} else {
			$w = apply_filters( 'quickmaps_default_width', $this->get_default_width());
		}
		if ( isset( $args['height'] ) && (preg_match('/^[0-9]+(%|px)$/', $args['height']) || is_numeric($args['height']))) {
			if(is_numeric($args['height'])) {
				$h = $args['height'].'px';
			} else {
				$h = $args['height'];
			}
		} else {
			$h = apply_filters( 'quickmaps_default_height', self::get_default_height());
		}
		if(is_null($content) || empty($content) || !$content) {
			$content = apply_filters( 'quickmaps_default_content', $this->get_default_place());
		}
		return sprintf('<iframe src="//www.google.com/maps?q=%1$s&amp;output=embed" frameborder="0" width="%2$s" height="%3$s" data-quickmaps="%4$s" class="quickmaps"></iframe>', esc_html( urlencode(trim($content))), esc_attr( $w ), esc_attr( $h ), esc_attr(QMAPS_VERSION));
	}

	public static function get_default_height() {
		$default_height = self::$default_height;
		return $default_height;
    }

    public static function get_default_width() {
		$default_width = self::$default_width;
		return $default_width;
    }

    public static function get_default_place() {
    	$default_place = self::$default_content;
		return $default_place;
    }
}