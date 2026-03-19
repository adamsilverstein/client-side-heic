<?php
/**
 * Settings for Client-Side HEIC Support.
 *
 * Adds controls under Settings > Media for HEIC conversion quality
 * and cross-origin isolation.
 *
 * @package ClientSideHeic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the plugin settings on the Media settings page.
 */
function csh_register_settings() {
	add_settings_section(
		'csh_settings_section',
		__( 'HEIC Support', 'client-side-heic' ),
		'csh_settings_section_callback',
		'media'
	);

	register_setting(
		'media',
		'csh_heic_enabled',
		array(
			'type'              => 'integer',
			'default'           => 1,
			'sanitize_callback' => 'csh_sanitize_enabled',
		)
	);

	add_settings_field(
		'csh_heic_enabled_field',
		__( 'Enable HEIC', 'client-side-heic' ),
		'csh_heic_enabled_field_callback',
		'media',
		'csh_settings_section'
	);

	register_setting(
		'media',
		'csh_coep_coop_enabled',
		array(
			'type'              => 'integer',
			'default'           => csh_get_coep_coop_default(),
			'sanitize_callback' => 'csh_sanitize_enabled',
		)
	);

	add_settings_field(
		'csh_coep_coop_enabled_field',
		__( 'Cross-Origin Isolation', 'client-side-heic' ),
		'csh_coep_coop_enabled_field_callback',
		'media',
		'csh_settings_section'
	);
}
add_action( 'admin_init', 'csh_register_settings' );

/**
 * Returns the default value for the COEP/COOP setting based on browser type.
 *
 * @return int 1 if COEP/COOP should be enabled by default, 0 otherwise.
 */
function csh_get_coep_coop_default() {
	$chrome_version = null;

	if ( function_exists( 'wp_get_chrome_major_version' ) ) {
		$chrome_version = wp_get_chrome_major_version();
	} elseif ( function_exists( 'gutenberg_get_chrome_major_version' ) ) {
		$chrome_version = gutenberg_get_chrome_major_version();
	}

	// Chromium 137+ uses Document-Isolation-Policy; COEP/COOP headers are not needed.
	$use_dip = null !== $chrome_version && $chrome_version >= 137;

	return $use_dip ? 0 : 1;
}

/**
 * Sanitizes the enabled setting value.
 *
 * @param mixed $value The setting value.
 * @return int Sanitized value (1 or 0).
 */
function csh_sanitize_enabled( $value ) {
	return $value ? 1 : 0;
}

/**
 * Outputs the settings section description.
 */
function csh_settings_section_callback() {
	echo '<p>' . esc_html__( 'Configure HEIC/HEIF image upload support with client-side conversion to JPEG.', 'client-side-heic' ) . '</p>';
}

/**
 * Outputs the checkbox field for the HEIC enabled setting.
 */
function csh_heic_enabled_field_callback() {
	$enabled = get_option( 'csh_heic_enabled', 1 );
	?>
	<input type="hidden" name="csh_heic_enabled" value="0" />
	<label for="csh_heic_enabled">
		<input type="checkbox" id="csh_heic_enabled" name="csh_heic_enabled" value="1" <?php checked( $enabled, 1 ); ?> />
		<?php esc_html_e( 'Enable HEIC/HEIF image upload support (converts to JPEG on the client side).', 'client-side-heic' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( 'When enabled, HEIC images are converted to JPEG in the browser using the heic2any library (which uses libheif, LGPL-3.0 licensed), loaded from an external CDN at runtime.', 'client-side-heic' ); ?>
	</p>
	<?php
}

/**
 * Outputs the checkbox field for the COEP/COOP enabled setting.
 */
function csh_coep_coop_enabled_field_callback() {
	$enabled = get_option( 'csh_coep_coop_enabled', csh_get_coep_coop_default() );
	?>
	<input type="hidden" name="csh_coep_coop_enabled" value="0" />
	<label for="csh_coep_coop_enabled">
		<input type="checkbox" id="csh_coep_coop_enabled" name="csh_coep_coop_enabled" value="1" <?php checked( $enabled, 1 ); ?> />
		<?php esc_html_e( 'Enable COEP/COOP cross-origin isolation headers for Firefox and Safari.', 'client-side-heic' ); ?>
	</label>
	<p class="description">
		<?php esc_html_e( 'Required for client-side media processing on browsers that do not support Document-Isolation-Policy.', 'client-side-heic' ); ?>
	</p>
	<?php
}

/**
 * Disables COEP/COOP when the setting is off.
 *
 * @param bool $use_coep_coop Whether COEP/COOP should be used.
 * @return bool Filtered value.
 */
function csh_maybe_disable_coep_coop( $use_coep_coop ) {
	if ( ! get_option( 'csh_coep_coop_enabled', csh_get_coep_coop_default() ) ) {
		return false;
	}
	return $use_coep_coop;
}
add_filter( 'csh_use_coep_coop', 'csh_maybe_disable_coep_coop', 5 );
