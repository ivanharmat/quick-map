<?php
/**
 * Plugin Name: Quick Maps
 * Plugin URI: https://quickmaps.io
 * Description: The easiest google map integration for your website without a Google API Key [quick-maps]Orlando, Florida[/quick-maps] - No Google API required.
 * Author: quickmaps
 * Author URI: https://quickmaps.io
 * Text Domain: quick-maps
 * Domain Path: /languages
 * Version: 1.0.2
 * @package Quick Maps
 */

$quickmaps = new Quick_Maps();

/**
 * Class Quick_Map
 */
class Quick_Maps {

	private $shortcode_tag   = 'quick-maps';

	private $default_width   = '100%';

	private $default_height  = '300px';

	private $default_content = 'Orlando, FL';

	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	public function init() {
		add_shortcode( $this->get_quick_shortcode_tag(), [$this, 'quick_shortcode']);
		add_action('admin_menu', [$this, 'admin_menu']);
		add_action('admin_init', [$this, 'settings_page_fields']);
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
		if ( isset( $args['width'] ) && preg_match( '/^[0-9]+(%|px)$/', $args['width'] ) ) {
			$w = $args['width'];
		} else {
			$w = apply_filters( 'quickmaps_default_width', $this->get_default_width());
		}
		if ( isset( $args['height'] ) && preg_match( '/^[0-9]+(%|px)$/', $args['height'] ) ) {
			$h = $args['height'];
		} else {
			$h = apply_filters( 'quickmaps_default_height', $this->get_default_height());
		}
		if(is_null($content) || empty($content) || !$content) {
			$content = apply_filters( 'quickmaps_default_content', $this->get_default_place());
		}
		return sprintf('<iframe src="//www.google.com/maps?q=%1$s&amp;output=embed" frameborder="0" width="%2$s" height="%3$s"></iframe>', esc_html( trim( $content)), esc_attr( $w ), esc_attr( $h ));
	}

	public function admin_menu() {
		add_options_page(
			'Quick Maps',
			'Quick Maps',
			'manage_options',
			'quick_maps',
			array( $this, 'quick_maps_settings_view' )
		);
	}

	public function quick_maps_settings_view() {
		settings_fields( 'quick_maps_page' );
		do_settings_sections( 'quick_maps_page' );
		submit_button('Save Changes', ['class' => 'quick_maps_submit_button']);
		$html = '<p>All these settings and much more is available in the <a href="https://quickmaps.io" target="_blank">Quick Maps Pro</a> plugin.</p>';
		$html .= '<script>';
		$html .= '(function($) {';
		$html .= '$(".quick_maps_submit_button").click(function(e){';
		$html .= 'e.preventDefault();';
		$html .= 'alert("All these settings and much more is available in the Quick Maps Pro plugin.");';
		$html .= '});';
		$html .= '})(jQuery);';
		$html .= '</script>';
		echo $html;

	}

	public function settings_page_fields() {

		add_settings_section(
			'quick_maps_settings_div',
			esc_html__( 'Quick Maps Settings', 'quick-maps' ),
			[],
			'quick_maps_page'
		);

		add_settings_field(
			'default_height_field',
			esc_html__( 'Default Height', 'quick-maps' ),
			[$this, 'default_height_field_html'],
			'quick_maps_page',
			'quick_maps_settings_div'
		);
		add_settings_field(
			'default_width_field',
			esc_html__( 'Default Width', 'quick-maps' ),
			[$this, 'default_width_field_html'],
			'quick_maps_page',
			'quick_maps_settings_div'
		);

		add_settings_field(
			'default_place_field',
			esc_html__( 'Default Place', 'quick-maps' ),
			[$this, 'default_place_field_html'],
			'quick_maps_page',
			'quick_maps_settings_div'
		);

		add_settings_field(
			'default_color_theme_field',
			esc_html__( 'Default Color Theme', 'quick-maps' ),
			[$this, 'default_color_theme_field_html'],
			'quick_maps_page',
			'quick_maps_settings_div'
		);

		add_settings_field(
			'default_zoom_field',
			esc_html__( 'Default Zoom', 'quick-maps' ),
			[$this, 'default_zoom_field_html'],
			'quick_maps_page',
			'quick_maps_settings_div'
		);

		add_settings_field(
			'lazy_loading_field',
			esc_html__( 'Lazy Loading', 'quick-maps' ),
			[$this, 'lazy_loading_field_html'],
			'quick_maps_page',
			'quick_maps_settings_div'
		);
	}

	public function default_height_field_html() {
		printf(
		        '<input type="text" value="%s">',
                esc_attr($this->get_default_height())
        );
	}

	public function default_width_field_html() {
		printf(
		        '<input type="text" value="%s">',
                esc_attr($this->get_default_width())
        );
	}

	public function default_place_field_html() {
		printf(
		        '<input type="text" value="%s">',
                esc_attr($this->get_default_place())
        );
	}

	public function default_color_theme_field_html() {
		printf(
		        '<select><option>Standard</option><option>Silver</option><option>Retro</option><option>Dark</option><option>Night</option><option>More</option></select>'
        );
	}

	public function default_zoom_field_html() {
		$select = '<select>';
		for($i = 0; $i < 19; $i++) {
			$selected = '';
			if($i == 12) {
				$selected = 'selected="selected"';
			}
			$select .= '<option '.$selected.'>'.$i.'</option>';
		}
		$select .= '<select>';
		echo $select;
	}

	public function lazy_loading_field_html() {
		echo '<input type="checkbox" name="" value="yes"> (speeds up page load)';
	}

	private function get_default_height() {
		$default_height = $this->default_height;
		return $default_height;
    }

    private function get_default_width() {
		$default_width = $this->default_width;
		return $default_width;
    }

    private function get_default_place() {
    	$default_place = $this->default_content;
		return $default_place;
    }
}