<?php
/**
 * Elementify Library
 *
 * A fluent interface for generating HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

namespace Elementify\Components;

use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Element;
use Elementify\Traits\Component\Parts;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Card Component
 *
 * Creates a card-style container with header, body, and footer sections.
 */
class Card extends Component {
	use Parts;

	/**
	 * Header element
	 *
	 * @var Element|null
	 */
	protected ?Element $header = null;

	/**
	 * Body element
	 *
	 * @var Element|null
	 */
	protected ?Element $body = null;

	/**
	 * Footer element
	 *
	 * @var Element|null
	 */
	protected ?Element $footer = null;

	/**
	 * Card style variant
	 *
	 * @var string
	 */
	protected string $variant = 'default';

	/**
	 * Available card style variants
	 *
	 * @var array
	 */
	protected const CARD_VARIANTS = [
		'default',
		'compact',
		'borderless',
		'no-padding'
	];

	/**
	 * Constructor
	 *
	 * @param mixed  $content     Card content (body content)
	 * @param string $title       Optional header title
	 * @param mixed  $footer      Optional footer content
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 * @param string $variant     Card style variant (default, compact, borderless, no-padding)
	 */
	public function __construct( $content = null, string $title = '', $footer = null, array $attributes = [], bool $include_css = true, string $variant = 'compact' ) {
		// Set style variant
		$this->set_variant( $variant );

		// Initialize component foundation
		$this->init_component( 'card', $attributes, $include_css );

		// Add variant class if not default
		if ( $this->variant !== 'default' ) {
			if (!isset($attributes['class'])) {
				$attributes['class'] = '';
			}
			$attributes['class'] .= " card--{$this->variant}";
		}

		// Initialize with a div element - explicitly set escaping to false for card containers
		parent::__construct( 'div', null, $attributes, false );

		// Set up card parts if provided
		if ( ! empty( $title ) ) {
			$this->set_header( $title );
		}

		if ( $content !== null ) {
			$this->set_body( $content );
		}

		if ( $footer !== null ) {
			$this->set_footer( $footer );
		}

		// Build the card
		$this->build();
	}

	/**
	 * Build the card structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Add header if exists
		if ( $this->header ) {
			$this->add_child( $this->header );
		}

		// Add body if exists
		if ( $this->body ) {
			$this->add_child( $this->body );
		}

		// Add footer if exists
		if ( $this->footer ) {
			$this->add_child( $this->footer );
		}
	}

	/**
	 * Set card header content
	 *
	 * @param mixed $content Header content
	 *
	 * @return $this
	 */
	public function set_header( $content ): self {
		if (is_string($content)) {
			// For string content, create a header element with proper escaping
			$header_div = new Element('div', null, ['class' => 'card-header'], false);
			// Add the title as a text element with escaping
			if (!empty($content)) {
				$title_element = new Element('h3', $content, [], true);
				$header_div->add_child($title_element);
			}
			$this->header = $header_div;
		} else {
			// For Element or other content types
			$this->header = $this->create_header('div', $content);
		}
		$this->build();

		return $this;
	}

	/**
	 * Set card body content
	 *
	 * @param mixed $content Body content
	 *
	 * @return $this
	 */
	public function set_body( $content ): self {
		$body_div = new Element('div', null, ['class' => 'card-body'], false);

		if (is_string($content)) {
			// For string content, disable escaping to preserve HTML
			$body_div->set_escape_content(false);
			$body_div->add_child($content);
		} else {
			// For Element or other content types
			$body_div->add_child($content);
		}

		$this->body = $body_div;
		$this->build();

		return $this;
	}

	/**
	 * Set card footer content
	 *
	 * @param mixed $content Footer content
	 *
	 * @return $this
	 */
	public function set_footer( $content ): self {
		$footer_div = new Element('div', null, ['class' => 'card-footer'], false);

		if (is_string($content)) {
			// For string content, disable escaping to preserve HTML
			$footer_div->set_escape_content(false);
			$footer_div->add_child($content);
		} else {
			// For Element or other content types
			$footer_div->add_child($content);
		}

		$this->footer = $footer_div;
		$this->build();

		return $this;
	}

	/**
	 * Add content to card body
	 *
	 * @param mixed $content Content to add
	 *
	 * @return $this
	 */
	public function add_to_body( $content ): self {
		if ( ! $this->body ) {
			$this->body = new Element('div', null, ['class' => 'card-body'], false);
		}

		if (is_string($content)) {
			// For string content, disable escaping to preserve HTML
			$this->body->set_escape_content(false);
		}

		$this->body->add_child($content);
		$this->build();

		return $this;
	}

	/**
	 * Set card image at the top
	 *
	 * @param string $src        Image URL
	 * @param string $alt        Alt text
	 * @param array  $attributes Image attributes
	 *
	 * @return $this
	 */
	public function set_image( string $src, string $alt = '', array $attributes = [] ): self {
		$image = Create::img( $src, $alt, array_merge( [ 'class' => 'card-img-top' ], $attributes ) );

		// Add the image before all other elements
		$this->children = array_merge( [ $image ], $this->children );

		return $this;
	}

	/**
	 * Set card style variant
	 *
	 * @param string $variant Style variant (default, compact, borderless, no-padding)
	 *
	 * @return $this
	 */
	public function set_variant( string $variant ): self {
		// Validate variant
		$this->variant = in_array( $variant, self::CARD_VARIANTS ) ? $variant : 'default';

		// Remove existing variant classes
		if ( $this->has_attribute( 'class' ) ) {
			$this->remove_class( function ( $class ) {
				return strpos( $class, 'card--' ) === 0;
			} );
		}

		// Add the new variant class if not default
		if ( $this->variant !== 'default' ) {
			$this->add_class( "card--{$this->variant}" );
		}

		return $this;
	}

	/**
	 * Get current card style variant
	 *
	 * @return string
	 */
	public function get_variant(): string {
		return $this->variant;
	}

	/**
	 * Get the header element
	 *
	 * @return Element|null
	 */
	public function get_header(): ?Element {
		return $this->header;
	}

	/**
	 * Get the body element
	 *
	 * @return Element|null
	 */
	public function get_body(): ?Element {
		return $this->body;
	}

	/**
	 * Get the footer element
	 *
	 * @return Element|null
	 */
	public function get_footer(): ?Element {
		return $this->footer;
	}
}