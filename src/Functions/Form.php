<?php
/**
 * Elementify Library - Core Utility Functions
 *
 * Helper functions for creating HTML elements.
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
use Elementify\Elements\Form;
use Elementify\Elements\Input;
use Elementify\Elements\Select;
use Elementify\Elements\Button;
use Elementify\Elements\Textarea;
use Elementify\Elements\Field;

/**
 * Form Element Functions
 */
if ( ! function_exists( 'el_form' ) ) {
	/**
	 * Create a form element.
	 *
	 * @param string $action     Form action URL.
	 * @param string $method     Form method (get/post).
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Form
	 */
	function el_form( string $action = '', string $method = 'post', array $attributes = [] ): Form {
		return Create::form( $action, $method, $attributes );
	}
}

if ( ! function_exists( 'el_form_render' ) ) {
	/**
	 * Create and render a form element.
	 *
	 * @param string $action     Form action URL.
	 * @param string $method     Form method (get/post).
	 * @param array  $attributes Additional attributes.
	 */
	function el_form_render( string $action = '', string $method = 'post', array $attributes = [] ): void {
		Create::form_render( $action, $method, $attributes );
	}
}

/**
 * Input Element Functions
 */
if ( ! function_exists( 'el_input' ) ) {
	/**
	 * Create an input element.
	 *
	 * @param string $type       Input type.
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Input
	 */
	function el_input( string $type, string $name, $value = null, array $attributes = [] ): Input {
		return Create::input( $type, $name, $value, $attributes );
	}
}

if ( ! function_exists( 'el_input_render' ) ) {
	/**
	 * Create and render an input element.
	 *
	 * @param string $type       Input type.
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param array  $attributes Additional attributes.
	 */
	function el_input_render( string $type, string $name, $value = null, array $attributes = [] ): void {
		Create::input_render( $type, $name, $value, $attributes );
	}
}

if ( ! function_exists( 'el_text' ) ) {
	/**
	 * Create a text input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Input
	 */
	function el_text( string $name, $value = '', array $attributes = [] ): Input {
		return Create::text( $name, $value, $attributes );
	}
}

if ( ! function_exists( 'el_text_render' ) ) {
	/**
	 * Create and render a text input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param array  $attributes Additional attributes.
	 */
	function el_text_render( string $name, $value = '', array $attributes = [] ): void {
		Create::text_render( $name, $value, $attributes );
	}
}

if ( ! function_exists( 'el_email' ) ) {
	/**
	 * Create an email input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Input
	 */
	function el_email( string $name, $value = '', array $attributes = [] ): Input {
		return Create::email( $name, $value, $attributes );
	}
}

if ( ! function_exists( 'el_email_render' ) ) {
	/**
	 * Create and render an email input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param array  $attributes Additional attributes.
	 */
	function el_email_render( string $name, $value = '', array $attributes = [] ): void {
		Create::email_render( $name, $value, $attributes );
	}
}

if ( ! function_exists( 'el_password' ) ) {
	/**
	 * Create a password input.
	 *
	 * @param string $name       Input name.
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Input
	 */
	function el_password( string $name, array $attributes = [] ): Input {
		return Create::password( $name, $attributes );
	}
}

if ( ! function_exists( 'el_password_render' ) ) {
	/**
	 * Create and render a password input.
	 *
	 * @param string $name       Input name.
	 * @param array  $attributes Additional attributes.
	 */
	function el_password_render( string $name, array $attributes = [] ): void {
		Create::password_render( $name, $attributes );
	}
}

if ( ! function_exists( 'el_checkbox' ) ) {
	/**
	 * Create a checkbox input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param bool   $checked    Whether the checkbox is checked.
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Input
	 */
	function el_checkbox( string $name, $value = '1', bool $checked = false, array $attributes = [] ): Input {
		return Create::checkbox( $name, $value, $checked, $attributes );
	}
}

if ( ! function_exists( 'el_checkbox_render' ) ) {
	/**
	 * Create and render a checkbox input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param bool   $checked    Whether the checkbox is checked.
	 * @param array  $attributes Additional attributes.
	 */
	function el_checkbox_render( string $name, $value = '1', bool $checked = false, array $attributes = [] ): void {
		Create::checkbox_render( $name, $value, $checked, $attributes );
	}
}

if ( ! function_exists( 'el_radio' ) ) {
	/**
	 * Create a radio input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param bool   $checked    Whether the radio is checked.
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Input
	 */
	function el_radio( string $name, $value, bool $checked = false, array $attributes = [] ): Input {
		return Create::radio( $name, $value, $checked, $attributes );
	}
}

if ( ! function_exists( 'el_radio_render' ) ) {
	/**
	 * Create and render a radio input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param bool   $checked    Whether the radio is checked.
	 * @param array  $attributes Additional attributes.
	 */
	function el_radio_render( string $name, $value, bool $checked = false, array $attributes = [] ): void {
		Create::radio_render( $name, $value, $checked, $attributes );
	}
}

/**
 * Textarea Element Functions
 */
if ( ! function_exists( 'el_textarea' ) ) {
	/**
	 * Create a textarea element.
	 *
	 * @param string $name       Textarea name.
	 * @param string $content    Textarea content.
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Textarea
	 */
	function el_textarea( string $name, string $content = '', array $attributes = [] ): Textarea {
		return Create::textarea( $name, $content, $attributes );
	}
}

