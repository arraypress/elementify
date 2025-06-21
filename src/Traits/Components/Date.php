<?php
/**
 * Elementify Library - Date Components Trait
 *
 * A collection of methods for creating date-related HTML components.
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

use Elementify\Components\Display\TimeAgo;

/**
 * Date Components Trait
 *
 * Provides methods for creating and rendering date-related HTML components.
 */
trait Date {

	/**
	 * Create a time ago component
	 *
	 * @param mixed $time        Timestamp, date string, or DateTime object
	 * @param array $options     Additional options
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS
	 *
	 * @return TimeAgo
	 */
	public static function timeago( $time, array $options = [], array $attributes = [], bool $include_css = true ): TimeAgo {
		return new TimeAgo( $time, $options, $attributes, $include_css );
	}

}