<?php
/**
 * Elementify Library - Interactive Components Trait
 *
 * A collection of methods for creating interactive HTML components.
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

use Elementify\Components\ProgressBar;
use Elementify\Components\Toggle;

/**
 * Interactive Components Trait
 *
 * Provides methods for creating and rendering interactive HTML components
 * such as progress bars and toggles.
 */
trait Interactive {

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
	 * Create a toggle component
	 *
	 * @param string      $name        Toggle input name
	 * @param bool        $checked     Whether the toggle is checked
	 * @param string|int  $value       Value when checked
	 * @param string|null $label       Optional label text
	 * @param array       $attributes  Element attributes
	 * @param bool        $disabled    Whether the toggle is disabled
	 * @param bool        $include_css Whether to include built-in CSS
	 *
	 * @return Toggle
	 */
	public static function toggle(
		string $name,
		bool $checked = false,
		$value = '1',
		?string $label = null,
		array $attributes = [],
		bool $disabled = false,
		bool $include_css = true
	): Toggle {
		return new Toggle( $name, $checked, $value, $label, $attributes, $disabled, $include_css );
	}

	/**
	 * Create and render a toggle component
	 *
	 * @param string      $name        Toggle input name
	 * @param bool        $checked     Whether the toggle is checked
	 * @param string|int  $value       Value when checked
	 * @param string|null $label       Optional label text
	 * @param array       $attributes  Element attributes
	 * @param bool        $disabled    Whether the toggle is disabled
	 * @param bool        $include_css Whether to include built-in CSS
	 *
	 * @return void
	 */
	public static function toggle_render(
		string $name,
		bool $checked = false,
		$value = '1',
		?string $label = null,
		array $attributes = [],
		bool $disabled = false,
		bool $include_css = true
	): void {
		self::toggle( $name, $checked, $value, $label, $attributes, $disabled, $include_css )->output();
	}

}