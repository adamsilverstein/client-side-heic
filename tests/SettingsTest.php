<?php
/**
 * Tests for the settings functionality.
 *
 * @package ClientSideHeic
 */

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Test class for includes/settings.php.
 */
class SettingsTest extends TestCase {

	/**
	 * Test that the sanitize callback returns 1 for truthy values.
	 */
	public function test_sanitize_enabled_truthy() {
		$this->assertSame( 1, csh_sanitize_enabled( 1 ) );
		$this->assertSame( 1, csh_sanitize_enabled( '1' ) );
		$this->assertSame( 1, csh_sanitize_enabled( true ) );
		$this->assertSame( 1, csh_sanitize_enabled( 'yes' ) );
	}

	/**
	 * Test that the sanitize callback returns 0 for falsy values.
	 */
	public function test_sanitize_enabled_falsy() {
		$this->assertSame( 0, csh_sanitize_enabled( 0 ) );
		$this->assertSame( 0, csh_sanitize_enabled( '' ) );
		$this->assertSame( 0, csh_sanitize_enabled( false ) );
		$this->assertSame( 0, csh_sanitize_enabled( null ) );
	}
}
