<?php
/**
 * Elementify Library - Form Builder
 *
 * Provides a fluent interface for building forms with automatic field wrapping.
 *
 * @package     ArrayPress\Elementify\Builders
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Builders;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Elements\Form;
use Elementify\Create;

/**
 * Form Builder Class
 *
 * Extends the Form element to provide fluent methods for adding form fields
 * with automatic field wrapper creation and validation.
 */
class FormBuilder extends Form {

	/**
	 * Add a text input field with label and description
	 *
	 * @param string $name        Input name attribute
	 * @param string $label       Field label text
	 * @param string $description Optional field description/help text
	 * @param array  $attributes  Input element attributes
	 *
	 * @return $this For method chaining
	 */
	public function text_field( string $name, string $label = '', string $description = '', array $attributes = [] ): self {
		$input = Create::text( $name, '', $attributes );
		$field = Create::field( $input, $label, $description );

		return $this->add_child( $field );
	}

	/**
	 * Add an email input field with label and description
	 *
	 * @param string $name        Input name attribute
	 * @param string $label       Field label text
	 * @param string $description Optional field description/help text
	 * @param array  $attributes  Input element attributes
	 *
	 * @return $this For method chaining
	 */
	public function email_field( string $name, string $label = '', string $description = '', array $attributes = [] ): self {
		$input = Create::email( $name, '', $attributes );
		$field = Create::field( $input, $label, $description );

		return $this->add_child( $field );
	}

	/**
	 * Add a password input field with label and description
	 *
	 * @param string $name        Input name attribute
	 * @param string $label       Field label text
	 * @param string $description Optional field description/help text
	 * @param array  $attributes  Input element attributes
	 *
	 * @return $this For method chaining
	 */
	public function password_field( string $name, string $label = '', string $description = '', array $attributes = [] ): self {
		$input = Create::password( $name, $attributes );
		$field = Create::field( $input, $label, $description );

		return $this->add_child( $field );
	}

	/**
	 * Add a number input field with label and description
	 *
	 * @param string $name        Input name attribute
	 * @param string $label       Field label text
	 * @param string $description Optional field description/help text
	 * @param array  $attributes  Input element attributes (min, max, step, etc.)
	 *
	 * @return $this For method chaining
	 */
	public function number_field( string $name, string $label = '', string $description = '', array $attributes = [] ): self {
		$input = Create::number( $name, '', $attributes );
		$field = Create::field( $input, $label, $description );

		return $this->add_child( $field );
	}

	/**
	 * Add a textarea field with label and description
	 *
	 * @param string $name        Textarea name attribute
	 * @param string $label       Field label text
	 * @param string $description Optional field description/help text
	 * @param array  $attributes  Textarea element attributes (rows, cols, etc.)
	 *
	 * @return $this For method chaining
	 */
	public function textarea_field( string $name, string $label = '', string $description = '', array $attributes = [] ): self {
		$input = Create::textarea( $name, '', $attributes );
		$field = Create::field( $input, $label, $description );

		return $this->add_child( $field );
	}

	/**
	 * Add a select dropdown field with label and description
	 *
	 * @param string $name        Select name attribute
	 * @param array  $options     Array of options (value => label)
	 * @param mixed  $selected    Selected value(s)
	 * @param string $label       Field label text
	 * @param string $description Optional field description/help text
	 * @param array  $attributes  Select element attributes
	 *
	 * @return $this For method chaining
	 */
	public function select_field( string $name, array $options, $selected = null, string $label = '', string $description = '', array $attributes = [] ): self {
		$input = Create::select( $name, $options, $selected, $attributes );
		$field = Create::field( $input, $label, $description );

		return $this->add_child( $field );
	}

	/**
	 * Add a checkbox field with label
	 *
	 * @param string $name       Checkbox name attribute
	 * @param string $value      Checkbox value when checked
	 * @param bool   $checked    Whether checkbox is checked by default
	 * @param string $label      Checkbox label text
	 * @param array  $attributes Checkbox element attributes
	 *
	 * @return $this For method chaining
	 */
	public function checkbox_field( string $name, string $value = '1', bool $checked = false, string $label = '', array $attributes = [] ): self {
		$checkbox = Create::checkbox( $name, $value, $checked, $attributes );
		$field    = Create::field( $checkbox, $label );

		return $this->add_child( $field );
	}

