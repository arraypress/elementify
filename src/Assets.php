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
	 * Map of component names to their asset file names
	 *
	 * @var array
	 */
	protected static array $component_map = [
		'accordion'    => 'accordion',
		'breadcrumbs'  => 'breadcrumbs',
		'card'         => 'card',
		'modal'        => 'modal',
		'notice'       => 'notice',
		'pagination'   => 'pagination',
		'progress-bar' => 'progress-bar',
		'status-badge' => 'status-badge',
		'tabs'         => 'tabs',
		'social-links' => 'social-links',
		'tooltip'      => 'tooltip',
		'datepicker'   => 'date-picker',
		'range'        => 'range',
		'toggle'       => 'toggle',
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
		'datepicker',
		'range'
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
		if ( ! function_exists( 'wp_register_style' ) ) {
			return;
		}

		// Determine which components to load
		$components_to_load = [];

		if ( $components === 'all' ) {
			$components_to_load = array_keys( self::$component_map );
		} elseif ( is_array( $components ) ) {
			$components_to_load = array_intersect( $components, array_keys( self::$component_map ) );
		} elseif ( is_string( $components ) && isset( self::$component_map[ $components ] ) ) {
			$components_to_load = [ $components ];
		}

		$base_url = self::get_assets_url();
		$base_dir = self::get_assets_dir();

		// Enqueue assets for each component
		foreach ( $components_to_load as $component ) {
			// Skip if already enqueued
			if ( in_array( $component, self::$enqueued ) ) {
				continue;
			}

			$file = self::$component_map[ $component ] ?? $component;

			// Handle CSS
			$css_file = 'css/' . $file . '.css';
			$css_path = $base_dir . '/' . $css_file;

			if ( file_exists( $css_path ) ) {
				wp_enqueue_style(
					'elementify-' . $component,
					$base_url . '/' . $css_file,
					[],
					filemtime( $css_path )
				);
			}

			// Handle JS if component has it
			if ( in_array( $component, self::$js_components ) ) {
				$js_file = 'js/' . $file . '.js';
				$js_path = $base_dir . '/' . $js_file;

				if ( file_exists( $js_path ) ) {
					wp_enqueue_script(
						'elementify-' . $component,
						$base_url . '/' . $js_file,
						[],
						filemtime( $js_path ),
						true
					);
				}
			}

			// Mark as enqueued
			self::$enqueued[] = $component;
		}
	}

	/**
	 * Get the URL to the assets directory
	 *
	 * @return string
	 */
	private static function get_assets_url(): string {
		$dir = dirname( __FILE__, 2 ); // Get the parent directory of the src folder

		// For Composer installations
		if ( defined( 'WP_PLUGIN_URL' ) && strpos( $dir, WP_PLUGIN_DIR ) !== false ) {
			$relative_path = str_replace( WP_PLUGIN_DIR, '', $dir );

			return WP_PLUGIN_URL . $relative_path . '/assets';
		}

		// Fallback for direct plugin installation
		if ( defined( 'WP_PLUGIN_URL' ) && function_exists( 'plugin_basename' ) ) {
			$plugin_name = basename( $dir );

			return WP_PLUGIN_URL . '/' . $plugin_name . '/assets';
		}

		// Final fallback
		return plugins_url( 'assets', $dir );
	}

	/**
	 * Get the directory path to the assets
	 *
	 * @return string
	 */
	private static function get_assets_dir(): string {
		return dirname( __FILE__, 2 ) . '/assets';
	}

	/**
	 * Check if debug mode is active for asset loading
	 *
	 * @return bool Whether debug mode is active
	 */
	public static function is_debug_enabled(): bool {
		return defined( 'ELEMENTIFY_DEBUG' ) && ELEMENTIFY_DEBUG;
	}

}