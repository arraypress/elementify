<?php
/**
 * Elementify Library - Input Elements Trait
 *
 * A collection of methods for creating input-related HTML elements.
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

use Elementify\Components\Interactive\Range;
use Elementify\Elements\Input;
use Elementify\Elements\Textarea;

/**
 * Input Elements Trait
 *
 * Provides methods for creating input-related HTML elements.
 */
trait Inputs {

	/**
	 * Create an input element
	 *
	 * @param string $type       Input type
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function input( string $type, string $name, $value = null, array $attributes = [] ): Input {
		return new Input( $type, $name, $value, $attributes );
	}

	/**
	 * Create a text input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function text( string $name, $value = '', array $attributes = [] ): Input {
		return new Input( 'text', $name, $value, $attributes );
	}

	/**
	 * Create a number input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function number( string $name, $value = '', array $attributes = [] ): Input {
		return new Input( 'number', $name, $value, $attributes );
	}

	/**
	 * Create a date input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function date( string $name, $value = '', array $attributes = [] ): Input {
		return new Input( 'date', $name, $value, $attributes );
	}

	/**
	 * Create an email input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function email( string $name, $value = '', array $attributes = [] ): Input {
		return new Input( 'email', $name, $value, $attributes );
	}

	/**
	 * Create a password input
	 *
	 * @param string $name       Input name
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function password( string $name, array $attributes = [] ): Input {
		return new Input( 'password', $name, '', $attributes );
	}

	/**
	 * Create a checkbox input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param bool   $checked    Whether the checkbox is checked
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function checkbox( string $name, $value = '1', bool $checked = false, array $attributes = [] ): Input {
		$checkbox = new Input( 'checkbox', $name, $value, $attributes );

		if ( $checked ) {
			$checkbox->set_attribute( 'checked', true );
		}

		return $checkbox;
	}

	/**
	 * Create a radio input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param bool   $checked    Whether the radio is checked
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function radio( string $name, $value, bool $checked = false, array $attributes = [] ): Input {
		$radio = new Input( 'radio', $name, $value, $attributes );

		if ( $checked ) {
			$radio->set_attribute( 'checked', true );
		}

		return $radio;
	}

	/**
	 * Create a hidden input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function hidden( string $name, $value = '', array $attributes = [] ): Input {
		return new Input( 'hidden', $name, $value, $attributes );
	}

	/**
	 * Create a file input
	 *
	 * @param string $name       Input name
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function file( string $name, array $attributes = [] ): Input {
		return new Input( 'file', $name, null, $attributes );
	}

	/**
	 * Create a textarea element
	 *
	 * @param string $name       Textarea name
	 * @param string $content    Textarea content
	 * @param array  $attributes Element attributes
	 *
	 * @return Textarea
	 */
	public static function textarea( string $name, string $content = '', array $attributes = [] ): Textarea {
		return new Textarea( $name, $content, $attributes );
	}

	/**
	 * Create a range with display component
	 *
	 * @param string $name          Input name
	 * @param mixed  $value         Input value
	 * @param mixed  $min           Minimum value
	 * @param mixed  $max           Maximum value
	 * @param mixed  $step          Step value
	 * @param bool   $display_value Whether to display the value
	 * @param array  $attributes    Element attributes
	 * @param bool   $include_css   Whether to include built-in CSS
	 *
	 * @return Range
	 */
	public static function range(
		string $name,
		$value = '50',
		$min = '0',
		$max = '100',
		$step = '1',
		bool $display_value = true,
		array $attributes = [],
		bool $include_css = true
	): Range {
		return new Range( $name, $value, $min, $max, $step, $display_value, $attributes, $include_css );
	}

	/**
	 * Create a color input
	 *
	 * @param string $name       Input name
	 * @param string $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function color( string $name, string $value = '#000000', array $attributes = [] ): Input {
		return new Input( 'color', $name, $value, $attributes );
	}

}