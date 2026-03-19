<?php
/**
 * PHPUnit bootstrap file.
 *
 * Provides lightweight WordPress function stubs so that plugin files
 * can be loaded without a full WordPress installation.
 *
 * @package ClientSideHeic
 */

// Define WordPress constants expected by the plugin.
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', '/tmp/wordpress/' );
}

// Yoast PHPUnit Polyfills for cross-version compatibility.
require_once dirname( __DIR__ ) . '/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';

/*
 * Minimal WordPress function stubs used by the plugin files.
 * Only functions that are called at file-load time need to be
 * defined here; functions invoked inside callbacks are exercised
 * through dedicated tests with their own mocks.
 */

if ( ! function_exists( 'plugin_dir_path' ) ) {
	/**
	 * Stub for plugin_dir_path().
	 *
	 * @param string $file File path.
	 * @return string Directory path.
	 */
	function plugin_dir_path( $file ) {
		return dirname( $file ) . '/';
	}
}

if ( ! function_exists( 'plugin_dir_url' ) ) {
	/**
	 * Stub for plugin_dir_url().
	 *
	 * @param string $file File path.
	 * @return string URL.
	 */
	function plugin_dir_url( $file ) {
		return 'https://example.com/wp-content/plugins/' . basename( dirname( $file ) ) . '/';
	}
}

// Track registered hooks for testing.
global $csh_test_hooks;
$csh_test_hooks = array();

if ( ! function_exists( 'add_action' ) ) {
	/**
	 * Stub for add_action().
	 *
	 * @param string   $hook     Hook name.
	 * @param callable $callback Callback.
	 * @param int      $priority Priority.
	 * @param int      $args     Number of args.
	 */
	function add_action( $hook, $callback, $priority = 10, $args = 1 ) {
		global $csh_test_hooks;
		$csh_test_hooks[] = array(
			'type'     => 'action',
			'hook'     => $hook,
			'callback' => $callback,
			'priority' => $priority,
		);
	}
}

if ( ! function_exists( 'add_filter' ) ) {
	/**
	 * Stub for add_filter().
	 *
	 * @param string   $hook     Hook name.
	 * @param callable $callback Callback.
	 * @param int      $priority Priority.
	 * @param int      $args     Number of args.
	 */
	function add_filter( $hook, $callback, $priority = 10, $args = 1 ) {
		global $csh_test_hooks;
		$csh_test_hooks[] = array(
			'type'     => 'filter',
			'hook'     => $hook,
			'callback' => $callback,
			'priority' => $priority,
		);
	}
}

if ( ! function_exists( 'apply_filters' ) ) {
	/**
	 * Stub for apply_filters().
	 *
	 * @param string $hook  Hook name.
	 * @param mixed  $value Value to filter.
	 * @return mixed
	 */
	function apply_filters( $hook, $value ) {
		return $value;
	}
}

if ( ! function_exists( 'get_option' ) ) {
	/**
	 * Stub for get_option().
	 *
	 * @param string $option  Option name.
	 * @param mixed  $default Default value.
	 * @return mixed
	 */
	function get_option( $option, $default = false ) {
		global $csh_test_options;
		if ( isset( $csh_test_options[ $option ] ) ) {
			return $csh_test_options[ $option ];
		}
		return $default;
	}
}

if ( ! function_exists( 'register_setting' ) ) {
	/**
	 * Stub for register_setting().
	 *
	 * @param string $group   Settings group.
	 * @param string $name    Setting name.
	 * @param array  $args    Arguments.
	 */
	function register_setting( $group, $name, $args = array() ) {
		// No-op for tests.
	}
}

if ( ! function_exists( 'add_settings_section' ) ) {
	/**
	 * Stub for add_settings_section().
	 *
	 * @param string   $id       Section ID.
	 * @param string   $title    Title.
	 * @param callable $callback Callback.
	 * @param string   $page     Page.
	 */
	function add_settings_section( $id, $title, $callback, $page ) {
		// No-op for tests.
	}
}

if ( ! function_exists( 'add_settings_field' ) ) {
	/**
	 * Stub for add_settings_field().
	 *
	 * @param string   $id       Field ID.
	 * @param string   $title    Title.
	 * @param callable $callback Callback.
	 * @param string   $page     Page.
	 * @param string   $section  Section.
	 */
	function add_settings_field( $id, $title, $callback, $page, $section = '' ) {
		// No-op for tests.
	}
}

