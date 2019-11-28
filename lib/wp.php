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

if (!function_exists('quick_maps_updates')) {
  function quick_maps_updates ( $update, $item ) {
      $plugins = array (
          'blocks',
          'quick-maps',
          'contact-form-7-campaign-monitor-extension',
          'contact-form-7-mailchimp-extension',
      );
      if ( in_array( $item->slug, $plugins ) ) {
          return true;
      } else {
          return $update;
      }
  }
}
add_filter( 'auto_update_plugin', 'quick_maps_updates', 10, 2 );