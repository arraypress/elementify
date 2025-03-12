<?php
/**
 * Elementify Library - Form Elements Trait
 *
 * A collection of methods for creating form-related HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits;

use Elementify\Element;
use Elementify\Elements\Form;
use Elementify\Elements\Input;
use Elementify\Elements\Label;
use Elementify\Elements\Select;
use Elementify\Elements\Textarea;
use Elementify\Elements\Button;
use Elementify\Elements\Field;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Form Elements Trait
 *
 * Provides methods for creating form-related HTML elements.
 */
trait Forms {

	/**
	 * Create a form element
	 *
	 * @param string $action     Form action URL
	 * @param string $method     Form method
	 * @param array  $attributes Element attributes
	 *
	 * @return Form
	 */
	public static function form( string $action = '', string $method = 'post', array $attributes = [] ): Form {
		return new Form( $action, $method, $attributes );
	}

	/**
	 * Create and render a form element
	 *
	 * @param string $action     Form action URL
	 * @param string $method     Form method
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function form_render( string $action = '', string $method = 'post', array $attributes = [] ): void {
		self::form( $action, $method, $attributes )->output();
	}

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
	 * Create a button element
	 *
	 * @param string $content    Button content
	 * @param string $type       Button type
	 * @param array  $attributes Element attributes
	 *
	 * @return Button
	 */
	public static function button( string $content, string $type = 'submit', array $attributes = [] ): Button {
		return new Button( $type, $content, $attributes );
	}

	/**
	 * Create and render a button element
	 *
	 * @param string $content    Button content
	 * @param string $type       Button type
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function button_render( string $content, string $type = 'submit', array $attributes = [] ): void {
		self::button( $content, $type, $attributes )->output();
	}

	/**
	 * Create a submit button
	 *
	 * @param string $content    Button content
	 * @param array  $attributes Element attributes
	 *
	 * @return Button
	 */
	public static function submit( string $content = 'Submit', array $attributes = [] ): Button {
		return self::button( $content, 'submit', $attributes );
	}

	/**
	 * Create and render a submit button
	 *
	 * @param string $content    Button content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function submit_render( string $content = 'Submit', array $attributes = [] ): void {
		self::submit( $content, $attributes )->output();
	}

	/**
	 * Create a label element
	 *
	 * @param string $for        ID of the associated form control
	 * @param string $content    Label content
	 * @param array  $attributes Element attributes
	 *
	 * @return Label
	 */
	public static function label( string $for, string $content, array $attributes = [] ): Label {
		return new Label( $for, $content, $attributes );
	}

	/**
	 * Create and render a label element
	 *
	 * @param string $for        ID of the associated form control
	 * @param string $content    Label content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function label_render( string $for, string $content, array $attributes = [] ): void {
		self::label( $for, $content, $attributes )->output();
	}

	/**
	 * Create a field wrapper (label + input + description)
	 *
	 * @param string|Element $input       Input element or name
	 * @param string         $label       Label text
	 * @param string         $description Description text
	 * @param array          $attributes  Wrapper attributes
	 *
	 * @return Field
	 */
	public static function field( $input, string $label = '', string $description = '', array $attributes = [] ): Field {
		return new Field( $input, $label, $description, $attributes );
	}

	/**
	 * Create and render a field wrapper
	 *
	 * @param string|Element $input       Input element or name
	 * @param string         $label       Label text
	 * @param string         $description Description text
	 * @param array          $attributes  Wrapper attributes
	 *
	 * @return void
	 */
	public static function field_render( $input, string $label = '', string $description = '', array $attributes = [] ): void {
		self::field( $input, $label, $description, $attributes )->output();
	}

	/**
	 * Create a range input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param mixed  $min        Minimum value
	 * @param mixed  $max        Maximum value
	 * @param array  $attributes Element attributes
	 *
	 * @return Input
	 */
	public static function range( string $name, $value = '50', $min = '0', $max = '100', array $attributes = [] ): Input {
		$range = new Input( 'range', $name, $value, $attributes );
		$range->set_min( $min );
		$range->set_max( $max );

		return $range;
	}

	/**
	 * Create and render a range input
	 *
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param mixed  $min        Minimum value
	 * @param mixed  $max        Maximum value
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function range_render( string $name, $value = '50', $min = '0', $max = '100', array $attributes = [] ): void {
		self::range( $name, $value, $min, $max, $attributes )->output();
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

	/**
	 * Create a fieldset element
	 *
	 * @param mixed  $content    Content of the fieldset
	 * @param string $legend     Legend text (optional)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function fieldset( $content = null, string $legend = '', array $attributes = [] ): Element {
		$fieldset = self::element( 'fieldset', null, $attributes );

		if ( ! empty( $legend ) ) {
			$fieldset->add_child( self::element( 'legend', $legend ) );
		}

		if ( $content !== null ) {
			$fieldset->add_content( $content );
		}

		return $fieldset;
	}

	/**
	 * Create and render a fieldset element
	 *
	 * @param mixed  $content    Content of the fieldset
	 * @param string $legend     Legend text (optional)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function fieldset_render( $content = null, string $legend = '', array $attributes = [] ): void {
		self::fieldset( $content, $legend, $attributes )->output();
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

	/**
	 * Create a WordPress nonce field
	 *
	 * @param string $action  Action name
	 * @param string $name    Nonce name
	 * @param bool   $referer Whether to include the referer field
	 *
	 * @return string
	 */
	public static function nonce( string $action, string $name = '_wpnonce', bool $referer = true ): string {
		if ( function_exists( 'wp_nonce_field' ) ) {
			ob_start();
			wp_nonce_field( $action, $name, $referer );

			return ob_get_clean();
		}

		return '';
	}

	/**
	 * Output a WordPress nonce field
	 *
	 * @param string $action  Action name
	 * @param string $name    Nonce name
	 * @param bool   $referer Whether to include the referer field
	 *
	 * @return void
	 */
	public static function nonce_render( string $action, string $name = '_wpnonce', bool $referer = true ): void {
		echo self::nonce( $action, $name, $referer );
	}

}