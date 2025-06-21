<?php
/**
 * Elementify Library - Abstract Component Base Class
 *
 * Base class for all Elementify component elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Abstracts;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Element;

/**
 * Abstract Component
 *
 * Base class that all component elements should extend to ensure
 * consistent implementation and behavior across the component system.
 */
abstract class Component extends Element {

	/**
	 * Component type/name used for class prefixes
	 *
	 * @var string
	 */
	protected string $component_type;

	/**
	 * Component default base class
	 *
	 * @var string
	 */
	protected string $base_class = '';

	/**
	 * Constructor
	 *
	 * Components should always have this escaping behavior:
	 * - Container itself doesn't escape content
	 * - Creates Elements that follow proper escaping rules
	 * - Child elements handle their own escaping
	 *
	 * @param string      $tag        HTML tag name
	 * @param string|null $content    Optional content
	 * @param array       $attributes Optional attributes
	 */
	public function __construct( string $tag, $content = null, array $attributes = [] ) {
		// Components should NEVER escape their content by default
		// They should create Elements with appropriate escaping settings instead
		parent::__construct( $tag, $content, $attributes, false );
	}

	/**
	 * Initialize the common component foundation
	 *
	 * Sets up common properties and behaviors for all components.
	 *
	 * @param string $component_type The component type name
	 * @param array  &$attributes    The HTML element attributes passed by reference
	 *
	 * @return void
	 */
	protected function init_component( string $component_type, array &$attributes ): void {
		// Store component type
		$this->component_type = $component_type;

		// Set base class if not already set
		if ( empty( $this->base_class ) ) {
			$this->base_class = $component_type;
		}

		// Prepare base classes
		$this->prepare_base_class( $attributes );
	}

	/**
	 * Create a text element with appropriate escaping
	 *
	 * Helper method for components to create text elements with proper escaping
	 *
	 * @param string $tag        HTML tag name
	 * @param mixed  $content    Content (will be escaped)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	protected function create_text_element( string $tag, $content, array $attributes = [] ): Element {
		return new Element( $tag, $content, $attributes, true );
	}

	/**
	 * Create a container element without escaping
	 *
	 * Helper method for components to create container elements
	 *
	 * @param string $tag        HTML tag name
	 * @param mixed  $content    Content (won't be escaped)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	protected function create_container( string $tag, $content = null, array $attributes = [] ): Element {
		return new Element( $tag, $content, $attributes, false );
	}

	/**
	 * Add content to the element with explicit escaping control
	 *
	 * @param mixed $content Content to add
	 * @param bool  $escape  Whether to escape the content
	 *
	 * @return $this
	 */
	public function add_content_with_escaping( $content, bool $escape ): self {
		if ( $this->is_self_closing ) {
			return $this;
		}

		// Store the original escaping setting
		$original_escape = $this->escape_content;

		// Set the requested escaping behavior
		$this->escape_content = $escape;

		// Add the content
		if ( is_array( $content ) ) {
			foreach ( $content as $item ) {
				$this->add_child( $item );
			}
		} else {
			$this->add_child( $content );
		}

		// Restore original escaping setting
		$this->escape_content = $original_escape;

		return $this;
	}

	/**
	 * Add raw HTML content without escaping
	 * Use with caution - only for trusted content
	 *
	 * @param mixed $content Content to add without escaping
	 *
	 * @return $this
	 */
	public function add_raw_content( $content ): self {
		return $this->add_content_with_escaping( $content, false );
	}

	/**
	 * Add content with forced escaping
	 * Use for user-generated text that needs XSS protection
	 *
	 * @param mixed $content Content to add with escaping
	 *
	 * @return $this
	 */
	public function add_safe_content( $content ): self {
		return $this->add_content_with_escaping( $content, true );
	}

	/**
	 * Prepare base class for the component
	 *
	 * Ensures the component has its required base class added to attributes.
	 *
	 * @param array &$attributes Element attributes passed by reference
	 *
	 * @return void
	 */
	protected function prepare_base_class( array &$attributes ): void {
		// Initialize class attribute if not set
		if ( ! isset( $attributes['class'] ) ) {
			$attributes['class'] = '';
		}

		// Add base class to string class attribute
		if ( is_string( $attributes['class'] ) ) {
			$classes = empty( $attributes['class'] ) ? [] : array_filter( explode( ' ', trim( $attributes['class'] ) ) );

			if ( ! in_array( $this->base_class, $classes ) ) {
				$classes[] = $this->base_class;
			}

			$attributes['class'] = implode( ' ', $classes );
		}
		// Add base class to array class attribute
		elseif ( is_array( $attributes['class'] ) ) {
			if ( ! in_array( $this->base_class, $attributes['class'] ) ) {
				$attributes['class'][] = $this->base_class;
			}
		}
	}

	/**
	 * Get the component type
	 *
	 * @return string
	 */
	public function get_component_type(): string {
		return $this->component_type;
	}

	/**
	 * Build the component structure
	 *
	 * Abstract method to be implemented by each component to build its internal structure.
	 * This should recreate the component's DOM structure based on its current state.
	 *
	 * @return void
	 */
	abstract protected function build(): void;

}