<?php
/**
 * Elementify Library - Card Builder
 *
 * Provides a fluent interface for building card components.
 *
 * @package     ArrayPress\Elementify\Builders
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Builders;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Components\Layout\Card;

/**
 * Card Builder Class
 *
 * Extends the Card component to provide fluent methods for building cards
 * with headers, bodies, footers, and various styling options.
 */
class CardBuilder extends Card {

	/**
	 * Set the card title/header
	 *
	 * @param mixed $title Header content (string or Element)
	 *
	 * @return $this For method chaining
	 */
	public function title( $title ): self {
		$this->set_header( $title );

		return $this;
	}

	/**
	 * Set the card header (alias for title)
	 *
	 * @param mixed $header Header content (string or Element)
	 *
	 * @return $this For method chaining
	 */
	public function header( $header ): self {
		return $this->title( $header );
	}

	/**
	 * Set the card body content
	 *
	 * @param mixed $content Body content (string, Element, or array)
	 *
	 * @return $this For method chaining
	 */
	public function content( $content ): self {
		$this->set_body( $content );

		return $this;
	}

	/**
	 * Set the card body content (alias for content)
	 *
	 * @param mixed $body Body content (string, Element, or array)
	 *
	 * @return $this For method chaining
	 */
	public function body( $body ): self {
		return $this->content( $body );
	}

	/**
	 * Set the card footer
	 *
	 * @param mixed $footer Footer content (string or Element)
	 *
	 * @return $this For method chaining
	 */
	public function footer( $footer ): self {
		$this->set_footer( $footer );

		return $this;
	}

	/**
	 * Add an image to the top of the card
	 *
	 * @param string $src        Image source URL
	 * @param string $alt        Alt text for the image
	 * @param array  $attributes Additional image attributes
	 *
	 * @return $this For method chaining
	 */
	public function image( string $src, string $alt = '', array $attributes = [] ): self {
		$this->set_image( $src, $alt, $attributes );

		return $this;
	}

	/**
	 * Set the card style variant
	 *
	 * @param string $variant Style variant (default, compact, borderless, no-padding)
	 *
	 * @return $this For method chaining
	 */
	public function variant( string $variant ): self {
		$this->set_variant( $variant );

		return $this;
	}

	/**
	 * Make the card compact
	 *
	 * @return $this For method chaining
	 */
	public function compact(): self {
		return $this->variant( 'compact' );
	}

	/**
	 * Make the card borderless
	 *
	 * @return $this For method chaining
	 */
	public function borderless(): self {
		return $this->variant( 'borderless' );
	}

	/**
	 * Remove padding from the card
	 *
	 * @return $this For method chaining
	 */
	public function no_padding(): self {
		return $this->variant( 'no-padding' );
	}

}