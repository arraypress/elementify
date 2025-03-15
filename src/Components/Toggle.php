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

namespace Elementify\Components;

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
	 * Toggle checked state
	 *
	 * @var bool
	 */
	protected bool $checked;

	/**
	 * Toggle value when checked
	 *
	 * @var string|int
	 */
	protected $value;

	/**
	 * Optional toggle label
	 *
	 * @var string|null
	 */
	protected ?string $label;

	/**
	 * Toggle disabled state
	 *
	 * @var bool
	 */
	protected bool $disabled;

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
		$this->name     = $name;
		$this->checked  = $checked;
		$this->value    = $value;
		$this->label    = $label;
		$this->disabled = $disabled;

		// Initialize with div element for the container
		parent::__construct( 'div', null, $attributes );

		// Add base class for styling
		$this->add_class( 'elementify-toggle-container' );

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
			'value' => $this->value,
			'class' => 'elementify-toggle-input',
			'id'    => 'toggle-' . $this->name,
		];

		if ( $this->checked ) {
			$input_attrs['checked'] = 'checked';
		}

		if ( $this->disabled ) {
			$input_attrs['disabled'] = 'disabled';
			$this->add_class( 'elementify-toggle-disabled' );
		}

		// Create the hidden input
		$input = new Input( 'checkbox', $this->name, $this->value, $input_attrs );

		// Create the toggle switch visual element
		$toggle_switch = Create::label( 'toggle-' . $this->name, '', [ 'class' => 'elementify-toggle-switch' ] );
		$toggle_switch->add_child( Create::span( null, [ 'class' => 'elementify-toggle-slider' ] ) );

		// Add components to the container
		$this->add_child( $input );
		$this->add_child( $toggle_switch );

		// Add label if provided
		if ( $this->label ) {
			$label_element = Create::span( $this->label, [ 'class' => 'elementify-toggle-label' ] );
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
		$this->checked = $checked;
		$this->build();

		return $this;
	}

	/**
	 * Set the toggle's value
	 *
	 * @param string|int $value Value when checked
	 *
	 * @return $this
	 */
	public function set_value( $value ): self {
		$this->value = $value;
		$this->build();

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
		$this->label = $label;
		$this->build();

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
		$this->disabled = $disabled;
		$this->build();

		return $this;
	}

}