<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             0.1
 * @package           Pilau_Responsive_Image_Sizes
 *
 * @wordpress-plugin
 * Plugin Name:       Pilau Responsive Image Sizes
 * Plugin URI:        https://github.com/pilau/responsive-image-sizes
 * Description:       Simple automated handling of responsive image sizes for WordPress
 * Version:           0.1
 * Author:            Steve Taylor
 * Author URI:        http://sltaylor.co.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       responsive-image-sizes
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-responsive-image-sizes-activator.php';

/**
 * The code that runs during plugin deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-responsive-image-sizes-deactivator.php';

/** This action is documented in includes/class-responsive-image-sizes-activator.php */
register_activation_hook( __FILE__, array( 'Pilau_Responsive_Image_Sizes_Activator', 'activate' ) );

/** This action is documented in includes/class-responsive-image-sizes-deactivator.php */
register_deactivation_hook( __FILE__, array( 'Pilau_Responsive_Image_Sizes_Deactivator', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-responsive-image-sizes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1
 */
function run_plugin_name() {

	$plugin = new Pilau_Responsive_Image_Sizes();
	$plugin->run();

}
run_plugin_name();
