<?php
/**
 * Elementify Library - Sanitize Trait
 *
 * A trait containing sanitization methods for common operations.
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
 * Sanitize Trait
 *
 * Provides sanitization methods for common data cleaning operations.
 */
class Sanitize {

	/**
	 * Clean a phone number to keep only digits and plus sign
	 *
	 * @param string $phone The phone number to clean
	 *
	 * @return string The cleaned phone number
	 */
	public static function clean_phone_number( string $phone ): string {
		return preg_replace( '/[^0-9+]/', '', $phone );
	}

}