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

namespace Elementify\Components\Interactive;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Traits\Component\Parts;
use Elementify\Traits\Component\SectionContent;

/**
 * Accordion Component
 *
 * Creates an accordion interface with collapsible sections.
 */
class Accordion extends Component {
	use Parts;
	use SectionContent;

	/**
	 * Whether multiple sections can be open at once
	 *
	 * @var bool
	 */
	protected bool $allow_multiple = false;

	/**
	 * Constructor
	 *
	 * @param array $sections       Array of sections with 'title', 'content', and optional 'active' keys
	 * @param bool  $allow_multiple Whether multiple sections can be open at once
	 * @param array $attributes     Element attributes
	 * @param bool  $include_css    Whether to include built-in CSS
	 */
	public function __construct( array $sections = [], bool $allow_multiple = false, array $attributes = [], bool $include_css = true ) {
		// Set accordion properties
		$this->allow_multiple = $allow_multiple;

		// Initialize component foundation
		$this->init_component( 'accordion', $attributes, $include_css );

		// Set data attribute for multiple sections
		$attributes['data-allow-multiple'] = $allow_multiple ? 'true' : 'false';

		// Initialize with a div element
		parent::__construct( 'div', null, $attributes );

		// Add sections if provided
		if ( ! empty( $sections ) ) {
			$this->add_sections( $sections );
		}

		// Build the accordion
		$this->build();
	}

	/**
	 * Build the accordion
	 */
	protected function build(): void {
		$this->children = []; // Clear children

		// Add sections
		foreach ( $this->sections as $section_id => $section ) {
			$is_active = isset( $section['active'] ) && $section['active'];

			// Create header
			$header = Create::div( $section['title'] )
			                ->add_class( 'accordion-header' )
			                ->toggle_class( 'active', $is_active )
			                ->set_data( 'section', $section_id );

			// Create content
			$content = Create::div( $section['content'] )
			                 ->set_id( $section_id )
			                 ->add_class( 'accordion-content' )
			                 ->set_styles( [ 'display' => $is_active ? 'block' : 'none' ] );

			// Add to accordion
			$this->add_child( $header );
			$this->add_child( $content );
		}
	}

	/**
	 * Set whether multiple sections can be open at once
	 *
	 * @param bool $allow Whether to allow multiple open sections
	 *
	 * @return $this
	 */
	public function set_allow_multiple( bool $allow ): self {
		$this->allow_multiple = $allow;
		$this->set_data( 'allow-multiple', $allow ? 'true' : 'false' );

		// If not allowing multiple and there are multiple active sections,
		// keep only the first active one
		if ( ! $allow ) {
			$found_active = false;
			foreach ( $this->sections as $section_id => $section ) {
				if ( isset( $section['active'] ) && $section['active'] ) {
					if ( $found_active ) {
						$this->sections[ $section_id ]['active'] = false;
					} else {
						$found_active         = true;
						$this->active_section = $section_id;
					}
				}
			}
		}

		// Rebuild accordion
		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Add a section
	 *
	 * @param string $id      Section ID
	 * @param string $title   Section title
	 * @param mixed  $content Section content
	 * @param bool   $active  Whether the section is active/open
	 *
	 * @return $this
	 */
	public function add_section( string $id, string $title, $content, bool $active = false ): self {
		// If setting this section as active and not allowing multiple,
		// deactivate any currently active sections
		if ( $active && ! $this->allow_multiple ) {
			foreach ( $this->sections as $section_id => $section ) {
				if ( isset( $section['active'] ) && $section['active'] ) {
					$this->sections[ $section_id ]['active'] = false;
				}
			}
		}

		$this->sections[ $id ] = [
			'title'   => $title,
			'content' => $content,
			'active'  => $active
		];

		$this->mark_for_rebuild();

		return $this;
	}

	/**
	 * Set a section as active/open
	 *
	 * @param string $id Section ID
	 *
	 * @return $this
	 */
	public function set_section_active( string $id ): self {
		if ( isset( $this->sections[ $id ] ) ) {
			// If not allowing multiple, deactivate all sections first
			if ( ! $this->allow_multiple ) {
				foreach ( $this->sections as $section_id => $section ) {
					$this->sections[ $section_id ]['active'] = false;
				}
			}

			// Set this section as active
			$this->sections[ $id ]['active'] = true;
			$this->active_section            = $id;

			$this->mark_for_rebuild();
		}

		return $this;
	}

	/**
	 * Check if multiple sections can be open at once
	 *
	 * @return bool
	 */
	public function is_multiple_allowed(): bool {
		return $this->allow_multiple;
	}
}