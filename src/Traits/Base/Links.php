<?php
/**
 * Elementify Library - Links Elements Trait
 *
 * A collection of methods for creating link-related HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits\Base;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Element;
use Elementify\Helpers;

/**
 * Links Elements Trait
 *
 * Provides methods for creating various types of link elements (a, mailto, tel, etc).
 */
trait Links {

	/**
	 * Create an anchor (a) element
	 *
	 * @param string $href       URL
	 * @param mixed  $content    Element content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function a( string $href, $content = null, array $attributes = [] ): Element {
		return self::element( 'a', $content, array_merge( [ 'href' => $href ], $attributes ) );
	}

	/**
	 * Create a mailto link
	 *
	 * @param string $email      Email address
	 * @param mixed  $content    Link content (defaults to email address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function mailto( string $email, $content = null, array $attributes = [] ): Element {
		// Sanitize email
		$sanitized_email = sanitize_email( $email );

		// Use email as content if none provided
		if ( $content === null ) {
			$content = $email;
		}

		return self::a( 'mailto:' . $sanitized_email, $content, $attributes );
	}

	/**
	 * Create a tel (telephone) link
	 *
	 * @param string $phone      Phone number
	 * @param mixed  $content    Link content (defaults to phone number if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function tel( string $phone, $content = null, array $attributes = [] ): Element {
		// Use phone number as content if none provided
		if ( $content === null ) {
			$content = $phone;
		}

		// Remove any non-numeric characters for the href but keep them for display
		$clean_phone = Helpers::clean_phone_number( $phone );

		return self::a( 'tel:' . $clean_phone, $content, $attributes );
	}

	/**
	 * Create an sms link
	 *
	 * @param string $phone      Phone number
	 * @param string $message    Optional default message
	 * @param mixed  $content    Link content (defaults to phone number if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function sms( string $phone, string $message = '', $content = null, array $attributes = [] ): Element {
		// Use phone number as content if none provided
		if ( $content === null ) {
			$content = $phone;
		}

		// Remove any non-numeric characters for the href
		$clean_phone = Helpers::clean_phone_number( $phone );
		$href        = 'sms:' . $clean_phone;

		// Add message if provided
		if ( ! empty( $message ) ) {
			$href .= '?body=' . rawurlencode( $message );
		}

		return self::a( $href, $content, $attributes );
	}

	/**
	 * Create a download link
	 *
	 * @param string $url        URL to the downloadable file
	 * @param string $filename   Suggested filename for download (optional)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function download( string $url, string $filename = '', $content = null, array $attributes = [] ): Element {
		// Set download attribute
		if ( ! empty( $filename ) ) {
			$attributes['download'] = $filename;
		} else {
			$attributes['download'] = true;
		}

		return self::a( $url, $content, $attributes );
	}

	/**
	 * Create an external link (with target="_blank" and security attributes)
	 *
	 * @param string $url        URL
	 * @param mixed  $content    Element content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function external_link( string $url, $content = null, array $attributes = [] ): Element {
		// Set target, rel attributes for security and usability
		$attributes = array_merge( [
			'target' => '_blank',
			'rel'    => 'noopener noreferrer'
		], $attributes );

		return self::a( $url, $content, $attributes );
	}

	/**
	 * Create an anchor link to a section within the page
	 *
	 * @param string $section    ID of the section (without #)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function anchor( string $section, $content = null, array $attributes = [] ): Element {
		// Use section ID as content if none provided
		if ( $content === null ) {
			$content = $section;
		}

		return self::a( '#' . $section, $content, $attributes );
	}

	/**
	 * Create a link with a custom protocol handler
	 *
	 * @param string $protocol   Protocol (without colon)
	 * @param string $path       Path or identifier for the protocol
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function protocol( string $protocol, string $path, $content = null, array $attributes = [] ): Element {
		// Use protocol and path as content if none provided
		if ( $content === null ) {
			$content = $protocol . ':' . $path;
		}

		return self::a( $protocol . ':' . $path, $content, $attributes );
	}

}