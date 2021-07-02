<?php
namespace Vimeotheque_Duplicates;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Vimeotheque_Duplicates\Admin\Admin;

/**
 * Class Plugin
 */
class Plugin {

	/**
	 * Holds the plugin instance.
	 *
	 * @var Plugin
	 */
	private static $instance = null;
	/**
	 * @var Admin
	 */
	private $admin;

	/**
	 * Clone.
	 *
	 * Disable class cloning and throw an error on object clone.
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object. Therefore, we don't want the object to be cloned.
	 *
	 * @access public
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'vimeotheque-allow-duplicates' ), '2.0' );
	}

	/**
	 * Wakeup.
	 *
	 * Disable unserializing of the class.
	 *
	 * @access public
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'vimeotheque-allow-duplicates' ), '2.0' );
	}

	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @access public
	 * @static
	 *
	 * @return Plugin
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructors - sets all filters and hooks
	 */
	private function __construct(){
		// start the autoloader
		$this->register_autoloader();

		add_action( 'init', [
			$this,
			'init_admin'
		], -99 );
	}

	/**
	 * Register the autoloader
	 */
	private function register_autoloader(){
		require namespace\PATH . 'includes/libs/autoload.class.php';
		Autoload::run();
	}

	/**
	 * Initialize administration
	 */
	public function init_admin(){
		if( is_admin() ){
			$this->admin = new Admin();
		}
	}
}

Plugin::instance();