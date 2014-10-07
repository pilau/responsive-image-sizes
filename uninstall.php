<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Responsive_Image_Sizes
 * @author    Steve Taylor <sltaylor.co.uk>
 * @license   GPL-2.0+
 * @copyright Steve Taylor
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// TODO: Define uninstall functionality here