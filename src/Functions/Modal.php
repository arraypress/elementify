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
use Elementify\Components\Modal;

if ( ! function_exists( 'el_modal' ) ) {
	/**
	 * Create a modal component.
	 *
	 * @param string $title       Modal title.
	 * @param mixed  $content     Modal content.
	 * @param array  $buttons     Modal buttons.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 *
	 * @return Modal
	 */
	function el_modal( string $title = '', $content = null, array $buttons = [], array $attributes = [], bool $include_css = true ): Modal {
		return Create::modal( $title, $content, $buttons, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_modal_render' ) ) {
	/**
	 * Create and render a modal component.
	 *
	 * @param string $title       Modal title.
	 * @param mixed  $content     Modal content.
	 * @param array  $buttons     Modal buttons.
	 * @param array  $attributes  Element attributes.
	 * @param bool   $include_css Whether to include built-in CSS.
	 */
	function el_modal_render( string $title = '', $content = null, array $buttons = [], array $attributes = [], bool $include_css = true ): void {
		Create::modal_render( $title, $content, $buttons, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_modal_with_trigger' ) ) {
	/**
	 * Create, trigger, and render a modal component in one step.
	 *
	 * @param string $title         Modal title.
	 * @param mixed  $content       Modal content.
	 * @param array  $buttons       Modal buttons.
	 * @param string $trigger_text  Text for the trigger button.
	 * @param array  $trigger_attrs Attributes for the trigger button.
	 * @param array  $modal_attrs   Attributes for the modal element.
	 * @param bool   $include_css   Whether to include built-in CSS.
	 */
	function el_modal_with_trigger(
		string $title,
		$content = null,
		array $buttons = [],
		string $trigger_text = 'Open Modal',
		array $trigger_attrs = [ 'class' => 'button button-primary' ],
		array $modal_attrs = [],
		bool $include_css = true
	): void {
		$modal = el_modal( $title, $content, $buttons, $modal_attrs, $include_css );

		// Output the trigger button
		echo $modal->create_trigger( $trigger_text, $trigger_attrs )->render();

		// Output the modal itself
		echo $modal->render();
	}
}