if ( ! function_exists( 'el_textarea_render' ) ) {
	/**
	 * Create and render a textarea element.
	 *
	 * @param string $name       Textarea name.
	 * @param string $content    Textarea content.
	 * @param array  $attributes Additional attributes.
	 */
	function el_textarea_render( string $name, string $content = '', array $attributes = [] ): void {
		Create::textarea_render( $name, $content, $attributes );
	}
}

/**
 * Select Element Functions
 */
if ( ! function_exists( 'el_select' ) ) {
	/**
	 * Create a select element.
	 *
	 * @param string $name           Select name.
	 * @param array  $options        Select options.
	 * @param mixed  $selected_value Selected value(s).
	 * @param array  $attributes     Additional attributes.
	 *
	 * @return Select
	 */
	function el_select( string $name, array $options = [], $selected_value = null, array $attributes = [] ): Select {
		return Create::select( $name, $options, $selected_value, $attributes );
	}
}

if ( ! function_exists( 'el_select_render' ) ) {
	/**
	 * Create and render a select element.
	 *
	 * @param string $name           Select name.
	 * @param array  $options        Select options.
	 * @param mixed  $selected_value Selected value(s).
	 * @param array  $attributes     Additional attributes.
	 */
	function el_select_render( string $name, array $options = [], $selected_value = null, array $attributes = [] ): void {
		Create::select_render( $name, $options, $selected_value, $attributes );
	}
}

/**
 * Button Element Functions
 */
if ( ! function_exists( 'el_button' ) ) {
	/**
	 * Create a button element.
	 *
	 * @param string $content    Button content.
	 * @param string $type       Button type.
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Button
	 */
	function el_button( string $content, string $type = 'submit', array $attributes = [] ): Button {
		return Create::button( $content, $type, $attributes );
	}
}

if ( ! function_exists( 'el_button_render' ) ) {
	/**
	 * Create and render a button element.
	 *
	 * @param string $content    Button content.
	 * @param string $type       Button type.
	 * @param array  $attributes Additional attributes.
	 */
	function el_button_render( string $content, string $type = 'submit', array $attributes = [] ): void {
		Create::button_render( $content, $type, $attributes );
	}
}

if ( ! function_exists( 'el_submit' ) ) {
	/**
	 * Create a submit button.
	 *
	 * @param string $content    Button content.
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Button
	 */
	function el_submit( string $content = 'Submit', array $attributes = [] ): Button {
		return Create::submit( $content, $attributes );
	}
}

if ( ! function_exists( 'el_submit_render' ) ) {
	/**
	 * Create and render a submit button.
	 *
	 * @param string $content    Button content.
	 * @param array  $attributes Additional attributes.
	 */
	function el_submit_render( string $content = 'Submit', array $attributes = [] ): void {
		Create::submit_render( $content, $attributes );
	}
}

/**
 * Field Wrapper Functions
 */
if ( ! function_exists( 'el_field' ) ) {
	/**
	 * Create a field wrapper (label + input + description).
	 *
	 * @param string|Element $input       Input element or name.
	 * @param string         $label       Label text.
	 * @param string         $description Description text.
	 * @param array          $attributes  Additional attributes.
	 *
	 * @return Field
	 */
	function el_field( $input, string $label = '', string $description = '', array $attributes = [] ): Field {
		return Create::field( $input, $label, $description, $attributes );
	}
}

if ( ! function_exists( 'el_field_render' ) ) {
	/**
	 * Create and render a field wrapper.
	 *
	 * @param string|Element $input       Input element or name.
	 * @param string         $label       Label text.
	 * @param string         $description Description text.
	 * @param array          $attributes  Additional attributes.
	 */
	function el_field_render( $input, string $label = '', string $description = '', array $attributes = [] ): void {
		Create::field_render( $input, $label, $description, $attributes );
	}
}

if ( ! function_exists( 'el_number' ) ) {
	/**
	 * Create a number input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Input
	 */
	function el_number( string $name, $value = '', array $attributes = [] ): Input {
		return Create::input( 'number', $name, $value, $attributes );
	}
}

if ( ! function_exists( 'el_number_render' ) ) {
	/**
	 * Create and render a number input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param array  $attributes Additional attributes.
	 */
	function el_number_render( string $name, $value = '', array $attributes = [] ): void {
		echo el_number( $name, $value, $attributes )->render();
	}
}

if ( ! function_exists( 'el_range' ) ) {
	/**
	 * Create a range input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param array  $attributes Additional attributes.
	 *
	 * @return Input
	 */
	function el_range( string $name, $value = '50', array $attributes = [] ): Input {
		return Create::input( 'range', $name, $value, $attributes );
	}
}

if ( ! function_exists( 'el_range_render' ) ) {
	/**
	 * Create and render a range input.
	 *
	 * @param string $name       Input name.
	 * @param mixed  $value      Input value.
	 * @param array  $attributes Additional attributes.
	 */
	function el_range_render( string $name, $value = '50', array $attributes = [] ): void {
		echo el_range( $name, $value, $attributes )->render();
	}
}