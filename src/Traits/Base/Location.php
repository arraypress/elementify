<?php
/**
 * Elementify Library - Location Links Trait
 *
 * A collection of methods for creating location-based HTML link elements.
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

/**
 * Location Trait
 *
 * Provides methods for creating location-based link elements for various map platforms.
 */
trait Location {

	/**
	 * Create a Google Maps link to an address
	 *
	 * @param string $address    Physical address
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function google_map( string $address, $content = null, array $attributes = [] ): Element {
		// Use address as content if none provided
		if ( $content === null ) {
			$content = $address;
		}

		$map_url = 'https://maps.google.com/?q=' . rawurlencode( $address );

		return self::a( $map_url, $content, $attributes );
	}

	/**
	 * Create and render a Google Maps link
	 *
	 * @param string $address    Physical address
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function google_map_render( string $address, $content = null, array $attributes = [] ): void {
		self::google_map( $address, $content, $attributes )->output();
	}

	/**
	 * Create a Bing Maps link to an address
	 *
	 * @param string $address    Physical address
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function bing_map( string $address, $content = null, array $attributes = [] ): Element {
		// Use address as content if none provided
		if ( $content === null ) {
			$content = $address;
		}

		$map_url = 'https://www.bing.com/maps?q=' . rawurlencode( $address );

		return self::a( $map_url, $content, $attributes );
	}

	/**
	 * Create and render a Bing Maps link
	 *
	 * @param string $address    Physical address
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function bing_map_render( string $address, $content = null, array $attributes = [] ): void {
		self::bing_map( $address, $content, $attributes )->output();
	}

	/**
	 * Create an Apple Maps link to an address
	 *
	 * @param string $address    Physical address
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function apple_map( string $address, $content = null, array $attributes = [] ): Element {
		// Use address as content if none provided
		if ( $content === null ) {
			$content = $address;
		}

		$map_url = 'https://maps.apple.com/?q=' . rawurlencode( $address );

		return self::a( $map_url, $content, $attributes );
	}

	/**
	 * Create and render an Apple Maps link
	 *
	 * @param string $address    Physical address
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function apple_map_render( string $address, $content = null, array $attributes = [] ): void {
		self::apple_map( $address, $content, $attributes )->output();
	}

	/**
	 * Create an OpenStreetMap link to an address
	 *
	 * @param string $address    Physical address
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function osm_map( string $address, $content = null, array $attributes = [] ): Element {
		// Use address as content if none provided
		if ( $content === null ) {
			$content = $address;
		}

		$map_url = 'https://www.openstreetmap.org/search?query=' . rawurlencode( $address );

		return self::a( $map_url, $content, $attributes );
	}

	/**
	 * Create and render an OpenStreetMap link
	 *
	 * @param string $address    Physical address
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function osm_map_render( string $address, $content = null, array $attributes = [] ): void {
		self::osm_map( $address, $content, $attributes )->output();
	}

	/**
	 * Create a map link for a specific platform or a generic one
	 *
	 * @param string $address    Physical address
	 * @param string $platform   Map platform (google, bing, apple, osm, waze, here)
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function map( string $address, string $platform = 'google', $content = null, array $attributes = [] ): Element {
		switch ( strtolower( $platform ) ) {
			case 'bing':
				return self::bing_map( $address, $content, $attributes );
			case 'apple':
				return self::apple_map( $address, $content, $attributes );
			case 'osm':
			case 'openstreetmap':
				return self::osm_map( $address, $content, $attributes );
			case 'google':
			default:
				return self::google_map( $address, $content, $attributes );
		}
	}

	/**
	 * Create and render a map link for a specific platform or a generic one
	 *
	 * @param string $address    Physical address
	 * @param string $platform   Map platform (google, bing, apple, osm, waze, here)
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function map_render( string $address, string $platform = 'google', $content = null, array $attributes = [] ): void {
		self::map( $address, $platform, $content, $attributes )->output();
	}

	/**
	 * Create a map link that uses the device's default map application
	 * This works better for mobile devices by using appropriate URI schemes
	 *
	 * @param string $address    Physical address
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function device_map( string $address, $content = null, array $attributes = [] ): Element {
		// Use address as content if none provided
		if ( $content === null ) {
			$content = $address;
		}

		// Use geo: URI scheme which will be handled by the device's default map app
		$map_url = 'geo:0,0?q=' . rawurlencode( $address );

		return self::a( $map_url, $content, $attributes );
	}

	/**
	 * Create and render a map link that uses the device's default map application
	 *
	 * @param string $address    Physical address
	 * @param mixed  $content    Link content (defaults to address if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function device_map_render( string $address, $content = null, array $attributes = [] ): void {
		self::device_map( $address, $content, $attributes )->output();
	}

	/**
	 * Create a map link for coordinates (latitude, longitude)
	 *
	 * @param float  $latitude   Latitude coordinate
	 * @param float  $longitude  Longitude coordinate
	 * @param string $platform   Map platform (google, bing, apple, osm, waze, here)
	 * @param mixed  $content    Link content (defaults to coordinates if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function coordinates_map( float $latitude, float $longitude, string $platform = 'google', $content = null, array $attributes = [] ): Element {
		// Use coordinates as content if none provided
		if ( $content === null ) {
			$content = "$latitude, $longitude";
		}

		// Create platform-specific URL formats for coordinates
		switch ( strtolower( $platform ) ) {
			case 'bing':
				$map_url = "https://www.bing.com/maps?cp=$latitude~$longitude&lvl=16";
				break;
			case 'apple':
				$map_url = "https://maps.apple.com/?ll=$latitude,$longitude";
				break;
			case 'osm':
			case 'openstreetmap':
				$map_url = "https://www.openstreetmap.org/?mlat=$latitude&mlon=$longitude&zoom=16";
				break;
			case 'google':
			default:
				$map_url = "https://maps.google.com/?q=$latitude,$longitude";
				break;
		}

		return self::a( $map_url, $content, $attributes );
	}

	/**
	 * Create and render a map link for coordinates
	 *
	 * @param float  $latitude   Latitude coordinate
	 * @param float  $longitude  Longitude coordinate
	 * @param string $platform   Map platform (google, bing, apple, osm, waze, here)
	 * @param mixed  $content    Link content (defaults to coordinates if not provided)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function coordinates_map_render( float $latitude, float $longitude, string $platform = 'google', $content = null, array $attributes = [] ): void {
		self::coordinates_map( $latitude, $longitude, $platform, $content, $attributes )->output();
	}

}