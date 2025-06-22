<?php
/**
 * Elementify Library - Media Elements Trait
 *
 * A collection of methods for creating media HTML elements.
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
use Elementify\Utils\File;

/**
 * Media Elements Trait
 *
 * Provides methods for creating media-related HTML elements (images, audio, video, iframe).
 */
trait Media {

	/**
	 * Create an image element
	 *
	 * @param string $src        Image URL
	 * @param string $alt        Alternative text
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function img( string $src, string $alt = '', array $attributes = [] ): Element {
		return self::element( 'img', null, array_merge( [ 'src' => $src, 'alt' => $alt ], $attributes ) );
	}

	/**
	 * Create an audio element
	 *
	 * @param string|array $src        Audio source URL or array of sources
	 * @param bool         $controls   Whether to show audio controls
	 * @param array        $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function audio( $src, bool $controls = true, array $attributes = [] ): Element {
		$audio = self::element( 'audio', null, $attributes );

		if ( $controls ) {
			$audio->set_attribute( 'controls', true );
		}

		// Handle single source
		if ( is_string( $src ) ) {
			$audio->add_child( self::source( $src, File::get_mime_type( $src ) ) );
		} // Handle multiple sources
		elseif ( is_array( $src ) ) {
			foreach ( $src as $source ) {
				if ( is_string( $source ) ) {
					$audio->add_child( self::source( $source, File::get_mime_type( $source ) ) );
				} elseif ( is_array( $source ) && isset( $source['src'], $source['type'] ) ) {
					$audio->add_child( self::source( $source['src'], $source['type'] ) );
				}
			}
		}

		return $audio;
	}

	/**
	 * Create a video element
	 *
	 * @param string|array $src        Video source URL or array of sources
	 * @param bool         $controls   Whether to show video controls
	 * @param array        $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function video( $src, bool $controls = true, array $attributes = [] ): Element {
		$video = self::element( 'video', null, $attributes );

		if ( $controls ) {
			$video->set_attribute( 'controls', true );
		}

		// Handle single source
		if ( is_string( $src ) ) {
			$video->add_child( self::source( $src, File::get_mime_type( $src ) ) );
		} // Handle multiple sources
		elseif ( is_array( $src ) ) {
			foreach ( $src as $source ) {
				if ( is_string( $source ) ) {
					$video->add_child( self::source( $source, File::get_mime_type( $source ) ) );
				} elseif ( is_array( $source ) && isset( $source['src'], $source['type'] ) ) {
					$video->add_child( self::source( $source['src'], $source['type'] ) );
				}
			}
		}

		return $video;
	}

	/**
	 * Create a source element for audio/video
	 *
	 * @param string $src        Source URL
	 * @param string $type       MIME type
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function source( string $src, string $type, array $attributes = [] ): Element {
		return self::element( 'source', null, array_merge( [
			'src'  => $src,
			'type' => $type
		], $attributes ) );
	}

	/**
	 * Create a picture element
	 *
	 * @param array  $sources    Array of source elements or arrays with src and media attributes
	 * @param string $img_src    Fallback image source
	 * @param string $alt        Alternative text for the image
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function picture( array $sources, string $img_src, string $alt = '', array $attributes = [] ): Element {
		$picture = self::element( 'picture', null, $attributes );

		// Add sources
		foreach ( $sources as $source ) {
			if ( $source instanceof Element ) {
				$picture->add_child( $source );
			} elseif ( is_array( $source ) && isset( $source['src'] ) ) {
				$source_elem = self::element( 'source', null, [
					'srcset' => $source['src'],
					'type'   => $source['type'] ?? File::get_mime_type( $source['src'] )
				] );

				if ( isset( $source['media'] ) ) {
					$source_elem->set_attribute( 'media', $source['media'] );
				}

				$picture->add_child( $source_elem );
			}
		}

		// Add fallback image
		$picture->add_child( self::img( $img_src, $alt ) );

		return $picture;
	}

	/**
	 * Create an iframe element
	 *
	 * @param string $src        Source URL
	 * @param string $title      Title for accessibility
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function iframe( string $src, string $title, array $attributes = [] ): Element {
		return self::element( 'iframe', null, array_merge( [
			'src'         => $src,
			'title'       => $title,
			'frameborder' => '0',
			'loading'     => 'lazy'
		], $attributes ) );
	}

}