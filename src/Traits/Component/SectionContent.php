<?php
/**
 * Elementify Library - Section Content Trait
 *
 * A collection of methods for managing section-based components like Accordions and Tabs.
 *
 * @package     ArrayPress\Elementify
 * @copyright   Copyright (c) 2025, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 */

declare( strict_types=1 );

namespace Elementify\Traits\Component;

use Elementify\Element;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Section Content Trait
 *
 * Provides methods for handling section-based components like Accordions and Tabs,
 * which have similar data structures and functionality for managing sections/tabs.
 *
 * Note: Sections contain 'title' and 'content' fields which may require different escaping:
 * - Title: Usually plain text that should be escaped when rendered
 * - Content: May contain HTML or nested Elements and should be handled appropriately
 */
trait SectionContent {

	/**
	 * Sections data array
	 *
	 * @var array
	 */
	protected array $sections = [];

	/**
	 * Currently active section ID
	 *
	 * @var string
	 */
	protected string $active_section = '';

	/**
	 * Add multiple sections at once
	 *
	 * @param array $sections Array of sections
	 *
	 * @return $this
	 */
	public function add_sections( array $sections ): self {
		foreach ( $sections as $index => $section ) {
			// If it's a simple array with numeric keys
			if ( is_int( $index ) ) {
				$section_id = $section['id'] ?? 'section-' . ( count( $this->sections ) + 1 );
				$active     = isset( $section['active'] ) && $section['active'];
				$this->add_section( $section_id, $section['title'] ?? '', $section['content'] ?? '', $active );
			} else {
				// If keys are the section IDs
				$active = isset( $section['active'] ) && $section['active'];
				$this->add_section( $index, $section['title'] ?? '', $section['content'] ?? '', $active );
			}
		}

		return $this;
	}

	/**
	 * Add a single section
	 *
	 * @param string $id      Section ID
	 * @param string|Element $title   Section title - will be escaped if it's a string
	 * @param mixed  $content Section content - handling depends on component implementation
	 * @param bool   $active  Whether the section is active (open) by default
	 *
	 * @return $this
	 */
	public function add_section( string $id, $title, $content, bool $active = false ): self {
		$this->sections[ $id ] = [
			'title'   => $title,
			'content' => $content,
			'active'  => $active
		];

		// If this section is active, set it as the active section
		if ( $active ) {
			$this->set_section_active( $id );
		}

		// Rebuild component
		$this->build();

		return $this;
	}

	/**
	 * Remove a section
	 *
	 * @param string $id Section ID to remove
	 *
	 * @return $this
	 */
	public function remove_section( string $id ): self {
		if ( isset( $this->sections[ $id ] ) ) {
			// If we're removing the active section, find a new active section
			if ( $this->active_section === $id ) {
				unset( $this->sections[ $id ] );

				// Find new active section if there are any sections left
				if ( ! empty( $this->sections ) ) {
					reset( $this->sections );
					$this->active_section = key( $this->sections );
				} else {
					$this->active_section = '';
				}
			} else {
				unset( $this->sections[ $id ] );
			}

			// Rebuild component
			$this->build();
		}

		return $this;
	}

	/**
	 * Set section active state
	 *
	 * @param string $id Section ID
	 *
	 * @return $this
	 */
	public function set_section_active( string $id ): self {
		if ( isset( $this->sections[ $id ] ) ) {
			// Handle section activation based on component's allowMultiple setting
			if ( property_exists( $this, 'allow_multiple' ) && method_exists( $this, 'is_multiple_allowed' ) ) {
				if ( ! $this->is_multiple_allowed() ) {
					// If multiple sections aren't allowed, deactivate all sections
					foreach ( $this->sections as $section_id => $section ) {
						$this->sections[ $section_id ]['active'] = ( $section_id === $id );
					}
				} else {
					// Just activate this section
					$this->sections[ $id ]['active'] = true;
				}
			} else {
				// Default behavior - just set this section as active
				$this->sections[ $id ]['active'] = true;
			}

			// Set as the active section
			$this->active_section = $id;

			// Rebuild component
			$this->build();
		}

		return $this;
	}

	/**
	 * Get all sections
	 *
	 * @return array
	 */
	public function get_sections(): array {
		return $this->sections;
	}

	/**
	 * Get a specific section
	 *
	 * @param string $id Section ID
	 *
	 * @return array|null
	 */
	public function get_section( string $id ): ?array {
		return $this->sections[ $id ] ?? null;
	}

	/**
	 * Get the active section ID
	 *
	 * @return string
	 */
	public function get_active_section(): string {
		return $this->active_section;
	}

}