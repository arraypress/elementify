<?php
/**
 * Elementify Library - Notice Components Trait
 *
 * A collection of methods for creating notification and message HTML components.
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

use Elementify\Components\Notification\Notice;

/**
 * Messaging Components Trait
 *
 * Provides methods for creating and rendering notification and message HTML components
 * such as info, success, warning, and error notices.
 */
trait Messaging {

	/**
	 * Create a notice component
	 *
	 * @param mixed  $content     Notice content
	 * @param string $type        Notice type (info, success, warning, error)
	 * @param bool   $dismissible Whether the notice can be dismissed
	 * @param array  $attributes  Element attributes
	 *
	 * @return Notice
	 */
	public static function notice( $content = null, string $type = 'info', bool $dismissible = false, array $attributes = [] ): Notice {
		return new Notice( $content, $type, $dismissible, $attributes );
	}

	/**
	 * Create an info notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 *
	 * @return Notice
	 */
	public static function info_notice( $content, bool $dismissible = false, array $attributes = [] ): Notice {
		return Notice::info( $content, $dismissible, $attributes );
	}

	/**
	 * Create a success notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 *
	 * @return Notice
	 */
	public static function success_notice( $content, bool $dismissible = false, array $attributes = [] ): Notice {
		return Notice::success( $content, $dismissible, $attributes );
	}

	/**
	 * Create a warning notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 *
	 * @return Notice
	 */
	public static function warning_notice( $content, bool $dismissible = false, array $attributes = [] ): Notice {
		return Notice::warning( $content, $dismissible, $attributes );
	}

	/**
	 * Create an error notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 *
	 * @return Notice
	 */
	public static function error_notice( $content, bool $dismissible = false, array $attributes = [] ): Notice {
		return Notice::error( $content, $dismissible, $attributes );
	}

}