<?php
/**
 * Elementify Library - Button Elements Trait
 *
 * A collection of methods for creating button-related HTML elements.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits\Form;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Elements\Button;

/**
 * Button Elements Trait
 *
 * Provides methods for creating button-related HTML elements.
 */
trait Buttons {

	/**
	 * Create a button element
	 *
	 * @param string $content    Button content
	 * @param string $type       Button type
	 * @param array  $attributes Element attributes
	 *
	 * @return Button
	 */
	public static function button( string $content, string $type = 'submit', array $attributes = [] ): Button {
		return new Button( $type, $content, $attributes );
	}

	/**
	 * Create and render a button element
	 *
	 * @param string $content    Button content
	 * @param string $type       Button type
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function button_render( string $content, string $type = 'submit', array $attributes = [] ): void {
		self::button( $content, $type, $attributes )->output();
	}

	/**
	 * Create a submit button
	 *
	 * @param string $content    Button content
	 * @param array  $attributes Element attributes
	 *
	 * @return Button
	 */
	public static function submit( string $content = 'Submit', array $attributes = [] ): Button {
		return self::button( $content, 'submit', $attributes );
	}

	/**
	 * Create and render a submit button
	 *
	 * @param string $content    Button content
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function submit_render( string $content = 'Submit', array $attributes = [] ): void {
		self::submit( $content, $attributes )->output();
	}

}