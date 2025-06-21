<?php
/**
 * Elementify Library - Basic Elements Trait
 *
 * A collection of methods for creating basic HTML elements.
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
 * Basic Elements Trait
 *
 * Provides methods for creating basic HTML elements like divs, spans, paragraphs, etc.
 */
trait Common {

	/**
	 * Create a div element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function div( $content = null, array $attributes = [] ): Element {
		return self::element( 'div', $content, $attributes );
	}

	/**
	 * Create and render a div element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function div_render( $content = null, array $attributes = [] ): void {
		self::div( $content, $attributes )->output();
	}

	/**
	 * Create a span element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function span( $content = null, array $attributes = [] ): Element {
		return self::element( 'span', $content, $attributes );
	}

	/**
	 * Create and render a span element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function span_render( $content = null, array $attributes = [] ): void {
		self::span( $content, $attributes )->output();
	}

	/**
	 * Create a paragraph element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function p( $content = null, array $attributes = [] ): Element {
		return self::element( 'p', $content, $attributes );
	}

	/**
	 * Create and render a paragraph element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function p_render( $content = null, array $attributes = [] ): void {
		self::p( $content, $attributes )->output();
	}

	/**
	 * Create a blockquote element
	 *
	 * @param mixed  $content    Blockquote content
	 * @param string $cite       Optional citation URL
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function blockquote( $content = null, string $cite = '', array $attributes = [] ): Element {
		if ( ! empty( $cite ) ) {
			$attributes['cite'] = $cite;
		}

		return self::element( 'blockquote', $content, $attributes );
	}

	/**
	 * Create and render a blockquote element
	 *
	 * @param mixed  $content    Blockquote content
	 * @param string $cite       Optional citation URL
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function blockquote_render( $content = null, string $cite = '', array $attributes = [] ): void {
		self::blockquote( $content, $cite, $attributes )->output();
	}

	/**
	 * Create a code element
	 *
	 * @param string $content    Code content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function code( string $content, array $attributes = [] ): Element {
		return self::element( 'code', $content, $attributes );
	}

	/**
	 * Create and render a code element
	 *
	 * @param string $content    Code content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function code_render( string $content, array $attributes = [] ): void {
		self::code( $content, $attributes )->output();
	}

	/**
	 * Create a pre element (for formatted code blocks)
	 *
	 * @param string $content    Pre-formatted content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function pre( string $content, array $attributes = [] ): Element {
		return self::element( 'pre', $content, $attributes );
	}

	/**
	 * Create and render a pre element
	 *
	 * @param string $content    Pre-formatted content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function pre_render( string $content, array $attributes = [] ): void {
		self::pre( $content, $attributes )->output();
	}

	/**
	 * Create a time element
	 *
	 * @param string $datetime   Machine-readable datetime
	 * @param string $content    Human-readable content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function time( string $datetime, string $content = '', array $attributes = [] ): Element {
		if ( empty( $content ) ) {
			$content = $datetime;
		}

		return self::element( 'time', $content, array_merge( [
			'datetime' => $datetime
		], $attributes ) );
	}

	/**
	 * Create and render a time element
	 *
	 * @param string $datetime   Machine-readable datetime
	 * @param string $content    Human-readable content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function time_render( string $datetime, string $content = '', array $attributes = [] ): void {
		self::time( $datetime, $content, $attributes )->output();
	}

}