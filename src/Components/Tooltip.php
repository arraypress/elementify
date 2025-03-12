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

declare( strict_types=1 );

namespace Elementify\Components;

use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Element;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Tooltip Component
 *
 * Creates a tooltip that can be attached to any element.
 */
class Tooltip extends Component {

	/**
	 * The target element the tooltip is attached to
	 *
	 * @var Element
	 */
	protected Element $target;

	/**
	 * The tooltip content element
	 *
	 * @var Element
	 */
	protected Element $tooltip_content;

	/**
	 * Constructor
	 *
	 * @param Element|string $target      Target element or content
	 * @param string         $tooltip     Tooltip content
	 * @param array          $options     Options for the tooltip (position, trigger, etc.)
	 * @param array          $attributes  Element attributes
	 * @param bool           $include_css Whether to include built-in CSS
	 */
	public function __construct( $target, string $tooltip, array $options = [], array $attributes = [], bool $include_css = true ) {
		// Default options
		$defaults = [
			'position' => 'top',      // top, right, bottom, left
			'trigger'  => 'hover',    // hover, click, focus
			'delay'    => 0,          // delay in ms
			'arrow'    => true,       // show arrow
			'theme'    => 'default',  // default, light, dark, info, warning, error
			'max_width' => null,      // maximum width in px
			'html'     => false       // whether tooltip contains HTML
		];

		$options = array_merge( $defaults, $options );

		// Create the target element if string was provided
		if ( is_string( $target ) ) {
			$this->target = Create::span( $target );
		} else {
			$this->target = $target;
		}

		// Initialize component foundation
		$this->init_component( 'tooltip', $attributes, $include_css );

		// Create the tooltip element
		$this->tooltip_content = Create::div()
		                               ->add_class( 'tooltip-content' )
		                               ->add_class( "tooltip-{$options['position']}" )
		                               ->add_class( "tooltip-theme-{$options['theme']}" );

		// Add arrow if enabled
		if ( $options['arrow'] ) {
			$this->tooltip_content->add_class( 'tooltip-arrow' );
		}

		// Set max width if provided
		if ( $options['max_width'] ) {
			$this->tooltip_content->set_styles( [ 'max-width' => $options['max_width'] . 'px' ] );
		}

		// Add tooltip content
		if ( $options['html'] ) {
			$this->tooltip_content->add_content( $tooltip )->set_escape_content( false );
		} else {
			$this->tooltip_content->add_content( $tooltip )->set_escape_content( true );
		}

		// Add data attributes for JS functionality
		$this->target->set_attribute( 'data-tooltip', 'true' );
		$this->target->set_attribute( 'data-tooltip-position', $options['position'] );
		$this->target->set_attribute( 'data-tooltip-trigger', $options['trigger'] );

		if ( $options['delay'] > 0 ) {
			$this->target->set_attribute( 'data-tooltip-delay', (string) $options['delay'] );
		}

		// Create the wrapper element that will contain both target and tooltip
		parent::__construct( 'div', null, array_merge( [ 'class' => 'tooltip-wrapper' ], $attributes ), false );

		// Build the tooltip
		$this->build();
	}

	/**
	 * Build the tooltip
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Add target and tooltip to wrapper
		$this->add_child( $this->target );
		$this->add_child( $this->tooltip_content );
	}

	/**
	 * Set tooltip position
	 *
	 * @param string $position Position (top, right, bottom, left)
	 *
	 * @return $this
	 */
	public function set_position( string $position ): self {
		$valid_positions = [ 'top', 'right', 'bottom', 'left' ];
		$position = in_array( $position, $valid_positions ) ? $position : 'top';

		// Remove existing position classes
		foreach ( $valid_positions as $pos ) {
			$this->tooltip_content->remove_class( "tooltip-{$pos}" );
		}

		// Add new position class
		$this->tooltip_content->add_class( "tooltip-{$position}" );
		$this->target->set_attribute( 'data-tooltip-position', $position );

		return $this;
	}

	/**
	 * Set tooltip trigger
	 *
	 * @param string $trigger Trigger type (hover, click, focus)
	 *
	 * @return $this
	 */
	public function set_trigger( string $trigger ): self {
		$valid_triggers = [ 'hover', 'click', 'focus' ];
		$trigger = in_array( $trigger, $valid_triggers ) ? $trigger : 'hover';

		$this->target->set_attribute( 'data-tooltip-trigger', $trigger );

		return $this;
	}

	/**
	 * Set tooltip theme
	 *
	 * @param string $theme Theme name (default, light, dark, info, warning, error)
	 *
	 * @return $this
	 */
	public function set_theme( string $theme ): self {
		$valid_themes = [ 'default', 'light', 'dark', 'info', 'warning', 'error' ];
		$theme = in_array( $theme, $valid_themes ) ? $theme : 'default';

		// Remove existing theme classes
		foreach ( $valid_themes as $t ) {
			$this->tooltip_content->remove_class( "tooltip-theme-{$t}" );
		}

		// Add new theme class
		$this->tooltip_content->add_class( "tooltip-theme-{$theme}" );

		return $this;
	}

	/**
	 * Set tooltip content
	 *
	 * @param string $content   Tooltip content
	 * @param bool   $html_mode Whether content contains HTML
	 *
	 * @return $this
	 */
	public function set_content( $content, bool $html_mode = false ): self {
		$this->tooltip_content->set_content( $content );
		$this->tooltip_content->set_escape_content( !$html_mode );

		return $this;
	}

	/**
	 * Get the target element
	 *
	 * @return Element
	 */
	public function get_target(): Element {
		return $this->target;
	}

	/**
	 * Get the tooltip content element
	 *
	 * @return Element
	 */
	public function get_tooltip_content(): Element {
		return $this->tooltip_content;
	}
}