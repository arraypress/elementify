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

use Elementify\Components\Range;
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
	 * Create and render an input element
	 *
	 * @param string $type       Input type
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function input_render( string $type, string $name, $value = null, array $attributes = [] ): void {
		self::input( $type, $name, $value, $attributes )->output();
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
	 * Create and render a text input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function text_render( string $name, $value = '', array $attributes = [] ): void {
		self::text( $name, $value, $attributes )->output();
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
	 * Create and render a number input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function number_render( string $name, $value = '', array $attributes = [] ): void {
		self::number( $name, $value, $attributes )->output();
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
	 * Create and render a date input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function date_render( string $name, $value = '', array $attributes = [] ): void {
		self::date( $name, $value, $attributes )->output();
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
	 * Create and render an email input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function email_render( string $name, $value = '', array $attributes = [] ): void {
		self::email( $name, $value, $attributes )->output();
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
	 * Create and render a password input
	 *
	 * @param string $name       Input name
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function password_render( string $name, array $attributes = [] ): void {
		self::password( $name, $attributes )->output();
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
	 * Create and render a checkbox input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param bool   $checked    Whether the checkbox is checked
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function checkbox_render( string $name, $value = '1', bool $checked = false, array $attributes = [] ): void {
		self::checkbox( $name, $value, $checked, $attributes )->output();
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
	 * Create and render a radio input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param bool   $checked    Whether the radio is checked
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function radio_render( string $name, $value, bool $checked = false, array $attributes = [] ): void {
		self::radio( $name, $value, $checked, $attributes )->output();
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
	 * Create and render a hidden input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function hidden_render( string $name, $value = '', array $attributes = [] ): void {
		self::hidden( $name, $value, $attributes )->output();
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
	 * Create and render a file input
	 *
	 * @param string $name       Input name
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function file_render( string $name, array $attributes = [] ): void {
		self::file( $name, $attributes )->output();
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
	 * Create and render a textarea element
	 *
	 * @param string $name       Textarea name
	 * @param string $content    Textarea content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function textarea_render( string $name, string $content = '', array $attributes = [] ): void {
		self::textarea( $name, $content, $attributes )->output();
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
	 * Create and render a range with display component
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
	 * @return void
	 */
	public static function range_render(
		string $name,
		$value = '50',
		$min = '0',
		$max = '100',
		$step = '1',
		bool $display_value = true,
		array $attributes = [],
		bool $include_css = true
	): void {
		self::range( $name, $value, $min, $max, $step, $display_value, $attributes, $include_css )->output();
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

	/**
	 * Create and render a color input
	 *
	 * @param string $name       Input name
	 * @param string $value      Input value
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function color_render( string $name, string $value = '#000000', array $attributes = [] ): void {
		self::color( $name, $value, $attributes )->output();
	}

}