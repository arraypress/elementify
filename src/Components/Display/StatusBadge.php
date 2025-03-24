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

namespace Elementify\Components\Display;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Element;
use Elementify\Traits\Component\Parts;

/**
 * Status Badge Component
 *
 * Creates a styled badge for displaying status information.
 */
class StatusBadge extends Component {
	use Parts;

	/**
	 * Status options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Badge label text
	 *
	 * @var string
	 */
	protected string $label = '';

	/**
	 * Badge status
	 *
	 * @var string
	 */
	protected string $status = 'default';

	/**
	 * Status icon mapping
	 *
	 * @var array
	 */
	protected static array $status_icons = [
		// General statuses
		'default'            => 'marker',
		'success'            => 'yes',
		'warning'            => 'warning',
		'error'              => 'no',
		'info'               => 'info',

		// Customer statuses
		'active'             => 'yes-alt',
		'inactive'           => 'marker',
		'pending'            => 'clock',
		'blocked'            => 'shield',

		// Commission statuses
		'unpaid'             => 'money-alt',
		'paid'               => 'yes-alt',
		'revoked'            => 'no-alt',

		// Order statuses
		'processing'         => 'update',
		'completed'          => 'yes-alt',
		'refunded'           => 'money-alt',
		'partially_refunded' => 'money',
		'failed'             => 'dismiss',
		'cancelled'          => 'no',
	];

	/**
	 * Constructor
	 *
	 * @param string $label       Badge label text
	 * @param string $status      Status type (success, warning, error, info, etc.)
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 */
	public function __construct( string $label, string $status = 'default', array $options = [], array $attributes = [], bool $include_css = true ) {
		// Store label and status
		$this->label  = $label;
		$this->status = $status;

		// Set default icon from mapping if not provided
		if ( ! isset( $options['icon'] ) && isset( self::$status_icons[ $status ] ) ) {
			$options['icon'] = self::$status_icons[ $status ];
		}

		// Merge default options
		$this->options = array_merge( [
			'icon'     => '',
			'position' => 'before',
			'dashicon' => true,
		], $options );

		// Ensure we have a 'class' attribute for later
		if ( ! isset( $attributes['class'] ) ) {
			$attributes['class'] = '';
		}

		// Explicitly add status class to the attributes
		if ( is_string( $attributes['class'] ) ) {
			// Append to string
			$attributes['class'] = trim( $attributes['class'] . " status-badge status-badge--{$status}" );
		} elseif ( is_array( $attributes['class'] ) ) {
			// Add to array
			$attributes['class'][] = 'status-badge';
			$attributes['class'][] = "status-badge--{$status}";
		}

		// Set base class
		$this->base_class = 'status-badge';

		// Initialize with a span element (before init_component to avoid class conflicts)
		parent::__construct( 'span', '', $attributes );

		// Initialize component foundation
		$this->init_component( 'status-badge', $attributes, $include_css );

		// Build the badge
		$this->build();
	}

	/**
	 * Build the badge structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Create icon if specified
		$icon = $this->create_icon();

		// Add icon before text if position is 'before'
		if ( $this->options['position'] === 'before' && ! empty( $icon ) ) {
			$this->add_child( $icon );
		}

		// Add the text
		$text = Create::span( $this->label )->add_class( 'status-badge__text' );
		$this->add_child( $text );

		// Add icon after text if position is 'after'
		if ( $this->options['position'] === 'after' && ! empty( $icon ) ) {
			$this->add_child( $icon );
		}
	}

	/**
	 * Create icon element
	 *
	 * @return Element|null
	 */
	protected function create_icon(): ?Element {
		if ( empty( $this->options['icon'] ) ) {
			return null;
		}

		$icon_wrapper = Create::span()->add_class( 'status-badge__icon' );

		$classes = [];
		if ( $this->options['dashicon'] ) {
			$classes[] = 'dashicons';
			$classes[] = "dashicons-{$this->options['icon']}";
		} else {
			$classes[] = $this->options['icon'];
		}

		$icon = Create::span()->add_class( implode( ' ', $classes ) );
		$icon_wrapper->add_child( $icon );

		return $icon_wrapper;
	}

	/**
	 * Set icon
	 *
	 * @param string $icon        Icon identifier
	 * @param bool   $is_dashicon Whether it's a dashicon
	 *
	 * @return $this
	 */
	public function set_icon( string $icon, bool $is_dashicon = true ): self {
		$this->options['icon']     = $icon;
		$this->options['dashicon'] = $is_dashicon;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set icon position
	 *
	 * @param string $position Position ('before' or 'after')
	 *
	 * @return $this
	 */
	public function set_position( string $position ): self {
		if ( in_array( $position, [ 'before', 'after' ] ) ) {
			$this->options['position'] = $position;
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Set status
	 *
	 * @param string $status Status identifier
	 *
	 * @return $this
	 */
	public function set_status( string $status ): self {
		// Remove the old status class
		$this->remove_class( "status-badge--{$this->status}" );

		// Store new status
		$this->status = $status;

		// Add new status class
		$this->add_class( "status-badge--{$status}" );

		// Update icon if there's a default for this status and no custom icon set
		if ( isset( self::$status_icons[ $status ] ) && empty( $this->options['icon'] ) ) {
			$this->options['icon'] = self::$status_icons[ $status ];
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Set the badge label
	 *
	 * @param string $label New label text
	 *
	 * @return $this
	 */
	public function set_label( string $label ): self {
		$this->label = $label;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Use dashicons for icons
	 *
	 * @param bool $use Whether to use dashicons
	 *
	 * @return $this
	 */
	public function use_dashicons( bool $use = true ): self {
		return $this->toggle_option( 'dashicon', $use );
	}

	/**
	 * Get the badge label
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->label;
	}

	/**
	 * Get the badge status
	 *
	 * @return string
	 */
	public function get_status(): string {
		return $this->status;
	}

}