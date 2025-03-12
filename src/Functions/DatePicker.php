<?php
/**
 * Elementify Library - DatePicker Utility Functions
 *
 * Helper functions for creating date picker elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Create;
use Elementify\Components\DatePicker;

if ( ! function_exists( 'el_datepicker' ) ) {
	/**
	 * Create a date picker component
	 *
	 * @param string $name        Input name attribute
	 * @param string $value       Default date value (YYYY-MM-DD format)
	 * @param array  $options     DatePicker options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 *
	 * @return DatePicker
	 */
	function el_datepicker( string $name = '', string $value = '', array $options = [], array $attributes = [], bool $include_css = true ): DatePicker {
		return Create::datepicker( $name, $value, $options, $attributes, $include_css );
	}
}

if ( ! function_exists( 'el_datepicker_render' ) ) {
	/**
	 * Create and render a date picker component
	 *
	 * @param string $name        Input name attribute
	 * @param string $value       Default date value (YYYY-MM-DD format)
	 * @param array  $options     DatePicker options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 *
	 * @return void
	 */
	function el_datepicker_render( string $name = '', string $value = '', array $options = [], array $attributes = [], bool $include_css = true ): void {
		Create::datepicker_render( $name, $value, $options, $attributes, $include_css );
	}
}

/**
 * Create specialized date pickers
 */
if ( ! function_exists( 'el_date_field' ) ) {
	/**
	 * Create a date field with label
	 *
	 * @param string $label       Field label
	 * @param string $name        Field name
	 * @param string $value       Default value
	 * @param array  $options     Date picker options
	 * @param array  $attributes  Field attributes
	 * @param bool   $required    Whether the field is required
	 *
	 * @return string HTML for the date field with label
	 */
	function el_date_field( string $label, string $name, string $value = '', array $options = [], array $attributes = [], bool $required = false ): string {
		$label_html = Create::label( $name, $label )
		                    ->set_attribute( 'style', 'display: block; margin-bottom: 5px;' )
		                    ->render();

		if ( $required ) {
			$attributes['required'] = 'required';
		}

		$datepicker = el_datepicker( $name, $value, $options, $attributes );

		return '<div class="form-field form-field-date">' . $label_html . $datepicker->render() . '</div>';
	}
}

if ( ! function_exists( 'el_datepicker_range' ) ) {
	/**
	 * Create a date range picker with start and end dates
	 *
	 * @param string $start_name  Start date input name
	 * @param string $end_name    End date input name
	 * @param string $start_value Start date value
	 * @param string $end_value   End date value
	 * @param array  $options     DatePicker options
	 *
	 * @return string HTML for the date range picker
	 */
	function el_datepicker_range( string $start_name, string $end_name, string $start_value = '', string $end_value = '', array $options = [] ): string {
		$default_options = [
			'format' => 'Y-m-d',
			'start_placeholder' => 'Start date',
			'end_placeholder' => 'End date'
		];

		$options = array_merge( $default_options, $options );

		// Create start date picker
		$start_options = $options;
		$start_options['placeholder'] = $options['start_placeholder'];

		$start_picker = el_datepicker( $start_name, $start_value, $start_options )
			->set_attribute( 'data-range-start', 'true' )
			->render();

		// Create end date picker
		$end_options = $options;
		$end_options['placeholder'] = $options['end_placeholder'];

		if ( ! empty( $start_value ) ) {
			$end_options['min_date'] = $start_value;
		}

		$end_picker = el_datepicker( $end_name, $end_value, $end_options )
			->set_attribute( 'data-range-end', 'true' )
			->render();

		// Combine with separator
		$html = '<div class="datepicker-range-wrapper">';
		$html .= '<div class="datepicker-range-start">' . $start_picker . '</div>';
		$html .= '<div class="datepicker-range-separator">to</div>';
		$html .= '<div class="datepicker-range-end">' . $end_picker . '</div>';
		$html .= '</div>';

		return $html;
	}
}

if ( ! function_exists( 'el_birthday_picker' ) ) {
	/**
	 * Create a birthday date picker with year, month, day dropdowns
	 *
	 * @param string $name        Field name prefix
	 * @param array  $value       Default value as array with 'year', 'month', 'day' keys
	 * @param array  $options     Options for the date picker
	 *
	 * @return string HTML for the birthday picker
	 */
	function el_birthday_picker( string $name, array $value = [], array $options = [] ): string {
		// Default options
		$default_options = [
			'start_year' => date( 'Y' ) - 100,  // 100 years ago
			'end_year'   => date( 'Y' ),        // Current year
			'month_format' => 'F',              // Full month name
			'year_first' => false,              // Whether to show year first
			'required'   => false,              // Whether fields are required
		];

		$options = array_merge( $default_options, $options );

		// Prepare values
		$selected_day = $value['day'] ?? '';
		$selected_month = $value['month'] ?? '';
		$selected_year = $value['year'] ?? '';

		// Create month dropdown
		$months = [];
		for ( $i = 1; $i <= 12; $i++ ) {
			$month_name = date( $options['month_format'], mktime( 0, 0, 0, $i, 1 ) );
			$months[ $i ] = $month_name;
		}

		$month_field = Create::select( $name . '[month]', $months, $selected_month )
		                     ->add_class( 'birthday-month' );

		if ( $options['required'] ) {
			$month_field->set_attribute( 'required', 'required' );
		}

		// Create day dropdown
		$days = [];
		for ( $i = 1; $i <= 31; $i++ ) {
			$days[ $i ] = $i;
		}

		$day_field = Create::select( $name . '[day]', $days, $selected_day )
		                   ->add_class( 'birthday-day' );

		if ( $options['required'] ) {
			$day_field->set_attribute( 'required', 'required' );
		}

		// Create year dropdown
		$years = [];
		for ( $i = $options['end_year']; $i >= $options['start_year']; $i-- ) {
			$years[ $i ] = $i;
		}

		$year_field = Create::select( $name . '[year]', $years, $selected_year )
		                    ->add_class( 'birthday-year' );

		if ( $options['required'] ) {
			$year_field->set_attribute( 'required', 'required' );
		}

		// Arrange fields in order
		$fields = [];

		if ( $options['year_first'] ) {
			$fields[] = $year_field->render();
			$fields[] = $month_field->render();
			$fields[] = $day_field->render();
		} else {
			$fields[] = $month_field->render();
			$fields[] = $day_field->render();
			$fields[] = $year_field->render();
		}

		// Combine fields
		$html = '<div class="birthday-picker">';
		$html .= implode( ' ', $fields );
		$html .= '</div>';

		return $html;
	}
}