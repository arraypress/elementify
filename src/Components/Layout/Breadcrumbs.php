<?php
/**
 * Elementify Library - Breadcrumbs Component
 *
 * Creates a breadcrumb navigation trail with icon support.
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
 * Creates a breadcrumb navigation trail with support for icons and flexible item formats.
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
	 */
	public function __construct( array $items = [], string $separator = '/', array $attributes = [] ) {
		// Set options with default separator
		$this->options = [
			'separator'  => $separator,
			'show_icons' => true
		];

		// Initialize component foundation
		$this->init_component( 'breadcrumbs', $attributes );

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

			// Create the breadcrumb content
			$content = $this->create_breadcrumb_content( $item, $is_last );
			$li->add_child( $content );

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
	 * Create breadcrumb content with icon support
	 *
	 * @param mixed $item    Breadcrumb item
	 * @param bool  $is_last Whether this is the last item
	 *
	 * @return Element
	 */
	protected function create_breadcrumb_content( $item, bool $is_last ): Element {
		$text    = '';
		$url     = '';
		$icon    = '';
		$classes = [];

		// Parse different item formats
		if ( is_string( $item ) ) {
			// Simple string item
			$text = $item;
		} elseif ( is_array( $item ) ) {
			if ( isset( $item['text'] ) ) {
				// Standard format: ['text' => 'Label', 'url' => 'URL', 'icon' => 'icon']
				$text    = $item['text'];
				$url     = $item['url'] ?? '';
				$icon    = $item['icon'] ?? '';
				$classes = $item['classes'] ?? [];
			} elseif ( isset( $item[0] ) ) {
				// Shorthand format: ['icon', 'text', 'url'] or ['icon', 'text']
				$icon = $item[0] ?? '';
				$text = $item[1] ?? '';
				$url  = $item[2] ?? '';
			}
		} elseif ( $item instanceof Element ) {
			// Element object - return as-is
			return $item;
		}

		// Create the content with icon support
		$content_parts = [];

		// Add icon if provided and icons are enabled
		if ( ! empty( $icon ) && $this->options['show_icons'] ) {
			$icon_element    = Create::span()
			                         ->add_class( "dashicons dashicons-{$icon}" );
			$content_parts[] = $icon_element;
		}

		// Add text
		if ( ! empty( $text ) ) {
			$content_parts[] = $text;
		}

		// Determine if this should be a link
		$should_link = ! $is_last && ! empty( $url );

		if ( $should_link ) {
			// Create link element
			$link = Create::a( $url );
			if ( ! empty( $classes ) ) {
				$link->add_class( $classes );
			}

			// Add content to link
			foreach ( $content_parts as $part ) {
				if ( $part instanceof Element ) {
					$link->add_child( $part );
				} else {
					$link->add_child( ' ' . $part );
				}
			}

			return $link;
		} else {
			// Create span for current item
			$span = Create::span();
			if ( ! empty( $classes ) ) {
				$span->add_class( $classes );
			}

			// Add content to span
			foreach ( $content_parts as $part ) {
				if ( $part instanceof Element ) {
					$span->add_child( $part );
				} else {
					$span->add_child( ' ' . $part );
				}
			}

			return $span;
		}
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
	 * Add a link breadcrumb item
	 *
	 * @param string      $url     Link URL
	 * @param string      $text    Link text
	 * @param string|null $icon    Optional Dashicon (without 'dashicons-' prefix)
	 * @param array       $classes Optional CSS classes
	 *
	 * @return $this
	 */
	public function add_link( string $url, string $text, ?string $icon = null, array $classes = [] ): self {
		$item = [
			'url'     => $url,
			'text'    => $text,
			'classes' => $classes
		];

		if ( $icon !== null ) {
			$item['icon'] = $icon;
		}

		return $this->add_item( $item );
	}

	/**
	 * Set the current (non-linked) breadcrumb item
	 *
	 * @param string      $text    Current item text
	 * @param string|null $icon    Optional Dashicon (without 'dashicons-' prefix)
	 * @param array       $classes Optional CSS classes
	 *
	 * @return $this
	 */
	public function set_current( string $text, ?string $icon = null, array $classes = [] ): self {
		$item = [
			'text'    => $text,
			'classes' => $classes
		];

		if ( $icon !== null ) {
			$item['icon'] = $icon;
		}

		return $this->add_item( $item );
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
	 * Enable or disable icon display
	 *
	 * @param bool $show_icons Whether to show icons
	 *
	 * @return $this
	 */
	public function show_icons( bool $show_icons = true ): self {
		$this->options['show_icons'] = $show_icons;
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
			'home_icon'   => 'admin-home',
			'folder_icon' => 'category',
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
				'url'  => $options['home_url'],
				'icon' => $options['home_icon']
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
				$items[] = [
					'text' => $text,
					'icon' => $options['folder_icon']
				];
			} else {
				$items[] = [
					'text' => $text,
					'url'  => rtrim( $base_url, '/' ) . $current_path,
					'icon' => $options['folder_icon']
				];
			}
		}

		return new self( $items, $options['separator'], [], $options['include_css'] );
	}

	/**
	 * Create a breadcrumb from a path string (compatible with your existing method)
	 *
	 * @param string      $base_url   Base URL for the breadcrumb links
	 * @param string      $base_label Label for the base URL
	 * @param string|null $base_icon  Optional. Dashicon for the base. Default null.
	 * @param string      $path       Forward slash separated path string
	 * @param string      $separator  Optional. Separator between items. Default '›'.
	 * @param array       $classes    Optional. CSS classes for container. Default empty array.
	 *
	 * @return self
	 */
	public static function from_path_legacy(
		string $base_url,
		string $base_label,
		?string $base_icon = null,
		string $path = '',
		string $separator = '›',
		array $classes = []
	): self {
		$breadcrumb = new self( [], $separator, [ 'class' => implode( ' ', $classes ) ] );

		// Add base link
		$breadcrumb->add_link( $base_url, $base_label, $base_icon );

		// Add path segments
		if ( ! empty( $path ) ) {
			$parts        = explode( '/', trim( $path, '/' ) );
			$current_path = '';

			foreach ( $parts as $i => $part ) {
				if ( empty( $part ) ) {
					continue;
				}

				$current_path .= $part . '/';
				$url          = add_query_arg( 'path', rtrim( $current_path, '/' ), $base_url );

				// Last part is current, others are links
				if ( $i === count( $parts ) - 1 ) {
					$breadcrumb->set_current( $part, 'category' );
				} else {
					$breadcrumb->add_link( $url, $part, 'category' );
				}
			}
		}

		return $breadcrumb;
	}

}