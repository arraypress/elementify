<?php
/**
 * Elementify Library - Notice Builder
 *
 * Provides a fluent interface for building WordPress-style notices.
 *
 * @package     ArrayPress\Elementify\Builders
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Builders;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Components\Notification\Notice;
use Elementify\Create;

/**
 * Notice Builder Class
 *
 * Provides a fluent interface for building WordPress admin notices
 * with actions and custom styling. Uses composition instead of inheritance.
 */
class NoticeBuilder {

	/**
	 * The underlying Notice component
	 *
	 * @var Notice
	 */
	protected Notice $notice;

	/**
	 * Action buttons for the notice
	 *
	 * @var array
	 */
	protected array $action_buttons = [];

	/**
	 * Notice icon
	 *
	 * @var string
	 */
	protected string $icon = '';

	/**
	 * Constructor
	 *
	 * @param mixed  $content     Notice content
	 * @param string $type        Notice type (info, success, warning, error)
	 * @param bool   $dismissible Whether the notice can be dismissed
	 * @param array  $attributes  Element attributes
	 */
	public function __construct( $content = '', string $type = 'info', bool $dismissible = false, array $attributes = [] ) {
		$this->notice = new Notice( $content, $type, $dismissible, $attributes );
	}

	/**
	 * Set notice as success type
	 *
	 * @return $this For method chaining
	 */
	public function success(): self {
		$this->notice->set_type( 'success' );

		return $this;
	}

	/**
	 * Set notice as warning type
	 *
	 * @return $this For method chaining
	 */
	public function warning(): self {
		$this->notice->set_type( 'warning' );

		return $this;
	}

	/**
	 * Set notice as error type
	 *
	 * @return $this For method chaining
	 */
	public function error(): self {
		$this->notice->set_type( 'error' );

		return $this;
	}

	/**
	 * Set notice as info type
	 *
	 * @return $this For method chaining
	 */
	public function info(): self {
		$this->notice->set_type( 'info' );

		return $this;
	}

	/**
	 * Make the notice dismissible
	 *
	 * @param bool $dismissible Whether the notice can be dismissed
	 *
	 * @return $this For method chaining
	 */
	public function dismissible( bool $dismissible = true ): self {
		$this->notice->set_dismissible( $dismissible );

		return $this;
	}

	/**
	 * Set notice content
	 *
	 * @param mixed $content Notice content
	 *
	 * @return $this For method chaining
	 */
	public function content( $content ): self {
		$this->notice->set_content( $content );

		return $this;
	}

	/**
	 * Add an action button to the notice
	 *
	 * @param string $text       Button text
	 * @param string $url        Button URL
	 * @param array  $attributes Button attributes
	 * @param bool   $primary    Whether this is a primary button
	 *
	 * @return $this For method chaining
	 */
	public function action( string $text, string $url, array $attributes = [], bool $primary = false ): self {
		$this->action_buttons[] = [
			'text'       => $text,
			'url'        => $url,
			'attributes' => $attributes,
			'primary'    => $primary
		];

		return $this;
	}

	/**
	 * Add a primary action button
	 *
	 * @param string $text       Button text
	 * @param string $url        Button URL
	 * @param array  $attributes Button attributes
	 *
	 * @return $this For method chaining
	 */
	public function primary_action( string $text, string $url, array $attributes = [] ): self {
		return $this->action( $text, $url, $attributes, true );
	}

	/**
	 * Add a secondary action button
	 *
	 * @param string $text       Button text
	 * @param string $url        Button URL
	 * @param array  $attributes Button attributes
	 *
	 * @return $this For method chaining
	 */
	public function secondary_action( string $text, string $url, array $attributes = [] ): self {
		return $this->action( $text, $url, $attributes, false );
	}

	/**
	 * Set an icon for the notice
	 *
	 * @param string $icon Dashicon name (without dashicons- prefix)
	 *
	 * @return $this For method chaining
	 */
	public function icon( string $icon ): self {
		$this->icon = $icon;

		return $this;
	}

	/**
	 * Add WordPress admin notice styling
	 *
	 * @return $this For method chaining
	 */
	public function wp_admin_style(): self {
		$this->notice->add_class( 'notice-alt' );

		return $this;
	}

