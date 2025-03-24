<?php
/**
 * Elementify Library - Boolean Icon Component
 *
 * @package     ArrayPress\Elementify\Components
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Components\Display;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;

/**
 * BooleanIcon Component
 *
 * Creates an icon representation of a boolean value.
 */
class BooleanIcon extends Component {

	/**
	 * Value being displayed
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * Component options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Icon for true value
	 *
	 * @var string
	 */
	protected string $true_icon;

	/**
	 * Icon for false value
	 *
	 * @var string
	 */
	protected string $false_icon;

	/**
	 * Constructor
	 *
	 * @param mixed $value       Value to display
	 * @param array $options     Component options
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS
	 */
	public function __construct( $value, array $options = [], array $attributes = [], bool $include_css = true ) {
		// Extract options with defaults
		$this->value = $value;

		// Set default options
		$this->options = array_merge( [
			'true_value'    => true,
			'false_value'   => false,
			'true_icon'     => 'yes-alt',
			'false_icon'    => 'no-alt',
			'true_label'    => __( 'Yes', 'arraypress' ),
			'false_label'   => __( 'No', 'arraypress' ),
			'use_dashicons' => true,
			'position'      => 'before'
		], $options );

		// Initialize component
		parent::__construct( 'span', '', $attributes );
		$this->init_component( 'boolean-icon', $attributes, $include_css );

		// Build the component
		$this->build();
	}

	/**
	 * Build the component structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Determine if value matches true or false
		if ( $this->value == $this->options['true_value'] ) {
			$icon  = $this->options['true_icon'];
			$label = $this->options['true_label'];
			$this->add_class( 'boolean-icon--true' );
		} elseif ( $this->value == $this->options['false_value'] ) {
			$icon  = $this->options['false_icon'];
			$label = $this->options['false_label'];
			$this->add_class( 'boolean-icon--false' );
		} else {
			// For non-boolean values
			$this->add_child( esc_html( (string) $this->value ) );

			return;
		}

		// Handle direct HTML
		if ( strpos( $icon, '<' ) === 0 ) {
			$this->add_child( $icon );

			return;
		}

		// Set accessible attributes
		$this->set_attribute( 'aria-label', $label );
		$this->add_tooltip( $label );

		// Add icon class
		if ( $this->options['use_dashicons'] ) {
			$this->add_class( "dashicons dashicons-{$icon}" );
		} else {
			$this->add_class( $icon );
		}
	}

	/**
	 * Set true value for comparison
	 *
	 * @param mixed $value Value to compare against
	 *
	 * @return $this
	 */
	public function set_true_value( $value ): self {
		$this->options['true_value'] = $value;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set false value for comparison
	 *
	 * @param mixed $value Value to compare against
	 *
	 * @return $this
	 */
	public function set_false_value( $value ): self {
		$this->options['false_value'] = $value;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set true icon
	 *
	 * @param string $icon Icon identifier or HTML
	 *
	 * @return $this
	 */
	public function set_true_icon( string $icon ): self {
		$this->options['true_icon'] = $icon;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set false icon
	 *
	 * @param string $icon Icon identifier or HTML
	 *
	 * @return $this
	 */
	public function set_false_icon( string $icon ): self {
		$this->options['false_icon'] = $icon;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set true label
	 *
	 * @param string $label Label for true value
	 *
	 * @return $this
	 */
	public function set_true_label( string $label ): self {
		$this->options['true_label'] = $label;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set false label
	 *
	 * @param string $label Label for false value
	 *
	 * @return $this
	 */
	public function set_false_label( string $label ): self {
		$this->options['false_label'] = $label;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set whether to use dashicons
	 *
	 * @param bool $use Whether to use dashicons
	 *
	 * @return $this
	 */
	public function use_dashicons( bool $use ): self {
		return $this->toggle_option( 'use_dashicons', $use );
	}
	
}