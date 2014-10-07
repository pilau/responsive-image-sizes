<?php

/**
 * Pilau Responsive Image Sizes.
 *
 * @package   Responsive_Image_Sizes
 * @author    Steve Taylor <sltaylor.co.uk>
 * @license   GPL-2.0+
 * @link      https://github.com/pilau/responsive-image-sizes
 * @copyright Steve Taylor
 *
 * @wordpress-plugin
 * Plugin Name:			Pilau Responsive Image Sizes
 * Plugin URI:			https://github.com/pilau/responsive-image-sizes
 * Description:			Simple automated handling of responsive image sizes for WordPress
 * Version:				0.1
 * Author:				gyrus
 * Text Domain:			pilau-ris-locale
 * License:				GPL-2.0+
 * License URI:			http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:			/lang
 * GitHub Plugin URI:	https://github.com/pilau/responsive-image-sizes
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( plugin_dir_path( __FILE__ ) . 'class-responsive-image-sizes.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'Responsive_Image_Sizes', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Responsive_Image_Sizes', 'deactivate' ) );

Responsive_Image_Sizes::get_instance();