	/**
	 * Make notice inline (for use within forms/metaboxes)
	 *
	 * @return $this For method chaining
	 */
	public function inline(): self {
		$this->notice->add_class( 'inline' );

		return $this;
	}

	/**
	 * Set notice to display at top of admin page
	 *
	 * @return $this For method chaining
	 */
	public function admin_notice(): self {
		$this->notice->add_class( 'notice' );

		return $this;
	}

	/**
	 * Add CSS class to the notice
	 *
	 * @param string|array $classes CSS class(es) to add
	 *
	 * @return $this For method chaining
	 */
	public function add_class( $classes ): self {
		$this->notice->add_class( $classes );

		return $this;
	}

	/**
	 * Set attribute on the notice
	 *
	 * @param string $name  Attribute name
	 * @param mixed  $value Attribute value
	 *
	 * @return $this For method chaining
	 */
	public function set_attribute( string $name, $value ): self {
		$this->notice->set_attribute( $name, $value );

		return $this;
	}

	/**
	 * Build the notice structure with actions and icons
	 *
	 * @return Notice The built notice component
	 */
	public function build(): Notice {
		// Get the paragraph content from the notice
		$notice_children = $this->notice->get_children();
		$paragraph       = $notice_children[0] ?? null;

		if ( $paragraph ) {
			// Add icon if specified
			if ( ! empty( $this->icon ) ) {
				$icon_element = Create::span( null, [ 'class' => "dashicons dashicons-{$this->icon}" ] );
				$icon_element->set_styles( [ 'margin-right' => '8px', 'vertical-align' => 'middle' ] );
				$paragraph->prepend_child( $icon_element );
			}

			// Add action buttons if any
			if ( ! empty( $this->action_buttons ) ) {
				$actions_wrapper = Create::div( null, [ 'class' => 'notice-actions' ] );
				$actions_wrapper->set_styles( [ 'margin-top' => '10px' ] );

				foreach ( $this->action_buttons as $action ) {
					$button_classes = [ 'button' ];

					if ( $action['primary'] ) {
						$button_classes[] = 'button-primary';
					} else {
						$button_classes[] = 'button-secondary';
					}

					$attributes = array_merge(
						[ 'class' => implode( ' ', $button_classes ) ],
						$action['attributes']
					);

					$button = Create::a( $action['url'], $action['text'], $attributes );
					$button->set_styles( [ 'margin-right' => '10px' ] );

					$actions_wrapper->add_child( $button );
				}

				$paragraph->add_child( $actions_wrapper );
			}
		}

		return $this->notice;
	}

	/**
	 * Render the notice
	 *
	 * @return string
	 */
	public function render(): string {
		return $this->build()->render();
	}

	/**
	 * Output the notice directly
	 *
	 * @return void
	 */
	public function output(): void {
		echo $this->render();
	}

	/**
	 * Create a quick success notice with action
	 *
	 * @param string      $message     Success message
	 * @param string|null $action_text Optional action button text
	 * @param string|null $action_url  Optional action button URL
	 *
	 * @return static
	 */
	public static function quick_success( string $message, ?string $action_text = null, ?string $action_url = null ): self {
		$builder = new static( $message, 'success', true );

		if ( $action_text && $action_url ) {
			$builder->primary_action( $action_text, $action_url );
		}

		return $builder;
	}

	/**
	 * Create a quick error notice with retry action
	 *
	 * @param string      $message    Error message
	 * @param string|null $retry_text Optional retry button text
	 * @param string|null $retry_url  Optional retry button URL
	 *
	 * @return static
	 */
	public static function quick_error( string $message, ?string $retry_text = null, ?string $retry_url = null ): self {
		$builder = new static( $message, 'error', true );
		$builder->icon( 'warning' );

		if ( $retry_text && $retry_url ) {
			$builder->primary_action( $retry_text, $retry_url );
		}

		return $builder;
	}

	/**
	 * Get the underlying Notice component
	 *
	 * @return Notice
	 */
	public function get_notice(): Notice {
		return $this->notice;
	}

}