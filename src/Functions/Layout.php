<?php
/**
 * Elementify Library - Layout Utility Functions
 *
 * Helper functions for creating HTML layout elements.
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

if ( ! function_exists( 'el_section' ) ) {
	/**
	 * Create a section element.
	 *
	 * @param mixed $content    Section content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_section( $content = null, array $attributes = [] ): Element {
		return Create::section( $content, $attributes );
	}
}

if ( ! function_exists( 'el_section_render' ) ) {
	/**
	 * Create and render a section element.
	 *
	 * @param mixed $content    Section content.
	 * @param array $attributes Element attributes.
	 */
	function el_section_render( $content = null, array $attributes = [] ): void {
		Create::section_render( $content, $attributes );
	}
}

if ( ! function_exists( 'el_article' ) ) {
	/**
	 * Create an article element.
	 *
	 * @param mixed $content    Article content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_article( $content = null, array $attributes = [] ): Element {
		return Create::article( $content, $attributes );
	}
}

if ( ! function_exists( 'el_article_render' ) ) {
	/**
	 * Create and render an article element.
	 *
	 * @param mixed $content    Article content.
	 * @param array $attributes Element attributes.
	 */
	function el_article_render( $content = null, array $attributes = [] ): void {
		Create::article_render( $content, $attributes );
	}
}

if ( ! function_exists( 'el_header' ) ) {
	/**
	 * Create a header element.
	 *
	 * @param mixed $content    Header content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_header( $content = null, array $attributes = [] ): Element {
		return Create::header( $content, $attributes );
	}
}

if ( ! function_exists( 'el_header_render' ) ) {
	/**
	 * Create and render a header element.
	 *
	 * @param mixed $content    Header content.
	 * @param array $attributes Element attributes.
	 */
	function el_header_render( $content = null, array $attributes = [] ): void {
		Create::header_render( $content, $attributes );
	}
}

if ( ! function_exists( 'el_footer' ) ) {
	/**
	 * Create a footer element.
	 *
	 * @param mixed $content    Footer content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_footer( $content = null, array $attributes = [] ): Element {
		return Create::footer( $content, $attributes );
	}
}

if ( ! function_exists( 'el_footer_render' ) ) {
	/**
	 * Create and render a footer element.
	 *
	 * @param mixed $content    Footer content.
	 * @param array $attributes Element attributes.
	 */
	function el_footer_render( $content = null, array $attributes = [] ): void {
		Create::footer_render( $content, $attributes );
	}
}

if ( ! function_exists( 'el_nav' ) ) {
	/**
	 * Create a nav element.
	 *
	 * @param mixed $content    Nav content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_nav( $content = null, array $attributes = [] ): Element {
		return Create::nav( $content, $attributes );
	}
}

if ( ! function_exists( 'el_nav_render' ) ) {
	/**
	 * Create and render a nav element.
	 *
	 * @param mixed $content    Nav content.
	 * @param array $attributes Element attributes.
	 */
	function el_nav_render( $content = null, array $attributes = [] ): void {
		Create::nav_render( $content, $attributes );
	}
}

if ( ! function_exists( 'el_main' ) ) {
	/**
	 * Create a main element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_main( $content = null, array $attributes = [] ): Element {
		return Create::main( $content, $attributes );
	}
}

if ( ! function_exists( 'el_main_render' ) ) {
	/**
	 * Create and render a main element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 */
	function el_main_render( $content = null, array $attributes = [] ): void {
		Create::main_render( $content, $attributes );
	}
}

if ( ! function_exists( 'el_aside' ) ) {
	/**
	 * Create an aside element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_aside( $content = null, array $attributes = [] ): Element {
		return Create::aside( $content, $attributes );
	}
}

if ( ! function_exists( 'el_aside_render' ) ) {
	/**
	 * Create and render an aside element.
	 *
	 * @param mixed $content    Element content.
	 * @param array $attributes Element attributes.
	 */
	function el_aside_render( $content = null, array $attributes = [] ): void {
		Create::aside_render( $content, $attributes );
	}
}

if ( ! function_exists( 'el_figure' ) ) {
	/**
	 * Create a figure with optional caption.
	 *
	 * @param mixed  $content    Figure content.
	 * @param string $caption    Figure caption.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_figure( $content, string $caption = '', array $attributes = [] ): Element {
		return Create::figure( $content, $caption, $attributes );
	}
}

if ( ! function_exists( 'el_figure_render' ) ) {
	/**
	 * Create and render a figure with optional caption.
	 *
	 * @param mixed  $content    Figure content.
	 * @param string $caption    Figure caption.
	 * @param array  $attributes Element attributes.
	 */
	function el_figure_render( $content, string $caption = '', array $attributes = [] ): void {
		Create::figure_render( $content, $caption, $attributes );
	}
}

if ( ! function_exists( 'el_table' ) ) {
	/**
	 * Create a table element.
	 *
	 * @param array $data       Table data.
	 * @param array $headers    Table headers.
	 * @param array $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_table( array $data = [], array $headers = [], array $attributes = [] ): Element {
		return Create::table( $data, $headers, $attributes );
	}
}

if ( ! function_exists( 'el_table_render' ) ) {
	/**
	 * Create and render a table element.
	 *
	 * @param array $data       Table data.
	 * @param array $headers    Table headers.
	 * @param array $attributes Element attributes.
	 */
	function el_table_render( array $data = [], array $headers = [], array $attributes = [] ): void {
		Create::table_render( $data, $headers, $attributes );
	}
}

if ( ! function_exists( 'el_details' ) ) {
	/**
	 * Create a details/summary expandable section.
	 *
	 * @param string $summary    Summary text.
	 * @param mixed  $content    Detailed content.
	 * @param bool   $open       Whether the section is open by default.
	 * @param array  $attributes Element attributes.
	 *
	 * @return Element
	 */
	function el_details( string $summary, $content, bool $open = false, array $attributes = [] ): Element {
		return Create::details( $summary, $content, $open, $attributes );
	}
}

if ( ! function_exists( 'el_details_render' ) ) {
	/**
	 * Create and render a details/summary expandable section.
	 *
	 * @param string $summary    Summary text.
	 * @param mixed  $content    Detailed content.
	 * @param bool   $open       Whether the section is open by default.
	 * @param array  $attributes Element attributes.
	 */
	function el_details_render( string $summary, $content, bool $open = false, array $attributes = [] ): void {
		Create::details_render( $summary, $content, $open, $attributes );
	}
}