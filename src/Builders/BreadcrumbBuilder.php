<?php
/**
 * Elementify Library - Breadcrumb Builder
 *
 * Provides a fluent interface for building breadcrumb navigation.
 *
 * @package     ArrayPress\Elementify\Builders
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Builders;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Components\Layout\Breadcrumbs;
use WP_Post;

/**
 * Breadcrumb Builder Class
 *
 * Provides a fluent interface for building breadcrumb navigation
 * with icons and custom styling. Uses composition instead of inheritance.
 */
class BreadcrumbBuilder {

	/**
	 * The underlying Breadcrumbs component
	 *
	 * @var Breadcrumbs
	 */
	protected Breadcrumbs $breadcrumbs;

	/**
	 * Constructor
	 *
	 * @param array  $items      Initial breadcrumb items
	 * @param string $separator  Separator between items
	 * @param array  $attributes Element attributes
	 */
	public function __construct( array $items = [], string $separator = '/', array $attributes = [] ) {
		$this->breadcrumbs = new Breadcrumbs( $items, $separator, $attributes );
	}

	/**
	 * Add home/root breadcrumb item
	 *
	 * @param string      $text Home link text
	 * @param string      $url  Home URL
	 * @param string|null $icon Optional home icon (dashicon name without prefix)
	 *
	 * @return $this For method chaining
	 */
	public function home( string $text = 'Home', string $url = '/', ?string $icon = 'admin-home' ): self {
		$item = [
			'text' => $text,
			'url'  => $url
		];

		if ( $icon ) {
			$item['icon'] = $icon;
		}

		$this->breadcrumbs->add_item( $item );

		return $this;
	}

	/**
	 * Add a linked breadcrumb item
	 *
	 * @param string      $text Link text
	 * @param string      $url  Link URL
	 * @param string|null $icon Optional icon (dashicon name without prefix)
	 *
	 * @return $this For method chaining
	 */
	public function link( string $text, string $url, ?string $icon = null ): self {
		$item = [
			'text' => $text,
			'url'  => $url
		];

		if ( $icon ) {
			$item['icon'] = $icon;
		}

		$this->breadcrumbs->add_item( $item );

		return $this;
	}

	/**
	 * Add the current page (non-linked) breadcrumb item
	 *
	 * @param string      $text Current page text
	 * @param string|null $icon Optional icon (dashicon name without prefix)
	 *
	 * @return $this For method chaining
	 */
	public function current( string $text, ?string $icon = null ): self {
		$item = [
			'text' => $text
		];

		if ( $icon ) {
			$item['icon'] = $icon;
		}

		$this->breadcrumbs->add_item( $item );

		return $this;
	}

	/**
	 * Set the breadcrumb separator
	 *
	 * @param string $separator Separator character or string
	 *
	 * @return $this For method chaining
	 */
	public function separator( string $separator ): self {
		$this->breadcrumbs->set_separator( $separator );

		return $this;
	}

	/**
	 * Use arrow separator
	 *
	 * @return $this For method chaining
	 */
	public function arrow_separator(): self {
		return $this->separator( '→' );
	}

	/**
	 * Use chevron separator
	 *
	 * @return $this For method chaining
	 */
	public function chevron_separator(): self {
		return $this->separator( '›' );
	}

	/**
	 * Use slash separator
	 *
	 * @return $this For method chaining
	 */
	public function slash_separator(): self {
		return $this->separator( '/' );
	}

	/**
	 * Disable icons for all breadcrumb items
	 *
	 * @return $this For method chaining
	 */
	public function no_icons(): self {
		$this->breadcrumbs->show_icons( false );

		return $this;
	}

	/**
	 * Add CSS class to the breadcrumbs
	 *
	 * @param string|array $classes CSS class(es) to add
	 *
	 * @return $this For method chaining
	 */
	public function add_class( $classes ): self {
		$this->breadcrumbs->add_class( $classes );

		return $this;
	}

	/**
	 * Add WordPress admin breadcrumb styling
	 *
	 * @return $this For method chaining
	 */
	public function wp_admin_style(): self {
		$this->breadcrumbs->add_class( 'wp-admin-breadcrumb' );

		return $this;
	}

