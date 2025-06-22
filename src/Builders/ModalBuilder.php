<?php
/**
 * Elementify Library - Modal Builder
 *
 * Provides a fluent interface for building modal dialog components.
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

use Elementify\Element;
use Elementify\Create;

/**
 * Modal Builder Class
 *
 * Provides a fluent interface for building modal dialog components
 * with headers, bodies, footers, and various modal behaviors.
 */
class ModalBuilder extends Element {

	/**
	 * Modal ID
	 *
	 * @var string
	 */
	protected string $modal_id;

	/**
	 * Modal title
	 *
	 * @var string
	 */
	protected string $modal_title = '';

	/**
	 * Modal body content
	 *
	 * @var mixed
	 */
	protected $modal_body = null;

	/**
	 * Modal footer buttons
	 *
	 * @var array
	 */
	protected array $footer_buttons = [];

	/**
	 * Modal size
	 *
	 * @var string
	 */
	protected string $size = 'medium';

	/**
	 * Whether clicking backdrop closes modal
	 *
	 * @var bool
	 */
	protected bool $backdrop_close = true;

	/**
	 * Whether modal is closable
	 *
	 * @var bool
	 */
	protected bool $closable = true;

	/**
	 * Constructor
	 *
	 * @param string $modal_id   Unique modal ID
	 * @param array  $attributes Element attributes
	 */
	public function __construct( string $modal_id, array $attributes = [] ) {
		$this->modal_id = $modal_id;

		parent::__construct( 'div', null, array_merge( [
			'id'          => $modal_id,
			'class'       => 'modal',
			'role'        => 'dialog',
			'aria-hidden' => 'true'
		], $attributes ) );
	}

	/**
	 * Set modal title
	 *
	 * @param string $title Modal title text
	 *
	 * @return $this For method chaining
	 */
	public function title( string $title ): self {
		$this->modal_title = $title;

		return $this;
	}

	/**
	 * Set modal body content
	 *
	 * @param mixed $content Modal body content
	 *
	 * @return $this For method chaining
	 */
	public function body( $content ): self {
		$this->modal_body = $content;

		return $this;
	}

	/**
	 * Add a primary button to modal footer
	 *
	 * @param string $text       Button text
	 * @param string $action     Button action (URL or JavaScript)
	 * @param array  $attributes Button attributes
	 *
	 * @return $this For method chaining
	 */
	public function primary_button( string $text, string $action = '', array $attributes = [] ): self {
		$this->footer_buttons[] = [
			'text'       => $text,
			'action'     => $action,
			'type'       => 'primary',
			'attributes' => $attributes
		];

		return $this;
	}

	/**
	 * Add a secondary button to modal footer
	 *
	 * @param string $text       Button text
	 * @param string $action     Button action (URL or JavaScript)
	 * @param array  $attributes Button attributes
	 *
	 * @return $this For method chaining
	 */
	public function secondary_button( string $text, string $action = '', array $attributes = [] ): self {
		$this->footer_buttons[] = [
			'text'       => $text,
			'action'     => $action,
			'type'       => 'secondary',
			'attributes' => $attributes
		];

		return $this;
	}

	/**
	 * Add a destructive/danger button to modal footer
	 *
	 * @param string $text       Button text
	 * @param string $action     Button action (URL or JavaScript)
	 * @param array  $attributes Button attributes
	 *
	 * @return $this For method chaining
	 */
	public function destructive_button( string $text, string $action = '', array $attributes = [] ): self {
		$this->footer_buttons[] = [
			'text'       => $text,
			'action'     => $action,
			'type'       => 'destructive',
			'attributes' => $attributes
		];

		return $this;
	}

	/**
	 * Set modal size
	 *
	 * @param string $size Modal size (small, medium, large, full)
	 *
	 * @return $this For method chaining
	 */
	public function size( string $size ): self {
		$valid_sizes = [ 'small', 'medium', 'large', 'full' ];

		if ( in_array( $size, $valid_sizes ) ) {
			$this->size = $size;
			$this->add_class( "modal-{$size}" );
		}

		return $this;
	}

	/**
	 * Make modal small
	 *
	 * @return $this For method chaining
	 */
	public function small(): self {
		return $this->size( 'small' );
	}

	/**
	 * Make modal large
	 *
	 * @return $this For method chaining
	 */
	public function large(): self {
		return $this->size( 'large' );
	}

	/**
	 * Make modal full screen
	 *
	 * @return $this For method chaining
	 */
	public function fullscreen(): self {
		return $this->size( 'full' );
	}

	/**
	 * Set whether clicking backdrop closes modal
	 *
	 * @param bool $closable Whether backdrop click closes modal
	 *
	 * @return $this For method chaining
	 */
	public function backdrop_close( bool $closable = true ): self {
		$this->backdrop_close = $closable;

		if ( ! $closable ) {
			$this->set_data( 'backdrop', 'static' );
		}

		return $this;
	}

