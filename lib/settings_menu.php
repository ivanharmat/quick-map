<?php 
/*  Copyright 2013-2019 Ivan Harmat (email: ivanharmat at yahoo.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require_once(QMAPS_PLUGIN_DIR.'/quick-maps.php');

$settings_menu = new Settings_menu();

class Settings_menu {

    private $quickmaps_class;

    function __construct() {
        add_action( 'init', array( $this, 'init' ));
        $this->quickmaps_class = new Quick_Maps();
    }

    public function init() {
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_init', [$this, 'settings_page_fields']);
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
            'default_place_field',
            esc_html__( 'Default Place', 'quick-maps' ),
            [$this, 'default_place_field_html'],
            'quick_maps_page',
            'quick_maps_settings_div'
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
                esc_attr($this->quickmaps_class->get_default_height())
        );
    }

    public function default_width_field_html() {
        printf(
                '<input type="text" value="%s">',
                esc_attr($this->quickmaps_class->get_default_width())
        );
    }

    public function default_place_field_html() {
        printf(
                '<input type="text" value="%s" class="regular-text">',
                esc_attr($this->quickmaps_class->get_default_place())
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
}