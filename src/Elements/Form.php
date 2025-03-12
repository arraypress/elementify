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
 * Form Element
 */
class Form extends Element {

	/**
	 * Constructor
	 *
	 * @param string $action     Form action URL
	 * @param string $method     Form method (get/post)
	 * @param array  $attributes Additional attributes
	 */
	public function __construct( string $action = '', string $method = 'post', array $attributes = [] ) {
		parent::__construct( 'form', null, $attributes );

		if ( ! empty( $action ) ) {
			$this->set_attribute( 'action', $action );
		}

		if ( ! empty( $method ) ) {
			$this->set_attribute( 'method', strtolower( $method ) );
		}
	}

	/**
	 * Set enctype attribute for file uploads
	 *
	 * @param bool $enable Whether to enable file uploads
	 *
	 * @return $this
	 */
	public function set_file_upload( bool $enable = true ): self {
		if ( $enable ) {
			return $this->set_attribute( 'enctype', 'multipart/form-data' );
		} else {
			return $this->set_attribute( 'enctype', null );
		}
	}

	/**
	 * Add WordPress nonce field
	 *
	 * @param string $action  Action name
	 * @param string $name    Nonce name
	 * @param bool   $referer Whether to include the referer field
	 *
	 * @return $this
	 */
	public function add_nonce( string $action, string $name = '_wpnonce', bool $referer = true ): self {
		if ( function_exists( 'wp_nonce_field' ) ) {
			ob_start();
			wp_nonce_field( $action, $name, $referer );
			$nonce_html = ob_get_clean();
			$this->add_content( $nonce_html );
		}

		return $this;
	}

}