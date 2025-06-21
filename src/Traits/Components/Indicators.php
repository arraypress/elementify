<?php
/**
 * Elementify Library - Indicators Components Trait
 *
 * A collection of methods for creating visual indicator HTML components.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits\Components;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Components\Display\BooleanIcon;
use Elementify\Components\Display\ProgressBar;
use Elementify\Components\Display\Rating;
use Elementify\Components\Display\StatusBadge;

/**
 * Indicators Components Trait
 *
 * Provides methods for creating and rendering visual indicator components
 * such as progress bars, ratings, status badges and boolean icons.
 */
trait Indicators {

	/**
	 * Create a progress bar component
	 *
	 * @param int|float $current     Current value
	 * @param int|float $total       Total value (maximum)
	 * @param array     $options     Additional options
	 * @param array     $attributes  Element attributes
	 * @param bool      $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return ProgressBar
	 */
	public static function progress_bar( $current, $total = 100, array $options = [], array $attributes = [], bool $include_css = true ): ProgressBar {
		return new ProgressBar( $current, $total, $options, $attributes, $include_css );
	}

	/**
	 * Create a rating component
	 *
	 * @param float $rating      Rating value
	 * @param array $options     Additional options
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS
	 *
	 * @return Rating
	 */
	public static function rating( float $rating, array $options = [], array $attributes = [], bool $include_css = true ): Rating {
		return new Rating( $rating, $options, $attributes, $include_css );
	}

	/**
	 * Create a status badge component
	 *
	 * @param string $label       Badge label text
	 * @param string $status      Status type (success, warning, error, info, etc.)
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return StatusBadge
	 */
	public static function badge( string $label, string $status = 'default', array $options = [], array $attributes = [], bool $include_css = true ): StatusBadge {
		// If label is empty, use capitalized status as label
		if ( empty( $label ) ) {
			$label = ucfirst( str_replace( [ '_', '-' ], ' ', $status ) );
		}

		return new StatusBadge( $label, $status, $options, $attributes, $include_css );
	}

	/**
	 * Create a boolean icon component
	 *
	 * @param mixed $value       Value to check
	 * @param array $options     Component options
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS
	 *
	 * @return BooleanIcon
	 */
	public static function boolean_icon( $value, array $options = [], array $attributes = [], bool $include_css = true ): BooleanIcon {
		return new BooleanIcon( $value, $options, $attributes, $include_css );
	}

}