<?php
/**
 * Elementify Library - Range Input with Display Component
 *
 * Provides a range slider with value display functionality.
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
use Elementify\Elements\Input;

/**
 * Range With Display Component
 *
 * Creates a styled range input slider with value display.
 */
class Range extends Component {

	/**
	 * Range input name
	 *
	 * @var string
	 */
	protected string $name;

	/**
	 * Current slider value
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * Minimum allowed value
	 *
	 * @var mixed
	 */
	protected $min;

	/**
	 * Maximum allowed value
	 *
	 * @var mixed
	 */
	protected $max;

	/**
	 * Step increment value
	 *
	 * @var mixed
	 */
	protected $step;

	/**
	 * Whether to display the value
	 *
	 * @var bool
	 */
	protected bool $display_value;

	/**
	 * Constructor
	 *
	 * @param string $name          Input name
	 * @param mixed  $value         Input value
	 * @param mixed  $min           Minimum value
	 * @param mixed  $max           Maximum value
	 * @param mixed  $step          Step value
	 * @param bool   $display_value Whether to display the value
	 * @param array  $attributes    Element attributes
	 * @param bool   $include_css   Whether to include built-in CSS
	 */
	public function __construct(
		string $name,
		$value = '50',
		$min = '0',
		$max = '100',
		$step = '1',
		bool $display_value = true,
		array $attributes = [],
		bool $include_css = true
	) {
		$this->name          = $name;
		$this->value         = $value;
		$this->min           = $min;
		$this->max           = $max;
		$this->step          = $step;
		$this->display_value = $display_value;

		// Initialize with div element
		parent::__construct( 'div', null, $attributes );

		// Add base class for styling
		$this->add_class( 'range-container' );

		// Initialize component foundation
		$this->init_component( 'range', $attributes, $include_css );

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

		// Add inner wrapper for better styling control
		$inner_wrapper = Create::div( null, [ 'class' => 'range-inner' ] );

		// Create the range input
		$input_id   = 'range-' . $this->name;
		$display_id = 'range-value-' . $this->name;

		// Create the range input directly
		$range_input = new Input( 'range', $this->name, $this->value, [
			'class'           => 'range-input',
			'id'              => $input_id,
			'step'            => $this->step,
			'min'             => $this->min,
			'max'             => $this->max,
			'data-display-id' => $display_id,
			'aria-labelledby' => $display_id
		] );

		$inner_wrapper->add_child( $range_input );

		// Add value display if enabled
		if ( $this->display_value ) {
			$display = Create::span(
				$this->value,
				[
					'class'     => 'range-value',
					'id'        => $display_id,
					'aria-live' => 'polite'
				]
			);

			$inner_wrapper->add_child( $display );
		}

		$this->add_child( $inner_wrapper );
	}

	/**
	 * Set the range value
	 *
	 * @param mixed $value New value
	 *
	 * @return $this
	 */
	public function set_value( $value ): self {
		$this->value = $value;
		$this->build();

		return $this;
	}

	/**
	 * Set the minimum value
	 *
	 * @param mixed $min Minimum value
	 *
	 * @return $this
	 */
	public function set_min( $min ): self {
		$this->min = $min;
		$this->build();

		return $this;
	}

	/**
	 * Set the maximum value
	 *
	 * @param mixed $max Maximum value
	 *
	 * @return $this
	 */
	public function set_max( $max ): self {
		$this->max = $max;
		$this->build();

		return $this;
	}

	/**
	 * Set the step increment
	 *
	 * @param mixed $step Step value
	 *
	 * @return $this
	 */
	public function set_step( $step ): self {
		$this->step = $step;
		$this->build();

		return $this;
	}

	/**
	 * Set whether to display the value
	 *
	 * @param bool $display Whether to display the value
	 *
	 * @return $this
	 */
	public function set_display_value( bool $display ): self {
		$this->display_value = $display;
		$this->build();

		return $this;
	}

}