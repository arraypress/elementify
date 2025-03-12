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

namespace Elementify;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Base Element class
 */
class Element {

	/** Properties ************************************************************/

	/**
	 * Element attributes
	 *
	 * @var array
	 */
	protected array $attributes = [];

	/**
	 * Element content/children
	 *
	 * @var array
	 */
	protected array $children = [];

	/**
	 * Whether the element is self-closing
	 *
	 * @var bool
	 */
	protected bool $is_self_closing = false;

	/**
	 * Whether to escape content when rendering
	 *
	 * @var bool
	 */
	protected bool $escape_content = false;

	/**
	 * Element tag name
	 *
	 * @var string
	 */
	protected string $tag;

	/** Constants *************************************************************/

	/**
	 * List of self-closing HTML tags
	 *
	 * @var array
	 */
	public const SELF_CLOSING_TAGS = [
		'area',
		'base',
		'br',
		'col',
		'embed',
		'hr',
		'img',
		'input',
		'link',
		'meta',
		'param',
		'source',
		'track',
		'wbr'
	];

	/**
	 * List of HTML elements that should not escape content by default
	 * These elements typically contain other HTML elements rather than text
	 *
	 * @var array
	 */
	public const RAW_HTML_ELEMENTS = [
		// Component wrapper elements
		'div',
		'span',

		// Form-related container elements
		'form',
		'fieldset',
		'label',
		'legend',
		'optgroup',
		'select',
		'option',
		'datalist',
		'output',

		// Rich content/component containers
		'article',
		'section',
		'main',
		'aside',
		'nav',
		'header',
		'footer',
		'figure',
		'figcaption',
		'address',
		'blockquote',
		'summary',
		'details',

		// Heading elements
		'h1',
		'h2',
		'h3',
		'h4',
		'h5',
		'h6',
		'hgroup',

		// Tables (structure and content)
		'table',
		'thead',
		'tbody',
		'tfoot',
		'tr',
		'td',
		'th',
		'caption',
		'colgroup',
		'col',

		// List containers and items
		'ul',
		'ol',
		'dl',
		'li',
		'dt',
		'dd',
		'menu',

		// Interactive elements
		'details',
		'dialog',
		'menu',
		'menuitem',
		'summary',
		'button',
		'fieldset',
		'keygen',
		'meter',
		'progress',

		// Multimedia containers
		'picture',
		'audio',
		'video',
		'canvas',
		'map',
		'svg',
		'figure',
		'iframe',
		'object',
		'param',
		'embed',

		// Layout and structural elements
		'template',
		'slot',
		'portal',
		'marquee',
		'nobr',
		'time',
		'wbr',
		'bdi',
		'bdo',
		'cite',
		'data',

		// Text elements that might contain other elements
		'pre',
		'q',
		'ruby',
		'rt',
		'rp',
		's',
		'small',
		'mark',

		// Component-specific elements and content containers
		'card',
		'card-body',
		'card-header',
		'card-footer',
		'modal',
		'modal-title',
		'modal-body',
		'modal-footer',
		'modal-content',
		'accordion',
		'accordion-header',
		'accordion-content',
		'tab',
		'tab-content',
		'tabs-nav',
		'tabs-content'
	];

	/** Constructor & Initialization ******************************************/

	/**
	 * Constructor
	 *
	 * @param string      $tag            HTML tag name
	 * @param string|null $content        Optional content
	 * @param array       $attributes     Optional attributes
	 * @param bool|null   $escape_content Whether to escape content when rendering (null for auto-detection)
	 */
	public function __construct( string $tag, $content = null, array $attributes = [], ?bool $escape_content = null ) {
		$this->tag = $tag;

		// Auto-detect escaping if not explicitly set
		if ( $escape_content === null ) {
			$this->escape_content = ! in_array( $tag, self::RAW_HTML_ELEMENTS );
		} else {
			$this->escape_content = $escape_content;
		}

		// Set attributes if provided
		foreach ( $attributes as $name => $value ) {
			$this->set_attribute( $name, $value );
		}

		// Set content if provided
		if ( $content !== null ) {
			$this->set_content( $content );
		}

		// Determine if element is self-closing
		$this->is_self_closing = in_array( $tag, self::SELF_CLOSING_TAGS );
	}

	/**
	 * Create a new instance
	 *
	 * @param string|null $content        Optional content
	 * @param array       $attributes     Optional attributes
	 * @param bool        $escape_content Whether to escape content when rendering
	 *
	 * @return static
	 */
	public static function create( $content = null, array $attributes = [], bool $escape_content = false ): self {
		$tag = strtolower( str_replace( 'Elementify\\', '', static::class ) );

		return new static( $tag, $content, $attributes, $escape_content );
	}

	/**
	 * Special handling for components to ensure they are treated as containers
	 * that shouldn't escape their content
	 */
	protected function is_component(): bool {
		// Check if this class extends the Component abstract class
		return is_a( $this, 'Elementify\\Abstracts\\Component' ) ||
		       strpos( get_class( $this ), 'Elementify\\Components\\' ) === 0;
	}

