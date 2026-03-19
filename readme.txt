=== Client-Side HEIC Support ===
Contributors: adamsilverstein
Tags: heic, heif, media, image, upload
Requires at least: 6.4
Tested up to: 6.8
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Enables HEIC/HEIF image upload support in WordPress with client-side conversion to JPEG.

== Description ==

iPhones capture photos in HEIC format by default, but WordPress does not natively support HEIC uploads. This plugin adds seamless HEIC/HEIF upload support by converting images to JPEG directly in the browser before uploading.

**What this plugin does:**

* Enables uploading HEIC/HEIF images in the block editor.
* Converts HEIC images to JPEG on the client side using the [heic2any](https://github.com/alexcorvi/heic2any) library.
* Preserves the original HEIC file by sideloading it back to the attachment after upload.
* Sends COEP/COOP cross-origin isolation headers for browsers that need them (Firefox, Safari).
* Works transparently — users simply upload their iPhone photos as usual.

**How it works:**

1. When a HEIC file is selected for upload, the plugin detects it automatically.
2. The heic2any library is loaded from an external CDN (only when needed).
3. The HEIC file is converted to JPEG at configurable quality (default 0.92).
4. The JPEG is uploaded through the normal WordPress pipeline.
5. The original HEIC is sideloaded back to preserve the raw file.

**Licensing:**

The heic2any library uses [libheif](https://github.com/strukturag/libheif) (LGPL-3.0 licensed) for HEIC decoding. Since the library is loaded at runtime from a CDN rather than bundled with the plugin, it is treated as a separate work and does not affect the plugin's GPL-2.0-or-later license.

== Installation ==

1. Upload the `client-side-heic` folder to `/wp-content/plugins/`.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Upload HEIC images in the block editor — they will be automatically converted.

== Frequently Asked Questions ==

= Do I need this plugin on Safari? =

Safari natively supports HEIC images, so the conversion step is skipped. However, the plugin still registers HEIC as an allowed upload type so WordPress accepts the files.

= Can I change the JPEG quality? =

Yes. Use the `csh_heic_jpeg_quality` filter:

`add_filter( 'csh_heic_jpeg_quality', function() { return 0.85; } );`

= Can I self-host the conversion library? =

Yes. Use the `csh_heic_library_url` filter:

`add_filter( 'csh_heic_library_url', function() { return 'https://example.com/heic2any.min.js'; } );`

= What about cross-origin isolation? =

The plugin includes COEP/COOP header support for Firefox and Safari, which is required for the WebAssembly-based conversion library to work. This can be toggled under Settings > Media.

== Changelog ==

= 1.0.0 =
* Initial release.
* HEIC/HEIF to JPEG client-side conversion.
* Cross-origin isolation via COEP/COOP headers.
* Settings under Settings > Media.
* Filterable CDN URL, integrity hash, and JPEG quality.
