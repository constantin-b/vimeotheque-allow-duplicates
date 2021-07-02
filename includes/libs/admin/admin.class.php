<?php
/**
 * @author CodeFlavors
 * @project vimeotheque-automatic-import
 */

namespace Vimeotheque_Duplicates\Admin;

use Vimeotheque\Admin\Helper_Admin;
use Vimeotheque\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Admin
 *
 * @package Vimeotheque_Duplicates\Admin
 */
class Admin {

	/**
	 * Admin constructor.
	 */
	public function __construct(){
		add_action( 'wp_loaded', [
			$this,
			'init'
		], 0 );
	}

	/**
	 * Initialize admin
	 */
	public function init(){

		add_action( 'vimeotheque\admin\import_meta_panel\post_options_fields', [ $this, 'output_field' ], 99 );

		add_action( 'vimeotheque\duplicate_posts_found',  [ $this, 'allow_duplicates' ] );

	}

	/**
	 * Output the option for creating duplicate posts
	 */
	public function output_field(){
?>
        <h4><?php _e('Post duplicates', 'vimeotheque-pro');?></h4>

        <label for="import_duplicates"><?php _e('Import duplicates', 'vimeotheque-allow-duplicates');?>:</label>
		<input type="checkbox" value="1" id="import_duplicates" name="import_duplicates"<?php Helper_Admin::check( isset( $_POST['import_duplicates'] ) );?> />
        <p>
            <em><?php _e( 'When checked, may create duplicate posts if a video was already imported.', 'vimeotheque-allow-duplicates' );?></em>
        </p>
<?php
	}

	/**
	 * @param array $found_duplicates   The duplicates found for each video ID. Structured as [ video_id => [ post_id, post_id, ... ] ]
	 *
	 * @return array
	 */
	public function allow_duplicates( $found_duplicates ){

	    if( isset( $_POST['model']['import']['import_duplicates'] ) ){

	        if( $found_duplicates ){

	            foreach ( $found_duplicates as $video_id => $post_ids ){
		            Helper::debug_message(
		                sprintf(
                            'Importing duplicate post for video ID "%s". Found existing post IDs: %s.',
                            $video_id,
                            implode( ', ', $post_ids )
                        )
		            );
                }

            }
            // reset the found duplicates array since they are allowed
	        $found_duplicates = [];
        }

	    return $found_duplicates;

    }

}