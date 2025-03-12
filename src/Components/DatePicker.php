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
 * DatePicker Component
 *
 * Creates a date picker input with calendar popup.
 */
class DatePicker extends Component {

	/**
	 * Input element
	 *
	 * @var Element
	 */
	protected Element $input;

	/**
	 * Calendar container element
	 *
	 * @var Element
	 */
	protected Element $calendar;

	/**
	 * Selected date
	 *
	 * @var string
	 */
	protected string $selected_date = '';

	/**
	 * DatePicker options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Constructor
	 *
	 * @param string $name        Input name attribute
	 * @param string $value       Default date value (YYYY-MM-DD format)
	 * @param array  $options     DatePicker options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 */
	public function __construct( string $name = '', string $value = '', array $options = [], array $attributes = [], bool $include_css = true ) {
		// Default options
		$defaults = [
			'format'      => 'Y-m-d',         // PHP date format
			'min_date'    => '',              // Minimum selectable date (YYYY-MM-DD)
			'max_date'    => '',              // Maximum selectable date (YYYY-MM-DD)
			'placeholder' => 'Select a date', // Input placeholder
			'readonly'    => false,           // Whether the input is readonly
			'disabled'    => false,           // Whether the input is disabled
			'show_clear'  => true,            // Show clear button
			'show_today'  => true,            // Show today button
			'first_day'   => 0,               // First day of week (0 = Sunday, 1 = Monday)
			'locale'      => '',            // Calendar locale
		];

		$this->options       = array_merge( $defaults, $options );
		$this->selected_date = $value;

		// Set base class
		$this->base_class = 'datepicker-wrapper';

		// Initialize component foundation
		$this->init_component( 'datepicker', $attributes, $include_css );

		// Initialize with div element
		parent::__construct( 'div', null, $attributes );

		// Create the input element
		$input_attributes = [
			'class'           => 'datepicker-input',
			'placeholder'     => $this->options['placeholder'],
			'data-datepicker' => 'true',
			'data-format'     => $this->options['format'],
			'autocomplete'    => 'off'
		];

		// Add min/max date attributes if set
		if ( ! empty( $this->options['min_date'] ) ) {
			$input_attributes['data-min-date'] = $this->options['min_date'];
		}

		if ( ! empty( $this->options['max_date'] ) ) {
			$input_attributes['data-max-date'] = $this->options['max_date'];
		}

		// Add readonly/disabled attributes if needed
		if ( $this->options['readonly'] ) {
			$input_attributes['readonly'] = 'readonly';
		}

		if ( $this->options['disabled'] ) {
			$input_attributes['disabled'] = 'disabled';
		}

		// Fixed: properly create the input with all required parameters
		$this->input = Create::input('text', $name, $value, $input_attributes);

		// Create calendar container element (will be populated by JS)
		$this->calendar = Create::div()
		                        ->add_class( 'datepicker-calendar' )
		                        ->set_attribute( 'data-first-day', (string) $this->options['first_day'] )
		                        ->set_attribute( 'data-locale', $this->options['locale'] )
		                        ->set_attribute( 'data-show-clear', $this->options['show_clear'] ? 'true' : 'false' )
		                        ->set_attribute( 'data-show-today', $this->options['show_today'] ? 'true' : 'false' );

		// Build the datepicker
		$this->build();
	}

	/**
	 * Build the datepicker
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Create input container with icon
		$input_container = Create::div()->add_class( 'datepicker-input-container' );
		$input_container->add_child( $this->input );

		// Add calendar icon
		$calendar_icon = Create::span( '📅' )->add_class( 'datepicker-icon' );
		$input_container->add_child( $calendar_icon );

		// Add input container and calendar
		$this->add_child( $input_container );
		$this->add_child( $this->calendar );
	}

	/**
	 * Set date format
	 *
	 * @param string $format PHP date format
	 *
	 * @return $this
	 */
	public function set_format( string $format ): self {
		$this->options['format'] = $format;
		$this->input->set_attribute( 'data-format', $format );

		return $this;
	}

