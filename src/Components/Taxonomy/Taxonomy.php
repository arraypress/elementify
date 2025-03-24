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

namespace Elementify\Components\Taxonomy;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Traits\Component\Parts;

/**
 * Taxonomy Component
 *
 * Creates a component for displaying taxonomy terms.
 */
class Taxonomy extends Component {
	use Parts;

	/**
	 * Taxonomy options
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Terms data
	 *
	 * @var array
	 */
	protected array $terms = [];

	/**
	 * Constructor
	 *
	 * @param mixed  $source      Post ID, term IDs array, or terms array
	 * @param string $taxonomy    Taxonomy name (category, post_tag, etc.)
	 * @param array  $options     Additional options
	 * @param array  $attributes  Element attributes
	 * @param bool   $include_css Whether to include built-in CSS
	 */
	public function __construct( $source, string $taxonomy = 'category', array $options = [], array $attributes = [], bool $include_css = true ) {
		// Merge default options
		$this->options = array_merge( [
			'link'          => true,           // Link to term archive
			'separator'     => ', ',           // Separator between terms
			'link_target'   => '',             // Link target (_blank, etc.)
			'show_count'    => false,          // Show post count
			'count_format'  => ' (%d)',        // Format for count display
			'placeholder'   => __( 'None' ),   // Text to show when no terms
			'limit'         => 0,              // Limit number of terms (0 = no limit)
			'show_more'     => true,           // Show "and X more" when limited
			'more_format'   => __( 'and %d more' ), // Format for "more" text
			'badge'         => false,          // Display as badge
			'badge_options' => []              // Options for badge
		], $options );

		// Fetch terms
		$this->terms = $this->get_terms_data( $source, $taxonomy );

		// Set base class
		$this->base_class = 'taxonomy-component';

		// Initialize component foundation
		$this->init_component( 'taxonomy', $attributes, $include_css );

		// Initialize with a span element
		parent::__construct( 'span', null, $attributes );

		// Build the taxonomy component
		$this->build();
	}

	/**
	 * Get terms data from source
	 *
	 * @param mixed  $source   Post ID, term IDs array, or terms array
	 * @param string $taxonomy Taxonomy name
	 *
	 * @return array Term data array
	 */
	protected function get_terms_data( $source, string $taxonomy ): array {
		$result = [];

		// If source is a post ID, get its terms
		if ( is_numeric( $source ) ) {
			$post_id    = (int) $source;
			$post_terms = get_the_terms( $post_id, $taxonomy );

			if ( is_wp_error( $post_terms ) || empty( $post_terms ) ) {
				return [];
			}

			return $post_terms;
		} // If source is already an array of term objects
		elseif ( is_array( $source ) && ! empty( $source ) && isset( $source[0]->term_id ) ) {
			return $source;
		} // If source is an array of term IDs or slugs
		elseif ( is_array( $source ) ) {
			foreach ( $source as $term_id_or_slug ) {
				$term = is_numeric( $term_id_or_slug )
					? get_term( $term_id_or_slug, $taxonomy )
					: get_term_by( 'slug', $term_id_or_slug, $taxonomy );

				if ( $term && ! is_wp_error( $term ) ) {
					$result[] = $term;
				}
			}
		} // If source is a comma-separated list of term IDs or slugs
		elseif ( is_string( $source ) && strpos( $source, ',' ) !== false ) {
			$term_array = array_map( 'trim', explode( ',', $source ) );
			foreach ( $term_array as $term_id_or_slug ) {
				$term = is_numeric( $term_id_or_slug )
					? get_term( $term_id_or_slug, $taxonomy )
					: get_term_by( 'slug', $term_id_or_slug, $taxonomy );

				if ( $term && ! is_wp_error( $term ) ) {
					$result[] = $term;
				}
			}
		}

		return $result;
	}

