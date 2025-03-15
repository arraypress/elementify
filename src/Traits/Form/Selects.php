<?php
/**
 * Elementify Library - Select Elements Trait
 *
 * A collection of methods for creating select and option-related HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits\Form;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Element;
use Elementify\Elements\Select;

/**
 * Select Elements Trait
 *
 * Provides methods for creating select and option-related HTML elements.
 */
trait Selects {

	/**
	 * Create a select element
	 *
	 * @param string $name           Select name
	 * @param array  $options        Select options
	 * @param mixed  $selected_value Selected value(s)
	 * @param array  $attributes     Element attributes
	 *
	 * @return Select
	 */
	public static function select( string $name, array $options = [], $selected_value = null, array $attributes = [] ): Select {
		return new Select( $name, $options, $selected_value, $attributes );
	}

	/**
	 * Create and render a select element
	 *
	 * @param string $name           Select name
	 * @param array  $options        Select options
	 * @param mixed  $selected_value Selected value(s)
	 * @param array  $attributes     Element attributes
	 *
	 * @return void
	 */
	public static function select_render( string $name, array $options = [], $selected_value = null, array $attributes = [] ): void {
		self::select( $name, $options, $selected_value, $attributes )->output();
	}

	/**
	 * Create a datalist element
	 *
	 * @param string $id         Datalist ID
	 * @param array  $options    Array of options
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function datalist( string $id, array $options, array $attributes = [] ): Element {
		$datalist = self::element( 'datalist', null, array_merge( [ 'id' => $id ], $attributes ) );

		foreach ( $options as $key => $value ) {
			$option_attrs = [];

			if ( is_string( $key ) && ! is_numeric( $key ) ) {
				$option_attrs['value'] = $key;
				$option_attrs['label'] = $value;
			} else {
				$option_attrs['value'] = $value;
			}

			$datalist->add_child( self::element( 'option', null, $option_attrs ) );
		}

		return $datalist;
	}

	/**
	 * Create and render a datalist element
	 *
	 * @param string $id         Datalist ID
	 * @param array  $options    Array of options
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function datalist_render( string $id, array $options, array $attributes = [] ): void {
		self::datalist( $id, $options, $attributes )->output();
	}

}