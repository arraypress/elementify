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

use Elementify\Components\Layout\Card;

/**
 * Layout Components Trait
 *
 * Provides methods for creating and rendering layout-related HTML components
 * such as cards.
 */
trait Layout {

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

}