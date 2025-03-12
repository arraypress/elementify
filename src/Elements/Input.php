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
 * Input element
 */
class Input extends Element {

	/**
	 * Constructor
	 *
	 * @param string $type       Input type (text, number, etc.)
	 * @param string $name       Input name
	 * @param mixed  $value      Input value
	 * @param array  $attributes Additional attributes
	 */
	public function __construct( string $type, string $name = '', $value = null, array $attributes = [] ) {
		parent::__construct( 'input', null, $attributes );
		$this->set_attribute( 'type', $type );

		if ( ! empty( $name ) ) {
			$this->set_attribute( 'name', $name );
		}

		if ( $value !== null ) {
			$this->set_value( $value );
		}
	}

	/**
	 * Set input value
	 *
	 * @param mixed $value Input value
	 *
	 * @return $this
	 */
	public function set_value( $value ): self {
		return $this->set_attribute( 'value', $value );
	}

	/**
	 * Set placeholder
	 *
	 * @param string $placeholder Placeholder text
	 *
	 * @return $this
	 */
	public function set_placeholder( string $placeholder ): self {
		return $this->set_attribute( 'placeholder', $placeholder );
	}

	/**
	 * Set required attribute
	 *
	 * @param bool $required Whether the input is required
	 *
	 * @return $this
	 */
	public function set_required( bool $required = true ): self {
		return $this->set_attribute( 'required', $required );
	}

	/**
	 * Set disabled attribute
	 *
	 * @param bool $disabled Whether the input is disabled
	 *
	 * @return $this
	 */
	public function set_disabled( bool $disabled = true ): self {
		return $this->set_attribute( 'disabled', $disabled );
	}

	/**
	 * Set readonly attribute
	 *
	 * @param bool $readonly Whether the input is readonly
	 *
	 * @return $this
	 */
	public function set_readonly( bool $readonly = true ): self {
		return $this->set_attribute( 'readonly', $readonly );
	}

	/**
	 * Set min attribute (for number, range, date inputs)
	 *
	 * @param mixed $min Minimum value
	 *
	 * @return $this
	 */
	public function set_min( $min ): self {
		return $this->set_attribute( 'min', $min );
	}

	/**
	 * Set max attribute (for number, range, date inputs)
	 *
	 * @param mixed $max Maximum value
	 *
	 * @return $this
	 */
	public function set_max( $max ): self {
		return $this->set_attribute( 'max', $max );
	}

	/**
	 * Set step attribute (for number, range inputs)
	 *
	 * @param mixed $step Step value
	 *
	 * @return $this
	 */
	public function set_step( $step ): self {
		return $this->set_attribute( 'step', $step );
	}

	/**
	 * Set pattern attribute (for client-side validation)
	 *
	 * @param string $pattern Regex pattern
	 *
	 * @return $this
	 */
	public function set_pattern( string $pattern ): self {
		return $this->set_attribute( 'pattern', $pattern );
	}

	/**
	 * Set autocomplete attribute
	 *
	 * @param string $value Autocomplete value
	 *
	 * @return $this
	 */
	public function set_autocomplete( string $value ): self {
		return $this->set_attribute( 'autocomplete', $value );
	}

}