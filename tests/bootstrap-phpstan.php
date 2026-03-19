<?php
/**
 * PHPStan bootstrap file.
 *
 * Defines constants that the plugin expects so PHPStan
 * can resolve them during static analysis.
 *
 * @package ClientSideHeic
 */

define( 'ABSPATH', '/tmp/wordpress/' );
define( 'CSH_VERSION', '1.0.0' );
define( 'CSH_PLUGIN_DIR', dirname( __DIR__ ) . '/' );
define( 'CSH_PLUGIN_URL', 'https://example.com/wp-content/plugins/client-side-heic/' );
