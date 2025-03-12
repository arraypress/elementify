<?php
/**
 * Elementify Library
 *
 * A fluent interface for generating HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Elements;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Element;


/**
 * Select Element
 */
class Select extends Element {

	/**
	 * Options for the select element
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Option groups for the select element
	 *
	 * @var array
	 */
	protected array $optgroups = [];

	/**
	 * Constructor
	 *
	 * @param string $name           Select name
	 * @param array  $options        Optional array of options
	 * @param mixed  $selected_value Optional selected value(s)
	 * @param array  $attributes     Additional attributes
	 */
	public function __construct( string $name = '', array $options = [], $selected_value = null, array $attributes = [] ) {
		parent::__construct( 'select', null, $attributes );

		if ( ! empty( $name ) ) {
			$this->set_attribute( 'name', $name );
		}

		if ( ! empty( $options ) ) {
			$this->add_options( $options, $selected_value );
		}
	}

	/**
	 * Add an option to the select element
	 *
	 * @param string $value      Option value
	 * @param string $label      Option label
	 * @param bool   $selected   Whether the option is selected
	 * @param array  $attributes Additional attributes
	 *
	 * @return $this
	 */
	public function add_option( string $value, string $label, bool $selected = false, array $attributes = [] ): self {
		$this->options[] = [
			'value'      => $value,
			'label'      => $label,
			'selected'   => $selected,
			'attributes' => $attributes,
		];

		return $this;
	}

	/**
	 * Add multiple options at once
	 *
	 * @param array             $options        Array of options
	 * @param string|array|null $selected_value Selected value(s)
	 *
	 * @return $this
	 */
	public function add_options( array $options, $selected_value = null ): self {
		// Convert selected value to array for easier checking
		if ( ! is_array( $selected_value ) ) {
			$selected_value = $selected_value !== null ? [ $selected_value ] : [];
		}

		foreach ( $options as $value => $label ) {
			// Handle array of arrays format ([['value' => 'x', 'label' => 'y'], ...])
			if ( is_array( $label ) && isset( $label['value'] ) && isset( $label['label'] ) ) {
				$selected   = in_array( $label['value'], $selected_value, true );
				$attributes = $label['attributes'] ?? [];
				$this->add_option( $label['value'], $label['label'], $selected, $attributes );
			} // Handle simple key-value format (['x' => 'y', ...])
			else {
				$selected = in_array( $value, $selected_value, true );
				$this->add_option( (string) $value, (string) $label, $selected );
			}
		}

		return $this;
	}

	/**
	 * Add an option group
	 *
	 * @param string            $label          Option group label
	 * @param array             $options        Options for this group
	 * @param string|array|null $selected_value Selected value(s)
	 * @param array             $attributes     Group attributes
	 *
	 * @return $this
	 */
	public function add_optgroup( string $label, array $options, $selected_value = null, array $attributes = [] ): self {
		// Convert selected value to array for easier checking
		if ( ! is_array( $selected_value ) ) {
			$selected_value = $selected_value !== null ? [ $selected_value ] : [];
		}

		$group_options = [];

		foreach ( $options as $value => $option_label ) {
			// Handle array of arrays format
			if ( is_array( $option_label ) && isset( $option_label['value'] ) && isset( $option_label['label'] ) ) {
				$selected          = in_array( $option_label['value'], $selected_value, true );
				$option_attributes = $option_label['attributes'] ?? [];

				$group_options[] = [
					'value'      => $option_label['value'],
					'label'      => $option_label['label'],
					'selected'   => $selected,
					'attributes' => $option_attributes,
				];
			} // Handle simple key-value format
			else {
				$selected = in_array( $value, $selected_value, true );

				$group_options[] = [
					'value'      => (string) $value,
					'label'      => (string) $option_label,
					'selected'   => $selected,
					'attributes' => [],
				];
			}
		}

		$this->optgroups[] = [
			'label'      => $label,
			'options'    => $group_options,
			'attributes' => $attributes,
		];

		return $this;
	}

	/**
	 * Set multiple attribute
	 *
	 * @param bool $multiple Whether multiple options can be selected
	 *
	 * @return $this
	 */
	public function set_multiple( bool $multiple = true ): self {
		$this->set_attribute( 'multiple', $multiple );

		// Update name to array format if multiple is true
		if ( $multiple && isset( $this->attributes['name'] ) ) {
			$name = $this->attributes['name'];
			if ( substr( $name, - 2 ) !== '[]' ) {
				$this->attributes['name'] = $name . '[]';
			}
		}

		return $this;
	}

	/**
	 * Set required attribute
	 *
	 * @param bool $required Whether the select is required
	 *
	 * @return $this
	 */
	public function set_required( bool $required = true ): self {
		return $this->set_attribute( 'required', $required );
	}

	/**
	 * Set disabled attribute
	 *
	 * @param bool $disabled Whether the select is disabled
	 *
	 * @return $this
	 */
	public function set_disabled( bool $disabled = true ): self {
		return $this->set_attribute( 'disabled', $disabled );
	}

	/**
	 * Set size attribute
	 *
	 * @param int $size Number of visible options
	 *
	 * @return $this
	 */
	public function set_size( int $size ): self {
		return $this->set_attribute( 'size', $size );
	}

	/**
	 * Render the element
	 *
	 * @return string
	 */
	public function render(): string {
		// Add options and optgroups as content
		$this->children = []; // Clear any existing content

		// First add the standard options
		foreach ( $this->options as $option ) {
			$option_attributes = $option['attributes'] ?? [];
			if ( $option['selected'] ) {
				$option_attributes['selected'] = true;
			}

			$option_elem = new Element( 'option', $option['label'], array_merge(
				[ 'value' => $option['value'] ],
				$option_attributes
			) );

			$this->add_child( $option_elem );
		}

		// Then add optgroups
		foreach ( $this->optgroups as $group ) {
			$optgroup = new Element( 'optgroup', null, array_merge(
				[ 'label' => $group['label'] ],
				$group['attributes']
			) );

			foreach ( $group['options'] as $option ) {
				$option_attributes = $option['attributes'] ?? [];
				if ( $option['selected'] ) {
					$option_attributes['selected'] = true;
				}

				$option_elem = new Element( 'option', $option['label'], array_merge(
					[ 'value' => $option['value'] ],
					$option_attributes
				) );

				$optgroup->add_child( $option_elem );
			}

			$this->add_child( $optgroup );
		}

		// Now render the complete element
		return parent::render();
	}

}