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
 * FileSize Component
 *
 * Creates a component for displaying human-readable file sizes.
 */
class FileSize extends Component {
	use Parts;

	/**
	 * FileSize options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * File size in bytes
	 *
	 * @var int
	 */
	protected int $bytes;

	/**
	 * Constructor
	 *
	 * @param int|string $bytes       File size in bytes
	 * @param array      $options     Additional options
	 * @param array      $attributes  Element attributes
	 * @param bool       $include_css Whether to include built-in CSS
	 */
	public function __construct( $bytes, array $options = [], array $attributes = [], bool $include_css = true ) {
		// Convert to integer
		$this->bytes = is_numeric( $bytes ) ? (int) $bytes : 0;

		// Merge default options
		$this->options = array_merge( [
			'decimals'    => 2,              // Decimal precision
			'binary'      => true,           // Use binary (base 1024) or decimal (base 1000)
			'format'      => '%s',           // Format string for the output
			'tooltip'     => '',             // Optional tooltip text
			'tooltip_raw' => false,          // Show raw bytes in tooltip
			'raw_format'  => '%s bytes',     // Format for raw bytes in tooltip
		], $options );

		// Set base class
		$this->base_class = 'filesize';

		// Initialize component foundation
		$this->init_component( 'filesize', $attributes, $include_css );

		// Initialize with a span element
		parent::__construct( 'span', null, $attributes );

		// Add tooltip if provided or using raw bytes
		if ( ! empty( $this->options['tooltip'] ) ) {
			$this->add_tooltip( $this->options['tooltip'] );
		} else if ( $this->options['tooltip_raw'] ) {
			$raw_bytes = sprintf( $this->options['raw_format'], number_format_i18n( $this->bytes ) );
			$this->add_tooltip( $raw_bytes );
		}

		// Build the filesize component
		$this->build();
	}

	/**
	 * Build the filesize component structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Format the filesize
		$formatted_size = $this->format_filesize();

		// Apply format
		$display_text = sprintf( $this->options['format'], $formatted_size );

		// Create the element
		$content = Create::span( $display_text );

		// Add content to component
		$this->add_child( $content );
	}

	/**
	 * Format filesize into human-readable string
	 *
	 * @return string Formatted filesize
	 */
	protected function format_filesize(): string {
		// Use WordPress function if available
		if ( function_exists( 'size_format' ) ) {
			return size_format( $this->bytes, $this->options['decimals'] );
		}

		// Fallback to custom implementation
		$units = $this->options['binary']
			? [ 'B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB' ]
			: [ 'B', 'KB', 'MB', 'GB', 'TB', 'PB' ];

		$bytes = max( $this->bytes, 0 );
		$base  = $this->options['binary'] ? 1024 : 1000;
		$i     = $bytes ? floor( log( $bytes, $base ) ) : 0;
		$i     = min( $i, count( $units ) - 1 );

		$result = $bytes / pow( $base, $i );

		return number_format_i18n( $result, $this->options['decimals'] ) . ' ' . $units[ $i ];
	}

	/**
	 * Set the file size in bytes
	 *
	 * @param int $bytes File size in bytes
	 *
	 * @return $this
	 */
	public function set_bytes( int $bytes ): self {
		$this->bytes = max( 0, $bytes );

		// Update tooltip if showing raw bytes
		if ( $this->options['tooltip_raw'] ) {
			$raw_bytes = sprintf( $this->options['raw_format'], number_format_i18n( $this->bytes ) );
			$this->add_tooltip( $raw_bytes );
		}

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
	 * Set whether to use binary (base 1024) or decimal (base 1000)
	 *
	 * @param bool $binary Use binary (true) or decimal (false)
	 *
	 * @return $this
	 */
	public function use_binary( bool $binary = true ): self {
		return $this->toggle_option( 'binary', $binary );
	}

	/**
	 * Set output format
	 *
	 * @param string $format Format string (use %s for formatted size)
	 *
	 * @return $this
	 */
	public function set_format( string $format ): self {
		$this->options['format'] = $format;
		$this->mark_for_rebuild();

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
	 * Show/hide raw bytes in tooltip
	 *
	 * @param bool $show Whether to show raw bytes
	 *
	 * @return $this
	 */
	public function show_raw_tooltip( bool $show = true ): self {
		$this->options['tooltip_raw'] = $show;

		if ( $show && empty( $this->options['tooltip'] ) ) {
			$raw_bytes = sprintf( $this->options['raw_format'], number_format_i18n( $this->bytes ) );
			$this->add_tooltip( $raw_bytes );
		}

		return $this;
	}

	/**
	 * Set raw bytes format
	 *
	 * @param string $format Format for raw bytes (use %s for bytes)
	 *
	 * @return $this
	 */
	public function set_raw_format( string $format ): self {
		$this->options['raw_format'] = $format;

		// Update tooltip if showing raw bytes
		if ( $this->options['tooltip_raw'] ) {
			$raw_bytes = sprintf( $format, number_format_i18n( $this->bytes ) );
			$this->add_tooltip( $raw_bytes );
		}

		return $this;
	}

	/**
	 * Get the file size in bytes
	 *
	 * @return int
	 */
	public function get_bytes(): int {
		return $this->bytes;
	}

}