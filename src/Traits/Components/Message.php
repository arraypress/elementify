<?php
/**
 * Elementify Library - Message Components Trait
 *
 * A collection of methods for creating message and notification-related HTML components.
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

use Elementify\Components\Notice;
use Elementify\Components\StatusBadge;
use Elementify\Components\Tooltip;

/**
 * Message Components Trait
 *
 * Provides methods for creating and rendering message and notification-related HTML components
 * such as notices, tooltips, and badges.
 */
trait Message {

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
	 * Create and render a status badge component
	 *
	 * @param string $label       Badge label text
	 * @param string $status      Status type (success, warning, error, info, etc.)
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function badge_render( string $label, string $status = 'default', array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::badge( $label, $status, $options, $attributes, $include_css )->output();
	}

	/**
	 * Create a tooltip component
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Options for the tooltip (position, trigger, etc.)
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Tooltip
	 */
	public static function tooltip( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): Tooltip {
		return new Tooltip( $target, $tooltip, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a tooltip component
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Options for the tooltip (position, trigger, etc.)
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function tooltip_render( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::tooltip( $target, $tooltip, $options, $attributes, $include_css )->output();
	}

	/**
	 * Create a tooltip triggered by click
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Tooltip
	 */
	public static function click_tooltip( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): Tooltip {
		$options['trigger'] = 'click';

		return self::tooltip( $target, $tooltip, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a tooltip triggered by click
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function click_tooltip_render( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::click_tooltip( $target, $tooltip, $options, $attributes, $include_css )->output();
	}

	/**
	 * Create a tooltip triggered by focus
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Tooltip
	 */
	public static function focus_tooltip( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): Tooltip {
		$options['trigger'] = 'focus';

		return self::tooltip( $target, $tooltip, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a tooltip triggered by focus
	 *
	 * @param mixed  $target      Target element or content
	 * @param string $tooltip     Tooltip content
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function focus_tooltip_render( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::focus_tooltip( $target, $tooltip, $options, $attributes, $include_css )->output();
	}
}