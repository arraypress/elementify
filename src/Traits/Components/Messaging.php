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
	 * @param bool   $include_css Whether to include built-in CSS (only for non-admin contexts)
	 *
	 * @return Notice
	 */
	public static function notice( $content = null, string $type = 'info', bool $dismissible = false, array $attributes = [], bool $include_css = true ): Notice {
		return new Notice( $content, $type, $dismissible, $attributes, $include_css );
	}

	/**
	 * Create and render a notice component
	 *
	 * @param mixed  $content     Notice content
	 * @param string $type        Notice type (info, success, warning, error)
	 * @param bool   $dismissible Whether the notice can be dismissed
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (only for non-admin contexts)
	 *
	 * @return void
	 */
	public static function notice_render( $content = null, string $type = 'info', bool $dismissible = false, array $attributes = [], bool $include_css = true ): void {
		self::notice( $content, $type, $dismissible, $attributes, $include_css )->output();
	}

	/**
	 * Create an info notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (only for non-admin contexts)
	 *
	 * @return Notice
	 */
	public static function info_notice( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): Notice {
		return Notice::info( $content, $dismissible, $attributes, $include_css );
	}

	/**
	 * Create and render an info notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (only for non-admin contexts)
	 *
	 * @return void
	 */
	public static function info_notice_render( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): void {
		self::info_notice( $content, $dismissible, $attributes, $include_css )->output();
	}

	/**
	 * Create a success notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (only for non-admin contexts)
	 *
	 * @return Notice
	 */
	public static function success_notice( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): Notice {
		return Notice::success( $content, $dismissible, $attributes, $include_css );
	}

	/**
	 * Create and render a success notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (only for non-admin contexts)
	 *
	 * @return void
	 */
	public static function success_notice_render( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): void {
		self::success_notice( $content, $dismissible, $attributes, $include_css )->output();
	}

	/**
	 * Create a warning notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (only for non-admin contexts)
	 *
	 * @return Notice
	 */
	public static function warning_notice( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): Notice {
		return Notice::warning( $content, $dismissible, $attributes, $include_css );
	}

	/**
	 * Create and render a warning notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (only for non-admin contexts)
	 *
	 * @return void
	 */
	public static function warning_notice_render( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): void {
		self::warning_notice( $content, $dismissible, $attributes, $include_css )->output();
	}

	/**
	 * Create an error notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (only for non-admin contexts)
	 *
	 * @return Notice
	 */
	public static function error_notice( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): Notice {
		return Notice::error( $content, $dismissible, $attributes, $include_css );
	}

	/**
	 * Create and render an error notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (only for non-admin contexts)
	 *
	 * @return void
	 */
	public static function error_notice_render( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): void {
		self::error_notice( $content, $dismissible, $attributes, $include_css )->output();
	}

}