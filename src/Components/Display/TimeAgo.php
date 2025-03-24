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
 * TimeAgo Component
 *
 * Creates a human-readable relative time display.
 */
class TimeAgo extends Component {
	use Parts;

	/**
	 * TimeAgo options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Timestamp
	 *
	 * @var int
	 */
	protected int $timestamp;

	/**
	 * Constructor
	 *
	 * @param mixed $time        Timestamp, date string, or DateTime object
	 * @param array $options     Additional options
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS
	 */
	public function __construct( $time, array $options = [], array $attributes = [], bool $include_css = true ) {
		// Convert time to timestamp
		$this->timestamp = $this->get_timestamp( $time );

		// Merge default options
		$this->options = array_merge( [
			'show_tooltip'   => true,                   // Show exact date/time as tooltip
			'tooltip_format' => '',                     // Date format for tooltip (empty = use WP defaults)
			'future_format'  => __( 'in %s' ),     // Format for future dates
			'past_format'    => __( '%s ago' ),    // Format for past dates
			'threshold'      => 0,                      // Threshold in seconds (0 = always relative)
			'cutoff'         => 0,                      // Cutoff in seconds (0 = no cutoff)
		], $options );

		// Set base class
		$this->base_class = 'timeago';

		// Initialize component foundation
		$this->init_component( 'timeago', $attributes, $include_css );

		// Initialize with a span element
		parent::__construct( 'span', null, $attributes );

		// Build the time ago component
		$this->build();
	}

	/**
	 * Build the time ago structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Get current time for comparison
		$current_time = current_time( 'timestamp' );

		// Determine if this is a future or past time
		$is_future = $this->timestamp > $current_time;

		// Calculate the difference in seconds
		$diff = abs( $this->timestamp - $current_time );

		// Check if we should show an absolute date instead of relative time based on threshold
		if ( $this->options['threshold'] > 0 && $diff > $this->options['threshold'] ) {
			// Use absolute date instead of relative time
			$content = $this->get_formatted_date();
		} // Check if we should show an absolute date instead of relative time based on cutoff
		else if ( $this->options['cutoff'] > 0 && $diff > $this->options['cutoff'] ) {
			// Use absolute date instead of relative time
			$content = $this->get_formatted_date();
		} else {
			// Get human-readable time difference
			$human_time = human_time_diff( $this->timestamp, $current_time );

			// Format based on whether it's future or past
			$format  = $is_future ? $this->options['future_format'] : $this->options['past_format'];
			$content = sprintf( $format, $human_time );
		}

		// Set content
		if ( $this->options['show_tooltip'] ) {
			// Add tooltip with exact date/time
			$tooltip_text = $this->get_formatted_date( $this->options['tooltip_format'] );

			// Create element with tooltip
			$this->set_attribute( 'title', $tooltip_text );
			$this->set_content( $content );
		} else {
			// Simple content without tooltip
			$this->set_content( $content );
		}
	}

	/**
	 * Get timestamp from various input formats
	 *
	 * @param mixed $time Timestamp, date string, or DateTime object
	 *
	 * @return int Unix timestamp
	 */
	protected function get_timestamp( $time ): int {
		// If it's already a timestamp
		if ( is_numeric( $time ) ) {
			return (int) $time;
		}

		// If it's a DateTime object
		if ( $time instanceof \DateTime ) {
			return $time->getTimestamp();
		}

		// If it's a string, parse it
		if ( is_string( $time ) ) {
			$timestamp = strtotime( $time );
			if ( $timestamp !== false ) {
				return $timestamp;
			}
		}

		// Default to current time if parsing fails
		return current_time( 'timestamp' );
	}

	/**
	 * Get formatted date
	 *
	 * @param string $format Date format (empty = use WP defaults)
	 *
	 * @return string Formatted date
	 */
	protected function get_formatted_date( string $format = '' ): string {
		if ( empty( $format ) ) {
			$date_format = get_option( 'date_format' );
			$time_format = get_option( 'time_format' );
			$format      = $date_format . ' ' . $time_format;
		}

		return date_i18n( $format, $this->timestamp );
	}

	/**
	 * Set threshold in seconds
	 *
	 * If the time difference is greater than this threshold,
	 * an absolute date will be shown instead of relative time.
	 *
	 * @param int $seconds Threshold in seconds (0 = always show relative time)
	 *
	 * @return $this
	 */
	public function set_threshold( int $seconds ): self {
		$this->options['threshold'] = max( 0, $seconds );

		// Rebuild the component
		$this->build();

		return $this;
	}

	/**
	 * Set cutoff in seconds
	 *
	 * If the time difference is greater than this cutoff,
	 * an absolute date will be shown instead of relative time.
	 *
	 * @param int $seconds Cutoff in seconds (0 = no cutoff)
	 *
	 * @return $this
	 */
	public function set_cutoff( int $seconds ): self {
		$this->options['cutoff'] = max( 0, $seconds );

		// Rebuild the component
		$this->build();

		return $this;
	}

	/**
	 * Show/hide tooltip
	 *
	 * @param bool $show Whether to show tooltip
	 *
	 * @return $this
	 */
	public function show_tooltip( bool $show = true ): self {
		$this->options['show_tooltip'] = $show;

		// Rebuild the component
		$this->build();

		return $this;
	}

	/**
	 * Set tooltip date format
	 *
	 * @param string $format Date format
	 *
	 * @return $this
	 */
	public function set_tooltip_format( string $format ): self {
		$this->options['tooltip_format'] = $format;

		// Rebuild the component if tooltip is enabled
		if ( $this->options['show_tooltip'] ) {
			$this->build();
		}

		return $this;
	}

	/**
	 * Set future format
	 *
	 * @param string $format Format for future dates
	 *
	 * @return $this
	 */
	public function set_future_format( string $format ): self {
		$this->options['future_format'] = $format;

		// Rebuild the component
		$this->build();

		return $this;
	}

	/**
	 * Set past format
	 *
	 * @param string $format Format for past dates
	 *
	 * @return $this
	 */
	public function set_past_format( string $format ): self {
		$this->options['past_format'] = $format;

		// Rebuild the component
		$this->build();

		return $this;
	}

	/**
	 * Update time
	 *
	 * @param mixed $time New timestamp, date string, or DateTime object
	 *
	 * @return $this
	 */
	public function update_time( $time ): self {
		$this->timestamp = $this->get_timestamp( $time );

		// Rebuild the component
		$this->build();

		return $this;
	}

}