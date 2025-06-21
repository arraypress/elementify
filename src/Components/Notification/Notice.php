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

namespace Elementify\Components\Notification;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Element;
use Elementify\Traits\Component\Parts;

/**
 * Notice Component
 *
 * Creates a notification or alert box.
 */
class Notice extends Component {
	use Parts;

	/**
	 * Available notice types
	 *
	 * @var array
	 */
	protected const NOTICE_TYPES = [
		'info',
		'success',
		'warning',
		'error'
	];

	/**
	 * Notice type
	 *
	 * @var string
	 */
	protected string $type = 'info';

	/**
	 * Whether the notice is dismissible
	 *
	 * @var bool
	 */
	protected bool $dismissible = false;

	/**
	 * Notice content
	 *
	 * @var mixed
	 */
	protected $content = null;

	/**
	 * Constructor
	 *
	 * @param mixed  $content     Notice content
	 * @param string $type        Notice type (info, success, warning, error)
	 * @param bool   $dismissible Whether the notice can be dismissed
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS (ignored - WordPress handles styling)
	 */
	public function __construct( $content = null, string $type = 'info', bool $dismissible = false, array $attributes = [], bool $include_css = true ) {
		// Store the content
		$this->content = $content;

		// Set notice properties
		$this->type        = in_array( $type, self::NOTICE_TYPES ) ? $type : 'info';
		$this->dismissible = $dismissible;

		// Initialize base class
		$this->base_class = 'notice';

		// Prepare attributes with notice classes
		if ( ! isset( $attributes['class'] ) ) {
			$attributes['class'] = '';
		}

		// Ensure the "notice" class is always first
		if ( is_string( $attributes['class'] ) ) {
			// Make sure we start with "notice"
			$classes = array_filter( explode( ' ', trim( $attributes['class'] ) ) );
			if ( ! in_array( 'notice', $classes ) ) {
				array_unshift( $classes, 'notice' );
			}
			$attributes['class'] = implode( ' ', $classes );
		} elseif ( is_array( $attributes['class'] ) ) {
			if ( ! in_array( 'notice', $attributes['class'] ) ) {
				array_unshift( $attributes['class'], 'notice' );
			}
			$attributes['class'] = implode( ' ', $attributes['class'] );
		}

		// Add type class
		$attributes['class'] .= " notice-{$this->type}";

		// Add dismissible class if needed
		if ( $this->dismissible ) {
			$attributes['class'] .= ' is-dismissible';
		}

		// Initialize with a div element
		parent::__construct( 'div', null, $attributes );

		// Never include CSS/JS - WordPress handles this natively
		$this->init_component( 'notice', $attributes, false );

		// Build the notice structure
		$this->build();
	}

	/**
	 * Build the notice structure
	 */
	protected function build(): void {
		// Clear children first
		$this->children = [];

		// Create paragraph for the content (WordPress standard structure)
		$content_paragraph = Create::p();

		// Add content to paragraph
		if ( $this->content instanceof Element ) {
			$content_paragraph->add_child( $this->content );
		} else {
			$content_paragraph->add_content( (string) $this->content );
		}

		// Add the paragraph to the notice
		$this->add_child( $content_paragraph );

		// WordPress automatically handles dismiss buttons for dismissible notices
		// No need to add our own dismiss button
	}

	/**
	 * Set notice type
	 *
	 * @param string $type Notice type (info, success, warning, error)
	 *
	 * @return $this
	 */
	public function set_type( string $type ): self {
		if ( in_array( $type, self::NOTICE_TYPES ) ) {
			// Remove old type class
			$this->remove_class( array_map( function ( $t ) {
				return "notice-{$t}";
			}, self::NOTICE_TYPES ) );

			// Add new type class
			$this->add_class( "notice-{$type}" );

			// Update type property
			$this->type = $type;
		}

		return $this;
	}

	/**
	 * Set whether the notice is dismissible
	 *
	 * @param bool $dismissible Whether the notice can be dismissed
	 *
	 * @return $this
	 */
	public function set_dismissible( bool $dismissible ): self {
		if ( $dismissible !== $this->dismissible ) {
			$this->dismissible = $dismissible;
			$this->toggle_class( 'is-dismissible', $dismissible );
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Set notice content
	 *
	 * @param mixed $content Notice content
	 *
	 * @return $this
	 */
	public function set_content( $content ): self {
		$this->content = $content;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Create an info notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (ignored)
	 *
	 * @return Notice
	 */
	public static function info( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): Notice {
		return new Notice( $content, 'info', $dismissible, $attributes, false );
	}

	/**
	 * Create a success notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (ignored)
	 *
	 * @return Notice
	 */
	public static function success( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): Notice {
		return new Notice( $content, 'success', $dismissible, $attributes, false );
	}

	/**
	 * Create a warning notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (ignored)
	 *
	 * @return Notice
	 */
	public static function warning( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): Notice {
		return new Notice( $content, 'warning', $dismissible, $attributes, false );
	}

	/**
	 * Create an error notice
	 *
	 * @param mixed $content     Notice content
	 * @param bool  $dismissible Whether the notice can be dismissed
	 * @param array $attributes  Element attributes
	 * @param bool  $include_css Whether to include built-in CSS (ignored)
	 *
	 * @return Notice
	 */
	public static function error( $content, bool $dismissible = false, array $attributes = [], bool $include_css = true ): Notice {
		return new Notice( $content, 'error', $dismissible, $attributes, false );
	}

	/**
	 * Get the notice type
	 *
	 * @return string
	 */
	public function get_type(): string {
		return $this->type;
	}

	/**
	 * Check if the notice is dismissible
	 *
	 * @return bool
	 */
	public function is_dismissible(): bool {
		return $this->dismissible;
	}

}