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
use Elementify\Traits\Component\Parts;

/**
 * Rating Component
 *
 * Creates a visual star rating display.
 */
class Rating extends Component {
	use Parts;

	/**
	 * Rating options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Rating value
	 *
	 * @var float
	 */
	protected float $rating;

	/**
	 * Constructor
	 *
	 * @param float $rating      Rating value
	 * @param array $options     Additional options
	 * @param array $attributes  Element attributes
	 */
	public function __construct( float $rating, array $options = [], array $attributes = [] ) {
		// Store rating value
		$this->rating = $rating;

		// Merge default options
		$this->options = array_merge( [
			'max'          => 5,              // Maximum rating value
			'show_value'   => true,           // Show numeric rating value
			'precision'    => 1,              // Decimal precision for displayed value
			'style'        => 'stars',        // stars, hearts, thumbs, custom
			'empty_icon'   => '★',            // Empty icon character
			'filled_icon'  => '★',            // Filled icon character
			'dashicons'    => false,          // Use WordPress Dashicons
			'empty_color'  => '#ccc',         // Color for empty icons
			'filled_color' => '#ffb900',     // Color for filled icons
			'size'         => 16,             // Icon size in pixels
			'tooltip'      => '',             // Optional tooltip text
			'show_max'     => true,           // Show max value (e.g., "4.5/5")
		], $options );

		// Set base class
		$this->base_class = 'rating';

		// Initialize component foundation
		$this->init_component( 'rating', $attributes );

		// Initialize with a div element
		parent::__construct( 'div', null, $attributes );

		// Add tooltip if provided
		if (!empty($this->options['tooltip'])) {
			$this->add_tooltip($this->options['tooltip']);
		}

		// Build the rating component
		$this->build();
	}

	/**
	 * Build the rating component structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Normalize rating to be between 0 and max
		$max     = $this->options['max'];
		$rating  = min( max( 0, $this->rating ), $max );
		$percent = ( $rating / $max ) * 100;

		// Create the rating container
		$container = Create::div()->add_class( 'rating-container' );

		// Use dashicons or custom icons based on settings
		if ( $this->options['dashicons'] ) {
			// Add dashicon class to container
			$container->add_class( 'dashicons-rating' );

			// Determine dashicon based on style
			$filled_icon = $this->get_dashicon_by_style();
			$empty_icon  = str_replace( '-filled', '-empty', $filled_icon );

			// Add each star/icon individually
			$full_stars = floor( $rating );
			$partial    = $rating - $full_stars;

			// Add full stars
			for ( $i = 0; $i < $full_stars; $i ++ ) {
				$icon = Create::span()->add_class( "dashicons $filled_icon" );
				$icon->set_attribute( 'style', "color: {$this->options['filled_color']};" );
				$container->add_child( $icon );
			}

			// Add partial star if needed (as empty star - we'll handle the partial fill with CSS)
			if ( $partial > 0 ) {
				$partial_percent = $partial * 100;
				$icon_wrapper    = Create::span()->add_class( 'rating-partial-wrapper' )
				                         ->set_attribute( 'style', 'position: relative; display: inline-block;' );

				// Empty star as background
				$empty = Create::span()->add_class( "dashicons $empty_icon" )
				               ->set_attribute( 'style', "color: {$this->options['empty_color']};" );
				$icon_wrapper->add_child( $empty );

				// Filled star overlay with partial width
				$filled = Create::span()->add_class( "dashicons $filled_icon" )
				                ->set_attribute( 'style', "color: {$this->options['filled_color']}; position: absolute; top: 0; left: 0; overflow: hidden; width: {$partial_percent}%;" );
				$icon_wrapper->add_child( $filled );

				$container->add_child( $icon_wrapper );

				// Remaining empty stars
				$remaining = $max - $full_stars - 1;
				for ( $i = 0; $i < $remaining; $i ++ ) {
					$icon = Create::span()->add_class( "dashicons $empty_icon" );
					$icon->set_attribute( 'style', "color: {$this->options['empty_color']};" );
					$container->add_child( $icon );
				}
			} else {
				// Remaining empty stars if no partial star
				$remaining = $max - $full_stars;
				for ( $i = 0; $i < $remaining; $i ++ ) {
					$icon = Create::span()->add_class( "dashicons $empty_icon" );
					$icon->set_attribute( 'style', "color: {$this->options['empty_color']};" );
					$container->add_child( $icon );
				}
			}
		} else {
			// Use CSS-based approach for custom characters
			$size = $this->options['size'];

			// Adjust characters based on style if empty/filled are not customized
			if ( $this->options['style'] !== 'custom' ) {
				$this->set_icons_by_style();
			}

			// Create element with empty stars
			$empty = Create::div( str_repeat( $this->options['empty_icon'], $max ) )
			               ->add_class( 'rating-empty' )
			               ->set_attribute( 'style', "color: {$this->options['empty_color']}; font-size: {$size}px;" );

			// Create element with filled stars (overlay)
			$filled = Create::div( str_repeat( $this->options['filled_icon'], $max ) )
			                ->add_class( 'rating-filled' )
			                ->set_attribute( 'style', "color: {$this->options['filled_color']}; width: {$percent}%; font-size: {$size}px; overflow: hidden; white-space: nowrap; position: absolute; top: 0; left: 0;" );

			// Add container styles
			$container->set_attribute( 'style', 'display: inline-block; position: relative; unicode-bidi: bidi-override;' );

			// Add empty and filled elements
			$container->add_child( $empty );
			$container->add_child( $filled );
		}

		// Create wrapper to hold rating and value
		$wrapper = Create::div()->add_class( 'rating-wrapper' );
		$wrapper->add_child( $container );

		// Add numeric value if enabled
		if ( $this->options['show_value'] ) {
			$formatted_rating = number_format_i18n( $rating, $this->options['precision'] );

			$value_text = $formatted_rating;
			if ( $this->options['show_max'] ) {
				$value_text .= '/' . $max;
			}

			$value = Create::span( $value_text )->add_class( 'rating-value' );

			// Add margin to separate from stars
			$value->set_attribute( 'style', 'margin-left: 5px; vertical-align: middle;' );

			$wrapper->add_child( $value );
		}

		// Add wrapper to component
		$this->add_child( $wrapper );
	}

	/**
	 * Get dashicon class based on style
	 *
	 * @return string Dashicon class
	 */
	protected function get_dashicon_by_style(): string {
		switch ( $this->options['style'] ) {
			case 'hearts':
				return 'dashicons-heart';

			case 'thumbs':
				return 'dashicons-thumbs-up';

			case 'stars':
			default:
				return 'dashicons-star-filled';
		}
	}

