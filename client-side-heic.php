<?php
/**
 * Plugin Name: Client-Side HEIC Support
 * Plugin URI:  https://github.com/adamsilverstein/client-side-heic
 * Description: Enables HEIC/HEIF image upload support in WordPress with client-side conversion to JPEG.
 * Version:     1.0.0
 * Requires at least: 6.4
 * Requires PHP: 7.4
 * Author:      Adam Silverstein
 * Author URI:  https://developer.wordpress.org
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: client-side-heic
 *
 * @package ClientSideHeic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CSH_VERSION', '1.0.0' );
define( 'CSH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CSH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once CSH_PLUGIN_DIR . 'includes/settings.php';
require_once CSH_PLUGIN_DIR . 'includes/cross-origin-isolation.php';
require_once CSH_PLUGIN_DIR . 'includes/heic-support.php';
