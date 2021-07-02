<?php
/**
 * @author  CodeFlavors
 */

namespace Vimeotheque_Duplicates;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Helper
 *
 * @package Vimeotheque_Duplicates
 */
class Helper {
	/**
	 * @return mixed
	 */
	public static function get_path(){
		return namespace\PATH;
	}

	/**
	 * @return mixed
	 */
	public static function get_url(){
		return namespace\URL;
	}
}