	/**
	 * Build the taxonomy component structure
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// If no terms, show placeholder
		if ( empty( $this->terms ) ) {
			$this->add_child( Create::span( $this->options['placeholder'] )->add_class( 'taxonomy-placeholder' ) );

			return;
		}

		// Determine if we should limit the terms
		$terms_to_display = $this->terms;
		$hidden_count     = 0;

		if ( $this->options['limit'] > 0 && count( $this->terms ) > $this->options['limit'] ) {
			$terms_to_display = array_slice( $this->terms, 0, $this->options['limit'] );
			$hidden_count     = count( $this->terms ) - $this->options['limit'];
		}

		// Create term elements
		$term_elements = [];
		foreach ( $terms_to_display as $term ) {
			// Skip invalid terms
			if ( ! isset( $term->name ) ) {
				continue;
			}

			// Create term content
			if ( $this->options['badge'] ) {
				// Create term as badge
				$badge_options           = $this->options['badge_options'];
				$badge_options['status'] = $badge_options['status'] ?? $term->slug;

				$term_element = Create::badge( $term->name, $badge_options['status'], $badge_options );
			} else {
				// Create term as text
				$term_content = $term->name;

				// Add post count if needed
				if ( $this->options['show_count'] ) {
					$term_content .= sprintf( $this->options['count_format'], $term->count );
				}

				// Create term element
				$term_element = Create::span( $term_content )->add_class( 'taxonomy-term' );

				// Add term slug as a class
				$term_element->add_class( 'term-' . sanitize_html_class( $term->slug ) );
			}

			// Wrap with link if needed
			if ( $this->options['link'] ) {
				$term_url = get_term_link( $term );

				// Only create link if URL is valid
				if ( ! is_wp_error( $term_url ) ) {
					$link_element = Create::a( $term_url, $term_element );

					// Add target if specified
					if ( ! empty( $this->options['link_target'] ) ) {
						$link_element->set_attribute( 'target', $this->options['link_target'] );
					}

					$term_element = $link_element;
				}
			}

			$term_elements[] = $term_element;
		}

		// Add "and X more" text if needed
		if ( $hidden_count > 0 && $this->options['show_more'] ) {
			$more_text       = sprintf( $this->options['more_format'], $hidden_count );
			$term_elements[] = Create::span( $more_text )->add_class( 'taxonomy-more' );
		}

		// Add the elements with separators
		$count = count( $term_elements );
		for ( $i = 0; $i < $count; $i ++ ) {
			$this->add_child( $term_elements[ $i ] );

			// Add separator if not the last element
			if ( $i < $count - 1 ) {
				$this->add_child( Create::span( $this->options['separator'] )->add_class( 'taxonomy-separator' ) );
			}
		}
	}

	/**
	 * Enable/disable links to term archives
	 *
	 * @param bool $enable Whether to enable links
	 *
	 * @return $this
	 */
	public function enable_links( bool $enable = true ): self {
		return $this->toggle_option('link', $enable);
	}

	/**
	 * Set link target
	 *
	 * @param string $target Link target (_blank, etc.)
	 *
	 * @return $this
	 */
	public function set_link_target( string $target ): self {
		$this->options['link_target'] = $target;

		// Rebuild the component if links are enabled
		if ( $this->options['link'] ) {
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Set terms separator
	 *
	 * @param string $separator Separator between terms
	 *
	 * @return $this
	 */
	public function set_separator( string $separator ): self {
		$this->options['separator'] = $separator;
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Show/hide term count
	 *
	 * @param bool $show Whether to show count
	 *
	 * @return $this
	 */
	public function show_count( bool $show = true ): self {
		return $this->toggle_option('show_count', $show);
	}

	/**
	 * Set count format
	 *
	 * @param string $format Format string (use %d for count)
	 *
	 * @return $this
	 */
	public function set_count_format( string $format ): self {
		$this->options['count_format'] = $format;

		// Rebuild the component if counts are shown
		if ( $this->options['show_count'] ) {
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Limit number of terms to display
	 *
	 * @param int $limit Maximum number of terms (0 = no limit)
	 *
	 * @return $this
	 */
	public function set_limit( int $limit ): self {
		$this->options['limit'] = max( 0, $limit );
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Show/hide "and X more" text
	 *
	 * @param bool $show Whether to show "more" text
	 *
	 * @return $this
	 */
	public function show_more( bool $show = true ): self {
		return $this->toggle_option('show_more', $show);
	}

	/**
	 * Set "more" format
	 *
	 * @param string $format Format string (use %d for count)
	 *
	 * @return $this
	 */
	public function set_more_format( string $format ): self {
		$this->options['more_format'] = $format;

		// Rebuild the component if limited and showing more
		if ( $this->options['limit'] > 0 && $this->options['show_more'] && count( $this->terms ) > $this->options['limit'] ) {
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Enable/disable badge display
	 *
	 * @param bool  $enable  Whether to display as badges
	 * @param array $options Badge options
	 *
	 * @return $this
	 */
	public function enable_badges( bool $enable = true, array $options = [] ): self {
		$this->options['badge'] = $enable;

		if ( ! empty( $options ) ) {
			$this->options['badge_options'] = $options;
		}

		$this->mark_for_rebuild();
		return $this;
	}

	/**
	 * Set badge options
	 *
	 * @param array $options Badge options
	 *
	 * @return $this
	 */
	public function set_badge_options( array $options ): self {
		$this->options['badge_options'] = $options;

		// Rebuild if badges are enabled
		if ( $this->options['badge'] ) {
			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Get the terms
	 *
	 * @return array
	 */
	public function get_terms(): array {
		return $this->terms;
	}
}