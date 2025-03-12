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

namespace Elementify\Elements;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Element;

/**
 * Label Element
 */
class Label extends Element {

	/**
	 * Constructor
	 *
	 * @param string $for        ID of the associated form control
	 * @param string $content    Label content
	 * @param array  $attributes Additional attributes
	 */
	public function __construct( string $for = '', string $content = '', array $attributes = [] ) {
		parent::__construct( 'label', $content, $attributes );

		if ( ! empty( $for ) ) {
			$this->set_attribute( 'for', $for );
		}
	}

}