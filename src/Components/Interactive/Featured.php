<?php
/**
 * Elementify Library - Featured Component
 *
 * Provides a styled star icon for toggling featured status.
 *
 * @package     ArrayPress\Elementify\Components
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Components\Interactive;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;
use Elementify\Create;

/**
 * Featured Component
 *
 * Creates a star icon that can be clicked to toggle featured status.
 */
class Featured extends Component {

	/**
	 * Feature name
	 *
	 * @var string
	 */
	protected string $name;

	/**
	 * Featured options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Constructor
	 *
	 * @param string      $name        Featured input name
	 * @param bool        $featured    Whether the item is featured
	 * @param string|null $label       Optional label text
	 * @param array       $attributes  Element attributes
	 * @param bool        $disabled    Whether the featured control is disabled
	 * @param bool        $include_css Whether to include built-in CSS
	 */
	public function __construct(
		string $name,
		bool $featured = false,
		?string $label = null,
		array $attributes = [],
		bool $disabled = false,
		bool $include_css = true
	) {
		$this->name = $name;

		// Store options
		$this->options = [
			'featured' => $featured,
			'label'    => $label,
			'disabled' => $disabled
		];

		// Initialize with div element for the container
		parent::__construct( 'div', null, $attributes );

		// Add base class for styling
		$this->add_class( 'featured-container' );

		// Initialize component foundation
		$this->init_component( 'featured', $attributes, $include_css );

		// Build the component structure
		$this->build();
	}

	/**
	 * Build the component structure
	 *
	 * @return void
	 */
	protected function build(): void {
		// Clear any existing children
		$this->children = [];

		// Determine the icon class based on featured state
		$icon_class = $this->options['featured'] ? 'dashicons-star-filled' : 'dashicons-star-empty';

		// Add featured state class
		if ( $this->options['featured'] ) {
			$this->add_class( 'is-featured' );
		} else {
			$this->remove_class( 'is-featured' );
		}

		// Set disabled state if needed
		if ( $this->options['disabled'] ) {
			$this->add_class( 'featured-disabled' );
		} else {
			$this->remove_class( 'featured-disabled' );
		}

		// Create the star icon
		$star_icon = Create::span( null, [
			'class'      => 'dashicons ' . $icon_class,
			'role'       => 'button',
			'tabindex'   => $this->options['disabled'] ? '-1' : '0',
			'aria-label' => $this->options['featured'] ?
				__( 'Remove from featured', 'elementify' ) :
				__( 'Mark as featured', 'elementify' ),
			'title'      => $this->options['featured'] ?
				__( 'Remove from featured', 'elementify' ) :
				__( 'Mark as featured', 'elementify' )
		] );

		// Add the star icon to the container
		$this->add_child( $star_icon );

		// Add label if provided
		if ( $this->options['label'] ) {
			$label_element = Create::span( $this->options['label'], [ 'class' => 'featured-label' ] );
			$this->add_child( $label_element );
		}
	}

	/**
	 * Set the featured state
	 *
	 * @param bool $featured Whether the item is featured
	 *
	 * @return $this
	 */
	public function set_featured( bool $featured ): self {
		$this->options['featured'] = $featured;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set the featured label
	 *
	 * @param string|null $label Label text
	 *
	 * @return $this
	 */
	public function set_label( ?string $label ): self {
		$this->options['label'] = $label;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set the disabled state
	 *
	 * @param bool $disabled Whether the control is disabled
	 *
	 * @return $this
	 */
	public function set_disabled( bool $disabled ): self {
		$this->options['disabled'] = $disabled;
		$this->mark_for_rebuild();

		return $this;
	}

}