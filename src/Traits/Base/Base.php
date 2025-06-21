<?php
/**
 * Elementify Library - Basic Elements Trait
 *
 * A collection of methods for creating basic HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits\Base;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Element;

/**
 * Basic Elements Trait
 *
 * Provides methods for creating basic HTML elements like divs, spans, paragraphs, etc.
 */
trait Base {

	/**
	 * Create a generic element
	 *
	 * @param string $tag        HTML tag
	 * @param mixed  $content    Element content
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function element( string $tag, $content = null, array $attributes = [] ): Element {
		return new Element( $tag, $content, $attributes );
	}

}