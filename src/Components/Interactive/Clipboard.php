<?php
/**
 * Elementify Library - SimpleClipboard Component
 *
 * A lightweight component for displaying text with a copy-to-clipboard button.
 *
 * @package     ArrayPress\Elementify\Components
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Components\Interactive;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;
use Elementify\Create;

/**
 * SimpleClipboard Component
 *
 * Creates a container with text and a copy button.
 */
class Clipboard extends Component {

	/**
	 * Text content
	 *
	 * @var string
	 */
	protected string $text = '';

	/**
	 * Component options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Constructor
	 *
	 * @param string $text        The text to display and copy
	 * @param array  $options     Component options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 */
	public function __construct(
		string $text,
		array $options = [],
		array $attributes = [],
		bool $include_css = true
	) {
		// Store text and options
		$this->text = $text;

		// Set default options
		$this->options = array_merge( [
			'display_text' => '',              // Optional different text to display (if empty, uses text)
			'max_length'   => 0,               // Max length for display text (0 = no limit)
			'add_ellipsis' => true,            // Add ellipsis when truncating
			'width'        => '180px',         // Width of the component
			'tooltip'      => 'Click to copy', // Tooltip for the component
		], $options );

		// Initialize with div element for the container
		parent::__construct( 'div', null, $attributes );

		// Add base class for styling
		$this->add_class( 'clipboard-container' );

		// Add inline width if specified
		if ( ! empty( $this->options['width'] ) ) {
			$current_style = $this->get_attribute( 'style', '' );
			$this->set_attribute( 'style', $current_style . 'width:' . $this->options['width'] . ';' );
		}

		// Add tooltip
		if ( ! empty( $this->options['tooltip'] ) ) {
			$this->add_tooltip( $this->options['tooltip'] );
		}

		// Initialize component foundation
		$this->init_component( 'clipboard', $attributes, $include_css );

		// Build the component structure
		$this->build();
	}

	/**
	 * Build the component structure
	 */
	protected function build(): void {
		// Clear any existing children
		$this->children = [];

		// Generate a unique ID for this instance
		$unique_id = 'clipboard-' . uniqid();

		// Determine what text to display
		$display_text = ! empty( $this->options['display_text'] ) ? $this->options['display_text'] : $this->text;

		// Truncate if needed
		if ( $this->options['max_length'] > 0 && strlen( $display_text ) > $this->options['max_length'] ) {
			$display_text = substr( $display_text, 0, $this->options['max_length'] );
			if ( $this->options['add_ellipsis'] ) {
				$display_text .= '...';
			}
		}

		// Create the text element
		$text_el = Create::span( $display_text )->add_class( 'clipboard-text' );

		// Create the button with icon
		$button = Create::button( '', 'button', [
			'class'             => 'clipboard-button',
			'data-clipboard-id' => $unique_id,
			'aria-label'        => 'Copy to clipboard'
		] );

		// Add dashicon for copy
		$icon = Create::span()->add_class( 'dashicons dashicons-clipboard' );
		$button->add_child( $icon );

		// Create the container
		$container = Create::div()->add_class( 'clipboard-field' );
		$container->add_child( $text_el );
		$container->add_child( $button );

		$this->add_child( $container );

		// Add hidden input for copying
		$hidden_input = Create::element( 'input', null, [
			'type'        => 'hidden',
			'id'          => $unique_id,
			'value'       => $this->text,
			'readonly'    => 'readonly',
			'aria-hidden' => 'true'
		] );
		$this->add_child( $hidden_input );
	}

	/**
	 * Set text content
	 *
	 * @param string $text New text content
	 *
	 * @return $this
	 */
	public function set_text( string $text ): self {
		$this->text = $text;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set display text (what's shown to user)
	 *
	 * @param string $display_text Text to display
	 *
	 * @return $this
	 */
	public function set_display_text( string $display_text ): self {
		$this->options['display_text'] = $display_text;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set max length for display text
	 *
	 * @param int  $length       Maximum length
	 * @param bool $add_ellipsis Whether to add ellipsis when truncating
	 *
	 * @return $this
	 */
	public function set_max_length( int $length, bool $add_ellipsis = true ): self {
		$this->options['max_length']   = $length;
		$this->options['add_ellipsis'] = $add_ellipsis;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set component width
	 *
	 * @param string $width Width with CSS units (e.g., '200px')
	 *
	 * @return $this
	 */
	public function set_width( string $width ): self {
		$this->options['width'] = $width;

		// Update inline style
		$current_style = $this->get_attribute( 'style', '' );
		$new_style     = preg_replace( '/width:[^;]+;/', '', $current_style ) . 'width:' . $width . ';';
		$this->set_attribute( 'style', $new_style );

		return $this;
	}

	/**
	 * Set tooltip text
	 *
	 * @param string $tooltip Tooltip text
	 *
	 * @return $this
	 */
	public function set_tooltip( string $tooltip ): self {
		$this->options['tooltip'] = $tooltip;
		$this->add_tooltip( $tooltip );

		return $this;
	}

	/**
	 * Get the text content
	 *
	 * @return string
	 */
	public function get_text(): string {
		return $this->text;
	}

}