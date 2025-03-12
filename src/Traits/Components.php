<?php
/**
 * Elementify Library - Components Trait
 *
 * A collection of methods for creating complex component HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits;

use Elementify\Components\Accordion;
use Elementify\Components\Breadcrumbs;
use Elementify\Components\Card;
use Elementify\Components\DatePicker;
use Elementify\Components\Modal;
use Elementify\Components\Notice;
use Elementify\Components\ProgressBar;
use Elementify\Components\StatusBadge;
use Elementify\Components\Tabs;
use Elementify\Components\Tooltip;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Components Trait
 *
 * Provides methods for creating and rendering advanced component HTML elements.
 */
trait Components {

	/**
	 * Create a tabs component
	 *
	 * @param array  $tabs        Array of tabs with 'id', 'title', and 'content' keys
	 * @param string $active_tab  ID of the active tab
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Tabs
	 */
	public static function tabs( array $tabs = [], string $active_tab = '', array $attributes = [], bool $include_css = true ): Tabs {
		return new Tabs( $tabs, $active_tab, $attributes, $include_css );
	}

	/**
	 * Create and render a tabs component
	 *
	 * @param array  $tabs        Array of tabs with 'id', 'title', and 'content' keys
	 * @param string $active_tab  ID of the active tab
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function tabs_render( array $tabs = [], string $active_tab = '', array $attributes = [], bool $include_css = true ): void {
		self::tabs( $tabs, $active_tab, $attributes, $include_css )->output();
	}

	/**
	 * Create an accordion component
	 *
	 * @param array $sections       Array of sections with 'title', 'content', and optional 'active' keys
	 * @param bool  $allow_multiple Whether multiple sections can be open at once
	 * @param array $attributes     Element attributes
	 * @param bool  $include_css    Whether to include built-in CSS (default: true)
	 *
	 * @return Accordion
	 */
	public static function accordion( array $sections = [], bool $allow_multiple = false, array $attributes = [], bool $include_css = true ): Accordion {
		return new Accordion( $sections, $allow_multiple, $attributes, $include_css );
	}

	/**
	 * Create and render an accordion component
	 *
	 * @param array $sections       Array of sections with 'title', 'content', and optional 'active' keys
	 * @param bool  $allow_multiple Whether multiple sections can be open at once
	 * @param array $attributes     Element attributes
	 * @param bool  $include_css    Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function accordion_render( array $sections = [], bool $allow_multiple = false, array $attributes = [], bool $include_css = true ): void {
		self::accordion( $sections, $allow_multiple, $attributes, $include_css )->output();
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
	 * Create and render a progress bar component
	 *
	 * @param int|float $current     Current value
	 * @param int|float $total       Total value (maximum)
	 * @param array     $options     Additional options
	 * @param array     $attributes  Element attributes
	 * @param bool      $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function progress_bar_render( $current, $total = 100, array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::progress_bar( $current, $total, $options, $attributes, $include_css )->output();
	}

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
	 * Create a modal component
	 *
	 * @param string $title       Modal title
	 * @param mixed  $content     Modal content
	 * @param array  $buttons     Array of buttons for footer
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Modal
	 */
	public static function modal( string $title = '', $content = null, array $buttons = [], array $attributes = [], bool $include_css = true ): Modal {
		return new Modal( $title, $content, $buttons, $attributes, $include_css );
	}

	/**
	 * Create and render a modal component
	 *
	 * @param string $title       Modal title
	 * @param mixed  $content     Modal content
	 * @param array  $buttons     Array of buttons for footer
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function modal_render( string $title = '', $content = null, array $buttons = [], array $attributes = [], bool $include_css = true ): void {
		self::modal( $title, $content, $buttons, $attributes, $include_css )->output();
	}

	/**
	 * Create a card component
	 *
	 * @param mixed  $content     Card content (body content)
	 * @param string $title       Optional header title
	 * @param mixed  $footer      Optional footer content
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 * @param string $variant     Card style variant (default, compact, borderless, no-padding)
	 *
	 * @return Card
	 */
	public static function card( $content = null, string $title = '', $footer = null, array $attributes = [], bool $include_css = true, string $variant = 'no-padding' ): Card {
		return new Card( $content, $title, $footer, $attributes, $include_css, $variant );
	}

	/**
	 * Create and render a card component
	 *
	 * @param mixed  $content     Card content (body content)
	 * @param string $title       Optional header title
	 * @param mixed  $footer      Optional footer content
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 * @param string $variant     Card style variant (default, compact, borderless, no-padding)
	 *
	 * @return void
	 */
	public static function card_render( $content = null, string $title = '', $footer = null, array $attributes = [], bool $include_css = true, string $variant = 'no-padding' ): void {
		self::card( $content, $title, $footer, $attributes, $include_css, $variant )->output();
	}

	/**
	 * Create breadcrumbs component
	 *
	 * @param array  $items       Array of breadcrumb items
	 * @param string $separator   Separator between items
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return Breadcrumbs
	 */
	public static function breadcrumbs( array $items = [], string $separator = '/', array $attributes = [], bool $include_css = true ): Breadcrumbs {
		return new Breadcrumbs( $items, $separator, $attributes, $include_css );
	}

	/**
	 * Create and render breadcrumbs component
	 *
	 * @param array  $items       Array of breadcrumb items
	 * @param string $separator   Separator between items
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function breadcrumbs_render( array $items = [], string $separator = '/', array $attributes = [], bool $include_css = true ): void {
		self::breadcrumbs( $items, $separator, $attributes, $include_css )->output();
	}

	/**
	 * Create breadcrumbs from a URL path
	 *
	 * @param string $path     URL path
	 * @param string $base_url Base URL for links
	 * @param array  $options  Additional options including 'include_css' to enable/disable CSS
	 *
	 * @return Breadcrumbs
	 */
	public static function breadcrumbs_from_path( string $path, string $base_url = '', array $options = [] ): Breadcrumbs {
		return Breadcrumbs::from_path( $path, $base_url, $options );
	}

	/**
	 * Create and render breadcrumbs from a URL path
	 *
	 * @param string $path     URL path
	 * @param string $base_url Base URL for links
	 * @param array  $options  Additional options including 'include_css' to enable/disable CSS
	 *
	 * @return void
	 */
	public static function breadcrumbs_from_path_render( string $path, string $base_url = '', array $options = [] ): void {
		self::breadcrumbs_from_path( $path, $base_url, $options )->output();
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
	 * Create a date picker component
	 *
	 * @param string $name        Input name attribute
	 * @param string $value       Default date value (YYYY-MM-DD format)
	 * @param array  $options     DatePicker options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return DatePicker
	 */
	public static function datepicker( string $name = '', string $value = '', array $options = [], array $attributes = [], bool $include_css = true ): DatePicker {
		return new DatePicker( $name, $value, $options, $attributes, $include_css );
	}

	/**
	 * Create and render a date picker component
	 *
	 * @param string $name        Input name attribute
	 * @param string $value       Default date value (YYYY-MM-DD format)
	 * @param array  $options     DatePicker options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function datepicker_render( string $name = '', string $value = '', array $options = [], array $attributes = [], bool $include_css = true ): void {
		self::datepicker( $name, $value, $options, $attributes, $include_css )->output();
	}

}