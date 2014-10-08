<?php
/**
 * Plugin Name.
 *
 * @package   Responsive_Image_Sizes
 * @author    Steve Taylor <sltaylor.co.uk>
 * @license   GPL-2.0+
 * @copyright Steve Taylor
 */

/**
 * Plugin class.
 *
 * @package Responsive_Image_Sizes
 * @author  Steve Taylor <sltaylor.co.uk>
 */
class Responsive_Image_Sizes {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   0.1
	 *
	 * @var     string
	 */
	protected $version = '0.1';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    0.1
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'pilau-ris';

	/**
	 * Instance of this class.
	 *
	 * @since    0.1
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    0.1
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Data on all image sizes.
	 *
	 * @since    0.1
	 *
	 * @var      string
	 */
	protected $image_sizes = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     0.1
	 */
	private function __construct() {

		// Initialise
		add_action( 'init', array( $this, 'init' ) );

		// Admin init
		//add_action( 'admin_init', array( $this, 'admin_init' ) );

		// Add the settings page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'process_plugin_admin_settings' ) );

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Load public-facing style sheet and JavaScript.
		//add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		//add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Other hooks
		add_action( 'wp_loaded', array( $this, 'gather_image_sizes' ) );
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'filter_image_attributes' ), 10, 2 );

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.1
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    0.1
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    0.1
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

	}

	/**
	 * Initialize
	 *
	 * @since    0.1
	 */
	public function init() {

		// Set the settings
		$this->settings = $this->get_settings();

		// Load plugin text domain
		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );

	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     0.1
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     0.1
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );
		}

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    0.1
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/public.css', __FILE__ ), array(), $this->version );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    0.1
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), $this->version );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    0.1
	 */
	public function add_plugin_admin_menu() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Responsive image sizes', $this->plugin_slug ),
			__( 'Responsive image sizes', $this->plugin_slug ),
			'update_core',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    0.1
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Get the plugin's settings
	 *
	 * @since    0.1
	 */
	public function get_settings() {

		$settings = get_option( $this->plugin_slug . '_settings' );

		if ( ! $settings ) {

			// Image sizes may not have been gathered
			if ( ! $this->image_sizes ) {
				$this->gather_image_sizes();
			}

			// Defaults
			$settings = array();

			// Go through image sizes
			foreach ( $this->image_sizes as $size_name => $size_data ) {
				$settings[ 'use_' . $size_name ] = false;
				$settings[ 'for_' . $size_name ] = $size_data['width'];
			}

			// Retina
			$settings[ 'retina' ] = false;

		}

		return $settings;
	}

	/**
	 * Set the plugin's settings
	 *
	 * @since    0.1
	 */
	public function set_settings( $settings ) {
		return update_option( $this->plugin_slug . '_settings', $settings );
	}

	/**
	 * Process the settings page for this plugin.
	 *
	 * @since    0.1
	 */
	public function process_plugin_admin_settings() {

		// Submitted?
		if ( isset( $_POST[ $this->plugin_slug . '_settings_admin_nonce' ] ) && check_admin_referer( $this->plugin_slug . '_settings', $this->plugin_slug . '_settings_admin_nonce' ) ) {

			// Init settings array
			$settings = array();

			// Image sizes may not have been gathered
			if ( ! $this->image_sizes ) {
				$this->gather_image_sizes();
			}

			// Go through image sizes
			foreach ( $this->image_sizes as $size_name => $size_data ) {
				$settings[ 'use_' . $size_name ] = isset( $_POST[ $this->plugin_slug . '_use' ] ) && is_array( $_POST[ $this->plugin_slug . '_use' ] ) && in_array( $size_name, $_POST[ $this->plugin_slug . '_use' ] );
				$settings[ 'for_' . $size_name ] = intval( $_POST[ $this->plugin_slug . '_' . $size_name ] );
			}

			// Retina?
			$settings[ 'retina' ] = isset( $_POST[ $this->plugin_slug . '_retina' ] );

			// Save as option
			$this->set_settings( $settings );

			// Redirect
			wp_redirect( admin_url( 'options-general.php?page=' . $this->plugin_slug . '&done=1' ) );

		}

	}

	/**
	 * Gather image sizes
	 *
	 * @since    0.1
	 */
	public function gather_image_sizes() {
		global $_wp_additional_image_sizes;
		$this->image_sizes = array();

		// First add standard sizes
		foreach ( array( 'thumbnail', 'medium', 'large' ) as $standard_size ) {
			$this->image_sizes[ $standard_size ] = array(
				'width'			=> get_option( $standard_size . '_size_w' )
			);
		}

		// Now add custom sizes
		$this->image_sizes = array_merge( $this->image_sizes, $_wp_additional_image_sizes );

	}

	/**
	 * Filter WP image attributes
	 *
	 * @since    0.1
	 */
	public function filter_image_attributes( $attr, $attachment ) {

		// Front-end only
		if ( ! is_admin() ) {
			$settings = $this->get_settings();

			// Get the width of the image being used
			$used_image_width = null;
			$used_image_filename_parts = explode( '-', pathinfo( $attr['src'], PATHINFO_FILENAME ) );
			if ( count( $used_image_filename_parts ) > 1 && strpos( end( $used_image_filename_parts ), 'x' ) !== false ) {
				$used_image_dimensions = explode( 'x', end( $used_image_filename_parts ) );
			} else {
				$used_image_dimensions = wp_get_attachment_image_src( $attachment->ID, 'full' );
				array_shift( $used_image_dimensions ); // Remove the URL so the width is in the first position, to match above
			}
			$used_image_width = $used_image_dimensions[0];

			if ( $used_image_width ) {

				// Start building srcset
				$srcset = array();



				// Add srcset
				$attr['srcset'] = implode( ', ', $srcset );

			}

		}

		return $attr;
	}

}