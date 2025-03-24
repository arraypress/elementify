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

namespace Elementify\Traits;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Element;
use Elementify\Utils;

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
	 * Create and render an anchor (a) element
	 *
	 * @param string $href       URL
	 * @param mixed  $content    Element content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function a_render( string $href, $content = null, array $attributes = [] ): void {
		self::a( $href, $content, $attributes )->output();
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
	 * Create and render a mailto link
	 *
	 * @param string $email      Email address
	 * @param mixed  $content    Link content (defaults to email address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function mailto_render( string $email, $content = null, array $attributes = [] ): void {
		self::mailto( $email, $content, $attributes )->output();
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
		$clean_phone = Utils::clean_phone_number( $phone );

		return self::a( 'tel:' . $clean_phone, $content, $attributes );
	}

	/**
	 * Create and render a tel (telephone) link
	 *
	 * @param string $phone      Phone number
	 * @param mixed  $content    Link content (defaults to phone number if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function tel_render( string $phone, $content = null, array $attributes = [] ): void {
		self::tel( $phone, $content, $attributes )->output();
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
		$clean_phone = Utils::clean_phone_number( $phone );
		$href        = 'sms:' . $clean_phone;

		// Add message if provided
		if ( ! empty( $message ) ) {
			$href .= '?body=' . rawurlencode( $message );
		}

		return self::a( $href, $content, $attributes );
	}

	/**
	 * Create and render an sms link
	 *
	 * @param string $phone      Phone number
	 * @param string $message    Optional default message
	 * @param mixed  $content    Link content (defaults to phone number if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function sms_render( string $phone, string $message = '', $content = null, array $attributes = [] ): void {
		self::sms( $phone, $message, $content, $attributes )->output();
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
	 * Create and render a download link
	 *
	 * @param string $url        URL to the downloadable file
	 * @param string $filename   Suggested filename for download (optional)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function download_render( string $url, string $filename = '', $content = null, array $attributes = [] ): void {
		self::download( $url, $filename, $content, $attributes )->output();
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
	 * Create and render an external link
	 *
	 * @param string $url        URL
	 * @param mixed  $content    Element content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function external_link_render( string $url, $content = null, array $attributes = [] ): void {
		self::external_link( $url, $content, $attributes )->output();
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
	 * Create and render an anchor link to a section within the page
	 *
	 * @param string $section    ID of the section (without #)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function anchor_render( string $section, $content = null, array $attributes = [] ): void {
		self::anchor( $section, $content, $attributes )->output();
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

	/**
	 * Create and render a link with a custom protocol handler
	 *
	 * @param string $protocol   Protocol (without colon)
	 * @param string $path       Path or identifier for the protocol
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function protocol_render( string $protocol, string $path, $content = null, array $attributes = [] ): void {
		self::protocol( $protocol, $path, $content, $attributes )->output();
	}

	/**
	 * Create a Telegram link
	 *
	 * @param string $username   Telegram username (without @)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function telegram( string $username, $content = null, array $attributes = [] ): Element {
		// Use username as content if none provided
		if ( $content === null ) {
			$content = '@' . $username;
		}

		// Remove @ if it's at the beginning of the username
		$username = ltrim( $username, '@' );

		return self::a( 'https://t.me/' . $username, $content, $attributes );
	}

	/**
	 * Create and render a Telegram link
	 *
	 * @param string $username   Telegram username (without @)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function telegram_render( string $username, $content = null, array $attributes = [] ): void {
		self::telegram( $username, $content, $attributes )->output();
	}

	/**
	 * Create a FaceTime link
	 *
	 * @param string $contact    Email or phone number for FaceTime
	 * @param mixed  $content    Link content (defaults to contact if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function facetime( string $contact, $content = null, array $attributes = [] ): Element {
		// Use contact as content if none provided
		if ( $content === null ) {
			$content = $contact;
		}

		$contact = Utils::sanitize_contact( $contact );

		return self::a( 'facetime:' . $contact, $content, $attributes );
	}

	/**
	 * Create and render a FaceTime link
	 *
	 * @param string $contact    Email or phone number for FaceTime
	 * @param mixed  $content    Link content (defaults to contact if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function facetime_render( string $contact, $content = null, array $attributes = [] ): void {
		self::facetime( $contact, $content, $attributes )->output();
	}

	/**
	 * Create a webcal link for calendar events
	 *
	 * @param string $url        URL to the calendar file (without webcal:)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function webcal( string $url, $content = 'Add to Calendar', array $attributes = [] ): Element {
		// Remove http:// or https:// if present
		$url = Utils::strip_protocol( $url );

		return self::a( 'webcal://' . $url, $content, $attributes );
	}

	/**
	 * Create and render a webcal link
	 *
	 * @param string $url        URL to the calendar file (without webcal:)
	 * @param mixed  $content    Link content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function webcal_render( string $url, $content = 'Add to Calendar', array $attributes = [] ): void {
		self::webcal( $url, $content, $attributes )->output();
	}

}