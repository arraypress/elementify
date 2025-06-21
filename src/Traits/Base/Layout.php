<?php
/**
 * Elementify Library - Layout Elements Trait
 *
 * A collection of methods for creating layout HTML elements.
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
 * Layout Elements Trait
 *
 * Provides methods for creating layout-related HTML elements.
 */
trait Layout {

	/**
	 * Create a section element
	 *
	 * @param mixed $content    Section content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function section( $content = null, array $attributes = [] ): Element {
		return self::element( 'section', $content, $attributes );
	}

	/**
	 * Create an article element
	 *
	 * @param mixed $content    Article content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function article( $content = null, array $attributes = [] ): Element {
		return self::element( 'article', $content, $attributes );
	}

	/**
	 * Create a header element
	 *
	 * @param mixed $content    Header content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function header( $content = null, array $attributes = [] ): Element {
		return self::element( 'header', $content, $attributes );
	}

	/**
	 * Create a footer element
	 *
	 * @param mixed $content    Footer content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function footer( $content = null, array $attributes = [] ): Element {
		return self::element( 'footer', $content, $attributes );
	}

	/**
	 * Create a nav element
	 *
	 * @param mixed $content    Nav content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function nav( $content = null, array $attributes = [] ): Element {
		return self::element( 'nav', $content, $attributes );
	}

	/**
	 * Create a main element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function main( $content = null, array $attributes = [] ): Element {
		return self::element( 'main', $content, $attributes );
	}

	/**
	 * Create an aside element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function aside( $content = null, array $attributes = [] ): Element {
		return self::element( 'aside', $content, $attributes );
	}

	/**
	 * Create a figure with optional caption
	 *
	 * @param mixed  $content    Figure content
	 * @param string $caption    Figure caption
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function figure( $content, string $caption = '', array $attributes = [] ): Element {
		$figure = self::element( 'figure', null, $attributes );
		$figure->add_content( $content );

		if ( ! empty( $caption ) ) {
			$figure->add_child( self::element( 'figcaption', $caption ) );
		}

		return $figure;
	}

	/**
	 * Create a table element
	 *
	 * @param array $data       Table data
	 * @param array $headers    Table headers
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function table( array $data = [], array $headers = [], array $attributes = [] ): Element {
		$table = self::element( 'table', null, $attributes );

		// Add headers if provided
		if ( ! empty( $headers ) ) {
			$thead = self::element( 'thead' );
			$tr    = self::element( 'tr' );

			foreach ( $headers as $header ) {
				$tr->add_child( self::element( 'th', $header ) );
			}

			$thead->add_child( $tr );
			$table->add_child( $thead );
		}

		// Add data rows
		if ( ! empty( $data ) ) {
			$tbody = self::element( 'tbody' );

			foreach ( $data as $row ) {
				$tr = self::element( 'tr' );

				foreach ( $row as $cell ) {
					$tr->add_child( self::element( 'td', $cell ) );
				}

				$tbody->add_child( $tr );
			}

			$table->add_child( $tbody );
		}

		return $table;
	}

	/**
	 * Create a details/summary expandable section
	 *
	 * @param string $summary    Summary text
	 * @param mixed  $content    Detailed content
	 * @param bool   $open       Whether the section is open by default
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function details( string $summary, $content, bool $open = false, array $attributes = [] ): Element {
		if ( $open ) {
			$attributes['open'] = true;
		}

		$details = self::element( 'details', null, $attributes );
		$details->add_child( self::element( 'summary', $summary ) );
		$details->add_content( $content );

		return $details;
	}

}