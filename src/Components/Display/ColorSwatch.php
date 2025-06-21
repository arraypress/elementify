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
use Elementify\Traits\Component\Parts;

/**
 * Color Component
 *
 * Creates a visual color swatch with optional value display.
 */
class ColorSwatch extends Component {
	use Parts;

	/**
	 * Color options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Color value
	 *
	 * @var string
	 */
	protected string $color;

	/**
	 * Constructor
	 *
	 * @param string $color      The color value (hex, rgb, etc.)
	 * @param array  $options    Additional options
	 * @param array  $attributes Element attributes
	 */
	public function __construct( string $color, array $options = [], array $attributes = [] ) {
		// Store color value
		$this->color = $color;

		// Merge default options
		$this->options = array_merge( [
			'size'         => 20,            // Size in pixels
			'shape'        => 'square',      // square, circle
			'show_value'   => true,          // Show color value
			'value_format' => '%s',          // Format for value display
			'tooltip'      => '',            // Optional tooltip text
			'border'       => true,          // Show border
			'border_color' => 'rgba(0,0,0,0.1)', // Border color
		], $options );

		// Set base class
		$this->base_class = 'color-swatch';

		// Initialize with a span element
		parent::__construct( 'span', null, $attributes );

		// Initialize component foundation
		$this->init_component( 'color-swatch', $attributes );

		// Add tooltip if provided
		if ( ! empty( $this->options['tooltip'] ) ) {
			$this->add_tooltip( $this->options['tooltip'] );
		}

		// Build the color component
		$this->build();
	}

	/**
	 * Build the color swatch structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Create swatch element
		$size = intval( $this->options['size'] );

		// Determine border radius based on shape
		$border_radius = $this->options['shape'] === 'circle' ? '50%' : '3px';

		// Create style for the swatch
		$style = sprintf(
			'display:inline-block; width:%1$dpx; height:%1$dpx; background-color:%2$s; border-radius:%3$s; vertical-align:middle;',
			$size,
			esc_attr( $this->color ),
			$border_radius
		);

		// Add border if enabled
		if ( $this->options['border'] ) {
			$style .= sprintf( ' border:1px solid %s;', esc_attr( $this->options['border_color'] ) );
		}

		// Create the swatch element
		$swatch = Create::span()->set_attribute( 'style', $style )->add_class( 'color-swatch__sample' );

		// Create wrapper to hold swatch and value
		$wrapper = Create::span()->add_class( 'color-swatch__wrapper' );
		$wrapper->add_child( $swatch );

		// Add color value if enabled
		if ( $this->options['show_value'] ) {
			$value_text = sprintf( $this->options['value_format'], $this->color );
			$value      = Create::span( $value_text )->add_class( 'color-swatch__value' );

			// Add margin to the value
			$value->set_attribute( 'style', 'margin-left:5px; vertical-align:middle;' );

			$wrapper->add_child( $value );
		}

		// Add wrapper to component
		$this->add_child( $wrapper );
	}

	/**
	 * Set color value
	 *
	 * @param string $color New color value
	 *
	 * @return $this
	 */
	public function set_color( string $color ): self {
		$this->color = $color;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set swatch size
	 *
	 * @param int $size Size in pixels
	 *
	 * @return $this
	 */
	public function set_size( int $size ): self {
		$this->options['size'] = max( 1, $size );
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set swatch shape
	 *
	 * @param string $shape Shape (square, circle)
	 *
	 * @return $this
	 */
	public function set_shape( string $shape ): self {
		if ( in_array( $shape, [ 'square', 'circle' ] ) ) {
			$this->options['shape'] = $shape;
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Show/hide color value
	 *
	 * @param bool $show Whether to show value
	 *
	 * @return $this
	 */
	public function show_value( bool $show = true ): self {
		return $this->toggle_option( 'show_value', $show );
	}

	/**
	 * Set value format
	 *
	 * @param string $format Format string (use %s for color value)
	 *
	 * @return $this
	 */
	public function set_value_format( string $format ): self {
		$this->options['value_format'] = $format;

		// Rebuild the component if showing value
		if ( $this->options['show_value'] ) {
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Set tooltip text
	 *
	 * @param string $tooltip Tooltip text
	 *
	 * @return $this
	 */
	public function set_tooltip( string $tooltip ): self {
		$this->options['tooltip'] = $tooltip;
		$this->add_tooltip( $tooltip );

		return $this;
	}

	/**
	 * Show/hide border
	 *
	 * @param bool $show Whether to show border
	 *
	 * @return $this
	 */
	public function show_border( bool $show = true ): self {
		return $this->toggle_option( 'border', $show );
	}

	/**
	 * Set border color
	 *
	 * @param string $color Border color
	 *
	 * @return $this
	 */
	public function set_border_color( string $color ): self {
		$this->options['border_color'] = $color;

		// Rebuild the component if showing border
		if ( $this->options['border'] ) {
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Get the color value
	 *
	 * @return string
	 */
	public function get_color(): string {
		return $this->color;
	}

}