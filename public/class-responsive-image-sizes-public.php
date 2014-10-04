<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      0.1
 *
 * @package    Pilau_Responsive_Image_Sizes
 * @subpackage Pilau_Responsive_Image_Sizes/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Pilau_Responsive_Image_Sizes
 * @subpackage Pilau_Responsive_Image_Sizes/admin
 * @author     Steve Taylor <sltaylor.co.uk>
 */
class Pilau_Responsive_Image_Sizes_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pilau_Responsive_Image_Sizes_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pilau_Responsive_Image_Sizes_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/responsive-image-sizes-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pilau_Responsive_Image_Sizes_Public_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pilau_Responsive_Image_Sizes_Public_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/responsive-image-sizes-public.js', array( 'jquery' ), $this->version, false );

	}

}
