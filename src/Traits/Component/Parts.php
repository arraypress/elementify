<?php
/**
 * Elementify Library - Component Parts Trait
 *
 * A collection of methods for creating common component part elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits\Component;

use Elementify\Element;
use Elementify\Create;
use LogicException;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Component Parts Trait
 *
 * Provides methods for creating common UI component parts like headers, bodies, and footers
 * with consistent naming and structure.
 */
trait Parts {

	/**
	 * Create a section/part element for a component
	 *
	 * @param string $tag            The HTML tag to use ('div' by default)
	 * @param mixed  $content        The content for the element
	 * @param string $part_name      The name of the part (e.g., 'header', 'body', 'footer')
	 * @param array  $attributes     Additional attributes for the element
	 * @param bool   $escape_content Whether to escape the content
	 *
	 * @return Element The created element
	 */
	protected function create_part( string $tag, $content, string $part_name, array $attributes = [], bool $escape_content = false ): Element {
		// The component_type property must be defined in the using class
		if ( ! isset( $this->component_type ) ) {
			throw new LogicException( 'Component type property must be defined to use ComponentParts trait' );
		}

		// Component part class name
		$class_name = "{$this->component_type}-{$part_name}";

		// If existing element, ensure it has the correct class
		if ( $content instanceof Element ) {
			$element = $content;
			if ( ! $element->has_class( $class_name ) ) {
				$element->add_class( $class_name );
			}

			// Add any additional attributes
			foreach ( $attributes as $name => $value ) {
				$element->set_attribute( $name, $value );
			}
		} // Otherwise create a new element
		else {
			// Merge class with additional attributes
			if ( ! isset( $attributes['class'] ) ) {
				$attributes['class'] = $class_name;
			} else {
				$attributes['class'] .= " {$class_name}";
			}

			// Create the element with the specified tag and escaping setting
			$element = new Element( $tag, $content, $attributes, $escape_content );
		}

		return $element;
	}

	/**
	 * Create a header element
	 *
	 * @param string $tag        The HTML tag to use ('div' by default)
	 * @param mixed  $content    The header content
	 * @param array  $attributes Additional attributes for the header
	 *
	 * @return Element The header element
	 */
	protected function create_header( string $tag = 'div', $content = null, array $attributes = [] ): Element {
		// Headers typically contain text that should be escaped
		return $this->create_part( $tag, $content, 'header', $attributes, false );
	}

	/**
	 * Create a body element
	 *
	 * @param string $tag        The HTML tag to use ('div' by default)
	 * @param mixed  $content    The body content
	 * @param array  $attributes Additional attributes for the body
	 *
	 * @return Element The body element
	 */
	protected function create_body( string $tag = 'div', $content = null, array $attributes = [] ): Element {
		// Bodies are containers that shouldn't escape their content
		return $this->create_part( $tag, $content, 'body', $attributes, false );
	}

	/**
	 * Create a footer element
	 *
	 * @param string $tag        The HTML tag to use ('div' by default)
	 * @param mixed  $content    The footer content
	 * @param array  $attributes Additional attributes for the footer
	 *
	 * @return Element The footer element
	 */
	protected function create_footer( string $tag = 'div', $content = null, array $attributes = [] ): Element {
		// Footers are containers that shouldn't escape their content
		return $this->create_part( $tag, $content, 'footer', $attributes, false );
	}

	/**
	 * Create a title element
	 *
	 * @param mixed $content    The title content
	 * @param int   $level      The heading level (1-6)
	 * @param array $attributes Additional attributes for the title
	 *
	 * @return Element The title element
	 */
	protected function create_title( $content, int $level = 3, array $attributes = [] ): Element {
		// Titles typically contain text that should be escaped
		return $this->create_part( "h{$level}", $content, 'title', $attributes, true );
	}

	/**
	 * Create a content element
	 *
	 * @param string $tag        The HTML tag to use ('div' by default)
	 * @param mixed  $content    The content
	 * @param array  $attributes Additional attributes for the content
	 *
	 * @return Element The content element
	 */
	protected function create_content( string $tag = 'div', $content = null, array $attributes = [] ): Element {
		// Content containers shouldn't escape their content
		return $this->create_part( $tag, $content, 'content', $attributes, false );
	}

	/**
	 * Create a container element without escaping
	 *
	 * Method signature matches the one in Component class
	 *
	 * @param string $tag        The HTML tag to use ('div' by default)
	 * @param mixed  $content    The container content
	 * @param array  $attributes Additional attributes for the container
	 *
	 * @return Element The container element
	 */
	protected function create_container( string $tag = 'div', $content = null, array $attributes = [] ): Element {
		// Containers should never escape their content
		return $this->create_part( $tag, $content, 'container', $attributes, false );
	}
}