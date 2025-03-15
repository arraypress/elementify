<?php
/**
 * Elementify Library - Core Form Elements Trait
 *
 * Basic form-related HTML elements.
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

use Elementify\Element;
use Elementify\Elements\Form;

/**
 * Core Form Elements Trait
 *
 * Provides methods for creating basic form-related HTML elements.
 */
trait Core {

	/**
	 * Create a form element
	 *
	 * @param string $action     Form action URL
	 * @param string $method     Form method
	 * @param array  $attributes Element attributes
	 *
	 * @return Form
	 */
	public static function form( string $action = '', string $method = 'post', array $attributes = [] ): Form {
		return new Form( $action, $method, $attributes );
	}

	/**
	 * Create and render a form element
	 *
	 * @param string $action     Form action URL
	 * @param string $method     Form method
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function form_render( string $action = '', string $method = 'post', array $attributes = [] ): void {
		self::form( $action, $method, $attributes )->output();
	}

	/**
	 * Create a fieldset element
	 *
	 * @param mixed  $content    Content of the fieldset
	 * @param string $legend     Legend text (optional)
	 * @param array  $attributes Element attributes
	 *
	 * @return Element
	 */
	public static function fieldset( $content = null, string $legend = '', array $attributes = [] ): Element {
		$fieldset = self::element( 'fieldset', null, $attributes );

		if ( ! empty( $legend ) ) {
			$fieldset->add_child( self::element( 'legend', $legend ) );
		}

		if ( $content !== null ) {
			$fieldset->add_content( $content );
		}

		return $fieldset;
	}

	/**
	 * Create and render a fieldset element
	 *
	 * @param mixed  $content    Content of the fieldset
	 * @param string $legend     Legend text (optional)
	 * @param array  $attributes Element attributes
	 *
	 * @return void
	 */
	public static function fieldset_render( $content = null, string $legend = '', array $attributes = [] ): void {
		self::fieldset( $content, $legend, $attributes )->output();
	}

	/**
	 * Create a WordPress nonce field
	 *
	 * @param string $action  Action name
	 * @param string $name    Nonce name
	 * @param bool   $referer Whether to include the referer field
	 *
	 * @return string
	 */
	public static function nonce( string $action, string $name = '_wpnonce', bool $referer = true ): string {
		if ( function_exists( 'wp_nonce_field' ) ) {
			ob_start();
			wp_nonce_field( $action, $name, $referer );

			return ob_get_clean();
		}

		return '';
	}

	/**
	 * Output a WordPress nonce field
	 *
	 * @param string $action  Action name
	 * @param string $name    Nonce name
	 * @param bool   $referer Whether to include the referer field
	 *
	 * @return void
	 */
	public static function nonce_render( string $action, string $name = '_wpnonce', bool $referer = true ): void {
		echo self::nonce( $action, $name, $referer );
	}

}