if ( ! function_exists( '__' ) ) {
	/**
	 * Stub for __().
	 *
	 * @param string $text   Text.
	 * @param string $domain Domain.
	 * @return string
	 */
	function __( $text, $domain = 'default' ) {
		return $text;
	}
}

if ( ! function_exists( 'esc_html__' ) ) {
	/**
	 * Stub for esc_html__().
	 *
	 * @param string $text   Text.
	 * @param string $domain Domain.
	 * @return string
	 */
	function esc_html__( $text, $domain = 'default' ) {
		return $text;
	}
}

if ( ! function_exists( 'esc_html_e' ) ) {
	/**
	 * Stub for esc_html_e().
	 *
	 * @param string $text   Text.
	 * @param string $domain Domain.
	 */
	function esc_html_e( $text, $domain = 'default' ) {
		echo $text;
	}
}

if ( ! function_exists( 'checked' ) ) {
	/**
	 * Stub for checked().
	 *
	 * @param mixed $checked Checked value.
	 * @param mixed $current Current value.
	 * @param bool  $echo    Whether to echo.
	 * @return string
	 */
	function checked( $checked, $current = true, $echo = true ) {
		$result = ( (string) $checked === (string) $current ) ? " checked='checked'" : '';
		if ( $echo ) {
			echo $result;
		}
		return $result;
	}
}

if ( ! function_exists( 'esc_url' ) ) {
	/**
	 * Stub for esc_url().
	 *
	 * @param string $url URL.
	 * @return string
	 */
	function esc_url( $url ) {
		return $url;
	}
}

if ( ! function_exists( 'sanitize_text_field' ) ) {
	/**
	 * Stub for sanitize_text_field().
	 *
	 * @param string $str String.
	 * @return string
	 */
	function sanitize_text_field( $str ) {
		return $str;
	}
}

if ( ! function_exists( 'wp_enqueue_script' ) ) {
	/**
	 * Stub for wp_enqueue_script().
	 *
	 * @param string   $handle Handle.
	 * @param string   $src    Source.
	 * @param string[] $deps   Dependencies.
	 * @param string   $ver    Version.
	 * @param bool     $footer In footer.
	 */
	function wp_enqueue_script( $handle, $src = '', $deps = array(), $ver = false, $footer = false ) {
		// No-op for tests.
	}
}

if ( ! function_exists( 'wp_localize_script' ) ) {
	/**
	 * Stub for wp_localize_script().
	 *
	 * @param string $handle Handle.
	 * @param string $name   Object name.
	 * @param array  $data   Data.
	 */
	function wp_localize_script( $handle, $name, $data ) {
		// No-op for tests.
	}
}

if ( ! function_exists( 'wp_add_inline_script' ) ) {
	/**
	 * Stub for wp_add_inline_script().
	 *
	 * @param string $handle   Handle.
	 * @param string $data     Script data.
	 * @param string $position Position.
	 */
	function wp_add_inline_script( $handle, $data, $position = 'after' ) {
		// No-op for tests.
	}
}

if ( ! function_exists( 'get_current_user_id' ) ) {
	/**
	 * Stub for get_current_user_id().
	 *
	 * @return int
	 */
	function get_current_user_id() {
		return 1;
	}
}

if ( ! function_exists( 'user_can' ) ) {
	/**
	 * Stub for user_can().
	 *
	 * @param int    $user_id    User ID.
	 * @param string $capability Capability.
	 * @return bool
	 */
	function user_can( $user_id, $capability ) {
		return true;
	}
}

if ( ! function_exists( 'wp_use_widgets_block_editor' ) ) {
	/**
	 * Stub for wp_use_widgets_block_editor().
	 *
	 * @return bool
	 */
	function wp_use_widgets_block_editor() {
		return true;
	}
}

if ( ! function_exists( 'get_current_screen' ) ) {
	/**
	 * Stub for get_current_screen().
	 *
	 * @return object|null
	 */
	function get_current_screen() {
		return null;
	}
}

// Load the plugin files.
require_once dirname( __DIR__ ) . '/client-side-heic.php';
