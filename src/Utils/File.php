<?php
/**
 * Elementify Library - File Trait
 *
 * A trait containing file-related utility methods.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Utils;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * File Trait
 *
 * Provides file-related utility methods.
 */
class File {

	/**
	 * Helper method to get MIME type from file extension
	 *
	 * @param string $file File path or URL
	 *
	 * @return string MIME type
	 */
	public static function get_mime_type( string $file ): string {
		$extension = strtolower( pathinfo( $file, PATHINFO_EXTENSION ) );

		$mime_types = [
			// Image types
			'jpg'  => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png'  => 'image/png',
			'gif'  => 'image/gif',
			'svg'  => 'image/svg+xml',
			'webp' => 'image/webp',

			// Audio types
			'mp3'  => 'audio/mpeg',
			'wav'  => 'audio/wav',
			'ogg'  => 'audio/ogg',

			// Video types
			'mp4'  => 'video/mp4',
			'webm' => 'video/webm',
			'ogv'  => 'video/ogg'
		];

		return $mime_types[ $extension ] ?? 'application/octet-stream';
	}

}