	/**
	 * Set min date
	 *
	 * @param string $date Min date in YYYY-MM-DD format
	 *
	 * @return $this
	 */
	public function set_min_date( string $date ): self {
		$this->options['min_date'] = $date;
		$this->input->set_attribute( 'data-min-date', $date );

		return $this;
	}

	/**
	 * Set max date
	 *
	 * @param string $date Max date in YYYY-MM-DD format
	 *
	 * @return $this
	 */
	public function set_max_date( string $date ): self {
		$this->options['max_date'] = $date;
		$this->input->set_attribute( 'data-max-date', $date );

		return $this;
	}

	/**
	 * Set selected date
	 *
	 * @param string $date Date in YYYY-MM-DD format
	 *
	 * @return $this
	 */
	public function set_date( string $date ): self {
		$this->selected_date = $date;
		$this->input->set_attribute( 'value', $date );

		return $this;
	}

	/**
	 * Set placeholder
	 *
	 * @param string $placeholder Input placeholder text
	 *
	 * @return $this
	 */
	public function set_placeholder( string $placeholder ): self {
		$this->options['placeholder'] = $placeholder;
		$this->input->set_attribute( 'placeholder', $placeholder );

		return $this;
	}

	/**
	 * Set readonly
	 *
	 * @param bool $readonly Whether the input is readonly
	 *
	 * @return $this
	 */
	public function set_readonly( bool $readonly = true ): self {
		$this->options['readonly'] = $readonly;

		if ( $readonly ) {
			$this->input->set_attribute( 'readonly', 'readonly' );
		} else {
			$this->input->remove_attribute( 'readonly' );
		}

		return $this;
	}

	/**
	 * Set disabled
	 *
	 * @param bool $disabled Whether the input is disabled
	 *
	 * @return $this
	 */
	public function set_disabled( bool $disabled = true ): self {
		$this->options['disabled'] = $disabled;

		if ( $disabled ) {
			$this->input->set_attribute( 'disabled', 'disabled' );
		} else {
			$this->input->remove_attribute( 'disabled' );
		}

		return $this;
	}

	/**
	 * Show/hide clear button
	 *
	 * @param bool $show Whether to show the clear button
	 *
	 * @return $this
	 */
	public function show_clear_button( bool $show = true ): self {
		$this->options['show_clear'] = $show;
		$this->calendar->set_attribute( 'data-show-clear', $show ? 'true' : 'false' );

		return $this;
	}

	/**
	 * Show/hide today button
	 *
	 * @param bool $show Whether to show the today button
	 *
	 * @return $this
	 */
	public function show_today_button( bool $show = true ): self {
		$this->options['show_today'] = $show;
		$this->calendar->set_attribute( 'data-show-today', $show ? 'true' : 'false' );

		return $this;
	}

	/**
	 * Set first day of week
	 *
	 * @param int $day First day (0 = Sunday, 1 = Monday, etc.)
	 *
	 * @return $this
	 */
	public function set_first_day( int $day ): self {
		$day                        = max( 0, min( 6, $day ) ); // Ensure day is between 0-6
		$this->options['first_day'] = $day;
		$this->calendar->set_attribute( 'data-first-day', (string) $day );

		return $this;
	}

	/**
	 * Set locale
	 *
	 * @param string $locale Locale code (e.g., 'en', 'fr', 'de')
	 *
	 * @return $this
	 */
	public function set_locale( string $locale ): self {
		$this->options['locale'] = $locale;
		$this->calendar->set_attribute( 'data-locale', $locale );

		return $this;
	}

	/**
	 * Get the input element
	 *
	 * @return Element
	 */
	public function get_input(): Element {
		return $this->input;
	}

	/**
	 * Get the calendar element
	 *
	 * @return Element
	 */
	public function get_calendar(): Element {
		return $this->calendar;
	}
}