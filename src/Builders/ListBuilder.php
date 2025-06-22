<?php
/**
 * Elementify Library - List Builder
 *
 * Provides a fluent interface for building HTML lists with advanced features.
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

use Elementify\Element;
use Elementify\Create;

/**
 * List Builder Class
 *
 * Provides a fluent interface for building complex HTML lists including
 * navigation menus, nested lists, and lists with custom styling.
 */
class ListBuilder extends Element {

	/**
	 * List items
	 *
	 * @var array
	 */
	protected array $items = [];

	/**
	 * Whether this is an ordered list
	 *
	 * @var bool
	 */
	protected bool $is_ordered = false;

	/**
	 * Constructor
	 *
	 * @param array $attributes Element attributes
	 */
	public function __construct( array $attributes = [] ) {
		parent::__construct( 'ul', null, $attributes );
	}

	/**
	 * Add a simple list item
	 *
	 * @param mixed $content    Item content
	 * @param array $attributes Item attributes
	 *
	 * @return $this For method chaining
	 */
	public function item( $content, array $attributes = [] ): self {
		$this->items[] = [
			'type'       => 'item',
			'content'    => $content,
			'attributes' => $attributes
		];

		return $this;
	}

	/**
	 * Add a link item
	 *
	 * @param string $text       Link text
	 * @param string $url        Link URL
	 * @param array  $attributes Link attributes
	 * @param bool   $active     Whether the link is active
	 *
	 * @return $this For method chaining
	 */
	public function link( string $text, string $url, array $attributes = [], bool $active = false ): self {
		$this->items[] = [
			'type'       => 'link',
			'text'       => $text,
			'url'        => $url,
			'attributes' => $attributes,
			'active'     => $active
		];

		return $this;
	}

	/**
	 * Add a current/active item (non-clickable)
	 *
	 * @param string $text       Item text
	 * @param array  $attributes Item attributes
	 *
	 * @return $this For method chaining
	 */
	public function current( string $text, array $attributes = [] ): self {
		$this->items[] = [
			'type'       => 'current',
			'text'       => $text,
			'attributes' => array_merge( [ 'class' => 'current active' ], $attributes )
		];

		return $this;
	}

	/**
	 * Add a submenu (nested list)
	 *
	 * @param string $label      Submenu label
	 * @param array  $items      Submenu items (text => url or array of configurations)
	 * @param array  $attributes Submenu attributes
	 *
	 * @return $this For method chaining
	 */
	public function submenu( string $label, array $items, array $attributes = [] ): self {
		$this->items[] = [
			'type'       => 'submenu',
			'label'      => $label,
			'items'      => $items,
			'attributes' => $attributes
		];

		return $this;
	}

	/**
	 * Add a divider/separator item
	 *
	 * @param string $class CSS class for the divider
	 *
	 * @return $this For method chaining
	 */
	public function divider( string $class = 'divider' ): self {
		$this->items[] = [
			'type'  => 'divider',
			'class' => $class
		];

		return $this;
	}

	/**
	 * Add a header item (non-clickable label)
	 *
	 * @param string $text       Header text
	 * @param array  $attributes Header attributes
	 *
	 * @return $this For method chaining
	 */
	public function header( string $text, array $attributes = [] ): self {
		$this->items[] = [
			'type'       => 'header',
			'text'       => $text,
			'attributes' => array_merge( [ 'class' => 'list-header' ], $attributes )
		];

		return $this;
	}

	/**
	 * Convert to ordered list
	 *
	 * @return $this For method chaining
	 */
	public function ordered(): self {
		$this->is_ordered = true;
		$this->tag        = 'ol';

		return $this;
	}

	/**
	 * Convert to unordered list
	 *
	 * @return $this For method chaining
	 */
	public function unordered(): self {
		$this->is_ordered = false;
		$this->tag        = 'ul';

		return $this;
	}

	/**
	 * Make this a navigation list
	 *
	 * @return $this For method chaining
	 */
	public function navigation(): self {
		$this->add_class( 'nav' );
		$this->set_attribute( 'role', 'navigation' );

		return $this;
	}

	/**
	 * Style as breadcrumb navigation
	 *
	 * @return $this For method chaining
	 */
	public function breadcrumb(): self {
		$this->add_class( 'breadcrumb' );
		$this->set_attribute( 'aria-label', 'Breadcrumb' );

		return $this;
	}

	/**
	 * Style as horizontal menu
	 *
	 * @return $this For method chaining
	 */
	public function horizontal(): self {
		$this->add_class( 'horizontal' );

		return $this;
	}

	/**
	 * Style as vertical menu
	 *
	 * @return $this For method chaining
	 */
	public function vertical(): self {
		$this->add_class( 'vertical' );

		return $this;
	}

	/**
	 * Add WordPress menu classes
	 *
	 * @return $this For method chaining
	 */
	public function wp_menu(): self {
		$this->add_class( 'wp-menu' );

		return $this;
	}

	/**
	 * Build the list structure
	 *
	 * @return void
	 */
	protected function build(): void {
		$this->children = []; // Clear existing content

		foreach ( $this->items as $item_data ) {
			$li = null;

			switch ( $item_data['type'] ) {
				case 'item':
					$li = Create::li( $item_data['content'], $item_data['attributes'] );
					break;

				case 'link':
					$link = Create::a( $item_data['url'], $item_data['text'], $item_data['attributes'] );

					if ( $item_data['active'] ) {
						$link->add_class( 'active' );
					}

					$li = Create::li( $link );

					if ( $item_data['active'] ) {
						$li->add_class( 'active' );
					}
					break;

				case 'header':
				case 'current':
					$li = Create::li( $item_data['text'], $item_data['attributes'] );
					break;

				case 'submenu':
					$submenu_list = Create::ul();

					foreach ( $item_data['items'] as $key => $value ) {
						if ( is_string( $key ) && is_string( $value ) ) {
							// Key is URL, value is text
							$submenu_link = Create::a( $key, $value );
							$submenu_list->add_child( Create::li( $submenu_link ) );
						} elseif ( is_array( $value ) && isset( $value['text'], $value['url'] ) ) {
							// Array configuration
							$submenu_link = Create::a( $value['url'], $value['text'], $value['attributes'] ?? [] );
							$submenu_list->add_child( Create::li( $submenu_link ) );
						} else {
							// Simple text item
							$submenu_list->add_child( Create::li( $value ) );
						}
					}

					$li = Create::li( null, array_merge( [ 'class' => 'has-submenu' ], $item_data['attributes'] ) );
					$li->add_child( $item_data['label'] );
					$li->add_child( $submenu_list );
					break;

				case 'divider':
					$li = Create::li( null, [ 'class' => $item_data['class'] ] );
					break;

			}

			if ( $li ) {
				$this->add_child( $li );
			}
		}
	}

	/**
	 * Render the list
	 *
	 * @return string
	 */
	public function render(): string {
		$this->build();

		return parent::render();
	}

}