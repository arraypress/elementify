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
 * Field Wrapper
 *
 * A div wrapper for form fields with common structure
 */
class Field extends Element {

	/**
	 * Label element
	 *
	 * @var Label|null
	 */
	protected ?Label $label = null;

	/**
	 * Input element
	 *
	 * @var Element|null
	 */
	protected ?Element $input = null;

	/**
	 * Description element
	 *
	 * @var Element|null
	 */
	protected ?Element $description = null;

// In Field.php
	public function __construct( $input, string $label = '', string $description = '', array $attributes = [] ) {
		parent::__construct( 'div', null, array_merge( [ 'class' => 'field-wrapper' ], $attributes ) );

		// Set input
		if ( $input instanceof Element ) {
			$this->input = $input;
		} else {
			// Create a text input if string was passed
			$this->input = new Input( 'text', $input );
			$this->input->set_id( $input );
		}

		// Ensure the input element has an ID for label association
		if ( ! isset( $this->input->attributes['id'] ) && $label !== '' ) {
			// Generate an ID based on the name attribute if available, or a random ID
			$id = isset( $this->input->attributes['name'] ) ?
				'field-' . $this->input->attributes['name'] :
				'field-' . uniqid();
			$this->input->set_id( $id );
		}

		// Set label if provided
		if ( ! empty( $label ) ) {
			$input_id    = $this->input->attributes['id'] ?? '';
			$this->label = new Label( $input_id, $label );
		}

		// Set description if provided
		if ( ! empty( $description ) ) {
			$this->description = new Element( 'p', $description, [ 'class' => 'description' ] );
		}
	}

	/**
	 * Get the input element
	 *
	 * @return Element
	 */
	public function get_input(): Element {
		return $this->input;
	}

	/**
	 * Get the label element
	 *
	 * @return Label|null
	 */
	public function get_label(): ?Label {
		return $this->label;
	}

	/**
	 * Set label text
	 *
	 * @param string $text Label text
	 *
	 * @return $this
	 */
	public function set_label( string $text ): self {
		$input_id    = $this->input->attributes['id'] ?? null;
		$this->label = new Label( $input_id, $text );

		return $this;
	}

	/**
	 * Set description text
	 *
	 * @param string $text Description text
	 *
	 * @return $this
	 */
	public function set_description( string $text ): self {
		$this->description = new Element( 'p', $text, [ 'class' => 'description' ] );

		return $this;
	}

	/**
	 * Add error message
	 *
	 * @param string $message Error message
	 *
	 * @return $this
	 */
	public function set_error( string $message ): self {
		if ( ! empty( $message ) ) {
			$this->add_class( 'has-error' );
			$error = new Element( 'p', $message, [ 'class' => 'error-message' ] );
			$this->add_child( $error );
		}

		return $this;
	}

	/**
	 * Render the field
	 *
	 * @return string
	 */
	public function render(): string {
		// Clear children to rebuild
		$this->children = [];

		// Add label if exists
		if ( $this->label ) {
			$this->add_child( $this->label );
		}

		// Add input
		$this->add_child( $this->input );

		// Add description if exists
		if ( $this->description ) {
			$this->add_child( $this->description );
		}

		return parent::render();
	}

}