<?php
/**
 * Elementify Library - Toggle Component
 *
 * Provides a styled toggle switch alternative to checkboxes.
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
use Elementify\Elements\Input;

/**
 * Toggle Component
 *
 * Creates a styled toggle switch as an alternative to checkboxes.
 */
class Toggle extends Component {

	/**
	 * Toggle name
	 *
	 * @var string
	 */
	protected string $name;

	/**
	 * Toggle options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Constructor
	 *
	 * @param string      $name        Toggle input name
	 * @param bool        $checked     Whether the toggle is checked
	 * @param string|int  $value       Value when checked
	 * @param string|null $label       Optional label text
	 * @param array       $attributes  Element attributes
	 * @param bool        $disabled    Whether the toggle is disabled
	 * @param bool        $include_css Whether to include built-in CSS
	 */
	public function __construct(
		string $name,
		bool $checked = false,
		$value = '1',
		?string $label = null,
		array $attributes = [],
		bool $disabled = false,
		bool $include_css = true
	) {
		$this->name = $name;

		// Store options
		$this->options = [
			'checked'  => $checked,
			'value'    => $value,
			'label'    => $label,
			'disabled' => $disabled
		];

		// Initialize with div element for the container
		parent::__construct( 'div', null, $attributes );

		// Add base class for styling
		$this->add_class( 'toggle-container' );

		// Initialize component foundation
		$this->init_component( 'toggle', $attributes, $include_css );

		// Build the component structure
		$this->build();
	}

	/**
	 * Build the component structure
	 *
	 * @return void
	 */
	protected function build(): void {
		// Clear any existing children
		$this->children = [];

		// Create input attributes
		$input_attrs = [
			'type'  => 'checkbox',
			'name'  => $this->name,
			'value' => $this->options['value'],
			'class' => 'toggle-input',
			'id'    => 'toggle-' . $this->name,
		];

		// Set checked state if needed
		if ( $this->options['checked'] ) {
			$input_attrs['checked'] = 'checked';
		}

		// Set disabled state if needed
		if ( $this->options['disabled'] ) {
			$input_attrs['disabled'] = 'disabled';
			$this->toggle_class( 'toggle-disabled', true );
		} else {
			$this->toggle_class( 'toggle-disabled', false );
		}

		// Create the hidden input
		$input = new Input( 'checkbox', $this->name, $this->options['value'], $input_attrs );

		// Create the toggle switch visual element
		$toggle_switch = Create::label( 'toggle-' . $this->name, '', [ 'class' => 'toggle-switch' ] );
		$toggle_switch->add_child( Create::span( null, [ 'class' => 'toggle-slider' ] ) );

		// Add components to the container
		$this->add_child( $input );
		$this->add_child( $toggle_switch );

		// Add label if provided
		if ( $this->options['label'] ) {
			$label_element = Create::span( $this->options['label'], [ 'class' => 'toggle-label' ] );
			$this->add_child( $label_element );
		}
	}

	/**
	 * Set the toggle's checked state
	 *
	 * @param bool $checked Whether the toggle is checked
	 *
	 * @return $this
	 */
	public function set_checked( bool $checked ): self {
		return $this->toggle_option( 'checked', $checked );
	}

	/**
	 * Set the toggle's value
	 *
	 * @param string|int $value Value when checked
	 *
	 * @return $this
	 */
	public function set_value( $value ): self {
		$this->options['value'] = $value;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set the toggle's label
	 *
	 * @param string|null $label Label text
	 *
	 * @return $this
	 */
	public function set_label( ?string $label ): self {
		$this->options['label'] = $label;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set the toggle's disabled state
	 *
	 * @param bool $disabled Whether the toggle is disabled
	 *
	 * @return $this
	 */
	public function set_disabled( bool $disabled ): self {
		return $this->toggle_option( 'disabled', $disabled );
	}

}