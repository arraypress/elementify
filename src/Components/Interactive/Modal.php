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

namespace Elementify\Components\Interactive;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Element;
use Elementify\Traits\Component\Parts;

/**
 * Modal Component
 *
 * Creates a modal dialog box.
 */
class Modal extends Component {
	use Parts;

	/**
	 * Modal title
	 *
	 * @var Element|null
	 */
	protected ?Element $title = null;

	/**
	 * Modal body
	 *
	 * @var Element|null
	 */
	protected ?Element $body = null;

	/**
	 * Modal footer
	 *
	 * @var Element|null
	 */
	protected ?Element $footer = null;

	/**
	 * Content wrapper element
	 *
	 * @var Element
	 */
	protected Element $content_wrapper;

	/**
	 * Modal options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Constructor
	 *
	 * @param string $title       Modal title
	 * @param mixed  $content     Modal content
	 * @param array  $buttons     Array of buttons for footer
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 */
	public function __construct( string $title = '', $content = null, array $buttons = [], array $attributes = [], bool $include_css = true ) {
		// Set base class to modal-overlay
		$this->base_class = 'modal-overlay';

		// Initialize default options
		$this->options = [
			'closeable' => true,
			'visible'   => false,
		];

		// Make sure we have an ID - this is critical for proper functioning
		if ( ! isset( $attributes['id'] ) ) {
			$attributes['id'] = 'modal-' . uniqid();
		}

		// Ensure we have a class attribute
		if ( ! isset( $attributes['class'] ) ) {
			$attributes['class'] = '';
		}

		// Add base class to attributes directly
		if ( is_string( $attributes['class'] ) ) {
			$attributes['class'] = trim( $attributes['class'] . ' modal-overlay' );
		} elseif ( is_array( $attributes['class'] ) ) {
			$attributes['class'][] = 'modal-overlay';
		}

		// Set default style to be hidden
		$style = 'display: none;';
		if ( isset( $attributes['style'] ) ) {
			$attributes['style'] .= '; ' . $style;
		} else {
			$attributes['style'] = $style;
		}

		// Initialize component foundation
		$this->init_component( 'modal', $attributes, $include_css );

		// Initialize with a div element - explicitly disable escaping for modals
		parent::__construct( 'div', null, $attributes, false );

		// Create content wrapper - explicitly disable escaping
		$this->content_wrapper = new Element( 'div', null, [ 'class' => 'modal-content' ], false );

		// Set up modal parts if provided
		if ( ! empty( $title ) ) {
			$this->set_title( $title );
		}

		if ( $content !== null ) {
			$this->set_body( $content );
		}

		if ( ! empty( $buttons ) ) {
			$this->set_footer_buttons( $buttons );
		}

		// Build the modal
		$this->build();
	}

