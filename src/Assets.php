<?php
/**
 * Elementify Library - Assets Manager
 *
 * Handles loading CSS and JavaScript files for Elementify components.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Assets Manager
 *
 * Handles loading CSS and JavaScript files for Elementify components.
 */
class Assets {

	/**
	 * Available components
	 *
	 * @var array
	 */
	protected static array $components = [
		'accordion',
		'breadcrumbs',
		'card',
		'modal',
		'notice',
		'pagination',
		'progress-bar',
		'status-badge',
		'tabs',
		'social-links',
		'tooltip',
		'date-picker',
		'range',
		'toggle',
		'number',
		'rating',
		'time-ago',
		'taxonomy',
		'user',
		'clipboard',
		'featured',
	];

	/**
	 * Components that require JavaScript
	 *
	 * @var array
	 */
	protected static array $js_components = [
		'accordion',
		'modal',
		'notice',
		'tabs',
		'tooltip',
		'date-picker',
		'range',
		'clipboard',
	];

	/**
	 * Enqueued components
	 *
	 * @var array
	 */
	protected static array $enqueued = [];

	/**
	 * Enqueue assets for specific components
	 *
	 * @param string|array $components Component(s) to load assets for, or 'all' for all components
	 *
	 * @return void
	 */
	public static function enqueue( $components = 'all' ) {
		// Check if we have WordPress functions available
		if ( ! function_exists( 'wp_enqueue_style_from_composer_file' ) ) {
			return;
		}

		// Determine which components to load
		$components_to_load = self::resolve_components( $components );

		// Enqueue assets for each component
		foreach ( $components_to_load as $component ) {
			// Skip if already enqueued
			if ( in_array( $component, self::$enqueued ) ) {
				continue;
			}

			// Handle CSS
			$css_file = 'css/' . $component . '.css';
			wp_enqueue_style_from_composer_file(
				'elementify-' . $component,
				__FILE__,
				$css_file
			);

			// Handle JS if component has it
			if ( in_array( $component, self::$js_components ) ) {
				$js_file = 'js/' . $component . '.js';
				wp_enqueue_script_from_composer_file(
					'elementify-' . $component,
					__FILE__,
					$js_file
				);
			}

			// Mark as enqueued
			self::$enqueued[] = $component;
		}
	}

	/**
	 * Resolve which components to load based on input
	 *
	 * @param string|array $components Component(s) to load assets for, or 'all' for all components
	 *
	 * @return array Array of valid component names to load
	 */
	private static function resolve_components( $components ): array {
		if ( $components === 'all' ) {
			return self::$components;
		}

		if ( is_array( $components ) ) {
			return array_intersect( $components, self::$components );
		}

		if ( is_string( $components ) && in_array( $components, self::$components ) ) {
			return [ $components ];
		}

		return [];
	}

}