	/**
	 * Set icon characters based on style
	 */
	protected function set_icons_by_style(): void {
		switch ( $this->options['style'] ) {
			case 'hearts':
				$this->options['empty_icon']  = '♡';
				$this->options['filled_icon'] = '♥';
				break;

			case 'thumbs':
				$this->options['empty_icon']  = '👍';
				$this->options['filled_icon'] = '👍';
				break;

			case 'stars':
			default:
				$this->options['empty_icon']  = '★';
				$this->options['filled_icon'] = '★';
				break;
		}
	}

	/**
	 * Set rating value
	 *
	 * @param float $rating New rating value
	 *
	 * @return $this
	 */
	public function set_rating( float $rating ): self {
		$this->rating = $rating;
		$this->mark_for_rebuild();
		return $this;
	}

	/**
	 * Set maximum rating value
	 *
	 * @param int $max Maximum rating
	 *
	 * @return $this
	 */
	public function set_max( int $max ): self {
		$this->options['max'] = max( 1, $max );
		$this->mark_for_rebuild();
		return $this;
	}

	/**
	 * Show/hide numeric rating value
	 *
	 * @param bool $show Whether to show value
	 *
	 * @return $this
	 */
	public function show_value( bool $show = true ): self {
		return $this->toggle_option('show_value', $show);
	}

	/**
	 * Set value precision
	 *
	 * @param int $precision Number of decimal places
	 *
	 * @return $this
	 */
	public function set_precision( int $precision ): self {
		$this->options['precision'] = max( 0, $precision );

		// Only rebuild if showing value
		if ( $this->options['show_value'] ) {
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Set rating style
	 *
	 * @param string $style Style (stars, hearts, thumbs, custom)
	 *
	 * @return $this
	 */
	public function set_style( string $style ): self {
		$valid_styles = [ 'stars', 'hearts', 'thumbs', 'custom' ];

		if ( in_array( $style, $valid_styles ) ) {
			$this->options['style'] = $style;
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Set custom icons
	 *
	 * @param string $empty_icon  Icon for empty state
	 * @param string $filled_icon Icon for filled state
	 *
	 * @return $this
	 */
	public function set_icons( string $empty_icon, string $filled_icon ): self {
		$this->options['empty_icon']  = $empty_icon;
		$this->options['filled_icon'] = $filled_icon;
		$this->options['style']       = 'custom';
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Enable/disable dashicons
	 *
	 * @param bool $use_dashicons Whether to use dashicons
	 *
	 * @return $this
	 */
	public function use_dashicons( bool $use_dashicons = true ): self {
		return $this->toggle_option('dashicons', $use_dashicons);
	}

	/**
	 * Set icon colors
	 *
	 * @param string $empty_color  Color for empty icons
	 * @param string $filled_color Color for filled icons
	 *
	 * @return $this
	 */
	public function set_colors( string $empty_color, string $filled_color ): self {
		$this->options['empty_color']  = $empty_color;
		$this->options['filled_color'] = $filled_color;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set icon size
	 *
	 * @param int $size Size in pixels
	 *
	 * @return $this
	 */
	public function set_size( int $size ): self {
		$this->options['size'] = max( 1, $size );

		// Rebuild the component if not using dashicons
		if ( ! $this->options['dashicons'] ) {
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Set tooltip text
	 *
	 * @param string $tooltip Tooltip text
	 *
	 * @return $this
	 */
	public function set_tooltip( string $tooltip ): self {
		$this->options['tooltip'] = $tooltip;
		$this->add_tooltip($tooltip);
		return $this;
	}

	/**
	 * Show/hide maximum value
	 *
	 * @param bool $show Whether to show max value
	 *
	 * @return $this
	 */
	public function show_max( bool $show = true ): self {
		return $this->toggle_option('show_max', $show);
	}

	/**
	 * Get the rating value
	 *
	 * @return float
	 */
	public function get_rating(): float {
		return $this->rating;
	}

}