	/**
	 * Add a file upload field with label and description
	 *
	 * @param string $name        File input name attribute
	 * @param string $label       Field label text
	 * @param string $description Optional field description/help text
	 * @param array  $attributes  File input attributes (accept, multiple, etc.)
	 *
	 * @return $this For method chaining
	 */
	public function file_field( string $name, string $label = '', string $description = '', array $attributes = [] ): self {
		$input = Create::file( $name, $attributes );
		$field = Create::field( $input, $label, $description );

		// Enable file uploads on the form
		$this->set_file_upload( true );

		return $this->add_child( $field );
	}

	/**
	 * Add a date input field with label and description
	 *
	 * @param string $name        Date input name attribute
	 * @param string $label       Field label text
	 * @param string $description Optional field description/help text
	 * @param array  $attributes  Date input attributes
	 *
	 * @return $this For method chaining
	 */
	public function date_field( string $name, string $label = '', string $description = '', array $attributes = [] ): self {
		$input = Create::date( $name, '', $attributes );
		$field = Create::field( $input, $label, $description );

		return $this->add_child( $field );
	}

	/**
	 * Add a range slider field with label and description
	 *
	 * @param string $name        Range input name attribute
	 * @param mixed  $value       Default value
	 * @param mixed  $min         Minimum value
	 * @param mixed  $max         Maximum value
	 * @param mixed  $step        Step increment
	 * @param string $label       Field label text
	 * @param string $description Optional field description/help text
	 * @param bool   $show_value  Whether to show current value
	 *
	 * @return $this For method chaining
	 */
	public function range_field( string $name, $value = '50', $min = '0', $max = '100', $step = '1', string $label = '', string $description = '', bool $show_value = true ): self {
		$input = Create::range( $name, $value, $min, $max, $step, $show_value );
		$field = Create::field( $input, $label, $description );

		return $this->add_child( $field );
	}

	/**
	 * Add a submit button to the form
	 *
	 * @param string $text       Button text
	 * @param array  $attributes Button attributes
	 *
	 * @return $this For method chaining
	 */
	public function submit_button( string $text = 'Submit', array $attributes = [] ): self {
		return $this->add_child( Create::submit( $text, $attributes ) );
	}

	/**
	 * Add a WordPress nonce field to the form
	 *
	 * @param string $action  Nonce action name
	 * @param string $name    Nonce field name
	 * @param bool   $referer Whether to include referer field
	 *
	 * @return $this For method chaining
	 */
	public function nonce( string $action, string $name = '_wpnonce', bool $referer = true ): self {
		$this->add_nonce( $action, $name, $referer );

		return $this;
	}

	/**
	 * Add multiple fields from a configuration array
	 *
	 * @param array $fields Array of field configurations
	 *                      Format: ['name' => ['type' => 'text', 'label' => 'Label', 'options' => []]]
	 *
	 * @return $this For method chaining
	 */
	public function fields( array $fields ): self {
		foreach ( $fields as $name => $config ) {
			$type        = $config['type'] ?? 'text';
			$label       = $config['label'] ?? '';
			$description = $config['description'] ?? '';
			$attributes  = $config['attributes'] ?? [];

			$method_name = $type . '_field';

			if ( method_exists( $this, $method_name ) ) {
				// Handle special cases that need extra parameters
				if ( $type === 'select' ) {
					$options  = $config['options'] ?? [];
					$selected = $config['selected'] ?? null;
					$this->select_field( $name, $options, $selected, $label, $description, $attributes );
				} elseif ( $type === 'checkbox' ) {
					$value   = $config['value'] ?? '1';
					$checked = $config['checked'] ?? false;
					$this->checkbox_field( $name, $value, $checked, $label, $attributes );
				} elseif ( $type === 'range' ) {
					$value      = $config['value'] ?? '50';
					$min        = $config['min'] ?? '0';
					$max        = $config['max'] ?? '100';
					$step       = $config['step'] ?? '1';
					$show_value = $config['show_value'] ?? true;
					$this->range_field( $name, $value, $min, $max, $step, $label, $description, $show_value );
				} else {
					// Standard field types
					$this->$method_name( $name, $label, $description, $attributes );
				}
			}
		}

		return $this;
	}

}