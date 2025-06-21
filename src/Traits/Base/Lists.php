<?php
/**
 * Elementify Library - List Elements Trait
 *
 * A collection of methods for creating list HTML elements.
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
 * List Elements Trait
 *
 * Provides methods for creating list-related HTML elements (ul, ol, li, dl).
 */
trait Lists {

	/**
	 * Create an unordered list element
	 *
	 * @param array $items      List items
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function ul( array $items = [], array $attributes = [] ): Element {
		$ul = self::element( 'ul', null, $attributes );

		foreach ( $items as $item ) {
			if ( $item instanceof Element ) {
				if ( $item->get_tag() === 'li' ) {
					$ul->add_child( $item );
				} else {
					$ul->add_child( self::li( $item ) );
				}
			} else {
				$ul->add_child( self::li( $item ) );
			}
		}

		return $ul;
	}

	/**
	 * Create an ordered list element
	 *
	 * @param array $items      List items
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function ol( array $items = [], array $attributes = [] ): Element {
		$ol = self::element( 'ol', null, $attributes );

		foreach ( $items as $item ) {
			if ( $item instanceof Element ) {
				if ( $item->get_tag() === 'li' ) {
					$ol->add_child( $item );
				} else {
					$ol->add_child( self::li( $item ) );
				}
			} else {
				$ol->add_child( self::li( $item ) );
			}
		}

		return $ol;
	}

	/**
	 * Create a list item element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function li( $content = null, array $attributes = [] ): Element {
		return self::element( 'li', $content, $attributes );
	}

	/**
	 * Create a definition list
	 *
	 * @param array $items      Array of terms and definitions
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function dl( array $items = [], array $attributes = [] ): Element {
		$dl = self::element( 'dl', null, $attributes );

		foreach ( $items as $term => $definition ) {
			$dl->add_child( self::element( 'dt', $term ) );
			$dl->add_child( self::element( 'dd', $definition ) );
		}

		return $dl;
	}

	/**
	 * Create a menu (navigation list)
	 *
	 * @param array $items      Array of menu items
	 * @param array $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function menu( array $items, array $attributes = [] ): Element {
		$menu = self::element( 'ul', null, array_merge( [ 'class' => 'menu' ], $attributes ) );

		foreach ( $items as $item ) {
			// If item is already an Element
			if ( $item instanceof Element ) {
				if ( $item->get_tag() === 'li' ) {
					$menu->add_child( $item );
				} else {
					$menu->add_child( self::li( $item ) );
				}
			} // If item is an array with 'text' and 'href'
			elseif ( is_array( $item ) && isset( $item['text'] ) ) {
				$li = self::li();

				if ( isset( $item['href'] ) ) {
					$a = self::a( $item['href'], $item['text'] );

					if ( isset( $item['active'] ) && $item['active'] ) {
						$a->add_class( 'active' );
					}

					$li->add_child( $a );
				} else {
					$li->set_content( $item['text'] );
				}

				// Add any classes to the list item
				if ( isset( $item['class'] ) ) {
					$li->add_class( $item['class'] );
				}

				$menu->add_child( $li );
			} // If item is a string
			else {
				$menu->add_child( self::li( $item ) );
			}
		}

		return $menu;
	}

	/**
	 * Create a dropdown menu
	 *
	 * @param string $label      Dropdown label
	 * @param array  $items      Array of dropdown items
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function dropdown( string $label, array $items, array $attributes = [] ): Element {
		$dropdown = self::div( null, array_merge( [ 'class' => 'dropdown' ], $attributes ) );

		// Create toggle button
		$button = self::button( $label, 'button' )
		              ->add_class( 'dropdown-toggle' )
		              ->set_attribute( 'aria-haspopup', 'true' )
		              ->set_attribute( 'aria-expanded', 'false' );

		$dropdown->add_child( $button );

		// Create dropdown menu
		$menu = self::div( null, [ 'class' => 'dropdown-menu' ] );

		foreach ( $items as $key => $item ) {
			if ( is_string( $item ) && is_string( $key ) ) {
				// Key is href, value is label
				$menu->add_child(
					self::a( $key, $item )->add_class( 'dropdown-item' )
				);
			} elseif ( $item instanceof Element ) {
				if ( $item->get_tag() === 'a' ) {
					$item->add_class( 'dropdown-item' );
				}
				$menu->add_child( $item );
			} elseif ( is_array( $item ) && isset( $item['text'] ) ) {
				if ( isset( $item['href'] ) ) {
					$link = self::a( $item['href'], $item['text'] )->add_class( 'dropdown-item' );

					if ( isset( $item['active'] ) && $item['active'] ) {
						$link->add_class( 'active' );
					}

					$menu->add_child( $link );
				} elseif ( isset( $item['divider'] ) && $item['divider'] ) {
					$menu->add_child( self::div( null, [ 'class' => 'dropdown-divider' ] ) );
				} else {
					$menu->add_child( self::div( $item['text'], [ 'class' => 'dropdown-header' ] ) );
				}
			}
		}

		$dropdown->add_child( $menu );

		return $dropdown;
	}

	/**
	 * Create a list of links with flexible input format
	 *
	 * @param array $links      Array of links in various formats:
	 *                          - Associative array with keys as URLs and values as link text
	 *                          - Array of arrays with 'href' and 'text' keys
	 *                          - Array of arrays with additional attributes
	 * @param array $list_attrs Attributes for the list element
	 * @param bool  $ordered    Whether to create an ordered list (true) or unordered list (false)
	 *
	 * @return Element
	 */
	public static function link_list( array $links, array $list_attrs = [], bool $ordered = false ): Element {
		$items = [];

		foreach ( $links as $key => $value ) {
			if ( is_string( $key ) && is_string( $value ) ) {
				$items[] = self::a( $key, $value );
			} elseif ( is_array( $value ) && isset( $value['href'], $value['text'] ) ) {
				$attributes = $value;
				$href       = $attributes['href'];
				$text       = $attributes['text'];

				// Remove href and text from attributes
				unset( $attributes['href'], $attributes['text'] );

				$items[] = self::a( $href, $text, $attributes );
			} elseif ( $value instanceof Element && $value->get_tag() === 'a' ) {
				$items[] = $value;
			}
		}

		// Create ordered or unordered list based on preference
		return $ordered ? self::ol( $items, $list_attrs ) : self::ul( $items, $list_attrs );
	}

}