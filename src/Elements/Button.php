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
 * Button Element
 */
class Button extends Element {

	/**
	 * Constructor
	 *
	 * @param string $type       Button type (submit, button, reset)
	 * @param string $content    Button content
	 * @param array  $attributes Additional attributes
	 */
	public function __construct( string $type = 'submit', string $content = '', array $attributes = [] ) {
		parent::__construct( 'button', $content, $attributes );
		$this->set_attribute( 'type', $type );
	}

	/**
	 * Set disabled attribute
	 *
	 * @param bool $disabled Whether the button is disabled
	 *
	 * @return $this
	 */
	public function set_disabled( bool $disabled = true ): self {
		return $this->set_attribute( 'disabled', $disabled );
	}

}