	/**
	 * Build breadcrumbs from URL path automatically
	 *
	 * @param string $path     URL path to build from
	 * @param string $base_url Base URL for links
	 * @param array  $options  Path parsing options
	 *
	 * @return $this For method chaining
	 */
	public function from_path( string $path, string $base_url = '', array $options = [] ): self {
		// Clear existing items by getting current items and removing them
		$current_items = $this->breadcrumbs->get_items();
		foreach ( array_keys( $current_items ) as $index ) {
			$this->breadcrumbs->remove_item( $index );
		}

		// Add home if specified in options
		if ( isset( $options['home_text'] ) ) {
			$this->home(
				$options['home_text'],
				$options['home_url'] ?? '/',
				$options['home_icon'] ?? 'admin-home'
			);
		}

		// Parse path segments
		$segments     = array_filter( explode( '/', trim( $path, '/' ) ) );
		$current_path = '';

		foreach ( $segments as $index => $segment ) {
			$current_path .= '/' . $segment;

			// Transform segment text
			$text = isset( $options['transform'] ) && is_callable( $options['transform'] )
				? call_user_func( $options['transform'], $segment )
				: ucfirst( str_replace( [ '-', '_' ], ' ', $segment ) );

			// Last segment is current page
			if ( $index === count( $segments ) - 1 ) {
				$this->current( $text, $options['segment_icon'] ?? null );
			} else {
				$this->link( $text, rtrim( $base_url, '/' ) . $current_path, $options['segment_icon'] ?? null );
			}
		}

		return $this;
	}

	/**
	 * Build breadcrumbs from WordPress post hierarchy
	 *
	 * @param int|WP_Post $post Post ID or post object
	 *
	 * @return $this For method chaining
	 */
	public function from_post( $post ): self {
		if ( ! function_exists( 'get_post' ) ) {
			return $this;
		}

		$post = get_post( $post );
		if ( ! $post ) {
			return $this;
		}

		// Clear existing items
		$current_items = $this->breadcrumbs->get_items();
		foreach ( array_keys( $current_items ) as $index ) {
			$this->breadcrumbs->remove_item( $index );
		}

		// Add home
		$this->home( 'Home', home_url( '/' ) );

		// Add post type archive if applicable
		$post_type = get_post_type( $post );
		if ( $post_type !== 'post' && $post_type !== 'page' ) {
			$post_type_object = get_post_type_object( $post_type );
			if ( $post_type_object && $post_type_object->has_archive ) {
				$this->link(
					$post_type_object->labels->name,
					get_post_type_archive_link( $post_type )
				);
			}
		}

		// Add parent pages/posts
		$ancestors = get_post_ancestors( $post );
		$ancestors = array_reverse( $ancestors );

		foreach ( $ancestors as $ancestor ) {
			$ancestor_post = get_post( $ancestor );
			$this->link( $ancestor_post->post_title, get_permalink( $ancestor ) );
		}

		// Add current post
		$this->current( $post->post_title );

		return $this;
	}

	/**
	 * Render the breadcrumbs
	 *
	 * @return string
	 */
	public function render(): string {
		return $this->breadcrumbs->render();
	}

	/**
	 * Output the breadcrumbs directly
	 *
	 * @return void
	 */
	public function output(): void {
		echo $this->render();
	}

	/**
	 * Get the underlying Breadcrumbs component
	 *
	 * @return Breadcrumbs
	 */
	public function get_breadcrumbs(): Breadcrumbs {
		return $this->breadcrumbs;
	}

	/**
	 * Create breadcrumbs from URL path (static factory method)
	 *
	 * @param string $path     URL path to build from
	 * @param string $base_url Base URL for links
	 * @param array  $options  Path parsing options
	 *
	 * @return static
	 */
	public static function create_from_path( string $path, string $base_url = '', array $options = [] ): self {
		$builder = new static();

		return $builder->from_path( $path, $base_url, $options );
	}

	/**
	 * Create breadcrumbs from WordPress post (static factory method)
	 *
	 * @param int|WP_Post $post Post ID or post object
	 *
	 * @return static
	 */
	public static function create_from_post( $post ): self {
		$builder = new static();

		return $builder->from_post( $post );
	}

}