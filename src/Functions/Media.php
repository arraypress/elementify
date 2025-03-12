<?php
/**
 * Elementify Library - Media Utility Functions
 *
 * Helper functions for creating HTML media elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Create;
use Elementify\Element;

if ( ! function_exists( 'el_img' ) ) {
	/**
	 * Create an image element.
	 *
	 * @param string $src        Image URL.
	 * @param string $alt        Alternative text.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_img( string $src, string $alt = '', array $attributes = [] ): Element {
		return Create::img( $src, $alt, $attributes );
	}
}

if ( ! function_exists( 'el_img_render' ) ) {
	/**
	 * Create and render an image element.
	 *
	 * @param string $src        Image URL.
	 * @param string $alt        Alternative text.
	 * @param array  $attributes Element attributes.
	 */
	function el_img_render( string $src, string $alt = '', array $attributes = [] ): void {
		Create::img_render( $src, $alt, $attributes );
	}
}

if ( ! function_exists( 'el_audio' ) ) {
	/**
	 * Create an audio element.
	 *
	 * @param string|array $src        Audio source URL or array of sources.
	 * @param bool         $controls   Whether to show audio controls.
	 * @param array        $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_audio( $src, bool $controls = true, array $attributes = [] ): Element {
		return Create::audio( $src, $controls, $attributes );
	}
}

if ( ! function_exists( 'el_audio_render' ) ) {
	/**
	 * Create and render an audio element.
	 *
	 * @param string|array $src        Audio source URL or array of sources.
	 * @param bool         $controls   Whether to show audio controls.
	 * @param array        $attributes Element attributes.
	 */
	function el_audio_render( $src, bool $controls = true, array $attributes = [] ): void {
		Create::audio_render( $src, $controls, $attributes );
	}
}

if ( ! function_exists( 'el_video' ) ) {
	/**
	 * Create a video element.
	 *
	 * @param string|array $src        Video source URL or array of sources.
	 * @param bool         $controls   Whether to show video controls.
	 * @param array        $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_video( $src, bool $controls = true, array $attributes = [] ): Element {
		return Create::video( $src, $controls, $attributes );
	}
}

if ( ! function_exists( 'el_video_render' ) ) {
	/**
	 * Create and render a video element.
	 *
	 * @param string|array $src        Video source URL or array of sources.
	 * @param bool         $controls   Whether to show video controls.
	 * @param array        $attributes Element attributes.
	 */
	function el_video_render( $src, bool $controls = true, array $attributes = [] ): void {
		Create::video_render( $src, $controls, $attributes );
	}
}

if ( ! function_exists( 'el_source' ) ) {
	/**
	 * Create a source element for audio/video.
	 *
	 * @param string $src        Source URL.
	 * @param string $type       MIME type.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_source( string $src, string $type, array $attributes = [] ): Element {
		return Create::source( $src, $type, $attributes );
	}
}

if ( ! function_exists( 'el_source_render' ) ) {
	/**
	 * Create and render a source element for audio/video.
	 *
	 * @param string $src        Source URL.
	 * @param string $type       MIME type.
	 * @param array  $attributes Element attributes.
	 */
	function el_source_render( string $src, string $type, array $attributes = [] ): void {
		Create::source_render( $src, $type, $attributes );
	}
}

if ( ! function_exists( 'el_picture' ) ) {
	/**
	 * Create a picture element.
	 *
	 * @param array  $sources    Array of source elements or arrays with src and media attributes.
	 * @param string $img_src    Fallback image source.
	 * @param string $alt        Alternative text for the image.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_picture( array $sources, string $img_src, string $alt = '', array $attributes = [] ): Element {
		return Create::picture( $sources, $img_src, $alt, $attributes );
	}
}

if ( ! function_exists( 'el_picture_render' ) ) {
	/**
	 * Create and render a picture element.
	 *
	 * @param array  $sources    Array of source elements or arrays with src and media attributes.
	 * @param string $img_src    Fallback image source.
	 * @param string $alt        Alternative text for the image.
	 * @param array  $attributes Element attributes.
	 */
	function el_picture_render( array $sources, string $img_src, string $alt = '', array $attributes = [] ): void {
		Create::picture_render( $sources, $img_src, $alt, $attributes );
	}
}

if ( ! function_exists( 'el_iframe' ) ) {
	/**
	 * Create an iframe element.
	 *
	 * @param string $src        Source URL.
	 * @param string $title      Title for accessibility.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_iframe( string $src, string $title, array $attributes = [] ): Element {
		return Create::iframe( $src, $title, $attributes );
	}
}

if ( ! function_exists( 'el_iframe_render' ) ) {
	/**
	 * Create and render an iframe element.
	 *
	 * @param string $src        Source URL.
	 * @param string $title      Title for accessibility.
	 * @param array  $attributes Element attributes.
	 */
	function el_iframe_render( string $src, string $title, array $attributes = [] ): void {
		Create::iframe_render( $src, $title, $attributes );
	}
}