	/**
	 * Build the modal structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Reset content wrapper children
		$this->content_wrapper->children = [];

		// Add close button if closeable
		if ( $this->options['closeable'] ) {
			$close_button = new Element( 'span', '×', [
				'class'      => 'modal-close',
				'data-modal' => $this->get_attribute( 'id' )
			], true );

			$this->content_wrapper->add_child( $close_button );
		}

		// Add title if exists
		if ( $this->title ) {
			$this->content_wrapper->add_child( $this->title );
		}

		// Add body if exists
		if ( $this->body ) {
			$this->content_wrapper->add_child( $this->body );
		}

		// Add footer if exists
		if ( $this->footer ) {
			$this->content_wrapper->add_child( $this->footer );
		}

		// Add content wrapper to modal
		$this->add_child( $this->content_wrapper );
	}

	/**
	 * Set modal title
	 *
	 * @param mixed $title Title content
	 *
	 * @return $this
	 */
	public function set_title( $title ): self {
		// Create a title element with appropriate escaping
		$title_element = new Element( 'h3', null, [ 'class' => 'modal-title' ], false );

		if ( is_string( $title ) ) {
			// For string content, escape properly
			$title_span = new Element( 'span', $title, [], true );
			$title_element->add_child( $title_span );
		} else {
			// For Element or other content types
			$title_element->add_child( $title );
		}

		$this->title = $title_element;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set modal body content
	 *
	 * @param mixed $content Body content
	 *
	 * @return $this
	 */
	public function set_body( $content ): self {
		// Create a body container that doesn't escape its content
		$body_div = new Element( 'div', null, [ 'class' => 'modal-body' ], false );

		if ( is_string( $content ) ) {
			// For string content, disable escaping to preserve HTML
			$body_div->set_escape_content( false );
			$body_div->add_child( $content );
		} else {
			// For Element or other content types
			$body_div->add_child( $content );
		}

		$this->body = $body_div;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set modal footer content
	 *
	 * @param mixed $content Footer content
	 *
	 * @return $this
	 */
	public function set_footer( $content ): self {
		// Create a footer container that doesn't escape its content
		$footer_div = new Element( 'div', null, [ 'class' => 'modal-footer' ], false );

		if ( is_string( $content ) ) {
			// For string content, disable escaping to preserve HTML
			$footer_div->set_escape_content( false );
			$footer_div->add_child( $content );
		} else {
			// For Element or other content types
			$footer_div->add_child( $content );
		}

		$this->footer = $footer_div;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set footer buttons
	 *
	 * @param array $buttons Array of button configurations or Button elements
	 *
	 * @return $this
	 */
	public function set_footer_buttons( array $buttons ): self {
		$footer = new Element( 'div', null, [ 'class' => 'modal-footer' ], false );

		foreach ( $buttons as $button ) {
			if ( $button instanceof Element ) {
				$footer->add_child( $button );
			} elseif ( is_array( $button ) && isset( $button['text'] ) ) {
				$btn = Create::button( $button['text'], $button['type'] ?? 'button' );

				if ( isset( $button['class'] ) ) {
					$btn->add_class( $button['class'] );
				}

				if ( isset( $button['id'] ) ) {
					$btn->set_id( $button['id'] );
				}

				// Set data attributes
				if ( isset( $button['data'] ) && is_array( $button['data'] ) ) {
					foreach ( $button['data'] as $key => $value ) {
						$btn->set_data( $key, $value );
					}
				}

				// Add special modal actions (cancel, confirm, etc.)
				if ( isset( $button['action'] ) ) {
					$btn->set_data( 'modal-action', $button['action'] );
				}

				$footer->add_child( $btn );
			}
		}

		$this->footer = $footer;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Add content to modal body
	 *
	 * @param mixed $content Content to add
	 *
	 * @return $this
	 */
	public function add_to_body( $content ): self {
		if ( ! $this->body ) {
			$this->body = new Element( 'div', null, [ 'class' => 'modal-body' ], false );
		}

		if ( is_string( $content ) ) {
			// For string content, disable escaping to preserve HTML
			$this->body->set_escape_content( false );
		}

		$this->body->add_child( $content );
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set whether the modal can be closed by the user
	 *
	 * @param bool $closeable Whether the modal can be closed
	 *
	 * @return $this
	 */
	public function set_closeable( bool $closeable ): self {
		return $this->toggle_option( 'closeable', $closeable );
	}

	/**
	 * Set the visibility state of the modal
	 *
	 * @param bool $visible Whether the modal is visible
	 *
	 * @return $this
	 */
	public function set_visible( bool $visible ): self {
		$this->options['visible'] = $visible;

		// Update the style attribute
		$current_style = $this->get_attribute( 'style', '' );
		if ( $visible ) {
			$new_style = preg_replace( '/display:\s*none;?/', 'display: block;', $current_style );
			$this->set_attribute( 'style', $new_style );
		} else {
			$new_style = preg_replace( '/display:\s*block;?/', 'display: none;', $current_style );
			$this->set_attribute( 'style', $new_style );
		}

		return $this;
	}

	/**
	 * Create a button that opens this modal
	 *
	 * @param string $text       Button text
	 * @param array  $attributes Additional button attributes
	 *
	 * @return Element
	 */
	public function create_trigger( string $text, array $attributes = [] ): Element {
		// Get the modal ID directly
		$modal_id = $this->get_attribute( 'id' );

		// Ensure we have a modal ID
		if ( empty( $modal_id ) ) {
			$modal_id = 'modal-' . uniqid();
			$this->set_attribute( 'id', $modal_id );
		}

		// Set data attribute on the button
		$attributes['data-open-modal'] = $modal_id;

		// Create and return the button
		return Create::button( $text, 'button', $attributes );
	}

	/**
	 * Create a link that opens this modal
	 *
	 * @param string $text       Link text
	 * @param array  $attributes Additional link attributes
	 *
	 * @return Element
	 */
	public function create_trigger_link( string $text, array $attributes = [] ): Element {
		// Get the modal ID
		$modal_id = $this->get_attribute( 'id' );

		// Ensure we have a modal ID
		if ( empty( $modal_id ) ) {
			$modal_id = 'modal-' . uniqid();
			$this->set_attribute( 'id', $modal_id );
		}

		// Set data attributes for the link
		$attributes['data-open-modal'] = $modal_id;
		$attributes['href']            = "#{$modal_id}";

		return Create::a( '#', $text, $attributes );
	}

	/**
	 * Get the title element
	 *
	 * @return Element|null
	 */
	public function get_title(): ?Element {
		return $this->title;
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

	/**
	 * Get the content wrapper element
	 *
	 * @return Element
	 */
	public function get_content_wrapper(): Element {
		return $this->content_wrapper;
	}

}