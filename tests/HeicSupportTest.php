<?php
/**
 * Tests for the HEIC support functionality.
 *
 * @package ClientSideHeic
 */

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Test class for includes/heic-support.php.
 */
class HeicSupportTest extends TestCase {

	/**
	 * Test that csh_is_heic_enabled returns true by default.
	 */
	public function test_heic_enabled_by_default() {
		$this->assertTrue( csh_is_heic_enabled() );
	}

	/**
	 * Test that csh_is_heic_enabled returns false when option is 0.
	 */
	public function test_heic_disabled_via_option() {
		global $csh_test_options;
		$csh_test_options['csh_heic_enabled'] = 0;

		$this->assertFalse( csh_is_heic_enabled() );

		unset( $csh_test_options['csh_heic_enabled'] );
	}

	/**
	 * Test that HEIC MIME types are added when enabled.
	 */
	public function test_add_heic_mime_types() {
		$mimes  = array( 'jpg|jpeg|jpe' => 'image/jpeg' );
		$result = csh_add_heic_mime_types( $mimes );

		$this->assertArrayHasKey( 'heic', $result );
		$this->assertArrayHasKey( 'heif', $result );
		$this->assertSame( 'image/heic', $result['heic'] );
		$this->assertSame( 'image/heif', $result['heif'] );
	}

	/**
	 * Test that HEIC MIME types are not added when disabled.
	 */
	public function test_mime_types_not_added_when_disabled() {
		global $csh_test_options;
		$csh_test_options['csh_heic_enabled'] = 0;

		$mimes  = array( 'jpg|jpeg|jpe' => 'image/jpeg' );
		$result = csh_add_heic_mime_types( $mimes );

		$this->assertArrayNotHasKey( 'heic', $result );
		$this->assertArrayNotHasKey( 'heif', $result );

		unset( $csh_test_options['csh_heic_enabled'] );
	}

	/**
	 * Test the HEIC output format mapping.
	 */
	public function test_heic_output_format() {
		$formats = array();
		$result  = csh_heic_output_format( $formats );

		$this->assertSame( 'image/jpeg', $result['image/heic'] );
		$this->assertSame( 'image/jpeg', $result['image/heif'] );
	}

	/**
	 * Test output format returns unchanged when disabled.
	 */
	public function test_heic_output_format_when_disabled() {
		global $csh_test_options;
		$csh_test_options['csh_heic_enabled'] = 0;

		$formats = array( 'image/png' => 'image/webp' );
		$result  = csh_heic_output_format( $formats );

		$this->assertSame( $formats, $result );

		unset( $csh_test_options['csh_heic_enabled'] );
	}

	/**
	 * Test client-side MIME types include HEIC/HEIF.
	 */
	public function test_add_heic_client_side_mime_types() {
		$types  = array( 'image/jpeg' );
		$result = csh_add_heic_client_side_mime_types( $types );

		$this->assertContains( 'image/heic', $result );
		$this->assertContains( 'image/heif', $result );
	}

	/**
	 * Test client-side MIME types unchanged when disabled.
	 */
	public function test_client_side_mime_types_when_disabled() {
		global $csh_test_options;
		$csh_test_options['csh_heic_enabled'] = 0;

		$types  = array( 'image/jpeg' );
		$result = csh_add_heic_client_side_mime_types( $types );

		$this->assertNotContains( 'image/heic', $result );
		$this->assertNotContains( 'image/heif', $result );

		unset( $csh_test_options['csh_heic_enabled'] );
	}

	/**
	 * Test filetype check for .heic extension.
	 */
	public function test_heic_check_filetype_heic() {
		$data = array(
			'ext'             => '',
			'type'            => '',
			'proper_filename' => false,
		);

		$result = csh_heic_check_filetype( $data, '/tmp/test.heic', 'test.heic', array(), '' );

		$this->assertSame( 'heic', $result['ext'] );
		$this->assertSame( 'image/heic', $result['type'] );
	}

	/**
	 * Test filetype check for .heif extension.
	 */
	public function test_heic_check_filetype_heif() {
		$data = array(
			'ext'             => '',
			'type'            => '',
			'proper_filename' => false,
		);

		$result = csh_heic_check_filetype( $data, '/tmp/test.heif', 'test.heif', array(), '' );

		$this->assertSame( 'heif', $result['ext'] );
		$this->assertSame( 'image/heif', $result['type'] );
	}

	/**
	 * Test filetype check skips when data already set.
	 */
	public function test_heic_check_filetype_skips_when_set() {
		$data = array(
			'ext'             => 'jpg',
			'type'            => 'image/jpeg',
			'proper_filename' => false,
		);

		$result = csh_heic_check_filetype( $data, '/tmp/test.heic', 'test.heic', array(), '' );

		$this->assertSame( 'jpg', $result['ext'] );
		$this->assertSame( 'image/jpeg', $result['type'] );
	}
}