	/**
	 * Set whether modal can be closed
	 *
	 * @param bool $closable Whether modal can be closed
	 *
	 * @return $this For method chaining
	 */
	public function closable( bool $closable = true ): self {
		$this->closable = $closable;

		return $this;
	}

	/**
	 * Make modal non-closable
	 *
	 * @return $this For method chaining
	 */
	public function non_closable(): self {
		return $this->closable( false )->backdrop_close( false );
	}

	/**
	 * Add WordPress admin modal styling
	 *
	 * @return $this For method chaining
	 */
	public function wp_admin_style(): self {
		$this->add_class( 'wp-admin-modal' );

		return $this;
	}

	/**
	 * Build the modal structure
	 *
	 * @return void
	 */
	protected function build(): void {
		$this->children = []; // Clear existing content

		// Modal backdrop
		$backdrop = Create::div( null, [ 'class' => 'modal-backdrop' ] );

		// Modal dialog container
		$dialog = Create::div( null, [
			'class' => 'modal-dialog',
			'role'  => 'document'
		] );

		// Modal content wrapper
		$content = Create::div( null, [ 'class' => 'modal-content' ] );

		// Modal header
		if ( ! empty( $this->modal_title ) || $this->closable ) {
			$header = Create::div( null, [ 'class' => 'modal-header' ] );

			if ( ! empty( $this->modal_title ) ) {
				$title = Create::h4( $this->modal_title, [
					'class' => 'modal-title',
					'id'    => $this->modal_id . '-title'
				] );
				$header->add_child( $title );

				// Set aria-labelledby
				$this->set_attribute( 'aria-labelledby', $this->modal_id . '-title' );
			}

			if ( $this->closable ) {
				$close_button = Create::button( '×', 'button', [
					'class'        => 'modal-close',
					'aria-label'   => 'Close',
					'data-dismiss' => 'modal'
				] );
				$header->add_child( $close_button );
			}

			$content->add_child( $header );
		}

		// Modal body
		if ( $this->modal_body !== null ) {
			$body = Create::div( $this->modal_body, [ 'class' => 'modal-body' ] );
			$content->add_child( $body );
		}

		// Modal footer
		if ( ! empty( $this->footer_buttons ) ) {
			$footer = Create::div( null, [ 'class' => 'modal-footer' ] );

			foreach ( $this->footer_buttons as $button_config ) {
				$button_classes = [ 'button' ];

				switch ( $button_config['type'] ) {
					case 'primary':
						$button_classes[] = 'button-primary';
						break;
					case 'destructive':
						$button_classes[] = 'button-primary button-destructive';
						break;
					case 'secondary':
					default:
						$button_classes[] = 'button-secondary';
						break;
				}

				$attributes = array_merge(
					[ 'class' => implode( ' ', $button_classes ) ],
					$button_config['attributes']
				);

				// Add action if provided
				if ( ! empty( $button_config['action'] ) ) {
					if ( strpos( $button_config['action'], 'javascript:' ) === 0 || strpos( $button_config['action'], 'onclick:' ) === 0 ) {
						$attributes['onclick'] = str_replace( [
							'javascript:',
							'onclick:'
						], '', $button_config['action'] );
						$button                = Create::button( $button_config['text'], 'button', $attributes );
					} else {
						$button = Create::a( $button_config['action'], $button_config['text'], $attributes );
					}
				} else {
					$button = Create::button( $button_config['text'], 'button', $attributes );
				}

				$footer->add_child( $button );
			}

			$content->add_child( $footer );
		}

		$dialog->add_child( $content );
		$this->add_child( $backdrop );
		$this->add_child( $dialog );
	}

	/**
	 * Render the modal
	 *
	 * @return string
	 */
	public function render(): string {
		$this->build();

		return parent::render();
	}

	/**
	 * Create a confirmation modal
	 *
	 * @param string $id             Modal ID
	 * @param string $title          Modal title
	 * @param string $message        Confirmation message
	 * @param string $confirm_text   Confirm button text
	 * @param string $confirm_action Confirm button action
	 *
	 * @return static
	 */
	public static function confirmation( string $id, string $title, string $message, string $confirm_text = 'Confirm', string $confirm_action = '' ): self {
		return ( new static( $id ) )
			->title( $title )
			->body( $message )
			->secondary_button( 'Cancel', '', [ 'data-dismiss' => 'modal' ] )
			->primary_button( $confirm_text, $confirm_action )
			->size( 'small' );
	}

	/**
	 * Create a deletion confirmation modal
	 *
	 * @param string $id     Modal ID
	 * @param string $item   Item being deleted
	 * @param string $action Delete action
	 *
	 * @return static
	 */
	public static function delete_confirmation( string $id, string $item, string $action = '' ): self {
		return ( new static( $id ) )
			->title( 'Confirm Deletion' )
			->body( "Are you sure you want to delete \"{$item}\"? This action cannot be undone." )
			->secondary_button( 'Cancel', '', [ 'data-dismiss' => 'modal' ] )
			->destructive_button( 'Delete', $action )
			->size( 'small' );
	}

}