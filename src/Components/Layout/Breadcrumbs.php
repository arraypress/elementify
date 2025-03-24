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

namespace Elementify\Components\Layout;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Element;
use Elementify\Traits\Component\Parts;

/**
 * Breadcrumbs Component
 *
 * Creates a breadcrumb navigation trail.
 */
class Breadcrumbs extends Component {
	use Parts;

	/**
	 * Array of breadcrumb items
	 *
	 * @var array
	 */
	protected array $items = [];

	/**
	 * Breadcrumbs options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Constructor
	 *
	 * @param array  $items       Array of breadcrumb items
	 * @param string $separator   Separator between items
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 */
	public function __construct( array $items = [], string $separator = '/', array $attributes = [], bool $include_css = true ) {
		// Set options with default separator
		$this->options = [
			'separator' => $separator
		];

		// Initialize component foundation
		$this->init_component( 'breadcrumbs', $attributes, $include_css );

		// Initialize with a nav element
		parent::__construct( 'nav', null, $attributes );

		// Set accessibility attributes
		$this->set_attribute( 'aria-label', 'Breadcrumb' );

		// Add items if provided
		if ( ! empty( $items ) ) {
			$this->add_items( $items );
		}

		// Build the breadcrumbs
		$this->build();
	}

	/**
	 * Build the breadcrumbs structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Create breadcrumb list
		$list = Create::ol()->add_class( 'breadcrumb' );

		// Process items
		$last_index = count( $this->items ) - 1;

		foreach ( $this->items as $index => $item ) {
			$is_last = ( $index === $last_index );

			// Create list item
			$li = Create::li();

			// Mark current page with appropriate ARIA attributes
			$li->toggle_class( 'active', $is_last );
			$li->toggle_attribute( 'aria-current', 'page', $is_last );

			// Create content based on item type
			if ( is_string( $item ) ) {
				// Simple string item
				if ( $is_last ) {
					$li->add_child( $item );
				} else {
					$li->add_child( Create::a( '#', $item ) );
				}
			} elseif ( is_array( $item ) && isset( $item['text'] ) ) {
				// Array with text and URL
				if ( $is_last || ! isset( $item['url'] ) ) {
					$li->add_child( $item['text'] );
				} else {
					$li->add_child( Create::a( $item['url'], $item['text'] ) );
				}
			} elseif ( $item instanceof Element ) {
				// Element object
				$li->add_child( $item );
			}

			// Add separator span if not the last item
			if ( ! $is_last && ! empty( $this->options['separator'] ) ) {
				$li->add_child( Create::span( $this->options['separator'] )->add_class( 'separator' ) );
			}

			$list->add_child( $li );
		}

		// Add list to breadcrumbs container
		$this->add_child( $list );
	}

	/**
	 * Add multiple breadcrumb items
	 *
	 * @param array $items Array of breadcrumb items
	 *
	 * @return $this
	 */
	public function add_items( array $items ): self {
		foreach ( $items as $item ) {
			$this->add_item( $item );
		}

		return $this;
	}

	/**
	 * Add a single breadcrumb item
	 *
	 * @param mixed $item Breadcrumb item (string, array with 'text' and 'url', or Element)
	 *
	 * @return $this
	 */
	public function add_item( $item ): self {
		$this->items[] = $item;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set breadcrumb items (replaces existing items)
	 *
	 * @param array $items Array of breadcrumb items
	 *
	 * @return $this
	 */
	public function set_items( array $items ): self {
		$this->items = [];
		$this->add_items( $items );

		return $this;
	}

	/**
	 * Remove a breadcrumb item at specific index
	 *
	 * @param int $index Item index to remove
	 *
	 * @return $this
	 */
	public function remove_item( int $index ): self {
		if ( isset( $this->items[ $index ] ) ) {
			array_splice( $this->items, $index, 1 );
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Set the separator
	 *
	 * @param string $separator Separator between items
	 *
	 * @return $this
	 */
	public function set_separator( string $separator ): self {
		$this->options['separator'] = $separator;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Get all breadcrumb items
	 *
	 * @return array
	 */
	public function get_items(): array {
		return $this->items;
	}

	/**
	 * Get a specific breadcrumb item
	 *
	 * @param int $index Item index
	 *
	 * @return mixed|null
	 */
	public function get_item( int $index ) {
		return $this->items[ $index ] ?? null;
	}

	/**
	 * Get the separator
	 *
	 * @return string
	 */
	public function get_separator(): string {
		return $this->options['separator'];
	}

	/**
	 * Create breadcrumbs from a URL path
	 *
	 * @param string $path     URL path
	 * @param string $base_url Base URL for links
	 * @param array  $options  Additional options
	 *
	 * @return Breadcrumbs
	 */
	public static function from_path( string $path, string $base_url = '', array $options = [] ): Breadcrumbs {
		// Default options
		$defaults = [
			'separator'   => '/',
			'home_text'   => 'Home',
			'home_url'    => '/',
			'transform'   => function ( $segment ) {
				return str_replace( [ '-', '_' ], ' ', ucfirst( $segment ) );
			},
			'include_css' => true
		];

		$options = array_merge( $defaults, $options );

		// Clean path
		$path = trim( $path, '/' );

		// Create breadcrumbs array
		$items = [];

		// Add home item
		if ( ! empty( $options['home_text'] ) ) {
			$items[] = [
				'text' => $options['home_text'],
				'url'  => $options['home_url']
			];
		}

		// If path is empty, return just home
		if ( empty( $path ) ) {
			return new self( $items, $options['separator'], [], $options['include_css'] );
		}

		// Get path segments
		$segments     = explode( '/', $path );
		$current_path = '';

		// Build breadcrumb items
		foreach ( $segments as $index => $segment ) {
			$current_path .= '/' . $segment;

			// Transform segment text if needed
			$text = is_callable( $options['transform'] ) ?
				call_user_func( $options['transform'], $segment ) :
				$segment;

			// Last segment doesn't get a URL
			if ( $index === count( $segments ) - 1 ) {
				$items[] = $text;
			} else {
				$items[] = [
					'text' => $text,
					'url'  => rtrim( $base_url, '/' ) . $current_path
				];
			}
		}

		return new self( $items, $options['separator'], [], $options['include_css'] );
	}

}