	/**
	 * Check if a tag is self-closing
	 *
	 * @param string $tag HTML tag name
	 *
	 * @return bool
	 */
	public static function is_tag_self_closing( string $tag ): bool {
		return in_array( $tag, self::SELF_CLOSING_TAGS );
	}

	/**
	 * Set whether the element's content should be escaped using wp_kses_post()
	 *
	 * Enable this for elements that might contain user-generated content to prevent XSS.
	 * Disable for elements that need to preserve HTML structure (like components).
	 *
	 * @param bool $escape Whether to escape the content
	 *
	 * @return $this
	 */
	public function set_escape_content( bool $escape ): self {
		$this->escape_content = $escape;

		return $this;
	}

	/**
	 * Get whether content escaping is enabled for this element
	 *
	 * @return bool
	 */
	public function get_escape_content(): bool {
		return $this->escape_content;
	}

	/** Attribute Methods *****************************************************/

	/**
	 * Set an attribute
	 *
	 * @param string               $name  Attribute name
	 * @param string|bool|int|null $value Attribute value
	 *
	 * @return $this
	 */
	public function set_attribute( string $name, $value ): self {
		// Handle boolean attributes
		if ( is_bool( $value ) ) {
			if ( $value ) {
				$this->attributes[ $name ] = true;
			} else {
				unset( $this->attributes[ $name ] );
			}

			return $this;
		}

		// Skip null values
		if ( $value === null ) {
			unset( $this->attributes[ $name ] );

			return $this;
		}

		$this->attributes[ $name ] = $value;

		return $this;
	}

	/**
	 * Set ID attribute
	 *
	 * @param string $id Element ID
	 *
	 * @return $this
	 */
	public function set_id( string $id ): self {
		return $this->set_attribute( 'id', $id );
	}

	/**
	 * Add one or more classes
	 *
	 * @param string|array $classes One or more classes to add
	 *
	 * @return $this
	 */
	public function add_class( $classes ): self {
		// Normalize classes to array
		if ( is_string( $classes ) ) {
			$classes = array_filter( explode( ' ', trim( $classes ) ) );
		} elseif ( is_array( $classes ) ) {
			$classes = array_filter( $classes );
		} else {
			return $this;
		}

		// If no valid classes, return
		if ( empty( $classes ) ) {
			return $this;
		}

		// Get current classes as array
		$current_classes = isset( $this->attributes['class'] )
			? array_filter( explode( ' ', trim( (string) $this->attributes['class'] ) ) )
			: [];

		// Merge classes and remove duplicates
		$merged_classes = array_unique( array_merge( $current_classes, $classes ) );

		// Set the combined classes
		$this->attributes['class'] = implode( ' ', $merged_classes );

		return $this;
	}

	/**
	 * Check if element has a specific class
	 *
	 * @param string $class Class name to check for
	 *
	 * @return bool
	 */
	public function has_class( string $class ): bool {
		if ( ! isset( $this->attributes['class'] ) ) {
			return false;
		}

		$classes = explode( ' ', (string) $this->attributes['class'] );

		return in_array( $class, $classes );
	}

	/**
	 * Remove one or more classes
	 *
	 * @param string|array|callable $classes One or more classes to remove or a callback function
	 *
	 * @return $this
	 */
	public function remove_class( $classes ): self {
		if ( ! isset( $this->attributes['class'] ) ) {
			return $this;
		}

		// Get existing classes as array
		$existing_classes = explode( ' ', (string) $this->attributes['class'] );

		// If callback function is provided
		if ( is_callable( $classes ) ) {
			$filtered_classes = array_filter( $existing_classes, function ( $class ) use ( $classes ) {
				return ! $classes( $class );
			} );
		} else {
			// Convert string to array
			if ( is_string( $classes ) ) {
				$classes = explode( ' ', $classes );
			}

			// Remove specified classes
			$filtered_classes = array_diff( $existing_classes, $classes );
		}

		// Set back to attributes or remove if empty
		if ( empty( $filtered_classes ) ) {
			unset( $this->attributes['class'] );
		} else {
			$this->attributes['class'] = implode( ' ', $filtered_classes );
		}

		return $this;
	}


	/**
	 * Set data attribute
	 *
	 * @param string $name  Data attribute name (without 'data-' prefix)
	 * @param mixed  $value Attribute value
	 *
	 * @return $this
	 */
	public function set_data( string $name, $value ): self {
		return $this->set_attribute( 'data-' . $name, $value );
	}

	/**
	 * Set ARIA attribute
	 *
	 * @param string $name  ARIA attribute name (without 'aria-' prefix)
	 * @param mixed  $value Attribute value
	 *
	 * @return $this
	 */
	public function set_aria( string $name, $value ): self {
		return $this->set_attribute( 'aria-' . $name, $value );
	}

	/**
	 * Set CSS styles
	 *
	 * @param array $styles Associative array of style attributes and values
	 *
	 * @return $this
	 */
	public function set_styles( array $styles ): self {
		$style_string = '';

		foreach ( $styles as $property => $value ) {
			if ( $value !== null && $value !== '' ) {
				$style_string .= $property . ': ' . $value . '; ';
			}
		}

		if ( ! empty( $style_string ) ) {
			$this->set_attribute( 'style', trim( $style_string ) );
		}

		return $this;
	}

