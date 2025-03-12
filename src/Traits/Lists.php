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

namespace Elementify\Traits;

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
	 * Create and render an unordered list element
	 *
	 * @param array $items      List items
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function ul_render( array $items = [], array $attributes = [] ): void {
		self::ul( $items, $attributes )->output();
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
	 * Create and render an ordered list element
	 *
	 * @param array $items      List items
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function ol_render( array $items = [], array $attributes = [] ): void {
		self::ol( $items, $attributes )->output();
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
	 * Create and render a list item element
	 *
	 * @param mixed $content    Element content
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function li_render( $content = null, array $attributes = [] ): void {
		self::li( $content, $attributes )->output();
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
	 * Create and render a definition list
	 *
	 * @param array $items      Array of terms and definitions
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function dl_render( array $items = [], array $attributes = [] ): void {
		self::dl( $items, $attributes )->output();
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
	 * Create and render a menu (navigation list)
	 *
	 * @param array $items      Array of menu items
	 * @param array $attributes Element attributes
	 *
	 * @return void
	 */
	public static function menu_render( array $items, array $attributes = [] ): void {
		self::menu( $items, $attributes )->output();
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
	 * Create and render a dropdown menu
	 *
	 * @param string $label      Dropdown label
	 * @param array  $items      Array of dropdown items
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function dropdown_render( string $label, array $items, array $attributes = [] ): void {
		self::dropdown( $label, $items, $attributes )->output();
	}

}