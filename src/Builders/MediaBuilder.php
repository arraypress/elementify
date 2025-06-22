<?php
/**
 * Elementify Library - Media Builder
 *
 * Provides a fluent interface for building responsive media elements.
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
 * Media Builder Class
 *
 * Provides a fluent interface for building responsive media elements
 * including images, videos, audio, and picture elements with various features.
 */
class MediaBuilder extends Element {

	/**
	 * Media type (image, video, audio, picture)
	 *
	 * @var string
	 */
	protected string $media_type = 'image';

	/**
	 * Media source URL
	 *
	 * @var string
	 */
	protected string $src = '';

	/**
	 * Alternative text for images
	 *
	 * @var string
	 */
	protected string $alt = '';

	/**
	 * Media caption
	 *
	 * @var string
	 */
	protected string $caption = '';

	/**
	 * Responsive sources for picture element
	 *
	 * @var array
	 */
	protected array $responsive_sources = [];

	/**
	 * Whether to use lazy loading
	 *
	 * @var bool
	 */
	protected bool $lazy_loading = false;

	/**
	 * Media controls (for audio/video)
	 *
	 * @var bool
	 */
	protected bool $controls = true;

	/**
	 * Constructor
	 *
	 * @param array $attributes Element attributes
	 */
	public function __construct( array $attributes = [] ) {
		parent::__construct( 'figure', null, $attributes );
	}

	/**
	 * Set as image media type
	 *
	 * @param string $src Image source URL
	 * @param string $alt Alternative text
	 *
	 * @return $this For method chaining
	 */
	public function image( string $src, string $alt = '' ): self {
		$this->media_type = 'image';
		$this->src        = $src;
		$this->alt        = $alt;

		return $this;
	}

	/**
	 * Set as video media type
	 *
	 * @param string|array $src Video source URL(s)
	 *
	 * @return $this For method chaining
	 */
	public function video( $src ): self {
		$this->media_type = 'video';
		$this->src        = is_array( $src ) ? $src[0] : $src;

		if ( is_array( $src ) ) {
			$this->responsive_sources = $src;
		}

		return $this;
	}

	/**
	 * Set as audio media type
	 *
	 * @param string|array $src Audio source URL(s)
	 *
	 * @return $this For method chaining
	 */
	public function audio( $src ): self {
		$this->media_type = 'audio';
		$this->src        = is_array( $src ) ? $src[0] : $src;

		if ( is_array( $src ) ) {
			$this->responsive_sources = $src;
		}

		return $this;
	}

	/**
	 * Add responsive image sources for picture element
	 *
	 * @param array $sources Array of responsive sources
	 *                       Format: ['media_query' => 'image_url'] or detailed array format
	 *
	 * @return $this For method chaining
	 */
	public function responsive( array $sources ): self {
		$this->media_type         = 'picture';
		$this->responsive_sources = $sources;

		return $this;
	}

	/**
	 * Set media caption
	 *
	 * @param string $caption Caption text
	 *
	 * @return $this For method chaining
	 */
	public function caption( string $caption ): self {
		$this->caption = $caption;

		return $this;
	}

	/**
	 * Enable lazy loading
	 *
	 * @param bool $lazy Whether to enable lazy loading
	 *
	 * @return $this For method chaining
	 */
	public function lazy( bool $lazy = true ): self {
		$this->lazy_loading = $lazy;

		return $this;
	}

	/**
	 * Set controls for audio/video
	 *
	 * @param bool $controls Whether to show controls
	 *
	 * @return $this For method chaining
	 */
	public function controls( bool $controls = true ): self {
		$this->controls = $controls;

		return $this;
	}

	/**
	 * Make media responsive (full width)
	 *
	 * @return $this For method chaining
	 */
	public function responsive_sizing(): self {
		$this->add_class( 'responsive-media' );

		return $this;
	}

	/**
	 * Center the media element
	 *
	 * @return $this For method chaining
	 */
	public function centered(): self {
		$this->add_class( 'centered-media' );
		$this->set_styles( [ 'text-align' => 'center' ] );

		return $this;
	}

	/**
	 * Add a border to the media
	 *
	 * @param string $style Border style (CSS border property value)
	 *
	 * @return $this For method chaining
	 */
	public function border( string $style = '1px solid #ddd' ): self {
		$this->set_styles( [ 'border' => $style ] );

		return $this;
	}

	/**
	 * Add rounded corners
	 *
	 * @param string $radius Border radius value
	 *
	 * @return $this For method chaining
	 */
	public function rounded( string $radius = '8px' ): self {
		$this->set_styles( [ 'border-radius' => $radius ] );

		return $this;
	}

	/**
	 * Add shadow effect
	 *
	 * @param string $shadow Box shadow CSS value
	 *
	 * @return $this For method chaining
	 */
	public function shadow( string $shadow = '0 2px 8px rgba(0,0,0,0.1)' ): self {
		$this->set_styles( [ 'box-shadow' => $shadow ] );

		return $this;
	}

	/**
	 * Build the media structure
	 *
	 * @return void
	 */
	protected function build(): void {
		$this->children = []; // Clear existing content

		$media_element = null;
		$attributes    = [];

		// Add lazy loading if enabled
		if ( $this->lazy_loading ) {
			$attributes['loading'] = 'lazy';
		}

		switch ( $this->media_type ) {
			case 'image':
				$attributes['src'] = $this->src;
				$attributes['alt'] = $this->alt;
				$media_element     = Create::img( $this->src, $this->alt, $attributes );
				break;

			case 'picture':
				$sources = [];
				foreach ( $this->responsive_sources as $media => $src ) {
					if ( is_string( $media ) && is_string( $src ) ) {
						$sources[] = [
							'src'   => $src,
							'media' => $media
						];
					} elseif ( is_array( $src ) ) {
						$sources[] = $src;
					}
				}
				$media_element = Create::picture( $sources, $this->src, $this->alt );
				break;

			case 'video':
				if ( ! empty( $this->responsive_sources ) ) {
					$media_element = Create::video( $this->responsive_sources, $this->controls, $attributes );
				} else {
					$media_element = Create::video( $this->src, $this->controls, $attributes );
				}
				break;

			case 'audio':
				if ( ! empty( $this->responsive_sources ) ) {
					$media_element = Create::audio( $this->responsive_sources, $this->controls, $attributes );
				} else {
					$media_element = Create::audio( $this->src, $this->controls, $attributes );
				}
				break;
		}

		if ( $media_element ) {
			$this->add_child( $media_element );
		}

		// Add caption if provided
		if ( ! empty( $this->caption ) ) {
			$this->add_child( Create::element( 'figcaption', $this->caption ) );
		}
	}

	/**
	 * Render the media element
	 *
	 * @return string
	 */
	public function render(): string {
		$this->build();

		return parent::render();
	}

}