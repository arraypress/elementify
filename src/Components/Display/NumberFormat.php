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
use Elementify\Traits\Component\Parts;

/**
 * Number Component
 *
 * Creates a component for displaying formatted numbers.
 */
class NumberFormat extends Component {
	use Parts;

	/**
	 * Number options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Numeric value
	 *
	 * @var float|int|null
	 */
	protected $value;

	/**
	 * Constructor
	 *
	 * @param float|int|string|null $value       The numeric value
	 * @param array                 $options     Additional options
	 * @param array                 $attributes  Element attributes
	 */
	public function __construct( $value, array $options = [], array $attributes = [] ) {
		// Convert to numeric value if possible
		$this->value = $this->normalize_value( $value );

		// Merge default options
		$this->options = array_merge( [
			'decimals'       => 0,             // Number of decimal places
			'thousands_sep'  => null,          // Thousands separator (null = use WP default)
			'decimal_point'  => null,          // Decimal point character (null = use WP default)
			'prefix'         => '',            // Text to display before the number
			'suffix'         => '',            // Text to display after the number
			'format'         => '%s',          // Format string for the whole output
			'empty_value'    => '',            // Text to display when value is empty
			'tooltip'        => '',            // Optional tooltip text
			'colorize'       => false,         // Apply color based on value
			'positive_class' => 'positive',   // CSS class for positive values
			'negative_class' => 'negative',   // CSS class for negative values
			'neutral_class'  => 'neutral',    // CSS class for zero values
			'show_sign'      => false,         // Show plus sign for positive values
			'short_format'   => false,         // Use shortened format (K, M, B, etc.)
		], $options );

		// Set base class
		$this->base_class = 'number';

		// Initialize component foundation
		$this->init_component( 'number', $attributes );

		// Initialize with a span element
		parent::__construct( 'span', null, $attributes );

		// Add tooltip if provided
		if ( ! empty( $this->options['tooltip'] ) ) {
			$this->add_tooltip( $this->options['tooltip'] );
		}

		// Build the number component
		$this->build();
	}

	/**
	 * Normalize input value to numeric or null
	 *
	 * @param mixed $value Input value
	 *
	 * @return float|int|null Normalized value
	 */
	protected function normalize_value( $value ) {
		if ( $value === '' || $value === null ) {
			return null;
		}

		if ( is_numeric( $value ) ) {
			// Convert to int if it's a whole number, otherwise float
			return ( (float) $value == (int) $value ) ? (int) $value : (float) $value;
		}

		// Try to convert string to number
		if ( is_string( $value ) ) {
			$value = str_replace( [ ',', ' ' ], [ '', '' ], $value );
			if ( is_numeric( $value ) ) {
				return ( (float) $value == (int) $value ) ? (int) $value : (float) $value;
			}
		}

		return null;
	}

	/**
	 * Build the number component structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// If value is null/empty, display empty value
		if ( $this->value === null ) {
			$this->set_content( $this->options['empty_value'] );

			return;
		}

		// Format the number
		$formatted = $this->format_number( $this->value );

		// Add sign if needed
		if ( $this->options['show_sign'] && $this->value > 0 ) {
			$formatted = '+' . $formatted;
		}

		// Add prefix and suffix
		$content = $this->options['prefix'] . $formatted . $this->options['suffix'];

		// Apply format
		$content = sprintf( $this->options['format'], $content );

		// Set content
		$this->set_content( $content );

		// Apply colorizing if needed
		if ( $this->options['colorize'] ) {
			// First remove any existing color classes
			$this->remove_class( [
				$this->options['positive_class'],
				$this->options['negative_class'],
				$this->options['neutral_class']
			] );

			// Add appropriate class based on value
			if ( $this->value > 0 ) {
				$this->add_class( $this->options['positive_class'] );
			} elseif ( $this->value < 0 ) {
				$this->add_class( $this->options['negative_class'] );
			} else {
				$this->add_class( $this->options['neutral_class'] );
			}
		}
	}

	/**
	 * Format number according to options
	 *
	 * @param float|int $number The number to format
	 *
	 * @return string Formatted number
	 */
	protected function format_number( $number ): string {
		// Use short format if requested (K, M, B, etc.)
		if ( $this->options['short_format'] ) {
			return $this->format_short_number( $number );
		}

		// Use custom separators if provided
		if ( $this->options['thousands_sep'] !== null && $this->options['decimal_point'] !== null ) {
			return number_format(
				$number,
				$this->options['decimals'],
				$this->options['decimal_point'],
				$this->options['thousands_sep']
			);
		}

		// Use WordPress i18n formatting
		return number_format_i18n( $number, $this->options['decimals'] );
	}

