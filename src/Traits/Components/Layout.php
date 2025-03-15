<?php
/**
 * Elementify Library - Layout Components Trait
 *
 * A collection of methods for creating layout-related HTML components.
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

use Elementify\Components\Accordion;
use Elementify\Components\Card;
use Elementify\Components\Modal;

/**
 * Layout Components Trait
 *
 * Provides methods for creating and rendering layout-related HTML components
 * such as cards, modals, and accordions.
 */
trait Layout {

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
	 * Create a card component with image support and reordered parameters
	 *
	 * @param string $title       Card title
	 * @param mixed  $content     Card content
	 * @param string $image_src   Optional image source URL
	 * @param mixed  $footer      Optional footer content
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 * @param string $variant     Card style variant (default, compact, borderless, no-padding)
	 *
	 * @return Card
	 */
	public static function card_advanced( string $title, $content, string $image_src = '', $footer = '', array $attributes = [], bool $include_css = true, string $variant = 'default' ): Card {
		// Create the card using the standard card method
		$card = self::card( $content, $title, $footer, $attributes, $include_css, $variant );

		// Add image if provided
		if ( ! empty( $image_src ) ) {
			$card->set_image( $image_src, $title );
		}

		return $card;
	}

	/**
	 * Create and render a card component with image support and reordered parameters
	 *
	 * @param string $title       Card title
	 * @param mixed  $content     Card content
	 * @param string $image_src   Optional image source URL
	 * @param mixed  $footer      Optional footer content
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (default: true)
	 * @param string $variant     Card style variant (default, compact, borderless, no-padding)
	 *
	 * @return void
	 */
	public static function card_advanced_render( string $title, $content, string $image_src = '', $footer = '', array $attributes = [], bool $include_css = true, string $variant = 'default' ): void {
		self::card_advanced( $title, $content, $image_src, $footer, $attributes, $include_css, $variant )->output();
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
	 * Create, trigger, and render a modal component in one step
	 *
	 * @param string $title         Modal title
	 * @param mixed  $content       Modal content
	 * @param array  $buttons       Modal buttons
	 * @param string $trigger_text  Text for the trigger button
	 * @param array  $trigger_attrs Attributes for the trigger button
	 * @param array  $modal_attrs   Attributes for the modal element
	 * @param bool   $include_css   Whether to include built-in CSS (default: true)
	 *
	 * @return void
	 */
	public static function modal_with_trigger(
		string $title,
		$content = null,
		array $buttons = [],
		string $trigger_text = 'Open Modal',
		array $trigger_attrs = [ 'class' => 'button button-primary' ],
		array $modal_attrs = [],
		bool $include_css = true
	): void {
		$modal = self::modal( $title, $content, $buttons, $modal_attrs, $include_css );

		// Output the trigger button
		echo $modal->create_trigger( $trigger_text, $trigger_attrs )->render();

		// Output the modal itself
		echo $modal->render();
	}

}