<?php
/**
 * Elementify Library - Component Utility Functions
 *
 * Helper functions for creating component HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Create;
use Elementify\Components\Tabs;

if ( ! function_exists( 'el_tabs' ) ) {
	/**
	 * Create a tabs component.
	 *
	 * @param array  $tabs        Array of tabs with 'id', 'title', and 'content' keys.
	 * @param string $active_tab  Initially active tab ID.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 *
	 * @return Tabs
	 */
	function el_tabs( array $tabs = [], string $active_tab = '', array $attributes = [], bool $include_css = true ): Tabs {
		return Create::tabs( $tabs, $active_tab, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_tabs_render' ) ) {
	/**
	 * Create and render a tabs component.
	 *
	 * @param array  $tabs        Array of tabs with 'id', 'title', and 'content' keys.
	 * @param string $active_tab  Initially active tab ID.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 */
	function el_tabs_render( array $tabs = [], string $active_tab = '', array $attributes = [], bool $include_css = true ): void {
		Create::tabs_render( $tabs, $active_tab, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_tabs_flexible' ) ) {
	/**
	 * Create a tabbed interface component with flexible input format.
	 *
	 * @param array  $tabs        Array of tabs with ID as key and array with 'title' and 'content' as value.
	 * @param string $active_tab  ID of the tab that should be active by default.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 *
	 * @return Tabs
	 */
	function el_tabs_flexible( array $tabs, string $active_tab = '', array $attributes = [], bool $include_css = true ): Tabs {
		$tabs_array = [];

		// Transform our associative array format to the format expected by Create::tabs
		foreach ( $tabs as $id => $tab ) {
			if ( is_array( $tab ) && isset( $tab['title'] ) && isset( $tab['content'] ) ) {
				$tabs_array[] = [
					'id'      => $id,
					'title'   => $tab['title'],
					'content' => $tab['content']
				];
			}
		}

		// Default to first tab if no active tab specified
		if ( empty( $active_tab ) && ! empty( $tabs ) ) {
			reset( $tabs );
			$active_tab = key( $tabs );
		}

		return Create::tabs( $tabs_array, $active_tab, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_tabs_flexible_render' ) ) {
	/**
	 * Create and render a tabbed interface component with flexible input format.
	 *
	 * @param array  $tabs        Array of tabs with ID as key and array with 'title' and 'content' as value.
	 * @param string $active_tab  ID of the tab that should be active by default.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 */
	function el_tabs_flexible_render( array $tabs, string $active_tab = '', array $attributes = [], bool $include_css = true ): void {
		el_tabs_flexible( $tabs, $active_tab, $attributes, $include_css )->output();
	}
}

if ( ! function_exists( 'el_action_tabs' ) ) {
	/**
	 * Create tabs with common action buttons added to each tab.
	 *
	 * @param array  $tabs_content   Array of tabs with ID as key and array with 'title' and 'content' as value.
	 * @param array  $common_actions Array of action buttons to add to each tab.
	 *                               Each action should have 'text' and optionally 'class' and 'action' keys.
	 * @param string $active_tab     ID of the tab that should be active by default.
	 * @param array  $attributes     Element attributes.
	 * @param bool   $include_css    Whether to include built-in CSS.
	 *
	 * @return Tabs The tabs component with action buttons.
	 */
	function el_action_tabs( array $tabs_content, array $common_actions = [], string $active_tab = '', array $attributes = [], bool $include_css = true ): Tabs {
		$tabs = [];

		foreach ( $tabs_content as $id => $tab ) {
			$content = $tab['content'];

			// Add common actions to each tab if provided
			if ( ! empty( $common_actions ) ) {
				$actions_html = '<div class="tab-actions">';

				foreach ( $common_actions as $action ) {
					$actions_html .= el_button(
						$action['text'],
						'button',
						[
							'class'       => 'action-button ' . ( $action['class'] ?? '' ),
							'data-action' => $action['action'] ?? ''
						]
					)->render();
				}

				$actions_html .= '</div>';

				$content .= $actions_html;
			}

			$tabs[ $id ] = [
				'title'   => $tab['title'],
				'content' => $content
			];
		}

		return el_tabs_flexible( $tabs, $active_tab, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_action_tabs_render' ) ) {
	/**
	 * Create and render tabs with common action buttons added to each tab.
	 *
	 * @param array  $tabs_content   Array of tabs with ID as key and array with 'title' and 'content' as value.
	 * @param array  $common_actions Array of action buttons to add to each tab.
	 *                               Each action should have 'text' and optionally 'class' and 'action' keys.
	 * @param string $active_tab     ID of the tab that should be active by default.
	 * @param array  $attributes     Element attributes.
	 * @param bool   $include_css    Whether to include built-in CSS.
	 */
	function el_action_tabs_render( array $tabs_content, array $common_actions = [], string $active_tab = '', array $attributes = [], bool $include_css = true ): void {
		el_action_tabs( $tabs_content, $common_actions, $active_tab, $attributes, $include_css )->output();
	}
}