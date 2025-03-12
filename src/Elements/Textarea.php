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
 * Textarea Element
 */
class Textarea extends Element {

	/**
	 * Constructor
	 *
	 * @param string $name       Textarea name
	 * @param string $content    Textarea content
	 * @param array  $attributes Additional attributes
	 */
	public function __construct( string $name = '', string $content = '', array $attributes = [] ) {
		parent::__construct( 'textarea', $content, $attributes );

		if ( ! empty( $name ) ) {
			$this->set_attribute( 'name', $name );
		}
	}

	/**
	 * Set rows attribute
	 *
	 * @param int $rows Number of rows
	 *
	 * @return $this
	 */
	public function set_rows( int $rows ): self {
		return $this->set_attribute( 'rows', $rows );
	}

	/**
	 * Set cols attribute
	 *
	 * @param int $cols Number of columns
	 *
	 * @return $this
	 */
	public function set_cols( int $cols ): self {
		return $this->set_attribute( 'cols', $cols );
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
	 * @param bool $required Whether the textarea is required
	 *
	 * @return $this
	 */
	public function set_required( bool $required = true ): self {
		return $this->set_attribute( 'required', $required );
	}

	/**
	 * Set disabled attribute
	 *
	 * @param bool $disabled Whether the textarea is disabled
	 *
	 * @return $this
	 */
	public function set_disabled( bool $disabled = true ): self {
		return $this->set_attribute( 'disabled', $disabled );
	}

	/**
	 * Set readonly attribute
	 *
	 * @param bool $readonly Whether the textarea is readonly
	 *
	 * @return $this
	 */
	public function set_readonly( bool $readonly = true ): self {
		return $this->set_attribute( 'readonly', $readonly );
	}

}