<?php
/**
 * Elementify Library - Field Wrapper Elements Trait
 *
 * A collection of methods for creating field wrapper-related HTML elements.
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
use Elementify\Elements\Field;
use Elementify\Elements\Label;

/**
 * Field Wrapper Elements Trait
 *
 * Provides methods for creating field wrapper-related HTML elements.
 */
trait FieldWrappers {

	/**
	 * Create a label element
	 *
	 * @param string $for        ID of the associated form control
	 * @param string $content    Label content
	 * @param array  $attributes Element attributes
	 *
	 * @return Label
	 */
	public static function label( string $for, string $content, array $attributes = [] ): Label {
		return new Label( $for, $content, $attributes );
	}

	/**
	 * Create a field wrapper (label + input + description)
	 *
	 * @param string|Element $input       Input element or name
	 * @param string         $label       Label text
	 * @param string         $description Description text
	 * @param array          $attributes  Wrapper attributes
	 *
	 * @return Field
	 */
	public static function field( $input, string $label = '', string $description = '', array $attributes = [] ): Field {
		return new Field( $input, $label, $description, $attributes );
	}

}