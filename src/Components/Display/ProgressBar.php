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

namespace Elementify\Components\Display;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Element;
use Elementify\Traits\Component\Parts;

/**
 * Progress Bar Component
 *
 * Creates a visual progress bar for displaying completion progress.
 */
class ProgressBar extends Component {
	use Parts;

	/**
	 * Progress bar options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Current value
	 *
	 * @var int|float
	 */
	protected $current_value;

	/**
	 * Total value
	 *
	 * @var int|float
	 */
	protected $total_value;

	/**
	 * Constructor
	 *
	 * @param int|float $current     Current value
	 * @param int|float $total       Total value (maximum)
	 * @param array     $options     Additional options
	 * @param array     $attributes  Element attributes
	 * @param bool      $include_css Whether to include built-in CSS
	 */
	public function __construct( $current, $total = 100, array $options = [], array $attributes = [], bool $include_css = true ) {
		// Set current and total values
		$this->current_value = max( 0, $current );
		$this->total_value   = max( 1, $total ); // Prevent division by zero

		// Merge default options
		$this->options = array_merge( [
			'current_percentage' => false,    // Calculate from current/total if false
			'size'               => 'medium',  // small, medium, large
			'show_percentage'    => false,     // Show percentage in label
			'show_current'       => false,     // Show current value in label
			'show_total'         => false,     // Show total value in label
		], $options );

		// Set base class
		$this->base_class = 'progress-bar';

		// Initialize component foundation
		$this->init_component( 'progress-bar', $attributes, $include_css );

		// Add size class
		$this->add_class( $this->get_size_class() );

		// Initialize with a div element
		parent::__construct( 'div', null, $attributes );

		// Build the progress bar
		$this->build();
	}

	/**
	 * Build the progress bar structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Create container div that holds both progress and label
		$container = Create::div()->add_class( 'progress-container' );

		// Get percentage as number (without the % sign)
		$percentage = $this->get_percentage_value();

		// Create the progress element with direct width styling
		$progress = Create::div()
		                  ->add_class( 'progress' )
		                  ->set_attribute( 'style', 'width: ' . $percentage . '%;' );

		// Add progress to container
		$container->add_child( $progress );

		// Add label if needed - directly to container for proper positioning
		$label = $this->create_label();
		if ( $label ) {
			$container->add_child( $label );
		}

		// Add container to progress bar
		$this->add_child( $container );
	}

	/**
	 * Create label element if needed
	 *
	 * @return Element|null
	 */
	protected function create_label(): ?Element {
		$label_text = '';

		// Add percentage to label
		if ( $this->options['show_percentage'] ) {
			$percentage = $this->get_percentage_value();
			$label_text .= "{$percentage}%";
		}

		// Add current/total values to label
		if ( $this->options['show_current'] && $this->options['show_total'] ) {
			if ( ! empty( $label_text ) ) {
				$label_text = '';  // Clear previous content to match screenshot format
			}
			$label_text .= "{$this->current_value} / {$this->total_value}";
		} else if ( $this->options['show_current'] ) {
			$label_text .= (string) $this->current_value;
		} else if ( $this->options['show_total'] ) {
			$label_text .= (string) $this->total_value;
		}

		// Return null if no label content
		if ( empty( $label_text ) ) {
			return null;
		}

		// Create and return the label element
		return Create::div( $label_text )->add_class( 'label' );
	}

	/**
	 * Get size class
	 *
	 * @return string
	 */
	protected function get_size_class(): string {
		if ( in_array( $this->options['size'], [ 'small', 'medium', 'large' ], true ) ) {
			return $this->options['size'];
		}

		return 'medium';
	}

	/**
	 * Get current percentage
	 *
	 * @return string Percentage with % sign
	 */
	protected function get_percentage(): string {
		return $this->get_percentage_value() . '%';
	}

	/**
	 * Get percentage as numeric value
	 *
	 * @return int Percentage as number (without % sign)
	 */
	protected function get_percentage_value(): int {
		if ( is_numeric( $this->options['current_percentage'] ) ) {
			$percentage = intval( $this->options['current_percentage'] );
		} else {
			$percentage = intval( ( $this->current_value / $this->total_value ) * 100 );
		}

		// Cap at 100%
		return min( 100, $percentage );
	}

	/**
	 * Set current value
	 *
	 * @param int|float $value Current value
	 *
	 * @return $this
	 */
	public function set_current( $value ): self {
		$this->current_value = max( 0, $value );
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set total value
	 *
	 * @param int|float $value Total value
	 *
	 * @return $this
	 */
	public function set_total( $value ): self {
		$this->total_value = max( 1, $value );
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set size
	 *
	 * @param string $size Size (small, medium, large)
	 *
	 * @return $this
	 */
	public function set_size( string $size ): self {
		if ( in_array( $size, [ 'small', 'medium', 'large' ], true ) ) {
			$this->options['size'] = $size;

			// Update size class
			$this->remove_class( [ 'small', 'medium', 'large' ] );
			$this->add_class( $size );
		}

		return $this;
	}

	/**
	 * Show/hide percentage in label
	 *
	 * @param bool $show Whether to show percentage
	 *
	 * @return $this
	 */
	public function show_percentage( bool $show = true ): self {
		return $this->toggle_option( 'show_percentage', $show );
	}

	/**
	 * Show/hide current value in label
	 *
	 * @param bool $show Whether to show current value
	 *
	 * @return $this
	 */
	public function show_current( bool $show = true ): self {
		return $this->toggle_option( 'show_current', $show );
	}

	/**
	 * Show/hide total value in label
	 *
	 * @param bool $show Whether to show total value
	 *
	 * @return $this
	 */
	public function show_total( bool $show = true ): self {
		return $this->toggle_option( 'show_total', $show );
	}

}