	/**
	 * Get a specific attribute value
	 *
	 * @param string $name    Attribute name
	 * @param mixed  $default Default value if attribute doesn't exist
	 *
	 * @return mixed
	 */
	public function get_attribute( string $name, $default = null ) {
		return $this->attributes[ $name ] ?? $default;
	}

	/**
	 * Check if an attribute exists
	 *
	 * @param string $name Attribute name
	 *
	 * @return bool
	 */
	public function has_attribute( string $name ): bool {
		return isset( $this->attributes[ $name ] );
	}

	/**
	 * Get the element attributes
	 *
	 * @return array
	 */
	public function get_attributes(): array {
		return $this->attributes;
	}

	/** Content Management ****************************************************/

	/**
	 * Set the content of the element
	 *
	 * @param string|Element|array $content Element content
	 *
	 * @return $this
	 */
	public function set_content( $content ): self {
		// Clear existing children
		$this->children = [];

		// Add new content
		return $this->add_content( $content );
	}

	/**
	 * Add content to the element
	 *
	 * @param string|Element|array $content Content to add
	 *
	 * @return $this
	 */
	public function add_content( $content ): self {
		if ( $this->is_self_closing ) {
			return $this;
		}

		if ( is_array( $content ) ) {
			foreach ( $content as $item ) {
				$this->add_child( $item );
			}
		} else {
			$this->add_child( $content );
		}

		return $this;
	}

	/**
	 * Add a child to the element
	 *
	 * @param string|Element $child Child to add
	 *
	 * @return $this
	 */
	public function add_child( $child ): self {
		if ( $this->is_self_closing ) {
			return $this;
		}

		if ( $child instanceof Element || is_scalar( $child ) || is_null( $child ) ) {
			$this->children[] = $child;
		}

		return $this;
	}

	/**
	 * Get the element's children
	 *
	 * @return array
	 */
	public function get_children(): array {
		return $this->children;
	}

	/**
	 * Get the element's content as a string
	 *
	 * @return string
	 */
	public function get_content_string(): string {
		return $this->render_content();
	}

	/** Rendering & Output ****************************************************/

	/**
	 * Build HTML attributes string
	 *
	 * @return string
	 */
	protected function build_attributes_string(): string {
		$attributes_str = [];

		foreach ( $this->attributes as $name => $value ) {
			// Handle boolean attributes (just the name for true)
			if ( is_bool( $value ) && $value ) {
				$attributes_str[] = esc_attr( $name );
				continue;
			}

			// Regular attributes with values
			if ( ! is_bool( $value ) ) {
				// Special handling for class attribute to prevent leading spaces
				if ( $name === 'class' && is_string( $value ) ) {
					$classes = array_filter( explode( ' ', trim( $value ) ) );
					if ( ! empty( $classes ) ) {
						$attributes_str[] = sprintf( '%s="%s"', esc_attr( $name ), esc_attr( implode( ' ', $classes ) ) );
					}
				} else {
					$attributes_str[] = sprintf( '%s="%s"', esc_attr( $name ), esc_attr( $value ) );
				}
			}
		}

		return ! empty( $attributes_str ) ? ' ' . implode( ' ', $attributes_str ) : '';
	}

	/**
	 * Render the element's content with safe component handling
	 *
	 * @return string
	 */
	protected function render_content(): string {
		if ( $this->is_self_closing || empty( $this->children ) ) {
			return '';
		}

		// Components should NEVER escape their content
		$should_escape = $this->escape_content && ! $this->is_component();

		$content = '';
		foreach ( $this->children as $child ) {
			if ( $child instanceof Element ) {
				// Element children handle their own escaping logic
				$content .= $child->render();
			} else {
				$content_string = (string) $child;

				// Only escape raw text content if needed
				if ( $should_escape ) {
					$content_string = wp_kses_post( $content_string );
				}

				$content .= $content_string;
			}
		}

		return $content;
	}

	/**
	 * Render the element
	 *
	 * @return string
	 */
	public function render(): string {
		$attributes = $this->build_attributes_string();

		// Self-closing element
		if ( $this->is_self_closing ) {
			return sprintf( '<%s%s />', $this->tag, $attributes );
		}

		// Standard element with content
		$content = $this->render_content();

		return sprintf( '<%s%s>%s</%s>', $this->tag, $attributes, $content, $this->tag );
	}

	/**
	 * Output the element
	 *
	 * @return void
	 */
	public function output(): void {
		echo $this->render();
	}

	/** Utility Methods *******************************************************/

	/**
	 * Get the element tag name
	 *
	 * @return string
	 */
	public function get_tag(): string {
		return $this->tag;
	}

	/**
	 * Check if the element is self-closing
	 *
	 * @return bool
	 */
	public function is_self_closing(): bool {
		return $this->is_self_closing;
	}

	/**
	 * Convert to string when used in string context
	 *
	 * @return string
	 */
	public function __toString(): string {
		return $this->render();
	}

}