	/**
	 * Format number in short form (K, M, B, etc.)
	 *
	 * @param float|int $number The number to format
	 *
	 * @return string Formatted number
	 */
	protected function format_short_number( $number ): string {
		$abs  = abs( $number );
		$sign = ( $number < 0 ) ? '-' : '';

		if ( $abs >= 1_000_000_000 ) {
			$formatted = number_format_i18n( $abs / 1_000_000_000, $this->options['decimals'] );

			return $sign . $formatted . 'B';
		} elseif ( $abs >= 1_000_000 ) {
			$formatted = number_format_i18n( $abs / 1_000_000, $this->options['decimals'] );

			return $sign . $formatted . 'M';
		} elseif ( $abs >= 1_000 ) {
			$formatted = number_format_i18n( $abs / 1_000, $this->options['decimals'] );

			return $sign . $formatted . 'K';
		}

		return number_format_i18n( $number, $this->options['decimals'] );
	}

	/**
	 * Set numeric value
	 *
	 * @param float|int|string $value New value
	 *
	 * @return $this
	 */
	public function set_value( $value ): self {
		$this->value = $this->normalize_value( $value );
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set decimal precision
	 *
	 * @param int $decimals Number of decimal places
	 *
	 * @return $this
	 */
	public function set_decimals( int $decimals ): self {
		$this->options['decimals'] = max( 0, $decimals );
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set custom separators
	 *
	 * @param string $thousands_sep Thousands separator
	 * @param string $decimal_point Decimal point character
	 *
	 * @return $this
	 */
	public function set_separators( string $thousands_sep, string $decimal_point ): self {
		$this->options['thousands_sep'] = $thousands_sep;
		$this->options['decimal_point'] = $decimal_point;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set prefix and suffix
	 *
	 * @param string $prefix Text before the number
	 * @param string $suffix Text after the number
	 *
	 * @return $this
	 */
	public function set_wrapping( string $prefix = '', string $suffix = '' ): self {
		$this->options['prefix'] = $prefix;
		$this->options['suffix'] = $suffix;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set format string
	 *
	 * @param string $format Format string (use %s for the value)
	 *
	 * @return $this
	 */
	public function set_format( string $format ): self {
		$this->options['format'] = $format;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set empty value text
	 *
	 * @param string $text Text to display when value is empty
	 *
	 * @return $this
	 */
	public function set_empty_value( string $text ): self {
		$this->options['empty_value'] = $text;

		// Rebuild the component if value is null
		if ( $this->value === null ) {
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
	 * Enable/disable colorizing
	 *
	 * @param bool $enable Whether to enable colorizing
	 *
	 * @return $this
	 */
	public function enable_colorize( bool $enable = true ): self {
		return $this->toggle_option( 'colorize', $enable );
	}

	/**
	 * Set colorize classes
	 *
	 * @param string $positive Class for positive values
	 * @param string $negative Class for negative values
	 * @param string $neutral  Class for zero values
	 *
	 * @return $this
	 */
	public function set_color_classes( string $positive, string $negative, string $neutral ): self {
		$this->options['positive_class'] = $positive;
		$this->options['negative_class'] = $negative;
		$this->options['neutral_class']  = $neutral;

		// Rebuild the component if colorizing is enabled
		if ( $this->options['colorize'] ) {
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Show/hide plus sign for positive values
	 *
	 * @param bool $show Whether to show plus sign
	 *
	 * @return $this
	 */
	public function show_sign( bool $show = true ): self {
		return $this->toggle_option( 'show_sign', $show );
	}

	/**
	 * Enable/disable short format (K, M, B)
	 *
	 * @param bool $enable Whether to enable short format
	 *
	 * @return $this
	 */
	public function enable_short_format( bool $enable = true ): self {
		return $this->toggle_option( 'short_format', $enable );
	}

	/**
	 * Get the numeric value
	 *
	 * @return float|int|null
	 */
	public function get_value() {
		return $this->value;
	}
}