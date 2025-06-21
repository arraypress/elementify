<?php
/**
 * Elementify Library - Input Components Trait
 *
 * A collection of methods for creating form input HTML components.
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

use Elementify\Components\Interactive\Featured;
use Elementify\Components\Interactive\Toggle;

/**
 * Input Components Trait
 *
 * Provides methods for creating and rendering HTML form input components
 * such as toggles and other interactive input elements.
 */
trait Input {

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
	 * Create a featured star component
	 *
	 * @param string      $name        Featured input name
	 * @param bool        $featured    Whether the item is featured
	 * @param string|null $label       Optional label text
	 * @param array       $attributes  Element attributes
	 * @param bool        $disabled    Whether the control is disabled
	 * @param bool        $include_css Whether to include built-in CSS
	 *
	 * @return Featured
	 */
	public static function featured(
		string $name,
		bool $featured = false,
		?string $label = null,
		array $attributes = [],
		bool $disabled = false,
		bool $include_css = true
	): Featured {
		return new Featured( $name, $featured, $label, $attributes, $disabled, $include_css );
	}

}