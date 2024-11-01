<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.presstigers.com
 * @since      1.0.0
 *
 * @package    Simple_Vote
 * @subpackage Simple_Vote/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Vote
 * @subpackage Simple_Vote/admin
 * @author     Presstigers <support@presstigers.com>
 */
class Simple_Vote_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Vote_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Vote_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-vote-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'_font-awesome', plugin_dir_url( __FILE__ ) . 'css/simple-vote-admin-font-awesome.min.css', array(), $this->version, 'all' );
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */

	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Vote_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Vote_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-vote-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
     * Display settings page link beside plugin deactivate button on plugins page
     *
     * @since  1.0.0
     * @access public
     * @param {void}
     * @return {void}
     */

	function sv_add_plugin_page_settings_link($links){
	
		$links[] .= '<a href="' .
			admin_url( 'admin.php?page=theme-options' ) .
			'">' . esc_html__('Settings','simple-vote') . '</a>';
	
		return $links;
	}
}