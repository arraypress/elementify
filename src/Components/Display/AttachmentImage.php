<?php
/**
 * Simplified Attachment Image Component
 */

namespace Elementify\Components\Media;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;
use Elementify\Element;

/**
 * AttachmentImage Component
 */
class AttachmentImage extends Component {

	/**
	 * Image source
	 */
	protected $source;

	/**
	 * Image options
	 */
	protected array $options = [];

	/**
	 * Constructor
	 */
	public function __construct( $source, array $options = [], array $attributes = [], bool $include_css = true ) {
		// Store the image source
		$this->source = $source;

//		var_dump( $source );

		// Merge default options
		$this->options = array_merge( [
			'size'      => 32,
			'alt'       => '',
			'lazy_load' => true,
			'rounded'   => false,
			'circle'    => false,
			'fallback'  => '',
		], $options );

		// Set base class
		$this->base_class = 'attachment-image';

		// Initialize component foundation
		$this->init_component( 'attachment-image', $attributes, $include_css );

		// Initialize with a span element
		parent::__construct( 'span', null, $attributes );

		// Add shape classes if specified
		if ( $this->options['circle'] ) {
			$this->add_class( 'circle' );
		} elseif ( $this->options['rounded'] ) {
			$this->add_class( 'rounded' );
		}

		// Build the image component
		$this->build();
	}

	/**
	 * Build the image component structure
	 */
	protected function build(): void {
		// Clear existing content
		$this->empty();

		// Get the source (using fallback if needed)
		$source = ! empty( $this->source ) ? $this->source : $this->options['fallback'];

		// If no valid source, return empty component
		if ( empty( $source ) ) {
			return;
		}

		// Prepare image attributes
		$img_attrs = [
			'alt'   => $this->options['alt'],
			'class' => $this->base_class
		];

		// Add shape classes to image
		if ( $this->options['circle'] ) {
			$img_attrs['class'] .= ' circle';
		} elseif ( $this->options['rounded'] ) {
			$img_attrs['class'] .= ' rounded';
		}

		// Add lazy loading if enabled
		if ( $this->options['lazy_load'] ) {
			$img_attrs['loading'] = 'lazy';
		}

		// Handle size for img tag
		if ( is_numeric( $this->options['size'] ) ) {
			$img_attrs['width']  = (int) $this->options['size'];
			$img_attrs['height'] = (int) $this->options['size'];
		}

		// Generate HTML based on source type
		$image_html = '';

		// Handle numeric attachment ID
		if ( is_numeric( $source ) && function_exists( 'wp_get_attachment_image' ) ) {
			$size = is_numeric( $this->options['size'] )
				? [ (int) $this->options['size'], (int) $this->options['size'] ]
				: $this->options['size'];

			$image_html = wp_get_attachment_image( (int) $source, $size, false, $img_attrs );
		} // Handle HTML string (e.g., from functions like get_avatar)
		elseif ( is_string( $source ) && strpos( $source, '<img' ) === 0 ) {
			$image_html = $source;
		} // Handle URL string
		elseif ( is_string( $source ) ) {
			$image_html = $this->create_img_tag( $source, $img_attrs );
		}

		// Add the image HTML if we have it
		if ( ! empty( $image_html ) ) {
			$this->add_raw_content( $image_html );
		}
	}

	/**
	 * Create an img tag
	 */
	protected function create_img_tag( string $src, array $attributes = [] ): string {
		if ( empty( $src ) ) {
			return '';
		}

		$html = '<img src="' . esc_url( $src ) . '"';

		foreach ( $attributes as $name => $value ) {
			$html .= ' ' . $name . '="' . esc_attr( $value ) . '"';
		}

		$html .= '>';

		return $html;
	}

}