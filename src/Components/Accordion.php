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
namespace Elementify\Components;
use Elementify\Abstracts\Component;
use Elementify\Create;
use Elementify\Traits\Component\Parts;
use Elementify\Traits\Component\SectionContent;
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;
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
			                ->add_class( 'accordion-header' . ( $is_active ? ' active' : '' ) )
			                ->set_attribute( 'data-section', $section_id );
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
		$this->set_attribute( 'data-allow-multiple', $allow ? 'true' : 'false' );
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
		$this->build();
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